@extends('layouts.app')

@section('title', 'Cek Resi & Status Laundry - Washora')

@section('content')
    @include('layouts.navigation')

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center space-y-3 mb-10">
                <span class="px-3.5 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-bold">Public Order Tracking</span>
                <h1 class="text-3xl font-extrabold text-slate-900">Lacak Status Pesanan Laundry</h1>
                <p class="text-slate-500 text-sm max-w-xl mx-auto">
                    Masukkan nomor kode pesanan Washora Anda (contoh: <strong>WSH-20260929-001</strong>) untuk melihat perkembangan proses cuci secara real-time.
                </p>

                <!-- Search Box -->
                <form action="{{ route('tracking') }}" method="GET" class="max-w-xl mx-auto mt-6">
                    <div class="flex gap-2 p-2 bg-white rounded-2xl shadow-lg border border-slate-200">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                            <input type="text" name="code" value="{{ $code ?? '' }}" required placeholder="Masukkan Kode Pesanan..." class="w-full pl-11 pr-4 py-2.5 bg-transparent text-sm font-bold text-slate-800 focus:outline-none">
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-md transition-all">
                            Cari Pesanan
                        </button>
                    </div>
                </form>
            </div>

            @if($searched)
                @if($order)
                    <!-- Order Found Card -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xl space-y-8">
                        <!-- Top Order Summary -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                            <div>
                                <span class="text-xs font-bold uppercase text-slate-400">Kode Pesanan</span>
                                <h2 class="text-2xl font-black text-slate-900 tracking-tight">#{{ $order->order_code }}</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Dipesan pada: {{ $order->created_at->translatedFormat('d F Y, H:i WIB') }}</p>
                            </div>

                            @php
                                $statusInfo = $order->status_info;
                            @endphp
                            <div>
                                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border text-xs font-extrabold {{ $statusInfo['badge'] }}">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $statusInfo['dot'] }} animate-pulse"></span>
                                    Status: {{ $statusInfo['label'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Visual Step Tracker Timeline -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Progress Pengerjaan Laundry</h3>
                            
                            @php
                                $steps = [
                                    ['key' => 'pending', 'label' => 'Menunggu Verifikasi', 'icon' => 'fa-clock'],
                                    ['key' => 'confirmed', 'label' => 'Terkonfirmasi & Timbang', 'icon' => 'fa-clipboard-check'],
                                    ['key' => 'processing', 'label' => 'Penjemputan / Sortir', 'icon' => 'fa-truck'],
                                    ['key' => 'washing', 'label' => 'Pencucian', 'icon' => 'fa-water'],
                                    ['key' => 'finishing', 'label' => 'Setrika & Packing', 'icon' => 'fa-wand-magic-sparkles'],
                                    ['key' => 'ready', 'label' => 'Siap Diambil', 'icon' => 'fa-box-check'],
                                    ['key' => 'completed', 'label' => 'Selesai', 'icon' => 'fa-circle-check'],
                                ];

                                $currentStepOrder = [
                                    'pending' => 1,
                                    'confirmed' => 2,
                                    'processing' => 3,
                                    'washing' => 4,
                                    'finishing' => 5,
                                    'ready' => 6,
                                    'completed' => 7,
                                    'cancelled' => 0,
                                ];
                                $cur = $currentStepOrder[$order->status] ?? 1;
                            @endphp

                            @if($order->status === 'cancelled')
                                <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-sm flex items-center gap-3">
                                    <i class="fa-solid fa-circle-xmark text-xl text-rose-500"></i>
                                    <div>
                                        <p class="font-bold">Pesanan Telah Dibatalkan</p>
                                        <p class="text-xs text-rose-700">Pesanan ini telah dibatalkan dan proses pengerjaan dihentikan.</p>
                                    </div>
                                </div>
                            @else
                                <div class="relative py-4">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 text-center">
                                        @foreach($steps as $idx => $s)
                                            @php
                                                $stepNum = $idx + 1;
                                                $isPassed = $cur >= $stepNum;
                                                $isCurrent = $cur === $stepNum;
                                            @endphp
                                            <div class="flex flex-col items-center space-y-2">
                                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-sm font-bold transition-all {{ $isCurrent ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/30 scale-110 ring-4 ring-brand-100' : ($isPassed ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400') }}">
                                                    @if($isPassed && !$isCurrent)
                                                        <i class="fa-solid fa-check"></i>
                                                    @else
                                                        <i class="fa-solid {{ $s['icon'] }}"></i>
                                                    @endif
                                                </div>
                                                <span class="text-[11px] font-bold {{ $isCurrent ? 'text-brand-700 font-extrabold' : ($isPassed ? 'text-slate-800' : 'text-slate-400') }}">
                                                    {{ $s['label'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                            <!-- Left: Items and Weight -->
                            <div class="space-y-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Rincian Cucian</h3>
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-3">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-200/60 last:border-0 last:pb-0">
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $item->item_name }}</p>
                                                <p class="text-[11px] text-slate-500">Tarif: Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-bold text-slate-900">{{ $item->quantity }} {{ $item->unit }}</p>
                                                <p class="text-xs font-bold text-brand-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="p-4 bg-brand-50/60 rounded-2xl border border-brand-100 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-slate-500 font-semibold">Total Berat Ditimbang:</p>
                                        <p class="text-base font-black text-slate-900">{{ $order->total_weight ? $order->total_weight . ' Kg' : 'Menunggu Penimbangan' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-500 font-semibold">Total Biaya Akhir:</p>
                                        <p class="text-xl font-black text-brand-700">{{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Akan Dikonfirmasi' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Time & Notes -->
                            <div class="space-y-4">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Informasi Pengerjaan & Alamat</h3>
                                
                                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-3 text-xs">
                                    <div>
                                        <p class="text-slate-400 font-semibold">Estimasi Waktu Selesai:</p>
                                        <p class="font-bold text-slate-900 text-sm mt-0.5">
                                            {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('l, d F Y - H:i WIB') : 'Menunggu konfirmasi admin' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-slate-400 font-semibold">Alamat Penjemputan / Antar:</p>
                                        <p class="font-medium text-slate-800 mt-0.5">{{ $order->pickup_address }}</p>
                                    </div>
                                    @if($order->customer_note)
                                        <div>
                                            <p class="text-slate-400 font-semibold">Catatan Khusus Pelanggan:</p>
                                            <p class="font-medium text-slate-700 italic mt-0.5">"{{ $order->customer_note }}"</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- WhatsApp Confirmation Button -->
                                @if($order->status !== 'pending' && $order->status !== 'cancelled')
                                    <a href="{{ $order->whats_app_url }}" target="_blank" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs font-bold flex items-center justify-center gap-2 shadow-md shadow-emerald-600/20 transition-all">
                                        <i class="fa-brands fa-whatsapp text-base"></i>
                                        <span>Buka Notifikasi WhatsApp Pesanan Ini</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Status Timeline History -->
                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Log Riwayat Status</h3>
                            <div class="space-y-2">
                                @forelse($order->statusHistories as $log)
                                    <div class="flex items-start gap-3 p-3 bg-slate-50/80 rounded-xl text-xs border border-slate-100">
                                        <div class="w-2 h-2 rounded-full bg-brand-500 mt-1.5 shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-bold uppercase text-slate-800">{{ $log->status }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                            </div>
                                            <p class="text-slate-600 mt-0.5">{{ $log->note }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">Belum ada catatan log.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Order Not Found -->
                    <div class="bg-white rounded-3xl p-10 text-center border border-slate-200 shadow-sm space-y-4">
                        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Pesanan Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">
                            Kode pesanan <strong>"{{ $code }}"</strong> tidak ditemukan dalam sistem kami. Silakan periksa kembali format kode pesanan Anda.
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @include('layouts.footer')
@endsection
