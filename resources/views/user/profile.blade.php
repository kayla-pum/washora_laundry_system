@extends('layouts.user')

@section('title', 'Profil Pengguna - Washora')

@section('user-content')
<div class="max-w-3xl mx-auto space-y-8">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Profil</h1>
        <p class="text-xs sm:text-sm text-slate-500">Kelola informasi data pribadi dan kata sandi akun Anda.</p>
    </div>

    <!-- 1. Profile Information -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-brand-600 text-white font-extrabold text-xl flex items-center justify-center shadow-md shadow-brand-600/20">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">{{ $user->name }}</h2>
                <span class="px-2.5 py-0.5 rounded-full bg-cyan-50 text-cyan-700 text-xs font-semibold border border-cyan-200">
                    Pelanggan Terdaftar
                </span>
            </div>
        </div>

        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('email')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp</label>
                <input type="text" id="phone" name="phone" required value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('phone')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Change Password -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Ubah Kata Sandi</h2>
            <p class="text-xs text-slate-400 mt-0.5">Pastikan menggunakan kombinasi kata sandi yang aman.</p>
        </div>

        <form action="{{ route('user.password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Saat Ini</label>
                <div class="relative flex items-center">
                    <input type="password" id="current_password" name="current_password" required placeholder="••••••••" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('current_password', 'current-password-eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="current-password-eye" class="fa-solid fa-eye text-sm leading-none"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Baru</label>
                <div class="relative flex items-center">
                    <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('password', 'new-password-eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="new-password-eye" class="fa-solid fa-eye text-sm leading-none"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ulangi Kata Sandi Baru</label>
                <div class="relative flex items-center">
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ketik ulang kata sandi baru" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'confirm-password-eye')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="confirm-password-eye" class="fa-solid fa-eye text-sm leading-none"></i>
                    </button>
                </div>
            </div>

            <div class="pt-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all shadow-xs">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
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
