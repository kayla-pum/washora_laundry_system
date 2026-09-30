<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->subDays(6)->startOfDay();

        $stats = [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::whereIn('status', ['confirmed', 'processing', 'washing', 'finishing'])->count(),
            'ready_orders' => Order::where('status', 'ready')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'today_revenue' => Order::whereDate('created_at', $today)->where('status', '!=', 'cancelled')->sum('total_price') ?? 0,
            'month_revenue' => Order::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('status', '!=', 'cancelled')->sum('total_price') ?? 0,
            'total_customers' => User::where('role', 'user')->count(),
            'active_services' => Service::where('status', 'active')->count(),
        ];

        // Recent orders
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(8)
            ->get();

        // Pending verification orders priority queue
        $pendingOrders = Order::with(['user', 'items'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // 7 days chart data
        $chartDates = [];
        $chartRevenue = [];
        $chartOrders = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateLabel = Carbon::now()->subDays($i)->translatedFormat('D, d M');

            $chartDates[] = $dateLabel;
            $chartRevenue[] = Order::whereDate('created_at', $date)->where('status', '!=', 'cancelled')->sum('total_price') ?? 0;
            $chartOrders[] = Order::whereDate('created_at', $date)->where('status', '!=', 'cancelled')->count();
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'pendingOrders', 'chartDates', 'chartRevenue', 'chartOrders'));
    }

    public function profile()
    {
        $admin = auth()->user();

        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,'.$admin->id],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $admin->update($validated);

        return back()->with('success', 'Profil Administrator berhasil diperbarui.');
    }
}
