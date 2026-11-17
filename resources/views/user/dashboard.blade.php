@extends('layouts.user')

@section('title', 'Dashboard Pelanggan - Washora')

@section('user-content')
<div class="space-y-6">
    <!-- Welcome Header Banner -->
    <div class="bg-white rounded-xl p-5 sm:p-6 border border-slate-200 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Halo, {{ $user->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-lg leading-relaxed">
                Pantau proses cucian Anda secara real-time atau buat pesanan penjemputan baru ke alamat Anda.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0 pt-2 sm:pt-0">
            <a href="{{ route('user.orders.create') }}" class="px-4 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-xs transition-colors flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Buat Pesanan Baru</span>
            </a>
            <a href="{{ route('user.orders.index') }}" class="px-4 py-2.5 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 font-medium text-xs border border-slate-300 transition-colors">
                Riwayat Pesanan
            </a>
        </div>
    </div>

    <!-- Active Running Order Banner (if exists) -->
    @if($activeOrder)
        <div class="bg-white rounded-xl p-5 border border-brand-200 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center text-sm font-semibold">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-sm font-bold text-slate-900">Pesanan Aktif Sedang Berjalan</h2>
                            <span class="text-xs font-mono font-bold text-brand-600">#{{ $activeOrder->order_code }}</span>
                        </div>
                        <p class="text-xs text-slate-500">Dipesan pada {{ $activeOrder->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                    </div>
                </div>

                @php
                    $statusInfo = $activeOrder->status_info;
                @endphp
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-md border text-xs font-bold {{ $statusInfo['badge'] }}">
                        <span class="w-2 h-2 rounded-full {{ $statusInfo['dot'] }} inline-block mr-1"></span>
                        {{ $statusInfo['label'] }}
                    </span>
                    <a href="{{ route('user.orders.show', $activeOrder) }}" class="px-3 py-1 bg-brand-50 text-brand-700 hover:bg-brand-100 rounded-md text-xs font-semibold transition-colors">
                        Rincian &rarr;
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
                    'ready' => 'Siap Diantar',
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
                    <div class="p-2 rounded-lg border text-center text-xs transition-colors {{ $isCurrent ? 'bg-brand-600 text-white border-brand-600 font-bold' : ($isPassed ? 'bg-emerald-50 text-emerald-800 border-emerald-200 font-semibold' : 'bg-slate-50 text-slate-400 border-slate-100') }}">
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
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-3.5 bg-slate-50 rounded-lg text-xs text-slate-600 border border-slate-100">
                <div>
                    <span class="text-slate-400 font-medium">Layanan:</span>
                    <p class="font-bold text-slate-800 mt-0.5">{{ $activeOrder->items->first()->item_name ?? 'Layanan Laundry' }}</p>
                </div>
                <div>
                    <span class="text-slate-400 font-medium">Berat / Biaya:</span>
                    <p class="font-bold text-slate-800 mt-0.5">
                        {{ $activeOrder->total_weight ? $activeOrder->total_weight . ' Kg' : 'Menunggu timbang' }} &bull; 
                        <span class="text-brand-700">{{ $activeOrder->total_price ? 'Rp ' . number_format($activeOrder->total_price, 0, ',', '.') : 'Konfirmasi Outlet' }}</span>
                    </p>
                </div>
                <div>
                    <span class="text-slate-400 font-medium">Estimasi Selesai:</span>
                    <p class="font-bold text-slate-800 mt-0.5">
                        {{ $activeOrder->estimated_completed_at ? $activeOrder->estimated_completed_at->translatedFormat('d M Y, H:i WIB') : 'Segera dikonfirmasi' }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- 3 Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pesanan Aktif</p>
                <h3 class="text-xl font-bold text-slate-900 mt-0.5">{{ $stats['active_orders'] }}</h3>
                <p class="text-[11px] text-brand-600 mt-0.5 font-medium">Sedang diproses</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center text-base">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pesanan Selesai</p>
                <h3 class="text-xl font-bold text-slate-900 mt-0.5">{{ $stats['completed_orders'] }}</h3>
                <p class="text-[11px] text-emerald-600 mt-0.5 font-medium">Total riwayat</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-base">
                <i class="fa-solid fa-box-check"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Transaksi</p>
                <h3 class="text-xl font-bold text-slate-900 mt-0.5">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h3>
                <p class="text-[11px] text-slate-500 mt-0.5 font-medium">Pesanan lunas</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 flex items-center justify-center text-base">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Bagian Ulasan Pelanggan / Testimonial Section -->
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs">
        @if(isset($unreviewedOrders) && $unreviewedOrders->isNotEmpty())
            {{-- Kondisi: Ada pesanan selesai yang siap diulas --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-500 border border-amber-200 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-sm font-bold text-slate-900">Tulis Ulasan Anda</h2>
                            <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-bold">
                                {{ $unreviewedOrders->count() }} Pesanan Siap Diulas
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 max-w-2xl leading-relaxed">
                            Bagikan pengalaman mencuci Anda bersama Washora. Ulasan dan rating Anda akan langsung tampil di halaman beranda dan membantu kami menjaga mutu pelayanan.
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <button type="button" onclick="openReviewModal()" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-xs transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Tulis Ulasan Anda</span>
                    </button>
                </div>
            </div>

        @elseif(($completedOrdersCount ?? 0) === 0)
            {{-- Kondisi: Belum memiliki pesanan selesai --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-500 border border-slate-200 flex items-center justify-center text-base shrink-0">
                        <i class="fa-regular fa-comment-dots"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-sm font-bold text-slate-900">Tulis Ulasan Anda</h2>
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-medium border border-slate-200">
                                Info Ulasan
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 max-w-2xl leading-relaxed">
                            Bagikan pengalaman Anda menggunakan layanan Washora. Anda dapat memberikan ulasan dan rating bintang setelah pesanan cucian Anda selesai dikerjakan, atau tulis pengalaman Anda sekarang.
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <button type="button" onclick="openReviewModal()" class="w-full sm:w-auto px-4 py-2.5 rounded-lg bg-white hover:bg-slate-50 text-brand-600 border border-slate-300 font-semibold text-xs shadow-xs transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                        <span>Tulis Ulasan Anda</span>
                    </button>
                </div>
            </div>

        @else
            {{-- Kondisi: Seluruh pesanan selesai sudah diulas --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-base shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-sm font-bold text-slate-900">Terima Kasih atas Ulasan Anda!</h2>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold">
                                Semua Pesanan Selesai Telah Diulas
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 max-w-2xl leading-relaxed">
                            Seluruh pesanan laundry Anda yang telah selesai sudah berhasil diulas dan ditampilkan pada halaman beranda. Masukan Anda sangat berarti bagi tim Washora.
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <button type="button" onclick="openReviewModal()" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium text-xs transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-xs text-slate-500"></i>
                        <span>Tulis Ulasan Baru</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Orders Table Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Riwayat Pesanan Terkini</h2>
                <p class="text-xs text-slate-500">Daftar pesanan laundry terbaru Anda</p>
            </div>
            <a href="{{ route('user.orders.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 hover:underline">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-5">Kode Pesanan</th>
                        <th class="py-3 px-5">Layanan</th>
                        <th class="py-3 px-5">Tanggal</th>
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
                            <td class="py-3.5 px-5 font-medium">
                                {{ $order->items->first()->item_name ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500">
                                {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-3.5 px-5 font-semibold text-slate-800">
                                {{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-900">
                                {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Menunggu Admin' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold border {{ $statusInfo['badge'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    @if($order->status === 'completed')
                                        @if($order->review)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold" title="Pesanan ini sudah diulas">
                                                <i class="fa-solid fa-star text-amber-500 text-[9px]"></i>
                                                <span>Diulas</span>
                                            </span>
                                        @else
                                            <button type="button" onclick="openReviewModal({{ $order->id }})" class="px-2.5 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white font-semibold text-[11px] transition-colors flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                <span>Ulas</span>
                                            </button>
                                        @endif
                                    @endif
                                    <a href="{{ route('user.orders.show', $order) }}" class="px-2.5 py-1.5 rounded-md bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-700 font-semibold transition-colors text-[11px]">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                <i class="fa-solid fa-box-open text-2xl mb-1.5 block text-slate-300"></i>
                                Belum ada pesanan laundry. Buat pesanan pertama Anda sekarang!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Formulir Testimoni / Ulasan -->
<div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 overflow-y-auto" role="dialog" aria-modal="true" aria-labelledby="modalReviewTitle">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 max-w-lg w-full p-6 space-y-5 my-8 relative">
        <div class="flex items-start justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 id="modalReviewTitle" class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-star text-amber-500"></i>
                    <span>Tulis Ulasan Anda</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Testimoni Anda akan langsung tersimpan dan ditampilkan di halaman beranda Washora.
                </p>
            </div>
            <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition-colors" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('user.reviews.store') }}" method="POST" class="space-y-4">
            @csrf

            @if(isset($unreviewedOrders) && $unreviewedOrders->isNotEmpty())
                <div>
                    <label for="review_order_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Pesanan Selesai yang Diulas
                    </label>
                    <select id="review_order_id" name="order_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium text-slate-800 focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">
                        <option value="">-- Ulasan Umum Layanan Washora --</option>
                        @foreach($unreviewedOrders as $unreviewed)
                            <option value="{{ $unreviewed->id }}" {{ old('order_id') == $unreviewed->id ? 'selected' : '' }}>
                                #{{ $unreviewed->order_code }} - {{ $unreviewed->items->first()->item_name ?? 'Layanan Laundry' }} (Selesai {{ $unreviewed->updated_at->translatedFormat('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('order_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- Rating Bintang -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                    Rating Bintang <span class="text-rose-500">*</span>
                </label>
                <div class="flex items-center gap-2 flex-wrap">
                    @for($i = 5; $i >= 1; $i--)
                        <label class="cursor-pointer group flex items-center gap-1.5 px-3 py-2 rounded-lg border border-slate-200 hover:border-amber-400 hover:bg-amber-50/50 transition-colors">
                            <input type="radio" name="rating" value="{{ $i }}" class="peer sr-only" {{ old('rating', '5') == $i ? 'checked' : '' }} required>
                            <span class="text-xs font-bold text-slate-700 peer-checked:text-amber-600 flex items-center gap-1">
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <span>{{ $i }} Bintang</span>
                            </span>
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komentar / Isi Ulasan -->
            <div>
                <label for="review_comment" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Isi Ulasan atau Pengalaman Anda <span class="text-rose-500">*</span>
                </label>
                <textarea id="review_comment" name="comment" rows="4" required minlength="5" maxlength="1000" placeholder="Ceritakan kepuasan Anda mengenai kebersihan cucian, aroma wangi, ketepatan waktu, dan keramahan pelayanan Washora..." class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all">{{ old('comment') }}</textarea>
                <div class="flex items-center justify-between text-[11px] text-slate-400 mt-1">
                    <span>Minimal 5 karakter</span>
                    <span>Maksimal 1000 karakter</span>
                </div>
                @error('comment')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Identitas -->
            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 text-[11px] text-slate-500 flex items-center justify-between">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-user-check text-brand-600"></i>
                    <span>Mengirim sebagai: <strong class="text-slate-800">{{ $user->name }}</strong></span>
                </span>
                <span class="text-emerald-600 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-bolt text-xs"></i>
                    Langsung Ditampilkan di Beranda
                </span>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeReviewModal()" class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-xs transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Ulasan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReviewModal(orderId = null) {
        const modal = document.getElementById('reviewModal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (orderId) {
            const select = document.getElementById('review_order_id');
            if (select) {
                select.value = orderId;
            }
        }
    }

    function closeReviewModal() {
        const modal = document.getElementById('reviewModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeReviewModal();
        }
    });

    document.addEventListener('click', function(e) {
        const modal = document.getElementById('reviewModal');
        if (modal && e.target === modal) {
            closeReviewModal();
        }
    });

    @if($errors->any() && (old('order_id') || old('rating') || old('comment')))
        document.addEventListener('DOMContentLoaded', function() {
            openReviewModal();
        });
    @endif
</script>
@endsection
