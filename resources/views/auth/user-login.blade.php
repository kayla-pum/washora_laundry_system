@extends('layouts.app')

@section('title', 'Masuk Akun Pelanggan - Washora')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-brand-50 via-white to-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-4 group">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-brand-600 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-brand-500/25 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-shirt text-xl"></i>
            </div>
            <span class="text-3xl font-extrabold text-slate-900 tracking-tight">Washora</span>
        </a>

        <!-- Role Pill Indicator -->
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 text-cyan-700 border border-cyan-200 text-xs font-bold mb-2">
            <i class="fa-solid fa-user text-[10px]"></i>
            <span>Portal Masuk Pelanggan (Customer)</span>
        </div>

        <h2 class="text-xl font-bold text-slate-900">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola dan memantau cucian Anda secara realtime</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-3xl shadow-xl shadow-slate-200/80 border border-slate-200/80 space-y-6">
            <!-- Quick Demo Credentials Box -->
            <div class="p-3.5 bg-brand-50/70 border border-brand-200 rounded-2xl flex items-center justify-between">
                <div class="text-xs">
                    <p class="font-bold text-brand-900">Demo Akun Pelanggan:</p>
                    <p class="text-brand-700 font-mono text-[11px]">user@washora.com / password</p>
                </div>
                <button type="button" onclick="fillDemoCustomer()" class="px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-[11px] font-bold shadow-xs transition-colors">
                    Pakai Demo
                </button>
            </div>

            <!-- Login Form -->
            <form action="{{ route('user.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('email') border-rose-400 bg-rose-50/30 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg shadow-brand-600/25 hover:shadow-brand-600/35 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-xs"></i>
                    <span>Masuk ke Akun Pelanggan</span>
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center pt-2 text-xs text-slate-600">
                Belum memiliki akun?
                <a href="{{ route('user.register') }}" class="font-bold text-brand-600 hover:text-brand-700 hover:underline">
                    Daftar Akun Baru Sekarang
                </a>
            </div>

            <!-- Distinct Admin Portal Switcher Button -->
            <div class="pt-4 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-400 mb-2">Apakah Anda Administrator / Petugas Laundry?</p>
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                    <i class="fa-solid fa-shield-halved text-cyan-400 text-xs"></i>
                    <span>Masuk ke Portal Administrator (Admin)</span>
                </a>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                Kembali ke Beranda Utama
            </a>
        </div>
    </div>
</div>

<script>
    function fillDemoCustomer() {
        document.getElementById('email').value = 'user@washora.com';
        document.getElementById('password').value = 'password';
    }
</script>
@endsection
