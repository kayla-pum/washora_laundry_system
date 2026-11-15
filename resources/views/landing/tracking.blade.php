@extends('layouts.app')

@section('title', 'Lacak Status Pesanan - Washora')

@section('content')
    @include('layouts.navigation')

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center space-y-2 mb-8">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold">
                    Pelacakan Pesanan
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Lacak Status Pesanan Laundry</h1>
                <p class="text-slate-500 text-xs sm:text-sm max-w-lg mx-auto">
                    Masukkan nomor kode pemesanan Washora Anda (contoh: <strong>WSH-20261112-001</strong>) untuk memeriksa perkembangan proses cucian secara real-time.
                </p>

                <!-- Search Box -->
                <form action="{{ route('tracking') }}" method="GET" class="max-w-lg mx-auto mt-5">
                    <div class="flex gap-2 p-1.5 bg-white rounded-lg shadow-xs border border-slate-300">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                            <input type="text" name="code" value="{{ $code ?? '' }}" required placeholder="Ketik Kode Pesanan Anda..." class="w-full pl-9 pr-3 py-2 bg-transparent text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none">
                        </div>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-md shadow-xs transition-colors shrink-0">
                            Cari Pesanan
                        </button>
                    </div>
                </form>
            </div>

            @if($searched)
                @if($order)
                    <!-- Order Found Card -->
                    <div class="bg-white rounded-xl p-5 sm:p-7 border border-slate-200 shadow-xs space-y-6">
                        <!-- Top Order Summary -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-slate-100 gap-3">
                            <div>
                                <span class="text-[11px] font-semibold uppercase text-slate-400">Kode Pesanan</span>
                                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">#{{ $order->order_code }}</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Tanggal Pemesanan: {{ $order->created_at->translatedFormat('d F Y, H:i WIB') }}</p>
                            </div>

                            @php
                                $statusInfo = $order->status_info;
                            @endphp
                            <div>
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg border text-xs font-bold {{ $statusInfo['badge'] }}">
                                    <span class="w-2 h-2 rounded-full {{ $statusInfo['dot'] }}"></span>
                                    Status: {{ $statusInfo['label'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Visual Step Tracker Timeline -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Perkembangan Pesanan</h3>
                            
                            @php
                                $steps = [
                                    ['key' => 'pending', 'label' => 'Verifikasi', 'icon' => 'fa-clock'],
                                    ['key' => 'confirmed', 'label' => 'Terkonfirmasi', 'icon' => 'fa-clipboard-check'],
                                    ['key' => 'processing', 'label' => 'Penjemputan', 'icon' => 'fa-truck'],
                                    ['key' => 'washing', 'label' => 'Pencucian', 'icon' => 'fa-water'],
                                    ['key' => 'finishing', 'label' => 'Setrika/Packing', 'icon' => 'fa-wand-magic-sparkles'],
                                    ['key' => 'ready', 'label' => 'Siap Diantar', 'icon' => 'fa-box-check'],
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
                                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-lg text-rose-800 text-xs flex items-center gap-2.5">
                                    <i class="fa-solid fa-circle-xmark text-lg text-rose-500"></i>
                                    <div>
                                        <p class="font-bold">Pesanan Telah Dibatalkan</p>
                                        <p class="text-[11px] text-rose-700">Pesanan ini telah dibatalkan dan proses pengerjaan dihentikan.</p>
                                    </div>
                                </div>
                            @else
                                <div class="py-2">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2.5 text-center">
                                        @foreach($steps as $idx => $s)
                                            @php
                                                $stepNum = $idx + 1;
                                                $isPassed = $cur >= $stepNum;
                                                $isCurrent = $cur === $stepNum;
                                            @endphp
                                            <div class="flex flex-col items-center space-y-1.5 p-2 rounded-lg {{ $isCurrent ? 'bg-brand-50 border border-brand-200' : 'bg-slate-50 border border-slate-100' }}">
                                                <div class="w-8 h-8 rounded-md flex items-center justify-center text-xs font-bold {{ $isCurrent ? 'bg-brand-600 text-white' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                                                    @if($isPassed && !$isCurrent)
                                                        <i class="fa-solid fa-check text-[10px]"></i>
                                                    @else
                                                        <i class="fa-solid {{ $s['icon'] }} text-[10px]"></i>
                                                    @endif
                                                </div>
                                                <span class="text-[11px] font-semibold {{ $isCurrent ? 'text-brand-700 font-bold' : ($isPassed ? 'text-slate-800' : 'text-slate-400') }}">
                                                    {{ $s['label'] }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-3 border-t border-slate-100">
                            <!-- Left: Items and Weight -->
                            <div class="space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Layanan yang Dipilih</h3>
                                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200/80 space-y-2.5">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-200/60 last:border-0 last:pb-0">
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $item->item_name }}</p>
                                                <p class="text-[11px] text-slate-500">Tarif: Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-slate-700">{{ $item->quantity }} {{ $item->unit }}</p>
                                                <p class="text-xs font-bold text-brand-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="p-3.5 bg-slate-50 rounded-lg border border-slate-200 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-slate-500 font-medium">Total Berat Ditimbang:</p>
                                        <p class="text-sm font-bold text-slate-900">{{ $order->total_weight ? $order->total_weight . ' Kg' : 'Menunggu Penimbangan' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-500 font-medium">Total Biaya:</p>
                                        <p class="text-base font-bold text-slate-900">{{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Akan Dikonfirmasi' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Time & Operational Info (Protecting Customer Privacy) -->
                            <div class="space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Informasi Pengerjaan</h3>
                                
                                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200/80 space-y-2.5 text-xs">
                                    <div>
                                        <p class="text-slate-500 font-medium text-[11px]">Estimasi Selesai:</p>
                                        <p class="font-bold text-slate-900 mt-0.5">
                                            {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('l, d F Y - H:i WIB') : 'Menunggu konfirmasi admin' }}
                                        </p>
                                    </div>

                                    @php
                                        $isOwnerOrAdmin = auth()->check() && (auth()->id() === $order->user_id || auth()->user()->isAdmin());
                                    @endphp

                                    <div>
                                        <p class="text-slate-500 font-medium text-[11px]">Alamat Penjemputan:</p>
                                        @if($isOwnerOrAdmin)
                                            <p class="font-medium text-slate-800 mt-0.5">{{ $order->pickup_address }}</p>
                                        @else
                                            <p class="font-medium text-slate-600 mt-0.5 flex items-center gap-1.5">
                                                <i class="fa-solid fa-lock text-[10px] text-slate-400"></i>
                                                <span>Alamat Terdaftar (Disamarkan demi privasi data pelanggan)</span>
                                            </p>
                                        @endif
                                    </div>

                                    @if($isOwnerOrAdmin && $order->customer_note)
                                        <div>
                                            <p class="text-slate-500 font-medium text-[11px]">Catatan Pelanggan:</p>
                                            <p class="font-medium text-slate-700 italic mt-0.5">"{{ $order->customer_note }}"</p>
                                        </div>
                                    @endif
                                </div>

                                @if($isOwnerOrAdmin && $order->status !== 'pending' && $order->status !== 'cancelled')
                                    <a href="{{ $order->whats_app_url }}" target="_blank" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold flex items-center justify-center gap-2 shadow-xs transition-colors">
                                        <i class="fa-brands fa-whatsapp text-sm"></i>
                                        <span>Buka Notifikasi WhatsApp Pesanan Ini</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Status Timeline History -->
                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2.5">Log Riwayat Status Pengerjaan</h3>
                            <div class="space-y-1.5">
                                @forelse($order->statusHistories as $log)
                                    <div class="flex items-start gap-2.5 p-2.5 bg-slate-50 rounded-lg text-xs border border-slate-100">
                                        <div class="w-1.5 h-1.5 rounded-full bg-brand-600 mt-1.5 shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-bold text-slate-800 uppercase">{{ $log->status }}</span>
                                                <span class="text-[10px] text-slate-400">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                            </div>
                                            <p class="text-slate-600 mt-0.5">{{ $log->note }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic">Belum ada catatan log riwayat status.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Order Not Found -->
                    <div class="bg-white rounded-xl p-8 text-center border border-slate-200 shadow-xs space-y-3">
                        <div class="w-12 h-12 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Pesanan Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Kode pesanan <strong>"{{ $code }}"</strong> tidak ditemukan dalam sistem kami. Silakan pastikan nomor kode pesanan sudah benar (contoh: <em>WSH-20261112-001</em>).
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @include('layouts.footer')
@endsection
