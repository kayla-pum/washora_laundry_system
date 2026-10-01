<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show Customer Login page
     */
    public function showUserLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        return view('auth.user-login');
    }

    /**
     * Show Customer Register page
     */
    public function showUserRegister()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.user-register');
    }

    /**
     * Handle Customer Login
     */
    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('info', 'Selamat datang kembali, Administrator!');
            }

            return redirect()->intended(route('user.dashboard'))->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Handle Customer Registration
     */
    public function userRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Akun berhasil didaftarkan! Selamat datang di Washora.');
    }

    /**
     * Show Admin Login page
     */
    public function showAdminLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }

        return view('auth.admin-login');
    }

    /**
     * Handle Admin Login
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! Auth::user()->isAdmin()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun Administrator.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Berhasil login ke Portal Administrator Washora.');
        }

        return back()->withErrors([
            'email' => 'Kredensial login admin tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        $isAdmin = Auth::check() && Auth::user()->isAdmin();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect()->route('admin.login')->with('info', 'Anda telah berhasil keluar dari sesi Admin.');
        }

        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar.');
    }
}
