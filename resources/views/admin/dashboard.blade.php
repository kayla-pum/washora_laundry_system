@extends('layouts.admin')

@section('title', 'Admin Dashboard - Washora')
@section('page-title', 'Dashboard Administrator')

@section('admin-content')
<div class="space-y-8">
    <!-- 4 Stats Cards Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Pending Verification Orders -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Perlu Ditimbang</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['pending_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 font-semibold">Pesanan Baru (Pending)</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
            </div>
            @if($stats['pending_orders'] > 0)
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center justify-between">
                    <span>Verifikasi Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            @endif
        </div>

        <!-- 2. Processing Orders -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Sedang Dicuci</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['processing_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 font-semibold">Proses di Outlet</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-water"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'washing']) }}" class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-cyan-700 hover:text-cyan-800 flex items-center justify-between">
                <span>Lihat Antrean Cuci</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 3. Ready Orders -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Siap Diambil</p>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $stats['ready_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 font-semibold">Selesai Siap Kirim</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-check"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'ready']) }}" class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center justify-between">
                <span>Kelola Pengambilan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 4. Month Revenue -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs relative overflow-hidden group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Omset Bulan Ini</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($stats['month_revenue'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 font-semibold">Hari ini: Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-xl shadow-xs group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="mt-4 pt-3 border-t border-slate-100 text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center justify-between">
                <span>Buka Laporan Keuangan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>

    <!-- Priority Queue: Pending Orders Verification -->
    @if($pendingOrders->count() > 0)
        <div class="bg-gradient-to-r from-amber-50 via-white to-amber-50/50 rounded-3xl p-6 border border-amber-200 shadow-xs space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-bell animate-bounce"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Antrean Verifikasi Berat Laundry Masuk</h2>
                        <p class="text-xs text-amber-800">Ada {{ $pendingOrders->count() }} pesanan baru yang membutuhkan penimbangan dan penentuan estimasi selesai.</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs transition-colors">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
                @foreach($pendingOrders as $pOrder)
                    <div class="bg-white p-4 rounded-2xl border border-amber-200/80 shadow-xs flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-slate-900">#{{ $pOrder->order_code }}</span>
                                <span class="text-[10px] text-slate-400">{{ $pOrder->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs font-extrabold text-slate-800 mt-1">{{ $pOrder->user->name }}</p>
                            <p class="text-[11px] text-slate-500">{{ $pOrder->items->first()->item_name ?? 'Layanan' }}</p>
                            <p class="text-[11px] text-slate-400 truncate mt-1">📍 {{ $pOrder->pickup_address }}</p>
                        </div>
                        <a href="{{ route('admin.orders.show', $pOrder) }}" class="w-full py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-xl text-xs font-extrabold text-center block transition-colors">
                            Timbang & Konfirmasi
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Daftar Pesanan Laundry Terbaru</h2>
                <p class="text-xs text-slate-400">Kelola dan update status pengerjaan secara berkala</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                Kelola Semua Pesanan &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Kode Pesanan</th>
                        <th class="py-3.5 px-6">Pelanggan & Kontak</th>
                        <th class="py-3.5 px-6">Layanan</th>
                        <th class="py-3.5 px-6">Berat / Qty</th>
                        <th class="py-3.5 px-6">Total Harga</th>
                        <th class="py-3.5 px-6">Status Pengerjaan</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentOrders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                                #{{ $order->order_code }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $order->user->phone ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-medium">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 font-semibold">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Belum Ditimbang' }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-bold transition-all text-[11px] inline-block">
                                    Detail / Update
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
