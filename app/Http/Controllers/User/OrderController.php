<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Package;
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
            ->with(['items', 'statusHistories'])
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

    /**
     * Show form to create a new laundry order
     */
    public function create(Request $request)
    {
        $categories = ServiceCategory::where('status', 'active')
            ->with(['activeServices'])
            ->get();

        $packages = Package::where('status', 'active')
            ->with('services')
            ->get();

        $selectedServiceId = $request->input('service_id');
        $selectedPackageId = $request->input('package_id');

        return view('user.orders.create', compact('categories', 'packages', 'selectedServiceId', 'selectedPackageId'));
    }

    /**
     * Store new customer order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_type' => ['required', 'in:service,package'],
            'service_id' => ['required_if:item_type,service', 'nullable', 'exists:servies,id'],
            'package_id' => ['required_if:item_type,package', 'nullable', 'exists:packages,id'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'pickup_address' => ['required', 'string', 'min:5'],
            'customer_note' => ['nullable', 'string', 'max:500'],
        ], [
            'item_type.required' => 'Silakan pilih jenis pesanan (Layanan atau Paket).',
            'service_id.required_if' => 'Silakan pilih layanan laundry yang diinginkan.',
            'package_id.required_if' => 'Silakan pilih paket laundry yang diinginkan.',
            'pickup_address.required' => 'Alamat penjemputan wajib diisi.',
            'whatsapp_number.required' => 'Nomor WhatsApp aktif wajib diisi.',
        ]);

        return DB::transaction(function () use ($validated) {
            $user = Auth::user();

            // Update user's phone if changed
            if ($validated['whatsapp_number'] && $user->phone !== $validated['whatsapp_number']) {
                $user->update(['phone' => $validated['whatsapp_number']]);
            }

            // Generate unique Order Code: WSH-YYYYMMDD-XXX
            $today = Carbon::now()->format('Ymd');
            $countToday = Order::whereDate('created_at', Carbon::today())->count() + 1;
            $orderCode = 'WSH-'.$today.'-'.str_pad($countToday, 3, '0', STR_PAD_LEFT);

            // Create Order with pending status (weight & final price are left null for Admin to verify)
            $order = Order::create([
                'order_code' => $orderCode,
                'user_id' => $user->id,
                'pickup_address' => $validated['pickup_address'],
                'customer_note' => $validated['customer_note'] ?? null,
                'total_weight' => null,
                'total_price' => null,
                'estimated_completed_at' => null,
                'status' => 'pending',
                'confirmed_at' => null,
                'confirmed_by' => null,
            ]);

            // Attach Order Item
            if ($validated['item_type'] === 'service') {
                $service = Service::findOrFail($validated['service_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => 'service',
                    'service_id' => $service->id,
                    'package_id' => null,
                    'item_name' => $service->name,
                    'unit' => $service->unit,
                    'quantity' => 1,
                    'unit_price' => $service->price,
                    'subtotal' => 0, // Akan dihitung admin setelah ditimbang
                    'notes' => 'Menunggu penimbangan admin ('.$service->service_type.')',
                ]);
            } else {
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
                    'notes' => 'Paket: '.$package->name,
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

            return redirect()->route('user.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat dengan kode #'.$order->order_code.'! Admin akan segera menimbang dan mengonfirmasi total biaya.');
        });
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

        $order->load(['items.service', 'items.package', 'statusHistories.user', 'confirmedBy']);

        return view('user.orders.show', compact('order'));
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
