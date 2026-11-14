@extends('layouts.admin')

@section('title', 'Transaksi & Invoice - Washora')
@section('page-title', 'Riwayat Transaksi & Struk Invoice')

@section('admin-content')
<div class="space-y-6">
    <!-- Revenue Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Omset Terkonfirmasi</p>
            <h3 class="text-2xl font-black text-brand-700 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Semua pesanan terhitung</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Pendapatan Selesai (Lunas)</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($completedRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Pesanan status Completed</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-cyan-700 uppercase tracking-wider">Piutang Sedang Berjalan</p>
            <h3 class="text-2xl font-black text-cyan-700 mt-1">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Proses pengerjaan / siap ambil</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Nota & Transaksi</h2>
            <p class="text-xs text-slate-400">Pencarian transaksi, nota pembayaran, dan unduh laporan transaksi resmi.</p>
        </div>

        <form action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kode / nama..." class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            <select name="period" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                <option value="all" {{ ($period ?? 'all') === 'all' ? 'selected' : '' }}>Semua Periode</option>
                <option value="today" {{ ($period ?? '') === 'today' ? 'selected' : '' }}>Harian</option>
                <option value="7days" {{ ($period ?? '') === '7days' ? 'selected' : '' }}>Mingguan</option>
                <option value="1month" {{ ($period ?? '') === '1month' ? 'selected' : '' }}>Bulanan</option>
                <option value="3months" {{ ($period ?? '') === '3months' ? 'selected' : '' }}>3 Bulan</option>
                <option value="7months" {{ ($period ?? '') === '7months' ? 'selected' : '' }}>7 Bulan</option>
                <option value="1year" {{ ($period ?? '') === '1year' ? 'selected' : '' }}>Tahunan</option>
            </select>
            <select name="status" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                <option value="all">Semua Status</option>
                <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="washing" {{ $status === 'washing' ? 'selected' : '' }}>Washing</option>
                <option value="ready" {{ $status === 'ready' ? 'selected' : '' }}>Ready</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.transactions.export', request()->query()) }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold transition-all flex items-center gap-1.5 shadow-md shadow-brand-600/20">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Download Rekap PDF</span>
            </a>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">No. Invoice / Resi</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Waktu Konfirmasi</th>
                        <th class="py-4 px-6">Dikonfirmasi Oleh</th>
                        <th class="py-4 px-6">Total Tagihan</th>
                        <th class="py-4 px-6">Status Pesanan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($transactions as $trx)
                        @php
                            $statusInfo = $trx->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                                #INV-{{ $trx->order_code }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $trx->user->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $trx->user->phone ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $trx->confirmed_at ? $trx->confirmed_at->translatedFormat('d M Y, H:i') : $trx->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium">
                                {{ $trx->confirmedBy->name ?? 'Admin Outlet' }}
                            </td>
                            <td class="py-4 px-6 font-black text-brand-700 text-sm">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <a href="{{ route('admin.transactions.print', $trx) }}" target="_blank" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-[11px] transition-all inline-flex items-center gap-1.5 shadow-xs">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Cetak Struk</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Belum ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
