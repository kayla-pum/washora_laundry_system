<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('user.login')->with('warning', 'Silakan login terlebih dahulu untuk mengakses dashboard pelanggan.');
        }

        if (! Auth::user()->isUser()) {
            return redirect()->route('admin.dashboard')->with('info', 'Anda login sebagai Administrator.');
        }

        return $next($request);
    }
}
