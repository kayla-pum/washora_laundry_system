@extends('layouts.app')

@section('title', 'Portal Administrator - Washora')

@section('content')
<div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Subtle Background Elements -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center relative z-10">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4 group">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500 to-brand-600 text-slate-950 flex items-center justify-center shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform">
                <i class="fa-solid fa-shirt text-xl text-white"></i>
            </div>
            <span class="text-3xl font-extrabold text-white tracking-tight">Washora</span>
        </a>

        <!-- Admin Badge -->
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-slate-900 border border-slate-700 text-cyan-400 text-xs font-bold mb-2 shadow-inner">
            <i class="fa-solid fa-shield-halved text-[11px]"></i>
            <span>Portal Manajemen Administrator</span>
        </div>

        <h2 class="text-xl font-bold text-white">Login Petugas & Administrator</h2>
        <p class="text-xs text-slate-400 mt-1">Area otorisasi khusus pengelolaan pesanan, penimbangan, dan operasional</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 relative z-10">
        <div class="bg-slate-900/90 backdrop-blur-xl py-8 px-6 sm:px-10 rounded-3xl shadow-2xl border border-slate-800 space-y-6">
            <!-- Quick Demo Credentials Box -->
            <div class="p-3.5 bg-slate-800/80 border border-slate-700 rounded-2xl flex items-center justify-between">
                <div class="text-xs">
                    <p class="font-bold text-cyan-400">Akun Demo Administrator:</p>
                    <p class="text-slate-300 font-mono text-[11px]">admin@washora.com / password</p>
                </div>
                <button type="button" onclick="fillDemoAdmin()" class="px-3 py-1.5 bg-cyan-500 hover:bg-cyan-400 text-slate-950 rounded-xl text-[11px] font-bold shadow-xs transition-colors">
                    Pakai Demo
                </button>
            </div>

            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="admin_email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Email Administrator</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-500 text-sm"></i>
                        <input id="admin_email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="admin@washora.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-950/80 border @error('email') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all">
                    </div>
                    @error('email')
                        <p class="text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="admin_password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-500 text-sm"></i>
                        <input id="admin_password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••" class="w-full pl-10 pr-4 py-2.5 bg-slate-950/80 border border-slate-700 rounded-xl text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-cyan-500 to-brand-600 hover:from-cyan-400 hover:to-brand-500 text-slate-950 font-black text-sm shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/30 transition-all flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-shield text-xs"></i>
                    <span>Masuk ke Dashboard Admin</span>
                </button>
            </form>

            <!-- Distinct Customer Portal Switcher Button -->
            <div class="pt-4 border-t border-slate-800 text-center">
                <p class="text-[11px] text-slate-400 mb-2">Bukan Administrator? Masuk sebagai Pelanggan</p>
                <a href="{{ route('user.login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-brand-300 text-xs font-bold border border-slate-700 transition-all">
                    <i class="fa-solid fa-user text-xs"></i>
                    <span>Buka Portal Masuk Pelanggan (User)</span>
                </a>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                Kembali ke Beranda Utama
            </a>
        </div>
    </div>
</div>

<script>
    function fillDemoAdmin() {
        document.getElementById('admin_email').value = 'admin@washora.com';
        document.getElementById('admin_password').value = 'password';
    }
</script>
@endsection
