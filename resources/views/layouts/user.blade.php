@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-slate-50/80">
    <!-- Top Customer Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand & Role Badge -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-cyan-400 text-white flex items-center justify-center shadow-md shadow-brand-500/20">
                            <i class="fa-solid fa-shirt text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-slate-900 tracking-tight">Washora</span>
                    </a>
                    <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 bg-cyan-50 text-cyan-700 border border-cyan-200/80 rounded-full text-xs font-semibold">
                        <i class="fa-solid fa-user text-[10px]"></i>
                        Portal Pelanggan
                    </span>
                </div>

                <!-- Navigation Links for Customer -->
                <nav class="hidden md:flex items-center gap-1 text-sm font-semibold">
                    <a href="{{ route('user.dashboard') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('user.dashboard') ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-house text-xs"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('user.orders.index') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('user.orders.*') && !request()->routeIs('user.orders.create') ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }} transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-box-archive text-xs"></i>
                        Pesanan Saya
                    </a>
                    <a href="{{ route('user.orders.create') }}" class="px-3.5 py-2 rounded-xl {{ request()->routeIs('user.orders.create') ? 'bg-brand-600 text-white shadow-sm' : 'bg-brand-50 text-brand-700 hover:bg-brand-100' }} font-bold transition-all flex items-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i>
                        Pesan Laundry
                    </a>
                </nav>

                <!-- Right: Profile Dropdown & Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.orders.create') }}" class="md:hidden px-3 py-1.5 rounded-lg bg-brand-600 text-white text-xs font-bold flex items-center gap-1">
                        <i class="fa-solid fa-plus"></i> Pesan
                    </a>

                    <div class="relative group">
                        <button class="flex items-center gap-2.5 p-1.5 pl-3 rounded-full border border-slate-200 hover:border-brand-300 hover:bg-slate-50 transition-all">
                            <span class="text-xs font-semibold text-slate-700 hidden sm:inline-block max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold text-xs flex items-center justify-center border border-brand-200">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 mr-1 hidden sm:inline-block"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 hidden group-hover:block transition-all z-50">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-400 font-medium">Masuk sebagai Pelanggan</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    <i class="fa-solid fa-house text-slate-400 w-4"></i> Dashboard
                                </a>
                                <a href="{{ route('user.orders.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    <i class="fa-solid fa-box-archive text-slate-400 w-4"></i> Riwayat Pesanan
                                </a>
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    <i class="fa-solid fa-user-gear text-slate-400 w-4"></i> Pengaturan Profil
                                </a>
                                <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    <i class="fa-solid fa-globe text-slate-400 w-4"></i> Halaman Publik
                                </a>
                            </div>
                            <div class="pt-1 border-t border-slate-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sub-nav -->
        <div class="md:hidden flex items-center justify-around border-t border-slate-100 bg-slate-50/70 py-2 text-xs font-semibold text-slate-600">
            <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'text-brand-600 font-bold' : '' }}">Dashboard</a>
            <a href="{{ route('user.orders.index') }}" class="{{ request()->routeIs('user.orders.*') && !request()->routeIs('user.orders.create') ? 'text-brand-600 font-bold' : '' }}">Pesanan Saya</a>
            <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'text-brand-600 font-bold' : '' }}">Profil</a>
            <a href="{{ route('home') }}">Beranda</a>
        </div>
    </header>

    <!-- Main Customer Body -->
    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('user-content')
        </div>
    </main>

    <!-- Minimal Customer Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} Washora Smart Laundry - Portal Pelanggan</p>
            <p class="flex items-center gap-1 text-slate-500">
                <i class="fa-solid fa-shield-heart text-cyan-500"></i> Cucian Bersih, Higienis & Terpercaya
            </p>
        </div>
    </footer>
</div>
@endsection
