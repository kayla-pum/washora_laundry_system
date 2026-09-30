<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::where('status', 'active')
            ->with(['activeServices'])
            ->get();

        $featuredServices = Service::where('status', 'active')
            ->with('category')
            ->take(8)
            ->get();

        $packages = Package::where('status', 'active')
            ->with('services')
            ->get();

        $stats = [
            'total_orders' => Order::where('status', '!=', 'cancelled')->count() + 1250,
            'happy_customers' => User::where('role', 'user')->count() + 850,
            'satisfaction_rate' => '99.4%',
            'turnaround_speed' => '3-24 Jam',
        ];

        return view('landing.index', compact('categories', 'featuredServices', 'packages', 'stats'));
    }

    public function tracking(Request $request)
    {
        $code = trim($request->input('code', ''));
        $order = null;
        $searched = false;

        if ($code !== '') {
            $searched = true;
            $order = Order::with(['user', 'items', 'statusHistories.user'])
                ->where('order_code', $code)
                ->first();
        }

        return view('landing.tracking', compact('order', 'code', 'searched'));
    }

    public function services()
    {
        $categories = ServiceCategory::where('status', 'active')
            ->with(['activeServices'])
            ->get();

        $packages = Package::where('status', 'active')
            ->with('services')
            ->get();

        return view('landing.services', compact('categories', 'packages'));
    }
}
