<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = User::where('role', 'user')
            ->withCount(['orders', 'orders as active_orders_count' => function ($q) {
                $q->whereIn('status', ['pending', 'confirmed', 'processing', 'washing', 'finishing', 'ready']);
            }])
            ->withSum(['orders as total_spent' => function ($q) {
                $q->where('status', 'completed');
            }], 'total_price')
            ->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function show(User $customer)
    {
        if ($customer->isAdmin()) {
            abort(404);
        }

        $customer->load(['orders.items', 'orders.statusHistories']);

        return view('admin.customers.show', compact('customer'));
    }
}
