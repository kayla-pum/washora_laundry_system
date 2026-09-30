<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ServiceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', '1month'); // 'today', '7days', '1month', '3months', '6months', '1year'

        $now = Carbon::now();

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $periodLabel = 'Hari Ini ('.$now->translatedFormat('d F Y').')';
                break;
            case '7days':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $periodLabel = '7 Hari Terakhir';
                break;
            case '3months':
                $startDate = Carbon::now()->subMonths(3)->startOfDay();
                $periodLabel = '3 Bulan Terakhir';
                break;
            case '6months':
                $startDate = Carbon::now()->subMonths(6)->startOfDay();
                $periodLabel = '6 Bulan Terakhir';
                break;
            case '1year':
                $startDate = Carbon::now()->subYear()->startOfDay();
                $periodLabel = '1 Tahun Terakhir';
                break;
            case '1month':
            default:
                $period = '1month';
                $startDate = Carbon::now()->subMonth()->startOfDay();
                $periodLabel = '1 Bulan Terakhir (30 Hari)';
                break;
        }

        $orders = Order::with(['user', 'items'])
            ->where('created_at', '>=', $startDate)
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_price') ?? 0;
        $totalOrdersCount = $orders->count();
        $completedOrdersCount = $orders->where('status', 'completed')->count();
        $totalWeight = $orders->sum('total_weight') ?? 0;
        $averageOrderValue = $totalOrdersCount > 0 ? round($totalRevenue / $totalOrdersCount) : 0;

        // Group by category summary
        $categoryBreakdown = ServiceCategory::with(['services.orderItems' => function ($q) use ($startDate) {
            $q->whereHas('order', function ($oq) use ($startDate) {
                $oq->where('created_at', '>=', $startDate)->where('status', '!=', 'cancelled');
            });
        }])->get()->map(function ($cat) {
            $totalSubtotal = 0;
            $totalQty = 0;
            foreach ($cat->services as $svc) {
                foreach ($svc->orderItems as $item) {
                    $totalSubtotal += $item->subtotal;
                    $totalQty += $item->quantity;
                }
            }

            return [
                'name' => $cat->name,
                'total_revenue' => $totalSubtotal,
                'total_qty' => $totalQty,
            ];
        });

        // Group by day for chart
        $dailyData = Order::where('created_at', '>=', $startDate)
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as daily_revenue'),
                DB::raw('COUNT(*) as daily_orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.reports.index', compact(
            'period',
            'periodLabel',
            'orders',
            'totalRevenue',
            'totalOrdersCount',
            'completedOrdersCount',
            'totalWeight',
            'averageOrderValue',
            'categoryBreakdown',
            'dailyData'
        ));
    }

    public function print(Request $request)
    {
        $period = $request->input('period', '1month');

        switch ($period) {
            case 'today':
                $startDate = Carbon::today();
                $periodLabel = 'Hari Ini';
                break;
            case '7days':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $periodLabel = '7 Hari Terakhir';
                break;
            case '3months':
                $startDate = Carbon::now()->subMonths(3)->startOfDay();
                $periodLabel = '3 Bulan Terakhir';
                break;
            case '6months':
                $startDate = Carbon::now()->subMonths(6)->startOfDay();
                $periodLabel = '6 Bulan Terakhir';
                break;
            case '1year':
                $startDate = Carbon::now()->subYear()->startOfDay();
                $periodLabel = '1 Tahun Terakhir';
                break;
            case '1month':
            default:
                $startDate = Carbon::now()->subMonth()->startOfDay();
                $periodLabel = '1 Bulan Terakhir';
                break;
        }

        $orders = Order::with(['user', 'items'])
            ->where('created_at', '>=', $startDate)
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_price') ?? 0;
        $totalOrdersCount = $orders->count();
        $totalWeight = $orders->sum('total_weight') ?? 0;

        return view('admin.reports.print', compact('orders', 'periodLabel', 'totalRevenue', 'totalOrdersCount', 'totalWeight'));
    }
}
