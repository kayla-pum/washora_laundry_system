@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Volume - Washora')
@section('page-title', 'Laporan & Rekapitulasi')

@section('admin-content')
<div class="space-y-6">
    <!-- Header with Period Selector & Print Button -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Rekap Pendapatan & Volume Laundry</h1>
            <p class="text-xs text-slate-400">Periode Aktif: <strong class="text-brand-600 font-bold">{{ $periodLabel }}</strong></p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Period Selector Tabs -->
            <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-2xl text-xs font-bold">
                <a href="{{ route('admin.reports.index', ['period' => 'today']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === 'today' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">Hari Ini</a>
                <a href="{{ route('admin.reports.index', ['period' => '7days']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === '7days' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">7 Hari</a>
                <a href="{{ route('admin.reports.index', ['period' => '1month']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === '1month' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">1 Bulan</a>
                <a href="{{ route('admin.reports.index', ['period' => '3months']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === '3months' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">3 Bulan</a>
                <a href="{{ route('admin.reports.index', ['period' => '6months']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === '6months' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">6 Bulan</a>
                <a href="{{ route('admin.reports.index', ['period' => '1year']) }}" class="px-3 py-1.5 rounded-xl transition-all {{ $period === '1year' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">1 Tahun</a>
            </div>

            <!-- Print Report Button -->
            <a href="{{ route('admin.reports.print', ['period' => $period]) }}" target="_blank" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>

    <!-- 4 Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Omset Periode</p>
            <h3 class="text-2xl font-black text-brand-700 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">{{ $totalOrdersCount }} transaksi tercatat</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rata-rata per Pesanan</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Nilai transaksi rata-rata</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Berat Laundry</p>
            <h3 class="text-2xl font-black text-cyan-600 mt-1">{{ number_format($totalWeight, 1) }} Kg</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Volume cucian diproses</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Selesai</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $completedOrdersCount }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Transaksi sukses</p>
        </div>
    </div>

    <!-- Category Breakdown Grid -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-4">
        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-brand-600"></i>
            <span>Kontribusi Pendapatan per Kategori Layanan</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
            @foreach($categoryBreakdown as $cb)
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-slate-900 text-sm">{{ $cb['name'] }}</h4>
                        <span class="text-[11px] text-slate-500 font-semibold">{{ $cb['total_qty'] }} item/kg</span>
                    </div>
                    <p class="text-lg font-black text-brand-700">Rp {{ number_format($cb['total_revenue'], 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Transactions Recap Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900">Rincian Rekapitulasi Pesanan ({{ $periodLabel }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Kode Pesanan</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Layanan</th>
                        <th class="py-4 px-6">Berat</th>
                        <th class="py-4 px-6">Total Biaya</th>
                        <th class="py-4 px-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($orders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                                #{{ $order->order_code }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-800">
                                {{ $order->user->name }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada data transaksi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
