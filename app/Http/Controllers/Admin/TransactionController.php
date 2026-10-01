<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', 'all');

        $query = Order::with(['user', 'items', 'confirmedBy'])
            ->whereNotNull('total_price')
            ->where('status', '!=', 'cancelled')
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $transactions = $query->paginate(12)->withQueryString();

        $totalRevenue = Order::whereNotNull('total_price')->where('status', '!=', 'cancelled')->sum('total_price');
        $completedRevenue = Order::where('status', 'completed')->sum('total_price');
        $pendingRevenue = Order::whereIn('status', ['confirmed', 'processing', 'washing', 'finishing', 'ready'])->sum('total_price');

        return view('admin.transactions.index', compact('transactions', 'search', 'status', 'totalRevenue', 'completedRevenue', 'pendingRevenue'));
    }

    public function printInvoice(Order $order)
    {
        $order->load(['user', 'items', 'confirmedBy']);

        return view('admin.transactions.invoice', compact('order'));
    }
}
