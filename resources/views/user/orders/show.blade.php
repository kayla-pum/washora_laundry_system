@extends('layouts.user')

@section('title', 'Detail Pesanan #' . $order->order_code . ' - Washora')

@section('user-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header with Back Link -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('user.orders.index') }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <span class="text-xs font-bold text-slate-400">Rincian & Status Pesanan</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">#{{ $order->order_code }}</h1>
            </div>
        </div>

        @php
            $statusInfo = $order->status_info;
        @endphp
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <span class="px-4 py-1.5 rounded-2xl border text-xs font-black {{ $statusInfo['badge'] }}">
                <span class="w-2 h-2 rounded-full {{ $statusInfo['dot'] }} inline-block mr-1"></span>
                {{ $statusInfo['label'] }}
            </span>
        </div>
    </div>

    <!-- Stepper Tracker Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-timeline text-brand-600"></i>
                <span>Progress Pengerjaan Realtime</span>
            </h2>
            <span class="text-xs text-slate-400">Diperbarui: {{ $order->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
        </div>

        @php
            $steps = [
                ['key' => 'pending', 'label' => 'Pending', 'sub' => 'Menunggu Verifikasi', 'icon' => 'fa-clock'],
                ['key' => 'confirmed', 'label' => 'Confirmed', 'sub' => 'Terkonfirmasi & Timbang', 'icon' => 'fa-check'],
                ['key' => 'processing', 'label' => 'Processing', 'sub' => 'Penjemputan / Sortir', 'icon' => 'fa-truck'],
                ['key' => 'washing', 'label' => 'Washing', 'sub' => 'Pencucian Higienis', 'icon' => 'fa-water'],
                ['key' => 'finishing', 'label' => 'Finishing', 'sub' => 'Setrika & Packing', 'icon' => 'fa-wand-magic-sparkles'],
                ['key' => 'ready', 'label' => 'Ready', 'sub' => 'Siap Diambil / Antar', 'icon' => 'fa-box-check'],
                ['key' => 'completed', 'label' => 'Completed', 'sub' => 'Selesai Diterima', 'icon' => 'fa-circle-check'],
            ];

            $orderSteps = ['pending' => 1, 'confirmed' => 2, 'processing' => 3, 'washing' => 4, 'finishing' => 5, 'ready' => 6, 'completed' => 7, 'cancelled' => 0];
            $cur = $orderSteps[$order->status] ?? 1;
        @endphp

        @if($order->status === 'cancelled')
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-900 text-xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-ban text-lg"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Pesanan Ini Dibatalkan (Cancelled)</p>
                    <p class="text-rose-700">Pesanan telah dibatalkan dan proses pengerjaan dihentikan.</p>
                </div>
            </div>
        @else
            <!-- Visual Stepper Progress -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 text-center py-2">
                @foreach($steps as $idx => $s)
                    @php
                        $stepNum = $idx + 1;
                        $isPassed = $cur >= $stepNum;
                        $isCurrent = $cur === $stepNum;
                    @endphp
                    <div class="flex flex-col items-center space-y-2 p-2 rounded-2xl transition-all {{ $isCurrent ? 'bg-brand-50/80 border border-brand-200' : '' }}">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-sm font-bold transition-all {{ $isCurrent ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/30 scale-110 ring-4 ring-brand-100' : ($isPassed ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400') }}">
                            @if($isPassed && !$isCurrent)
                                <i class="fa-solid fa-check"></i>
                            @else
                                <i class="fa-solid {{ $s['icon'] }}"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold {{ $isCurrent ? 'text-brand-700 font-black' : ($isPassed ? 'text-slate-800' : 'text-slate-400') }}">
                                {{ $s['label'] }}
                            </p>
                            <p class="text-[10px] text-slate-400 hidden sm:block">{{ $s['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Order Items & Pricing Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- 2 Cols: Items breakdown -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-5">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-receipt text-brand-600"></i>
                <span>Rincian Layanan Cucian</span>
            </h2>

            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-3.5 flex items-center justify-between text-xs">
                        <div class="space-y-0.5">
                            <p class="font-bold text-slate-900 text-sm">{{ $item->item_name }}</p>
                            <p class="text-slate-400">
                                Tarif dasar: Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }}
                            </p>
                            @if($item->notes)
                                <p class="text-[11px] text-brand-600 italic">{{ $item->notes }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-700">{{ $item->quantity }} {{ $item->unit }}</p>
                            <p class="text-sm font-black text-brand-700">
                                {{ $item->subtotal > 0 ? 'Rp ' . number_format($item->subtotal, 0, ',', '.') : 'Menunggu timbang' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Price Summary Box -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/70 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Total Berat Ditimbang:</span>
                    <span class="font-bold text-slate-900">{{ $order->total_weight ? $order->total_weight . ' Kg' : 'Menunggu konfirmasi admin' }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Estimasi Waktu Selesai:</span>
                    <span class="font-bold text-slate-900">
                        {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('d F Y, H:i WIB') : 'Segera ditentukan admin' }}
                    </span>
                </div>
                <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-sm">
                    <span class="font-extrabold text-slate-900">Total Biaya Akhir:</span>
                    <span class="text-xl font-black text-brand-700">
                        {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Menunggu Admin' }}
                    </span>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-[11px] text-amber-800 flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-info-circle"></i>
                        Ingin membatalkan pesanan ini sebelum ditimbang?
                    </span>
                    <form action="{{ route('user.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="font-bold text-rose-600 hover:underline">Batalkan Pesanan</button>
                    </form>
                </div>
            @endif
        </div>

        <!-- 1 Col: Pickup Info & CS Action -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4 text-xs">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-rose-500"></i>
                    <span>Informasi Penjemputan</span>
                </h3>

                <div class="space-y-3 text-slate-600">
                    <div>
                        <span class="text-slate-400 font-semibold block">Nama Pemesan:</span>
                        <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold block">No. WhatsApp:</span>
                        <p class="font-bold text-slate-900">{{ $order->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold block">Alamat Pengambilan:</span>
                        <p class="font-medium text-slate-800 leading-relaxed">{{ $order->pickup_address }}</p>
                    </div>
                    @if($order->customer_note)
                        <div>
                            <span class="text-slate-400 font-semibold block">Catatan Khusus:</span>
                            <p class="font-medium text-slate-700 italic">"{{ $order->customer_note }}"</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Service WhatsApp Button -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-700 text-white rounded-3xl p-6 shadow-md shadow-emerald-500/15 space-y-3">
                <h4 class="font-bold text-sm">Butuh Bantuan Cucian?</h4>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Hubungi Customer Care Washora melalui WhatsApp jika memiliki instruksi tambahan untuk pesanan ini.
                </p>
                <a href="https://api.whatsapp.com/send?phone=6281234567890&text={{ urlencode('Halo Admin Washora, saya ingin bertanya mengenai pesanan #' . $order->order_code) }}" target="_blank" class="w-full py-2.5 bg-white text-emerald-800 hover:bg-slate-50 font-bold rounded-xl text-xs flex items-center justify-center gap-2 shadow-xs transition-all">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Chat CS Washora</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Change History Logs -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-4">
        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-brand-600"></i>
            <span>Riwayat Perubahan Status</span>
        </h2>

        <div class="space-y-3">
            @forelse($order->statusHistories as $log)
                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                    <div class="w-2.5 h-2.5 rounded-full bg-brand-600 mt-1 shrink-0"></div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold uppercase text-slate-900">{{ $log->status }}</span>
                            <span class="text-[10px] text-slate-400">{{ $log->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>
                        <p class="text-slate-600 mt-1 leading-relaxed">{{ $log->note }}</p>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic">Belum ada riwayat tercatat.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
