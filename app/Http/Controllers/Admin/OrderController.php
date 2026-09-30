<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Orders listing with search and filter
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = trim($request->input('search', ''));
        $date = $request->input('date', '');

        $query = Order::with(['user', 'items', 'confirmedBy'])->latest();

        if ($status !== 'all' && array_key_exists($status, Order::STATUSES)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhere('pickup_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($date !== '') {
            $query->whereDate('created_at', $date);
        }

        $orders = $query->paginate(12)->withQueryString();

        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'washing' => Order::where('status', 'washing')->count(),
            'finishing' => Order::where('status', 'finishing')->count(),
            'ready' => Order::where('status', 'ready')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'search', 'date', 'statusCounts'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.service', 'items.package', 'statusHistories.user', 'confirmedBy']);
        $allServices = Service::where('status', 'active')->get();

        return view('admin.orders.show', compact('order', 'allServices'));
    }

    /**
     * Confirm pending order: Admin inputs actual weight/qty, calculates subtotal & total, sets estimated completion
     */
    public function confirm(Request $request, Order $order)
    {
        $validated = $request->validate([
            'total_weight' => ['nullable', 'numeric', 'min:0.1'],
            'item_quantities' => ['nullable', 'array'],
            'item_quantities.*' => ['numeric', 'min:0.1'],
            'item_prices' => ['nullable', 'array'],
            'item_prices.*' => ['numeric', 'min:0'],
            'estimated_completed_at' => ['required', 'date'],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ], [
            'estimated_completed_at.required' => 'Estimasi waktu selesai wajib ditentukan.',
        ]);

        return DB::transaction(function () use ($order, $validated) {
            $totalPrice = 0;
            $totalWeight = $validated['total_weight'] ?? 0;

            // Update items if specified
            if (isset($validated['item_quantities'])) {
                foreach ($validated['item_quantities'] as $itemId => $qty) {
                    $item = OrderItem::where('order_id', $order->id)->where('id', $itemId)->first();
                    if ($item) {
                        $unitPrice = $validated['item_prices'][$itemId] ?? $item->unit_price;
                        $subtotal = $qty * $unitPrice;
                        $totalPrice += $subtotal;

                        $item->update([
                            'quantity' => $qty,
                            'unit_price' => $unitPrice,
                            'subtotal' => $subtotal,
                        ]);

                        if ($item->unit === 'kg') {
                            $totalWeight = $qty;
                        }
                    }
                }
            } else {
                // Default calculation if single service
                $firstItem = $order->items->first();
                if ($firstItem) {
                    $qty = $totalWeight > 0 ? $totalWeight : 1;
                    $subtotal = $qty * $firstItem->unit_price;
                    $totalPrice = $subtotal;

                    $firstItem->update([
                        'quantity' => $qty,
                        'subtotal' => $subtotal,
                        'notes' => 'Telah ditimbang admin: '.$qty.' '.$firstItem->unit,
                    ]);
                }
            }

            // Update Order
            $order->update([
                'total_weight' => $totalWeight > 0 ? $totalWeight : null,
                'total_price' => $totalPrice,
                'estimated_completed_at' => Carbon::parse($validated['estimated_completed_at']),
                'status' => 'confirmed',
                'confirmed_at' => Carbon::now(),
                'confirmed_by' => Auth::id(),
            ]);

            // Add Status History
            $note = 'Pesanan dikonfirmasi oleh Admin '.Auth::user()->name.'.';
            if ($totalWeight > 0) {
                $note .= ' Berat: '.$totalWeight.' Kg.';
            }
            $note .= ' Total: Rp '.number_format($totalPrice, 0, ',', '.').'.';
            if (! empty($validated['admin_note'])) {
                $note .= ' Catatan: '.$validated['admin_note'];
            }

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'confirmed',
                'note' => $note,
                'changed_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Pesanan #'.$order->order_code.' berhasil dikonfirmasi! Anda dapat mengirim notifikasi rincian via WhatsApp.')
                ->with('open_whatsapp_modal', true);
        });
    }

    /**
     * Update order progress status (processing, washing, finishing, ready, completed, cancelled)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,washing,finishing,ready,completed,cancelled'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $statusInfo = Order::STATUSES[$validated['status']] ?? ['label' => $validated['status']];
        $defaultNote = 'Status diperbarui menjadi "'.$statusInfo['label'].'" oleh Admin.';

        $note = ! empty($validated['note']) ? $validated['note'] : $defaultNote;

        DB::transaction(function () use ($order, $validated, $note) {
            $order->update([
                'status' => $validated['status'],
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $validated['status'],
                'note' => $note,
                'changed_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);
        });

        return back()->with('success', 'Status pesanan #'.$order->order_code.' berhasil diubah menjadi: '.$statusInfo['label']);
    }
}
