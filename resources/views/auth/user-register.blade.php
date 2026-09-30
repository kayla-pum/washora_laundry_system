@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - Washora')

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
            <i class="fa-solid fa-user-plus text-[10px]"></i>
            <span>Registrasi Akun Pelanggan Baru</span>
        </div>

        <h2 class="text-xl font-bold text-slate-900">Buat Akun Laundry Anda</h2>
        <p class="text-xs text-slate-500 mt-1">Daftar dalam 1 menit untuk kemudahan pesan & tracking cucian</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 sm:px-10 rounded-3xl shadow-xl shadow-slate-200/80 border border-slate-200/80 space-y-5">
            <form action="{{ route('user.register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="Contoh: Rian Pratama" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('name') border-rose-400 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('email') border-rose-400 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone / WhatsApp -->
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp (Aktif)</label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp absolute left-3.5 top-3.5 text-emerald-500 text-base"></i>
                        <input id="phone" name="phone" type="text" required value="{{ old('phone') }}" placeholder="081234567890" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('phone') border-rose-400 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Digunakan untuk konfirmasi berat & nota WhatsApp.</p>
                    @error('phone')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="password" name="password" type="password" required placeholder="Minimal 6 karakter" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('password') border-rose-400 @else border-slate-200 @enderror rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('password')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ulangi Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock-open absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ketik ulang kata sandi" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow-lg shadow-brand-600/25 hover:shadow-brand-600/35 transition-all flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <div class="text-center pt-2 text-xs text-slate-600">
                Sudah memiliki akun?
                <a href="{{ route('user.login') }}" class="font-bold text-brand-600 hover:text-brand-700 hover:underline">
                    Masuk ke Akun Anda
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
