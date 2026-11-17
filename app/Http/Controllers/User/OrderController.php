<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Package;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display list of customer orders
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $query = Order::where('user_id', Auth::id())
            ->with(['items', 'statusHistories', 'review'])
            ->latest();

        if ($status !== 'all' && array_key_exists($status, Order::STATUSES)) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        $statusCounts = [
            'all' => Order::where('user_id', Auth::id())->count(),
            'pending' => Order::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'active' => Order::where('user_id', Auth::id())->whereIn('status', ['confirmed', 'processing', 'washing', 'finishing', 'ready'])->count(),
            'completed' => Order::where('user_id', Auth::id())->where('status', 'completed')->count(),
            'cancelled' => Order::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
        ];

        return view('user.orders.index', compact('orders', 'status', 'statusCounts'));
    }

    
    public function create(Request $request)
    {
        $categories = ServiceCategory::where('status', 'active')
            ->with(['activeServices'])
            ->get();

        $kiloanServices = Service::where('status', 'active')
            ->whereRaw('LOWER(unit) = ?', ['kg'])
            ->with('category')
            ->get();

        $satuanServices = Service::where('status', 'active')
            ->whereRaw('LOWER(unit) != ?', ['kg'])
            ->with('category')
            ->get();

        $packages = Package::where('status', 'active')
            ->with('services')
            ->get();

        $selectedServiceId = $request->input('service_id');
        $selectedPackageId = $request->input('package_id');

        // Determine default active tab: 'kiloan', 'satuan', or 'package'
        $defaultType = 'kiloan';
        if ($selectedPackageId) {
            $defaultType = 'package';
        } elseif ($selectedServiceId) {
            $service = Service::find($selectedServiceId);
            if ($service && strtolower($service->unit) !== 'kg') {
                $defaultType = 'satuan';
            }
        }

        return view('user.orders.create', compact(
            'categories',
            'kiloanServices',
            'satuanServices',
            'packages',
            'selectedServiceId',
            'selectedPackageId',
            'defaultType'
        ));
    }

    /**
     * Store new customer order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_type' => ['required', 'in:kiloan,satuan,package,service'],
            'service_id' => ['required_if:item_type,kiloan,satuan,service', 'nullable', 'exists:servies,id'],
            'package_id' => ['required_if:item_type,package', 'nullable', 'exists:packages,id'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'whatsapp_number' => ['required', 'string', 'regex:/^[0-9]{8,20}$/'],
            'pickup_address' => ['required', 'string', 'min:5'],
            'has_valuable_items' => ['required', 'boolean'],
            'has_color_bleeding_risk' => ['required', 'boolean'],
            'customer_note' => ['nullable', 'string', 'max:500'],
        ], [
            'item_type.required' => 'Silakan tentukan jenis layanan (Paket Bundling, Layanan Satuan, atau Layanan Kiloan).',
            'service_id.required_if' => 'Silakan pilih layanan laundry yang diinginkan.',
            'package_id.required_if' => 'Silakan pilih paket laundry yang diinginkan.',
            'recipient_name.required' => 'Nama lengkap pemesan wajib diisi.',
            'pickup_address.required' => 'Alamat penjemputan cucian wajib diisi.',
            'has_valuable_items.required' => 'Silakan jawab apakah terdapat barang berharga.',
            'has_color_bleeding_risk.required' => 'Silakan jawab apakah terdapat bahan atau warna yang mudah luntur.',
            'whatsapp_number.required' => 'Nomor WhatsApp / telepon aktif wajib diisi.',
            'whatsapp_number.regex' => 'Nomor telepon hanya boleh berisi angka 0–9 (minimal 8 digit, tanpa huruf atau simbol).',
        ]);

        return DB::transaction(function () use ($validated) {
            $user = Auth::user();

            // Update user's phone if changed
            if ($validated['whatsapp_number'] && $user->phone !== $validated['whatsapp_number']) {
                $user->update(['phone' => $validated['whatsapp_number']]);
            }

            // Generate unique Order Code: WSH-YYYYMMDD-XXX
            $today = Carbon::now()->format('Ymd');
            $countToday = Order::where('order_code', 'like', 'WSH-'.$today.'-%')->count() + 1;
            do {
                $orderCode = 'WSH-'.$today.'-'.str_pad((string) $countToday, 3, '0', STR_PAD_LEFT);
                $countToday++;
            } while (Order::where('order_code', $orderCode)->exists());

            // Create Order with pending status (weight & final price are left null for Admin to verify)
            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => $user->id,
                'pickup_address' => $validated['pickup_address'],
                'has_valuable_items' => $validated['has_valuable_items'],
                'has_color_bleeding_risk' => $validated['has_color_bleeding_risk'],
                'customer_note' => $validated['customer_note'] ?? null,
                'total_weight' => null,
                'total_price' => null,
                'estimated_completed_at' => null,
                'status' => 'pending',
                'confirmed_at' => null,
                'confirmed_by' => null,
            ]);

            // Attach Order Item
            if ($validated['item_type'] === 'package') {
                $package = Package::findOrFail($validated['package_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => 'package',
                    'service_id' => null,
                    'package_id' => $package->id,
                    'item_name' => $package->name,
                    'unit' => 'paket',
                    'quantity' => 1,
                    'unit_price' => $package->price,
                    'subtotal' => $package->price,
                    'notes' => 'Paket Bundling: '.$package->name,
                ]);
            } else {
                $service = Service::findOrFail($validated['service_id']);
                $isKiloan = strtolower($service->unit) === 'kg';
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => 'service',
                    'service_id' => $service->id,
                    'package_id' => null,
                    'item_name' => $service->name,
                    'unit' => $service->unit,
                    'quantity' => 1,
                    'unit_price' => $service->price,
                    'subtotal' => $isKiloan ? 0 : $service->price,
                    'notes' => $isKiloan
                        ? 'Layanan Kiloan - Menunggu penimbangan admin ('.$service->service_type.')'
                        : 'Layanan Satuan ('.$service->service_type.')',
                ]);
            }

            // Create Order Status History
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'note' => 'Pesanan berhasil dibuat oleh pelanggan. Kurir/Admin akan segera menjemput & menimbang laundry.',
                'changed_by' => $user->id,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->route('user.orders.success', $order)
                ->with('success', 'Pesanan berhasil dibuat dengan kode #'.$order->order_code.'! Admin akan segera menimbang dan mengonfirmasi total biaya.');
        });
    }

    /**
     * Show success page after order is created
     */
    public function success(Order $order)
    {
        // Authorize customer
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['items.service', 'items.package', 'statusHistories.user']);

        return view('user.orders.success', compact('order'));
    }

    /**
     * Show detail order page for customer
     */
    public function show(Order $order)
    {
        // Authorize customer
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['items.service', 'items.package', 'statusHistories.user', 'confirmedBy', 'review']);

        return view('user.orders.show', compact('order'));
    }

    /**
     * Submit review / testimonial for completed order
     */
    public function storeReview(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Testimoni hanya dapat diberikan setelah pesanan selesai.');
        }

        if ($order->review()->exists()) {
            return back()->with('error', 'Anda sudah memberikan testimoni untuk pesanan ini.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'rating.required' => 'Silakan pilih rating bintang.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Tuliskan ulasan atau testimoni Anda.',
            'comment.min' => 'Ulasan minimal 5 karakter.',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'customer_name' => Auth::user()->name,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_published' => true, // Langsung dipublikasikan ke halaman beranda tanpa menunggu persetujuan admin
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda! Testimoni Anda telah berhasil dikirim dan kini tampil di halaman beranda.');
    }

    /**
     * Submit review / testimonial from customer dashboard
     */
    public function storeDashboardReview(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'order_id.exists' => 'Pesanan tidak ditemukan.',
            'rating.required' => 'Silakan pilih rating bintang 1–5.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Isi ulasan atau pengalaman Anda wajib diisi.',
            'comment.min' => 'Ulasan minimal 5 karakter.',
        ]);

        $order = null;
        if (! empty($validated['order_id'])) {
            $order = Order::findOrFail($validated['order_id']);

            if ($order->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
            }

            if ($order->review()->exists()) {
                return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
            }
        }

        Review::create([
            'user_id' => Auth::id(),
            'order_id' => $order?->id,
            'customer_name' => Auth::user()->name,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_published' => true, // Langsung tampil di beranda
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda! Testimoni Anda telah berhasil dikirim dan kini tampil di halaman beranda.');
    }

    /**
     * Cancel pending order
     */
    public function cancel(Order $order, Request $request)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan yang sudah dikonfirmasi atau sedang diproses tidak dapat dibatalkan secara mandiri.');
        }

        $reason = $request->input('reason', 'Dibatalkan oleh pelanggan');

        DB::transaction(function () use ($order, $reason) {
            $order->update([
                'status' => 'cancelled',
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'cancelled',
                'note' => 'Pesanan dibatalkan oleh pelanggan. Alasan: '.$reason,
                'changed_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);
        });

        return back()->with('info', 'Pesanan #'.$order->order_code.' berhasil dibatalkan.');
    }
}
