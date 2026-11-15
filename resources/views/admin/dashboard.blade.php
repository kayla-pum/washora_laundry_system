@extends('layouts.admin')

@section('title', 'Admin Dashboard - Washora')
@section('page-title', 'Dashboard Administrator')

@section('admin-content')
<div class="space-y-6">
    <!-- 4 Key Metrics Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Pending Verification Orders -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-amber-700 uppercase tracking-wider">Perlu Ditimbang</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['pending_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Pesanan Masuk (Pending)</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
            </div>
            @if($stats['pending_orders'] > 0)
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="pt-2.5 border-t border-slate-100 text-xs font-semibold text-amber-700 hover:text-amber-800 flex items-center justify-between">
                    <span>Verifikasi Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            @else
                <div class="pt-2.5 border-t border-slate-100 text-xs text-slate-400">
                    Semua pesanan terverifikasi
                </div>
            @endif
        </div>

        <!-- 2. Processing Orders -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-brand-700 uppercase tracking-wider">Sedang Dicuci</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['processing_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Proses Pengerjaan</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-water"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'washing']) }}" class="pt-2.5 border-t border-slate-100 text-xs font-semibold text-brand-700 hover:text-brand-800 flex items-center justify-between">
                <span>Lihat Antrean Cuci</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 3. Ready Orders -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wider">Siap Diambil/Antar</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ $stats['ready_orders'] }}</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Selesai Siap Kirim</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-box-check"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'ready']) }}" class="pt-2.5 border-t border-slate-100 text-xs font-semibold text-emerald-700 hover:text-emerald-800 flex items-center justify-between">
                <span>Kelola Pengantaran</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 4. Month Revenue -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Omset Bulan Ini</p>
                    <h3 class="text-xl font-bold text-slate-900 mt-0.5">Rp {{ number_format($stats['month_revenue'], 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">Hari ini: Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center text-base shrink-0">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="pt-2.5 border-t border-slate-100 text-xs font-semibold text-brand-700 hover:text-brand-800 flex items-center justify-between">
                <span>Laporan Keuangan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>

    <!-- Priority Queue: Pending Orders Verification -->
    @if($pendingOrders->count() > 0)
        <div class="bg-amber-50/60 rounded-xl p-5 border border-amber-200 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm font-semibold shrink-0">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900">Antrean Verifikasi Penimbangan Laundry</h2>
                        <p class="text-xs text-amber-900">Ada {{ $pendingOrders->count() }} pesanan baru yang membutuhkan penimbangan dan penentuan biaya di outlet.</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold text-xs transition-colors shrink-0">
                    Lihat Semua ({{ $pendingOrders->count() }})
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 pt-1">
                @foreach($pendingOrders as $pOrder)
                    <div class="bg-white p-4 rounded-lg border border-amber-200 shadow-2xs flex flex-col justify-between space-y-3">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-900 font-mono">#{{ $pOrder->order_code }}</span>
                                <span class="text-[10px] text-slate-400">{{ $pOrder->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs font-semibold text-slate-800">{{ $pOrder->user->name }}</p>
                            <p class="text-[11px] text-slate-500">{{ $pOrder->items->first()->item_name ?? 'Layanan' }}</p>
                            <p class="text-[11px] text-slate-400 truncate">📍 {{ $pOrder->pickup_address }}</p>
                        </div>
                        <a href="{{ route('admin.orders.show', $pOrder) }}" class="w-full py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-md text-xs font-semibold text-center block transition-colors">
                            Timbang & Konfirmasi
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Pesanan Laundry Terbaru</h2>
                <p class="text-xs text-slate-500">Kelola dan update status pengerjaan secara berkala</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition-colors">
                Kelola Semua Pesanan &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-5">Kode Pesanan</th>
                        <th class="py-3 px-5">Pelanggan & Kontak</th>
                        <th class="py-3 px-5">Layanan</th>
                        <th class="py-3 px-5">Berat / Qty</th>
                        <th class="py-3 px-5">Total Biaya</th>
                        <th class="py-3 px-5">Status</th>
                        <th class="py-3 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentOrders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-5 font-semibold text-slate-900 font-mono">
                                #{{ $order->order_code }}
                            </td>
                            <td class="py-3.5 px-5">
                                <p class="font-semibold text-slate-900">{{ $order->user->name }}</p>
                                <p class="text-[11px] text-slate-500">{{ $order->user->phone ?? '-' }}</p>
                            </td>
                            <td class="py-3.5 px-5 font-medium">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 font-semibold text-slate-800">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Belum Ditimbang' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right space-x-1">
                                <a href="{{ route('admin.orders.show', $order) }}" class="px-2.5 py-1.5 rounded-md bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-semibold transition-colors text-[11px] inline-block">
                                    Detail / Update
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
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
