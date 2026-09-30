@extends('layouts.admin')

@section('title', 'Detail Pelanggan ' . $customer->name . ' - Washora')
@section('page-title', 'Detail Pelanggan')

@section('admin-content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <span class="text-xs font-bold text-slate-400">Profil Pelanggan</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $customer->name }}</h1>
            </div>
        </div>

        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone ?? '') }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 shadow-sm">
            <i class="fa-brands fa-whatsapp text-sm"></i>
            <span>Chat WhatsApp</span>
        </a>
    </div>

    <!-- Customer Info Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
        <div>
            <span class="text-slate-400 font-semibold block">Email:</span>
            <p class="font-bold text-slate-900 mt-0.5">{{ $customer->email }}</p>
        </div>
        <div>
            <span class="text-slate-400 font-semibold block">Nomor WhatsApp:</span>
            <p class="font-bold text-slate-900 mt-0.5">{{ $customer->phone ?? '-' }}</p>
        </div>
        <div>
            <span class="text-slate-400 font-semibold block">Bergabung Sejak:</span>
            <p class="font-bold text-slate-900 mt-0.5">{{ $customer->created_at->translatedFormat('d F Y') }}</p>
        </div>
        <div>
            <span class="text-slate-400 font-semibold block">Total Transaksi:</span>
            <p class="font-black text-brand-700 text-sm mt-0.5">
                Rp {{ number_format($customer->orders->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Customer Orders History -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900">Riwayat Semua Pesanan Pelanggan</h2>
            <p class="text-xs text-slate-400">Daftar semua cucian yang pernah dipesan oleh {{ $customer->name }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Kode Pesanan</th>
                        <th class="py-4 px-6">Tanggal Pesan</th>
                        <th class="py-4 px-6">Layanan</th>
                        <th class="py-4 px-6">Berat / Qty</th>
                        <th class="py-4 px-6">Total Biaya</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($customer->orders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                                #{{ $order->order_code }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 font-semibold">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-bold rounded-xl text-[11px] transition-all">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Belum ada pesanan dari pelanggan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
