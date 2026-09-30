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
</div>
@endsection
