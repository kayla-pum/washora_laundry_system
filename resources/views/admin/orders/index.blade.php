@extends('layouts.admin')

@section('title', 'Manajemen Pesanan Laundry - Washora')
@section('page-title', 'Manajemen Pesanan Laundry')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Search Filter Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Daftar Semua Pesanan Masuk</h1>
                <p class="text-xs text-slate-400">Kelola konfirmasi timbangan, pantau proses, dan update status cucian</p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Kode / Pelanggan / No WA..." class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white w-56 sm:w-64">
                </div>

                <input type="date" name="date" value="{{ $date ?? '' }}" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500">

                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                    Filter
                </button>

                @if($search || $date || $status !== 'all')
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-bold scrollbar-none border-t border-slate-100 pt-3">
            <a href="{{ route('admin.orders.index', ['status' => 'all', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'all' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-500 text-slate-950 font-black ring-2 ring-amber-300' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
                Menunggu Verifikasi ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'confirmed', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-800 hover:bg-blue-100' }}">
                Terkonfirmasi ({{ $statusCounts['confirmed'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'washing', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'washing' ? 'bg-cyan-600 text-white' : 'bg-cyan-50 text-cyan-800 hover:bg-cyan-100' }}">
                Sedang Dicuci ({{ $statusCounts['washing'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'finishing', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'finishing' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-800 hover:bg-purple-100' }}">
                Setrika & Packing ({{ $statusCounts['finishing'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'ready', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'ready' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                Siap Diambil ({{ $statusCounts['ready'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'completed' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai ({{ $statusCounts['completed'] }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled', 'search' => $search, 'date' => $date]) }}" class="px-3.5 py-1.5 rounded-xl transition-all whitespace-nowrap {{ $status === 'cancelled' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-800 hover:bg-rose-100' }}">
                Dibatalkan ({{ $statusCounts['cancelled'] }})
            </a>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Kode Pesanan</th>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">Layanan & Catatan</th>
                        <th class="py-4 px-6">Berat / Qty</th>
                        <th class="py-4 px-6">Total Biaya</th>
                        <th class="py-4 px-6">Estimasi Selesai</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($orders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900 font-mono">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-brand-600 hover:underline">
                                    #{{ $order->order_code }}
                                </a>
                                <p class="text-[10px] text-slate-400 font-normal">{{ $order->created_at->translatedFormat('d M, H:i') }}</p>
                            </td>

                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone ?? '') }}" target="_blank" class="text-[11px] text-emerald-600 hover:underline font-semibold flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>{{ $order->user->phone ?? '-' }}</span>
                                </a>
                            </td>

                            <td class="py-4 px-6 max-w-xs">
                                <p class="font-bold text-slate-800">{{ $order->items->first()->item_name ?? '-' }}</p>
                                @if($order->customer_note)
                                    <p class="text-[11px] text-slate-400 italic truncate" title="{{ $order->customer_note }}">
                                        "{{ $order->customer_note }}"
                                    </p>
                                @endif
                            </td>

                            <td class="py-4 px-6 font-bold">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>

                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : '-' }}
                            </td>

                            <td class="py-4 px-6 text-slate-500">
                                {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('d M, H:i') : '-' }}
                            </td>

                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-right space-x-1">
                                @if($order->status === 'pending')
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-black rounded-xl text-[11px] transition-colors shadow-xs inline-flex items-center gap-1">
                                        <i class="fa-solid fa-scale-balanced"></i>
                                        <span>Timbang</span>
                                    </a>
                                @else
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-bold rounded-xl text-[11px] transition-all inline-block">
                                        Detail
                                    </a>
                                @endif

                                @if($order->total_price)
                                    <a href="{{ $order->whats_app_url }}" target="_blank" title="Kirim Notifikasi WhatsApp" class="p-1.5 bg-emerald-50 hover:bg-emerald-500 hover:text-white text-emerald-600 rounded-lg text-xs font-bold transition-all inline-block">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                Tidak ada data pesanan sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
