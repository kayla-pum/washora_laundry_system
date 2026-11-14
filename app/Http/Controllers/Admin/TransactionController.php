<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', 'all');
        $period = $request->input('period', 'all');

        $query = Order::with(['user', 'items', 'confirmedBy'])
            ->whereNotNull('total_price')
            ->where('status', '!=', 'cancelled')
            ->latest();

        if ($period !== 'all' && $period !== '') {
            $startDate = match ($period) {
                'today' => Carbon::today(),
                '7days' => Carbon::now()->subDays(6)->startOfDay(),
                '3months' => Carbon::now()->subMonths(3)->startOfDay(),
                '7months', '6months' => Carbon::now()->subMonths(7)->startOfDay(),
                '1year' => Carbon::now()->subYear()->startOfDay(),
                default => Carbon::now()->subMonth()->startOfDay(),
            };
            $query->where('created_at', '>=', $startDate);
        }

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

        return view('admin.transactions.index', compact('transactions', 'search', 'status', 'period', 'totalRevenue', 'completedRevenue', 'pendingRevenue'));
    }

    public function printInvoice(Order $order)
    {
        $order->load(['user', 'items', 'confirmedBy']);

        return view('admin.transactions.invoice', compact('order'));
    }

    /**
     * Export transaction recap report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $period = $request->input('period', '1month');
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $periodLabel = 'Harian (Hari Ini, '.$now->translatedFormat('d F Y').')';
                break;
            case '7days':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $periodLabel = 'Mingguan (7 Hari Terakhir)';
                break;
            case '3months':
                $startDate = Carbon::now()->subMonths(3)->startOfDay();
                $periodLabel = '3 Bulan Terakhir';
                break;
            case '7months':
            case '6months':
                $period = '7months';
                $startDate = Carbon::now()->subMonths(7)->startOfDay();
                $periodLabel = '7 Bulan Terakhir';
                break;
            case '1year':
                $startDate = Carbon::now()->subYear()->startOfDay();
                $periodLabel = 'Tahunan (1 Tahun Terakhir)';
                break;
            case '1month':
            default:
                $period = '1month';
                $startDate = Carbon::now()->subMonth()->startOfDay();
                $periodLabel = 'Bulanan (1 Bulan Terakhir)';
                break;
        }

        $query = Order::with(['user', 'items.service', 'items.package'])
            ->where('created_at', '>=', $startDate)
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('total_price');

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->get();

        $totalRevenue = $orders->sum('total_price') ?? 0;
        $totalOrdersCount = $orders->count();
        $totalWeight = $orders->sum('total_weight') ?? 0;

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'orders',
            'period',
            'periodLabel',
            'totalRevenue',
            'totalOrdersCount',
            'totalWeight'
        ))->setPaper('a4', 'portrait');

        $filename = 'Rekap-Transaksi-Washora-'.$period.'-'.date('YmdHis').'.pdf';

        return $pdf->download($filename);
    }
}
