@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_code . ' - Washora')
@section('page-title', 'Pemeriksaan & Update Pesanan')

@section('admin-content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header with Breadcrumb & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
                <span class="text-xs font-bold text-slate-400">Pemeriksaan Pesanan</span>
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

            @if($order->status !== 'pending' && $order->total_price)
                <a href="{{ $order->whats_app_url }}" target="_blank" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Kirim via WhatsApp</span>
                </a>
            @endif
        </div>
    </div>

    <!-- MAIN ACTION 1: If Order is PENDING, Show Verification & Weighing Form -->
    @if($order->status === 'pending')
        <div class="bg-gradient-to-br from-amber-50 via-white to-amber-50/40 rounded-3xl p-6 sm:p-8 border-2 border-amber-300 shadow-lg shadow-amber-500/10 space-y-6">
            <div class="flex items-start gap-4 pb-4 border-b border-amber-200/80">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center font-black text-xl shrink-0 shadow-md shadow-amber-500/30">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-200 text-amber-900 text-[10px] font-extrabold uppercase tracking-wider">Langkah 1: Verifikasi & Timbang</span>
                    <h2 class="text-lg font-black text-slate-900 mt-1">Form Pemeriksaan & Konfirmasi Timbangan Cucian</h2>
                    <p class="text-xs text-slate-600 mt-0.5">
                        Timbang laundry fisik, tentukan quantity aktual, periksa subtotal otomatis, dan tentukan estimasi waktu selesai.
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" class="space-y-6" id="verification-form">
                @csrf

                <!-- Items list for weight / quantity input -->
                <div class="space-y-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Rincian Item Laundry:</label>

                    @foreach($order->items as $item)
                        <div class="p-4 bg-white rounded-2xl border border-amber-200 shadow-xs space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $item->item_name }}</h4>
                                    <p class="text-xs text-slate-400">
                                        Tarif per satuan: <span class="font-bold text-slate-700">Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }}</span>
                                    </p>
                                </div>
                                <span class="px-2.5 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600 self-start sm:self-auto">
                                    Tipe: {{ strtoupper($item->item_type) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                                <!-- Input Qty / Weight -->
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                        Berat / Qty Aktual ({{ $item->unit }}):
                                    </label>
                                    <input type="number" step="0.1" min="0.1" name="item_quantities[{{ $item->id }}]" id="qty-{{ $item->id }}" value="{{ old('item_quantities.' . $item->id, $item->quantity > 0 ? $item->quantity : 1) }}" required oninput="calculateSubtotal({{ $item->id }}, {{ $item->unit_price }})" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
                                </div>

                                <!-- Unit Price Confirmation -->
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                        Harga Satuan (Rp):
                                    </label>
                                    <input type="number" step="100" min="0" name="item_prices[{{ $item->id }}]" id="price-{{ $item->id }}" value="{{ old('item_prices.' . $item->id, $item->unit_price) }}" required oninput="calculateSubtotal({{ $item->id }}, this.value)" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
                                </div>

                                <!-- Calculated Subtotal -->
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">
                                        Subtotal Otomatis (Rp):
                                    </label>
                                    <div class="px-3 py-2 bg-amber-50/80 border border-amber-200 rounded-xl text-xs font-black text-amber-900" id="subtotal-display-{{ $item->id }}">
                                        Rp {{ number_format($item->unit_price * (old('item_quantities.' . $item->id, $item->quantity > 0 ? $item->quantity : 1)), 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Estimated Completion and Admin Note -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="estimated_completed_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Estimasi Tanggal & Jam Selesai:
                        </label>
                        @php
                            $defaultEst = \Carbon\Carbon::now()->addHours(24)->format('Y-m-d\TH:i');
                        @endphp
                        <input type="datetime-local" id="estimated_completed_at" name="estimated_completed_at" required value="{{ old('estimated_completed_at', $defaultEst) }}" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-bold focus:ring-2 focus:ring-amber-500 transition-all">
                        @error('estimated_completed_at')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Catatan Verifikasi Admin (Opsional):
                        </label>
                        <input type="text" id="admin_note" name="admin_note" value="{{ old('admin_note') }}" placeholder="Contoh: Pakaian telah disortir, tidak ada noda luntur" class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-amber-500 transition-all">
                    </div>
                </div>

                <!-- Total & Submit Confirmation -->
                <div class="p-5 bg-white rounded-2xl border border-amber-300 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-xs text-slate-500 font-semibold">Total Biaya Setelah Penimbangan:</span>
                        <p class="text-2xl font-black text-brand-700" id="grand-total-display">
                            Rp {{ number_format($order->items->sum('unit_price'), 0, ',', '.') }}
                        </p>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-sm"></i>
                        <span>Konfirmasi & Ubah Status Jadi "Confirmed"</span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- MAIN ACTION 2: If Confirmed/Processing, Admin Status Progression Control -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-arrows-spin text-brand-600"></i>
                    <span>Perbarui Status Pengerjaan Laundry</span>
                </h2>
                <span class="text-xs text-slate-400">Admin Mode</span>
            </div>

            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                @csrf

                <!-- Status Selector -->
                <div class="md:col-span-4">
                    <label for="status_select" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ubah Status Menjadi:</label>
                    <select id="status_select" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-brand-500">
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed (Terkonfirmasi)</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing (Penjemputan / Sortir)</option>
                        <option value="washing" {{ $order->status === 'washing' ? 'selected' : '' }}>Washing (Sedang Dicuci)</option>
                        <option value="finishing" {{ $order->status === 'finishing' ? 'selected' : '' }}>Finishing (Setrika & Packing)</option>
                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready (Siap Diambil / Diantar)</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                </div>

                <!-- Custom Progress Note -->
                <div class="md:col-span-5">
                    <label for="progress_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Log Riwayat (Opsional):</label>
                    <input type="text" id="progress_note" name="note" placeholder="Contoh: Pakaian telah selesai disetrika uap dan dipacking rapi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Submit Button -->
                <div class="md:col-span-3">
                    <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-600/20 transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Status</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- WhatsApp Notification Modal / Preview Banner -->
    @if($order->status !== 'pending' && $order->status !== 'cancelled')
        <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-6 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-emerald-950">Kirim Pemberitahuan WhatsApp ke Pelanggan</h3>
                    <p class="text-xs text-emerald-800 mt-0.5">
                        Kirimkan rincian kode pesanan, berat akurat, total biaya (Rp {{ number_format($order->total_price, 0, ',', '.') }}), dan estimasi selesai ke nomor <strong>{{ $order->user->phone }}</strong>.
                    </p>
                </div>
            </div>

            <a href="{{ $order->whats_app_url }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black shadow-md shadow-emerald-600/25 transition-all flex items-center gap-2 whitespace-nowrap">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Buka WhatsApp Sekarang</span>
            </a>
        </div>
    @endif

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Customer & Order Summary -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4 text-xs">
            <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                <i class="fa-solid fa-user text-brand-600"></i>
                <span>Data Pelanggan</span>
            </h3>

            <div class="space-y-3 text-slate-600">
                <div>
                    <span class="text-slate-400 font-semibold block">Nama:</span>
                    <p class="font-bold text-slate-900">{{ $order->user->name }}</p>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">WhatsApp:</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone ?? '') }}" target="_blank" class="font-bold text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                        <i class="fa-brands fa-whatsapp"></i> {{ $order->user->phone ?? '-' }}
                    </a>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Email:</span>
                    <p class="font-medium text-slate-800">{{ $order->user->email }}</p>
                </div>
                <div>
                    <span class="text-slate-400 font-semibold block">Alamat Penjemputan:</span>
                    <p class="font-medium text-slate-800 leading-relaxed">{{ $order->pickup_address }}</p>
                </div>
                @if($order->customer_note)
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200">
                        <span class="text-amber-800 font-bold block mb-0.5">Catatan Pelanggan:</span>
                        <p class="text-amber-900 italic">"{{ $order->customer_note }}"</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items & Invoice Breakdown -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4 text-xs">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-brand-600"></i>
                    <span>Rincian Biaya & Layanan</span>
                </h3>
                @if($order->total_price)
                    <a href="{{ route('admin.transactions.print', $order) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Struk Invoice</span>
                    </a>
                @endif
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between">
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $item->item_name }}</p>
                            <p class="text-slate-400">
                                Tarif: Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-slate-700">{{ $item->quantity }} {{ $item->unit }}</p>
                            <p class="text-sm font-black text-slate-900">
                                {{ $item->subtotal > 0 ? 'Rp ' . number_format($item->subtotal, 0, ',', '.') : 'Menunggu timbang' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <div class="flex justify-between">
                    <span class="text-slate-500 font-semibold">Total Berat Ditimbang:</span>
                    <span class="font-bold text-slate-900">{{ $order->total_weight ? $order->total_weight . ' Kg' : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-semibold">Estimasi Selesai:</span>
                    <span class="font-bold text-slate-900">
                        {{ $order->estimated_completed_at ? $order->estimated_completed_at->translatedFormat('d F Y, H:i WIB') : '-' }}
                    </span>
                </div>
                <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-sm">
                    <span class="font-black text-slate-900">Total Biaya Akhir:</span>
                    <span class="text-xl font-black text-brand-700">
                        {{ $order->total_price ? 'Rp ' . number_format($order->total_price, 0, ',', '.') : 'Belum Dikonfirmasi' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Change History Logs -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-brand-600"></i>
            <span>Log Riwayat Status Pesanan</span>
        </h3>

        <div class="space-y-3">
            @forelse($order->statusHistories as $log)
                <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                    <div class="w-2.5 h-2.5 rounded-full bg-brand-600 mt-1 shrink-0"></div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold uppercase text-slate-900">{{ $log->status }}</span>
                                <span class="text-[10px] text-slate-400">oleh {{ $log->user->name ?? 'Sistem' }}</span>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $log->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
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

<script>
    function calculateSubtotal(itemId, price) {
        const qtyInput = document.getElementById('qty-' + itemId);
        const priceInput = document.getElementById('price-' + itemId);
        const subtotalBox = document.getElementById('subtotal-display-' + itemId);
        const qty = parseFloat(qtyInput ? qtyInput.value : 1) || 0;
        const pr = parseFloat(priceInput ? priceInput.value : price) || 0;
        const sub = qty * pr;
        if (subtotalBox) {
            subtotalBox.innerText = 'Rp ' + sub.toLocaleString('id-ID');
        }
        recalculateGrandTotal();
    }

    function recalculateGrandTotal() {
        const subBoxes = document.querySelectorAll('[id^="subtotal-display-"]');
        let total = 0;
        subBoxes.forEach(box => {
            const num = parseInt(box.innerText.replace(/[^0-9]/g, '')) || 0;
            total += num;
        });
        const grandTotalBox = document.getElementById('grand-total-display');
        if (grandTotalBox) {
            grandTotalBox.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    }
</script>
@endsection
