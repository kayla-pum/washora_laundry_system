@extends('layouts.app')

@section('content')
<div class="min-h-screen flex bg-slate-100/80">
    <!-- Desktop Sidebar -->
    <aside class="hidden lg:flex flex-col w-64 bg-slate-900 text-slate-300 border-r border-slate-800 shrink-0">
        <!-- Sidebar Header -->
        <div class="h-16 flex items-center gap-3 px-6 border-b border-slate-800 bg-slate-950/40">
            <img src="{{ asset('images/washoralogo.png') }}" alt="Logo Washora" class="w-8 h-8 object-contain shrink-0">
            <div>
                <h1 class="text-base font-bold text-white tracking-tight leading-none">Washora</h1>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Admin Panel</span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="flex-1 overflow-y-auto py-5 px-3 space-y-5">
            <!-- Main Section -->
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Operasional</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                @php
                    $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <div class="flex items-center gap-2.5">
                        <i class="fa-solid fa-box-open w-4 text-center"></i>
                        <span>Pesanan Laundry</span>
                    </div>
                    @if($pendingOrdersCount > 0)
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-slate-950">
                            {{ $pendingOrdersCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span>Data Pelanggan</span>
                </a>
            </div>

            <!-- Master Data Section -->
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Katalog & Layanan</p>

                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-jug-detergent w-4 text-center"></i>
                    <span>Daftar Layanan</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-layer-group w-4 text-center"></i>
                    <span>Kategori Layanan</span>
                </a>

                <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.packages.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-boxes-packing w-4 text-center"></i>
                    <span>Paket Hemat</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-star w-4 text-center text-amber-400"></i>
                    <span>Testimoni Pelanggan</span>
                </a>
            </div>

            <!-- Finance & Reports -->
            <div class="space-y-1">
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Keuangan & Analitik</p>

                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.transactions.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-receipt w-4 text-center"></i>
                    <span>Transaksi & Struk</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-medium transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-brand-600 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                    <span>Laporan & Rekap</span>
                </a>
            </div>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center gap-2.5 mb-2.5 px-1">
                <div class="w-8 h-8 rounded-md bg-slate-800 text-brand-400 border border-slate-700 flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">Administrator</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-800">
                <a href="{{ route('admin.profile') }}" title="Pengaturan Profil" class="py-1.5 text-center text-xs font-medium rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-gear text-[11px]"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-1.5 text-center text-xs font-medium rounded-md bg-slate-800 hover:bg-rose-950 hover:text-rose-400 text-slate-300 transition-colors flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-power-off text-[11px]"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Admin Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Admin Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 shrink-0">
            <!-- Left Info -->
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('mobile-admin-drawer').classList.toggle('hidden')" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-none">@yield('page-title', 'Admin Dashboard')</h2>
                    <p class="text-[11px] text-slate-400 mt-1 hidden sm:block">Sistem Manajemen Terpadu Washora Laundry</p>
                </div>
            </div>

            <!-- Right: Quick Portal Links & Time -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-600 hover:text-brand-600 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    Lihat Website
                </a>

                <div class="h-5 w-px bg-slate-200 hidden sm:block"></div>

                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold flex items-center gap-1.5">
                        <i class="fa-solid fa-shield text-[10px] text-brand-600"></i>
                        Admin Mode
                    </span>
                </div>
            </div>
        </header>

        <!-- Admin Content Area -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-slate-100/60">
            @yield('admin-content')
        </main>
    </div>
</div>

<!-- Mobile Admin Drawer -->
<div id="mobile-admin-drawer" class="hidden fixed inset-0 z-50 lg:hidden bg-slate-950/80 backdrop-blur-xs flex">
    <div class="w-72 bg-slate-900 text-slate-300 h-full flex flex-col p-4 shadow-2xl">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-cyan-500 text-white flex items-center justify-center font-bold">W</div>
                <span class="font-extrabold text-white">Washora Admin</span>
            </div>
            <button onclick="document.getElementById('mobile-admin-drawer').classList.add('hidden')" class="p-2 text-slate-400 hover:text-white">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4 space-y-2 text-sm font-semibold">
            <a href="{{ route('admin.dashboard') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Pesanan Masuk</a>
            <a href="{{ route('admin.customers.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Data Pelanggan</a>
            <a href="{{ route('admin.services.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Layanan Laundry</a>
            <a href="{{ route('admin.categories.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Kategori</a>
            <a href="{{ route('admin.packages.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Paket Hemat</a>
            <a href="{{ route('admin.transactions.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Transaksi & Struk</a>
            <a href="{{ route('admin.reports.index') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Laporan & Rekap</a>
            <a href="{{ route('admin.profile') }}" class="block p-2.5 rounded-lg hover:bg-slate-800 text-white">Profil Admin</a>
        </div>
        <div class="pt-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full p-2.5 rounded-lg bg-rose-600 text-white text-xs font-bold text-center">Keluar</button>
            </form>
        </div>
    </div>
</div>
@endsection
