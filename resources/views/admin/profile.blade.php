@extends('layouts.admin')

@section('title', 'Profil Administrator - Washora')
@section('page-title', 'Pengaturan Profil Admin')

@section('admin-content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white font-extrabold text-xl flex items-center justify-center shadow-md">
                {{ strtoupper(substr($admin->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">{{ $admin->name }}</h2>
                <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 text-xs font-bold border border-purple-200">
                    Administrator Master
                </span>
            </div>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Administrator</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $admin->name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Email Administrator</label>
                <input type="email" id="email" name="email" required value="{{ old('email', $admin->email) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('email')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Kontak / WhatsApp Petugas</label>
                <input type="text" id="phone" name="phone" required value="{{ old('phone', $admin->phone) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('phone')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Ubah Kata Sandi Administrator</h2>
            <p class="text-xs text-slate-400 mt-0.5">Perbarui kata sandi akun untuk menjaga keamanan akses dashboard.</p>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label for="admin_current_password" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <input type="password" id="admin_current_password" name="current_password" required placeholder="••••••••" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('admin_current_password', 'admin-current-eye')" class="absolute right-3.5 top-2.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="admin-current-eye" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_password" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" id="admin_password" name="password" required placeholder="Minimal 6 karakter" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('admin_password', 'admin-new-eye')" class="absolute right-3.5 top-2.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="admin-new-eye" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="admin_password_confirmation" class="block font-bold text-slate-700 uppercase tracking-wider mb-1">Ulangi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" id="admin_password_confirmation" name="password_confirmation" required placeholder="Ketik ulang kata sandi baru" class="w-full pl-4 pr-11 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    <button type="button" onclick="togglePasswordVisibility('admin_password_confirmation', 'admin-confirm-eye')" class="absolute right-3.5 top-2.5 text-slate-400 hover:text-slate-600 transition-colors focus:outline-none" title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan / Sembunyikan Kata Sandi">
                        <i id="admin-confirm-eye" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="pt-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all shadow-xs">
                    Perbarui Kata Sandi Admin
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
