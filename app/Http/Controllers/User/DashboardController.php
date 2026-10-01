<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items'])
            ->latest()
            ->take(5)
            ->get();

        // Active running order for live tracking banner
        $activeOrder = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'processing', 'washing', 'finishing', 'ready'])
            ->with(['items', 'statusHistories'])
            ->latest()
            ->first();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'active_orders' => Order::where('user_id', $user->id)->whereIn('status', ['pending', 'confirmed', 'processing', 'washing', 'finishing', 'ready'])->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'completed')->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 'completed')->sum('total_price'),
        ];

        $popularServices = Service::where('status', 'active')->take(4)->get();
        $packages = Package::where('status', 'active')->take(2)->get();

        return view('user.dashboard', compact('user', 'recentOrders', 'activeOrder', 'stats', 'popularServices', 'packages'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,'.$user->id],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
            'password.min' => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi Anda berhasil diubah.');
    }
}
