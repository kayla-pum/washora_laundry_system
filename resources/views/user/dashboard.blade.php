@extends('layouts.user')

@section('title', 'Dashboard Pelanggan - Washora')

@section('user-content')
<div class="space-y-8">
    <!-- Welcome Header Banner -->
    <div class="bg-gradient-to-r from-brand-600 via-brand-700 to-cyan-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-brand-600/15 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-2 relative z-10">
            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold text-cyan-200">
                👋 Selamat Datang Kembali
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ $user->name }}</h1>
            <p class="text-xs sm:text-sm text-brand-100 max-w-xl">
                Pantau progres cucian Anda secara realtime dan pesan penjemputan baru dengan mudah.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10 shrink-0">
            <a href="{{ route('user.orders.create') }}" class="px-5 py-3 rounded-2xl bg-white text-brand-700 hover:bg-slate-50 font-bold text-xs shadow-lg transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Buat Pesanan Baru</span>
            </a>
            <a href="{{ route('user.orders.index') }}" class="px-4 py-3 rounded-2xl bg-brand-800/60 hover:bg-brand-800 text-white font-semibold text-xs border border-white/20 transition-all">
                Pesanan Saya
            </a>
        </div>

        <!-- Decorative circles -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Active Running Order Banner (if exists) -->
    @if($activeOrder)
        <div class="bg-white rounded-3xl p-6 border border-brand-200 shadow-md shadow-brand-500/5 space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-spinner animate-spin"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-slate-900">Pesanan Aktif Sedang Diproses</h2>
                            <span class="text-xs font-mono font-bold text-brand-600">#{{ $activeOrder->order_code }}</span>
                        </div>
                        <p class="text-xs text-slate-500">Dipesan pada {{ $activeOrder->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                </div>

                @php
                    $statusInfo = $activeOrder->status_info;
                @endphp
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 rounded-xl border text-xs font-bold {{ $statusInfo['badge'] }}">
                        <span class="w-2 h-2 rounded-full {{ $statusInfo['dot'] }} inline-block mr-1"></span>
                        {{ $statusInfo['label'] }}
                    </span>
                    <a href="{{ route('user.orders.show', $activeOrder) }}" class="px-3 py-1.5 bg-brand-50 text-brand-700 hover:bg-brand-100 rounded-xl text-xs font-bold transition-colors">
                        Lihat Rincian &rarr;
                    </a>
                </div>
            </div>

            <!-- Stepper Progress Bar -->
            @php
                $steps = [
                    'pending' => 'Verifikasi',
                    'confirmed' => 'Terkonfirmasi',
                    'processing' => 'Penjemputan',
                    'washing' => 'Pencucian',
                    'finishing' => 'Setrika/Packing',
                    'ready' => 'Siap Diambil',
                ];
                $orderSteps = ['pending' => 1, 'confirmed' => 2, 'processing' => 3, 'washing' => 4, 'finishing' => 5, 'ready' => 6, 'completed' => 7];
                $currentStep = $orderSteps[$activeOrder->status] ?? 1;
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-6 gap-2">
                @foreach($steps as $key => $label)
                    @php
                        $stepVal = $orderSteps[$key];
                        $isPassed = $currentStep >= $stepVal;
                        $isCurrent = $currentStep === $stepVal;
                    @endphp
                    <div class="p-2.5 rounded-xl border text-center text-xs transition-all {{ $isCurrent ? 'bg-brand-600 text-white border-brand-600 font-bold shadow-sm ring-2 ring-brand-200' : ($isPassed ? 'bg-emerald-50 text-emerald-800 border-emerald-200 font-semibold' : 'bg-slate-50 text-slate-400 border-slate-100') }}">
                        <div class="flex items-center justify-center gap-1">
                            @if($isPassed && !$isCurrent)
                                <i class="fa-solid fa-check text-[10px]"></i>
                            @endif
                            <span>{{ $label }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-2xl text-xs text-slate-600">
                <div>
                    <span class="text-slate-400 font-semibold">Layanan:</span>
                    <p class="font-bold text-slate-800 mt-0.5">{{ $activeOrder->items->first()->item_name ?? 'Layanan Laundry' }}</p>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold">Berat / Biaya:</span>
                    <p class="font-bold text-slate-800 mt-0.5">
                        {{ $activeOrder->total_weight ? $activeOrder->total_weight . ' Kg' : 'Menunggu timbang' }} &bull; 
                        <span class="text-brand-700">{{ $activeOrder->total_price ? 'Rp ' . number_format($activeOrder->total_price, 0, ',', '.') : 'Konfirmasi Admin' }}</span>
                    </p>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold">Estimasi Selesai:</span>
                    <p class="font-bold text-slate-800 mt-0.5">
                        {{ $activeOrder->estimated_completed_at ? $activeOrder->estimated_completed_at->translatedFormat('d M Y, H:i WIB') : 'Segera dikonfirmasi' }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- 3 Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Aktif</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $stats['active_orders'] }}</h3>
                <p class="text-[11px] text-brand-600 mt-0.5 font-semibold">Sedang berjalan</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Selesai</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $stats['completed_orders'] }}</h3>
                <p class="text-[11px] text-emerald-600 mt-0.5 font-semibold">Total riwayat</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-check"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Transaksi</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h3>
                <p class="text-[11px] text-slate-400 mt-0.5 font-semibold">Pesanan lunas</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Riwayat Pesanan Terkini</h2>
                <p class="text-xs text-slate-400">Daftar pesanan laundry terbaru Anda</p>
            </div>
            <a href="{{ route('user.orders.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 hover:underline">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Kode Pesanan</th>
                        <th class="py-3.5 px-6">Layanan</th>
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Berat / Qty</th>
                        <th class="py-3.5 px-6">Total Biaya</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentOrders as $order)
                        @php
                            $statusInfo = $order->status_info;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                #{{ $order->order_code }}
                            </td>
                            <td class="py-4 px-6 font-medium">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 font-semibold">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Menunggu Admin' }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('user.orders.show', $order) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-700 font-bold transition-all text-[11px]">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-box-open text-3xl mb-2 block text-slate-300"></i>
                                Belum ada pesanan laundry. Buat pesanan pertama Anda sekarang!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
