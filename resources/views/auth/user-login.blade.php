@extends('layouts.app')

@section('title', 'Masuk Akun - Washora')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-brand-50 via-white to-slate-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-4 group">
            <img src="{{ asset('images/washoralogo.png') }}" alt="Washora Logo" class="w-10 h-10 object-contain shink-0">
        <span class="text-3xl font-extrabold text-slate-900 tracking-tight">Washora</span>
    </a>

        <h2 class="text-xl font-bold text-slate-900">Selamat Datang Kembali</h2>
        <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola dan memantau layanan laundry Anda.</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-3xl shadow-xl shadow-slate-200/80 border border-slate-200/80 space-y-6">
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
                    <span>Masuk</span>
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center pt-2 text-xs text-slate-600">
                Belum memiliki akun?
                <a href="{{ route('user.register') }}" class="font-bold text-brand-600 hover:text-brand-700 hover:underline">
                    Daftar Akun Baru Sekarang
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

@endsection
