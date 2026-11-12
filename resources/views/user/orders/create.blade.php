@extends('layouts.user')

@section('title', 'Buat Pesanan Laundry - Washora')

@section('user-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Form Pemesanan Laundry</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pesan penjemputan cucian dengan 3 langkah mudah dan praktis.</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat</span>
        </a>
    </div>

    <!-- Stepper Navigation Indicator: 01 Data Pelanggan → 02 Pilih Layanan → 03 Konfirmasi -->
    <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-200/90 shadow-xs">
        <div class="grid grid-cols-3 gap-2 sm:gap-4">
            <!-- Step 1 Tab -->
            <div id="step-tab-1" class="step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-brand-50 border border-brand-200 text-brand-700 transition-all">
                <div class="w-8 h-8 rounded-xl bg-brand-600 text-white flex items-center justify-center text-xs font-black shrink-0 shadow-xs">
                    01
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-bold text-brand-500 tracking-wider">Tahap 1</p>
                    <p class="text-xs sm:text-sm font-extrabold truncate text-slate-900">Data Pelanggan</p>
                </div>
            </div>

            <!-- Step 2 Tab -->
            <div id="step-tab-2" class="step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 transition-all">
                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-black shrink-0">
                    02
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tahap 2</p>
                    <p class="text-xs sm:text-sm font-extrabold truncate text-slate-700">Pilih Layanan</p>
                </div>
            </div>

            <!-- Step 3 Tab -->
            <div id="step-tab-3" class="step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 transition-all">
                <div class="w-8 h-8 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-black shrink-0">
                    03
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tahap 3</p>
                    <p class="text-xs sm:text-sm font-extrabold truncate text-slate-700">Konfirmasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Order Form (3 Steps) -->
    <form action="{{ route('user.orders.store') }}" method="POST" id="order-form" class="space-y-6">
        @csrf

        <!-- ==========================================
             TAHAP 1: DATA PELANGGAN
             ========================================== -->
        <div id="step-content-1" class="space-y-6">
            <!-- Notice Box: Tidak Perlu Menimbang Sendiri -->
            <div class="p-4 sm:p-5 bg-brand-50/80 border border-brand-200 rounded-3xl flex items-start gap-3.5 text-brand-950 shadow-xs">
                <div class="w-10 h-10 rounded-2xl bg-brand-600 text-white flex items-center justify-center shrink-0 text-lg shadow-sm">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div class="text-xs space-y-1">
                    <p class="font-bold text-sm text-brand-950">Tanpa Perlu Menimbang Cucian Sendiri</p>
                    <p class="text-brand-800 leading-relaxed">
                        Anda <strong>tidak perlu memasukkan berat pakaian</strong> pada formulir ini. Setelah kurir menjemput cucian, berat akurat akan ditimbang langsung di outlet Washora secara transparan dan rincian biaya dikonfirmasikan via WhatsApp.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                        Data Pemesan & Lokasi Penjemputan
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Lengkapi informasi kontak dan alamat agar kurir dapat menjemput tepat waktu.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Pemesan -->
                    <div>
                        <label for="recipient_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="recipient_name" name="recipient_name" required value="{{ old('recipient_name', auth()->user()->name) }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                        <p id="err-recipient_name" class="text-rose-600 text-xs mt-1 hidden"></p>
                        @error('recipient_name')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label for="whatsapp_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-xs font-bold text-slate-400">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                            </span>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" required value="{{ old('whatsapp_number', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Konfirmasi timbangan dan perkembangan laundry akan dikirim ke nomor ini.</p>
                        <p id="err-whatsapp_number" class="text-rose-600 text-xs mt-1 hidden"></p>
                        @error('whatsapp_number')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat Lengkap Penjemputan -->
                <div>
                    <label for="pickup_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Lengkap Penjemputan Cucian <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="pickup_address" name="pickup_address" rows="3" required placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan patokan (misal: Rumah cat biru, seberang masjid)" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">{{ old('pickup_address') }}</textarea>
                    <p id="err-pickup_address" class="text-rose-600 text-xs mt-1 hidden"></p>
                    @error('pickup_address')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Khusus Laundry -->
                <div>
                    <label for="customer_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Catatan Khusus untuk Laundry (Opsional)
                    </label>
                    <input type="text" id="customer_note" name="customer_note" value="{{ old('customer_note') }}" placeholder="Contoh: Baju putih mohon dipisah, penjemputan sore jam 15.00 WIB" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    @error('customer_note')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Button Step 1 -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="validateStep1AndProceed()" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-brand-600/25 transition-all flex items-center justify-center gap-2">
                        <span>Lanjutkan ke Pilih Layanan</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAHAP 2: PILIH LAYANAN
             ========================================== -->
        <div id="step-content-2" class="space-y-6 hidden">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                        Pilih Layanan Laundry atau Paket Hemat
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih jenis layanan pengerjaan (Regular atau Express) atau paket bundling yang Anda butuhkan.</p>
                </div>

                <!-- Tab Toggle: Layanan Satuan/Kiloan vs Paket Hemat -->
                <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-100 rounded-2xl max-w-md">
                    <label class="cursor-pointer">
                        <input type="radio" name="item_type" value="service" id="type-service" class="peer sr-only" {{ empty($selectedPackageId) ? 'checked' : '' }} onchange="switchItemType('service')">
                        <div class="py-2.5 px-4 text-center rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-white peer-checked:text-brand-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-jug-detergent"></i>
                            <span>Layanan Satuan / Kiloan</span>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="item_type" value="package" id="type-package" class="peer sr-only" {{ !empty($selectedPackageId) ? 'checked' : '' }} onchange="switchItemType('package')">
                        <div class="py-2.5 px-4 text-center rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-white peer-checked:text-brand-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-box-archive"></i>
                            <span>Paket Bundling</span>
                        </div>
                    </label>
                </div>

                <!-- Grid Daftar Layanan -->
                <div id="section-service" class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Layanan Tersedia:</label>
                        <span class="text-[11px] text-slate-400">Pilih salah satu layanan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[460px] overflow-y-auto p-1">
                        @foreach($categories as $category)
                            @foreach($category->activeServices as $service)
                                @php
                                    $isSelected = ($selectedServiceId == $service->id) || ($loop->parent->first && $loop->first && empty($selectedPackageId));
                                @endphp
                                <label class="cursor-pointer service-option-label block relative">
                                    <input type="radio" name="service_id" value="{{ $service->id }}" 
                                        data-name="{{ $service->name }}"
                                        data-price="{{ number_format($service->price, 0, ',', '.') }}"
                                        data-unit="{{ $service->unit }}"
                                        data-type="{{ $service->service_type === 'express' ? 'Express (' . $service->estimated_hours . ' Jam)' : 'Regular (' . $service->estimated_hours . ' Jam)' }}"
                                        data-category="{{ $category->name }}"
                                        class="peer sr-only" {{ $isSelected ? 'checked' : '' }}
                                        onchange="onServiceSelect(this)">
                                    
                                    <div class="p-5 rounded-3xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col justify-between h-full hover:border-slate-300">
                                        <div class="space-y-2.5">
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-700' }}">
                                                    {{ $service->service_type === 'express' ? '⚡ Express (' . $service->estimated_hours . ' Jam)' : '⏱️ Regular (' . $service->estimated_hours . ' Jam)' }}
                                                </span>
                                                <span class="text-[11px] font-semibold text-slate-400">{{ $category->name }}</span>
                                            </div>

                                            <h4 class="font-bold text-slate-900 text-sm">{{ $service->name }}</h4>
                                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $service->description ?? 'Layanan profesional dengan detergen antibakteri dan kebersihan terjamin.' }}</p>
                                        </div>

                                        <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                            <div>
                                                <span class="text-xs font-black text-brand-700">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                                <span class="text-[11px] text-slate-400">/ {{ $service->unit }}</span>
                                            </div>
                                            <span class="service-selected-pill text-[11px] font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-600 peer-checked:bg-brand-600 peer-checked:text-white transition-all">
                                                Pilih
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <!-- Grid Daftar Paket -->
                <div id="section-package" class="space-y-4 hidden">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Paket Bundling Tersedia:</label>
                        <span class="text-[11px] text-slate-400">Pilih salah satu paket hemat</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($packages as $pkg)
                            @php
                                $isPkgSelected = ($selectedPackageId == $pkg->id) || ($loop->first && !empty($selectedPackageId));
                            @endphp
                            <label class="cursor-pointer package-option-label block relative">
                                <input type="radio" name="package_id" value="{{ $pkg->id }}" 
                                    data-name="{{ $pkg->name }}"
                                    data-price="{{ number_format($pkg->price, 0, ',', '.') }}"
                                    data-unit="paket"
                                    data-type="Paket Bundling"
                                    data-category="Paket Hemat"
                                    class="peer sr-only" {{ $isPkgSelected ? 'checked' : '' }}
                                    onchange="onPackageSelect(this)">
                                
                                <div class="p-5 rounded-3xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col justify-between h-full hover:border-slate-300">
                                    <div class="space-y-2.5">
                                        <div class="flex items-center justify-between">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-brand-100 text-brand-800">
                                                Paket Bundling
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400">Est. {{ $pkg->estimated_hours }} Jam</span>
                                        </div>

                                        <h4 class="font-bold text-slate-900 text-sm">{{ $pkg->name }}</h4>
                                        <p class="text-xs text-slate-500 leading-relaxed">{{ $pkg->description }}</p>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <span class="text-sm font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                                        <span class="text-[11px] font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-600 peer-checked:bg-brand-600 peer-checked:text-white transition-all">
                                            Pilih
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <p id="err-service-selection" class="text-rose-600 text-xs font-semibold hidden"></p>

                <!-- Action Buttons Step 2 -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(1)" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs border border-slate-200 rounded-2xl transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Data Pelanggan</span>
                    </button>

                    <button type="button" onclick="validateStep2AndProceed()" class="px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-brand-600/25 transition-all flex items-center gap-2">
                        <span>Lanjutkan ke Konfirmasi</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAHAP 3: KONFIRMASI PEMESANAN
             ========================================== -->
        <div id="step-content-3" class="space-y-6 hidden">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">3</span>
                        Konfirmasi Ringkasan Pemesanan
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Periksa kembali data Anda sebelum mengirimkan formulir pesanan.</p>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Summary -->
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/70 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Data Pelanggan</span>
                            <button type="button" onclick="goToStep(1)" class="text-[11px] font-bold text-brand-600 hover:underline">Ubah</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Lengkap:</span>
                                <span id="summary-name" class="font-bold text-slate-800 text-sm">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor WhatsApp:</span>
                                <span id="summary-phone" class="font-bold text-slate-800">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Alamat Penjemputan:</span>
                                <span id="summary-address" class="font-medium text-slate-700 leading-relaxed block">-</span>
                            </div>
                            <div id="summary-note-box" class="hidden">
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Catatan Khusus:</span>
                                <span id="summary-note" class="italic text-slate-600 block">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Summary -->
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/70 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Layanan yang Dipilih</span>
                            <button type="button" onclick="goToStep(2)" class="text-[11px] font-bold text-brand-600 hover:underline">Ubah</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Layanan / Paket:</span>
                                <span id="summary-service-name" class="font-bold text-brand-700 text-sm">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Kategori & Pengerjaan:</span>
                                <span id="summary-service-type" class="font-semibold text-slate-800">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Tarif Dasar:</span>
                                <span id="summary-service-price" class="font-black text-slate-900 text-base">-</span>
                            </div>
                            <div class="pt-2 text-[11px] text-slate-500 border-t border-slate-200/60">
                                <span>Status Awal: <strong class="text-amber-600 font-bold">Pending (Menunggu Verifikasi)</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Explanation Note: Penimbangan & WhatsApp Confirmation -->
                <div class="p-5 bg-brand-50/70 border border-brand-200/80 rounded-3xl space-y-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-brand-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        Prosedur Penimbangan & Konfirmasi Biaya
                    </h4>
                    <p class="text-xs text-brand-900 leading-relaxed">
                        1. <strong>Penimbangan di Outlet:</strong> Pakaian Anda akan ditimbang dan diperiksa secara akurat oleh admin Washora setibanya kurir di outlet.<br>
                        2. <strong>Konfirmasi WhatsApp:</strong> Rincian berat aktual, total biaya resmi, dan perkiraan waktu selesai akan dikirimkan langsung ke nomor WhatsApp Anda sebelum proses cuci dimulai.
                    </p>
                </div>

                <!-- Terms and Conditions Agreement Checkbox -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="agree-terms" required class="mt-0.5 w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            Saya menyetujui syarat & ketentuan layanan penjemputan dan pencucian Washora. Saya mengizinkan admin untuk memeriksa dan menimbang pakaian saya secara transparan di outlet.
                        </span>
                    </label>
                    <p id="err-agree-terms" class="text-rose-600 text-xs mt-1 hidden"></p>
                </div>

                <!-- Action Buttons Step 3 -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(2)" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs border border-slate-200 rounded-2xl transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Pilih Layanan</span>
                    </button>

                    <button type="submit" id="btn-submit-order" class="px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm rounded-2xl shadow-xl shadow-brand-600/30 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Pesanan</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let currentStep = 1;

    function goToStep(step) {
        currentStep = step;

        // Hide all steps, show target step
        document.getElementById('step-content-1').classList.toggle('hidden', step !== 1);
        document.getElementById('step-content-2').classList.toggle('hidden', step !== 2);
        document.getElementById('step-content-3').classList.toggle('hidden', step !== 3);

        // Update step tabs styling
        updateTabStyles(step);

        // Scroll smoothly to top of form
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    function updateTabStyles(activeStep) {
        for (let i = 1; i <= 3; i++) {
            const tab = document.getElementById(`step-tab-${i}`);
            const badge = tab.querySelector('div:first-child');
            const title = tab.querySelector('p:last-child');

            if (i === activeStep) {
                tab.className = 'step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-brand-50 border-2 border-brand-600 text-brand-700 transition-all shadow-xs';
                badge.className = 'w-8 h-8 rounded-xl bg-brand-600 text-white flex items-center justify-center text-xs font-black shrink-0 shadow-xs';
                title.className = 'text-xs sm:text-sm font-extrabold truncate text-slate-900';
            } else if (i < activeStep) {
                // Completed step
                tab.className = 'step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 transition-all cursor-pointer';
                badge.className = 'w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs font-black shrink-0 shadow-xs';
                badge.innerHTML = '<i class="fa-solid fa-check"></i>';
                title.className = 'text-xs sm:text-sm font-bold truncate text-slate-800';
            } else {
                // Pending step
                tab.className = 'step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 transition-all';
                badge.className = 'w-8 h-8 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-black shrink-0';
                badge.textContent = `0${i}`;
                title.className = 'text-xs sm:text-sm font-extrabold truncate text-slate-500';
            }
        }
    }

    function validateStep1AndProceed() {
        const nameInput = document.getElementById('recipient_name');
        const phoneInput = document.getElementById('whatsapp_number');
        const addressInput = document.getElementById('pickup_address');

        let isValid = true;

        // Reset errors
        document.getElementById('err-recipient_name').classList.add('hidden');
        document.getElementById('err-whatsapp_number').classList.add('hidden');
        document.getElementById('err-pickup_address').classList.add('hidden');

        if (!nameInput.value.trim()) {
            const err = document.getElementById('err-recipient_name');
            err.textContent = 'Nama lengkap wajib diisi.';
            err.classList.remove('hidden');
            isValid = false;
        }

        const phoneVal = phoneInput.value.trim();
        if (!phoneVal) {
            const err = document.getElementById('err-whatsapp_number');
            err.textContent = 'Nomor WhatsApp wajib diisi.';
            err.classList.remove('hidden');
            isValid = false;
        } else if (phoneVal.length < 8) {
            const err = document.getElementById('err-whatsapp_number');
            err.textContent = 'Format nomor WhatsApp tidak valid (minimal 8 digit).';
            err.classList.remove('hidden');
            isValid = false;
        }

        if (!addressInput.value.trim() || addressInput.value.trim().length < 5) {
            const err = document.getElementById('err-pickup_address');
            err.textContent = 'Alamat penjemputan lengkap wajib diisi (minimal 5 karakter).';
            err.classList.remove('hidden');
            isValid = false;
        }

        if (isValid) {
            goToStep(2);
        }
    }

    function switchItemType(type) {
        const secSvc = document.getElementById('section-service');
        const secPkg = document.getElementById('section-package');
        if (type === 'service') {
            secSvc.classList.remove('hidden');
            secPkg.classList.add('hidden');
        } else {
            secSvc.classList.add('hidden');
            secPkg.classList.remove('hidden');
        }
    }

    function validateStep2AndProceed() {
        const itemType = document.querySelector('input[name="item_type"]:checked').value;
        const errSelection = document.getElementById('err-service-selection');
        errSelection.classList.add('hidden');

        let selected = null;
        if (itemType === 'service') {
            selected = document.querySelector('input[name="service_id"]:checked');
            if (!selected) {
                errSelection.textContent = 'Silakan pilih salah satu layanan laundry terlebih dahulu.';
                errSelection.classList.remove('hidden');
                return;
            }
        } else {
            selected = document.querySelector('input[name="package_id"]:checked');
            if (!selected) {
                errSelection.textContent = 'Silakan pilih salah satu paket laundry terlebih dahulu.';
                errSelection.classList.remove('hidden');
                return;
            }
        }

        // Populate Step 3 Summary
        populateSummary(selected);
        goToStep(3);
    }

    function populateSummary(selectedRadio) {
        // Customer Info
        document.getElementById('summary-name').textContent = document.getElementById('recipient_name').value.trim();
        document.getElementById('summary-phone').textContent = document.getElementById('whatsapp_number').value.trim();
        document.getElementById('summary-address').textContent = document.getElementById('pickup_address').value.trim();

        const note = document.getElementById('customer_note').value.trim();
        const noteBox = document.getElementById('summary-note-box');
        if (note) {
            document.getElementById('summary-note').textContent = `"${note}"`;
            noteBox.classList.remove('hidden');
        } else {
            noteBox.classList.add('hidden');
        }

        // Service Info from data attributes
        const name = selectedRadio.dataset.name;
        const price = selectedRadio.dataset.price;
        const unit = selectedRadio.dataset.unit;
        const type = selectedRadio.dataset.type;
        const category = selectedRadio.dataset.category;

        document.getElementById('summary-service-name').textContent = name;
        document.getElementById('summary-service-type').textContent = `${category} • ${type}`;
        document.getElementById('summary-service-price').textContent = `Rp ${price} / ${unit}`;
    }

    // Step 3 submission validation (checkbox)
    document.getElementById('order-form').addEventListener('submit', function (e) {
        const agreeCheckbox = document.getElementById('agree-terms');
        const errAgree = document.getElementById('err-agree-terms');
        if (!agreeCheckbox.checked) {
            e.preventDefault();
            errAgree.textContent = 'Anda harus menyetujui syarat & ketentuan sebelum mengirimkan pesanan.';
            errAgree.classList.remove('hidden');
            return false;
        }
        errAgree.classList.add('hidden');
    });

    // Make completed tabs clickable to navigate back
    document.getElementById('step-tab-1').addEventListener('click', () => goToStep(1));
    document.getElementById('step-tab-2').addEventListener('click', () => {
        const nameInput = document.getElementById('recipient_name');
        if (nameInput.value.trim()) goToStep(2);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const isPkg = document.getElementById('type-package').checked;
        switchItemType(isPkg ? 'package' : 'service');
    });
</script>
@endsection
