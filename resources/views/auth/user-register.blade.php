@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - Washora')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-3 group">
            <img src="{{ asset('images/washoralogo.png') }}" alt="Washora Logo" class="w-10 h-10 object-contain shrink-0">
            <span class="text-2xl font-bold text-slate-900 tracking-tight">Washora</span>
        </a>

        <!-- Role Pill Indicator -->
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold mb-2">
            <i class="fa-solid fa-user-plus text-brand-600 text-[10px]"></i>
            <span>Registrasi Akun Pelanggan Baru</span>
        </div>

        <h2 class="text-lg font-bold text-slate-900">Buat Akun Laundry Anda</h2>
        <p class="text-xs text-slate-500 mt-0.5">Daftar untuk kemudahan pemesanan & pelacakan status cucian.</p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-7 px-6 sm:px-8 rounded-xl shadow-xs border border-slate-200 space-y-4">
            <form action="{{ route('user.register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="Contoh: Rian Pratama" class="w-full pl-9 pr-3 py-2 bg-slate-50 border @error('name') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full pl-9 pr-3 py-2 bg-slate-50 border @error('email') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                    </div>
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone / WhatsApp -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp (Aktif)</label>
                    <div class="relative">
                        <i class="fa-brands fa-whatsapp absolute left-3.5 top-3 text-emerald-600 text-sm"></i>
                        <input id="phone" name="phone" type="text" required value="{{ old('phone') }}" placeholder="081234567890" class="w-full pl-9 pr-3 py-2 bg-slate-50 border @error('phone') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Digunakan untuk konfirmasi berat & nota WhatsApp.</p>
                    @error('phone')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                    <div class="relative flex items-center">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input id="password" name="password" type="password" required placeholder="Minimal 6 karakter" class="w-full pl-9 pr-10 py-2 bg-slate-50 border @error('password') border-rose-400 @else border-slate-300 @enderror rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                        <button type="button" onclick="togglePasswordVisibility('password', 'password-eye-icon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                            <i id="password-eye-icon" class="fa-solid fa-eye text-sm leading-none"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Ulangi Kata Sandi</label>
                    <div class="relative flex items-center">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-xs">
                            <i class="fa-solid fa-lock-open"></i>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ketik ulang kata sandi" class="w-full pl-9 pr-10 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'password-confirm-eye-icon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer" title="Tampilkan / Sembunyikan Konfirmasi Kata Sandi" aria-label="Tampilkan / Sembunyikan Konfirmasi Kata Sandi">
                            <i id="password-confirm-eye-icon" class="fa-solid fa-eye text-sm leading-none"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-xs transition-colors flex items-center justify-center gap-2 mt-2">
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

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
