@extends('layouts.user')

@section('title', 'Pesanan Saya - Washora')

@section('user-content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pesanan Saya</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pantau status pencucian, rincian biaya, dan riwayat pesanan Anda.</p>
        </div>
        <a href="{{ route('user.orders.create') }}" class="px-5 py-2.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/20 transition-all flex items-center justify-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Buat Pesanan Baru</span>
        </a>
    </div>

    <!-- Status Filters Bar -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs font-bold">
        <a href="{{ route('user.orders.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Semua ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'bg-white text-amber-800 border border-slate-200 hover:bg-amber-50' }}">
            Menunggu Verifikasi ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'processing' ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-indigo-700 border border-slate-200 hover:bg-indigo-50' }}">
            Sedang Diproses
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'washing']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'washing' ? 'bg-cyan-600 text-white shadow-xs' : 'bg-white text-cyan-700 border border-slate-200 hover:bg-cyan-50' }}">
            Sedang Dicuci
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'ready']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'ready' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-emerald-700 border border-slate-200 hover:bg-emerald-50' }}">
            Siap Diambil
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'completed' ? 'bg-slate-700 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Selesai ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('user.orders.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $status === 'cancelled' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-rose-700 border border-slate-200 hover:bg-rose-50' }}">
            Dibatalkan ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <!-- Orders Cards List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            @php
                $statusInfo = $order->status_info;
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:border-brand-300 hover:shadow-md transition-all">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between pb-4 border-b border-slate-100 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-shirt"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900 text-base">#{{ $order->order_code }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusInfo['dot'] }} inline-block mr-1"></span>
                                    {{ $statusInfo['label'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">Dipesan: {{ $order->created_at->translatedFormat('l, d F Y - H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('user.orders.show', $order) }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                            <span>Lacak & Rincian</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>

                        @if($order->status === 'pending')
                            <form action="{{ route('user.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-bold transition-colors">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Order Content Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 text-xs">
                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 space-y-1">
                        <span class="text-slate-400 font-semibold">Layanan Dipesan:</span>
                        <p class="font-bold text-slate-800">{{ $order->items->first()->item_name ?? 'Layanan Laundry' }}</p>
                        @if($order->customer_note)
                            <p class="text-[11px] text-slate-500 italic truncate">"{{ $order->customer_note }}"</p>
                        @endif
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 space-y-1">
                        <span class="text-slate-400 font-semibold">Total Berat & Biaya:</span>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800">{{ $order->total_weight ? $order->total_weight . ' Kg' : 'Menunggu timbang' }}</span>
                            <span class="font-black text-brand-700 text-sm">{{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Konfirmasi Admin' }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 space-y-1">
                        <span class="text-slate-400 font-semibold">Estimasi Selesai:</span>
                        <p class="font-bold text-slate-800">
                            {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('d M Y, H:i WIB') : 'Segera dikonfirmasi oleh admin' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-xs space-y-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum Ada Pesanan Dalam Kategori Ini</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Anda belum memiliki pesanan dengan filter status yang dipilih.
                </p>
                <div class="pt-2">
                    <a href="{{ route('user.orders.create') }}" class="px-5 py-2.5 rounded-xl bg-brand-600 text-white text-xs font-bold inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-plus"></i> Pesan Laundry Sekarang
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
