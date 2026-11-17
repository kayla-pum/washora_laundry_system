@extends('layouts.user')

@section('title', 'Form Pemesanan Laundry - Washora')

@section('user-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Form Pemesanan Laundry</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pesan penjemputan cucian dengan 3 tahapan mudah.</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Riwayat</span>
        </a>
    </div>

    <!-- Stepper Navigation Indicator: 01 Pilih Layanan → 02 Isi Data Diri → 03 Konfirmasi -->
    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs">
        <div class="grid grid-cols-3 gap-2 sm:gap-3">
            <!-- Step 1 Tab -->
            <div id="step-tab-1" class="step-tab flex items-center gap-2 sm:gap-3 p-2.5 rounded-lg bg-brand-50 border border-brand-600 text-brand-700 transition-colors">
                <div class="w-7 h-7 rounded-md bg-brand-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                    01
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-semibold text-brand-600 tracking-wider">Tahap 1</p>
                    <p class="text-xs sm:text-sm font-bold truncate text-slate-900">Pilih Layanan</p>
                </div>
            </div>

            <!-- Step 2 Tab -->
            <div id="step-tab-2" class="step-tab flex items-center gap-2 sm:gap-3 p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-400 transition-colors">
                <div class="w-7 h-7 rounded-md bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">
                    02
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-semibold text-slate-400 tracking-wider">Tahap 2</p>
                    <p class="text-xs sm:text-sm font-semibold truncate text-slate-500">Isi Data Diri</p>
                </div>
            </div>

            <!-- Step 3 Tab -->
            <div id="step-tab-3" class="step-tab flex items-center gap-2 sm:gap-3 p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-400 transition-colors">
                <div class="w-7 h-7 rounded-md bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold shrink-0">
                    03
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] uppercase font-semibold text-slate-400 tracking-wider">Tahap 3</p>
                    <p class="text-xs sm:text-sm font-semibold truncate text-slate-500">Konfirmasi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Order Form -->
    <form action="{{ route('user.orders.store') }}" method="POST" id="order-form" class="space-y-6">
        @csrf

        <!-- ==========================================
             TAHAP 1: PILIH LAYANAN
             (Paket Bundling, Layanan Satuan, Layanan Kiloan)
             ========================================== -->
        <div id="step-content-1" class="space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                        Tentukan Jenis & Pilihan Layanan Laundry
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih salah satu dari 3 kategori layanan Washora yang Anda butuhkan.</p>
                </div>

                <!-- 3 Category Selectors (Paket Bundling, Layanan Satuan, Layanan Kiloan) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- A. Paket Bundling -->
                    <label class="cursor-pointer">
                        <input type="radio" name="item_type" value="package" id="type-package" class="peer sr-only" {{ $defaultType === 'package' ? 'checked' : '' }} onchange="switchServiceCategory('package')">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col items-center text-center gap-2 hover:border-slate-300">
                            <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-boxes-packing"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Paket Bundling</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Paket gabungan hemat pengerjaan terjadwal</p>
                            </div>
                        </div>
                    </label>

                    <!-- B. Layanan Satuan -->
                    <label class="cursor-pointer">
                        <input type="radio" name="item_type" value="satuan" id="type-satuan" class="peer sr-only" {{ $defaultType === 'satuan' ? 'checked' : '' }} onchange="switchServiceCategory('satuan')">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col items-center text-center gap-2 hover:border-slate-300">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Layanan Satuan</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Sepatu, tas, bedcover, boneka, formal</p>
                            </div>
                        </div>
                    </label>

                    <!-- C. Layanan Kiloan -->
                    <label class="cursor-pointer">
                        <input type="radio" name="item_type" value="kiloan" id="type-kiloan" class="peer sr-only" {{ $defaultType === 'kiloan' ? 'checked' : '' }} onchange="switchServiceCategory('kiloan')">
                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col items-center text-center gap-2 hover:border-slate-300">
                            <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">Layanan Kiloan</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5 leading-snug">Pencucian harian per kg (Regular & Express)</p>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- SECTION A: Pilihan Paket Bundling -->
                <div id="container-package" class="space-y-3 {{ $defaultType === 'package' ? '' : 'hidden' }}">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Paket Bundling Hemat Tersedia:</span>
                        <span class="text-[11px] text-slate-400">Pilih salah satu paket</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($packages as $pkg)
                            @php
                                $isPkgSelected = ($selectedPackageId == $pkg->id) || ($loop->first && $defaultType === 'package');
                            @endphp
                            <label class="cursor-pointer block relative">
                                <input type="radio" name="package_id" value="{{ $pkg->id }}"
                                    data-name="{{ $pkg->name }}"
                                    data-price="{{ number_format($pkg->price, 0, ',', '.') }}"
                                    data-unit="paket"
                                    data-category="Paket Bundling"
                                    data-time="Est. {{ $pkg->estimated_hours }} Jam"
                                    data-type="Paket Bundling"
                                    class="peer sr-only package-radio-item" {{ $isPkgSelected ? 'checked' : '' }}
                                    onchange="onItemSelect()">
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

                                        @if($pkg->services->isNotEmpty())
                                            <div class="pt-2">
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Layanan yang Termasuk:</p>
                                                <div class="flex flex-wrap gap-1.5">
                                                    @foreach($pkg->services as $incSvc)
                                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-[10px] font-semibold text-slate-700">
                                                            {{ $incSvc->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <span class="text-sm font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                                        <span class="text-[11px] font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-600 peer-checked:bg-brand-600 peer-checked:text-white transition-all">
                                            Pilih Paket
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- SECTION B: Pilihan Layanan Satuan -->
                <div id="container-satuan" class="space-y-3 {{ $defaultType === 'satuan' ? '' : 'hidden' }}">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Layanan Satuan (Per Pcs / Pasang):</span>
                        <span class="text-[11px] text-slate-400">Pilih salah satu layanan satuan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[460px] overflow-y-auto p-1">
                        @foreach($satuanServices as $service)
                            @php
                                $isSatuanSelected = ($selectedServiceId == $service->id) || ($loop->first && $defaultType === 'satuan');
                            @endphp
                            <label class="cursor-pointer block relative">
                                <input type="radio" name="service_id" value="{{ $service->id }}"
                                    data-name="{{ $service->name }}"
                                    data-price="{{ number_format($service->price, 0, ',', '.') }}"
                                    data-unit="{{ $service->unit }}"
                                    data-category="Layanan Satuan ({{ $service->category->name ?? 'Umum' }})"
                                    data-time="{{ $service->service_type === 'express' ? 'Express (' . $service->estimated_hours . ' Jam)' : 'Regular (' . $service->estimated_hours . ' Jam)' }}"
                                    data-type="Layanan Satuan"
                                    class="peer sr-only satuan-radio-item" {{ $isSatuanSelected ? 'checked' : '' }}
                                    onchange="onItemSelect()">
                                <div class="p-5 rounded-3xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col justify-between h-full hover:border-slate-300">
                                    <div class="space-y-2.5">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-purple-100 text-purple-700' }}">
                                                {{ $service->service_type === 'express' ? '⚡ Express (' . $service->estimated_hours . ' Jam)' : '⏱️ Regular (' . $service->estimated_hours . ' Jam)' }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400">{{ $service->category->name ?? 'Umum' }}</span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $service->name }}</h4>
                                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $service->description ?? 'Pencucian bahan khusus dengan perlakuan profesional & higienis.' }}</p>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <div>
                                            <span class="text-xs font-black text-brand-700">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                            <span class="text-[11px] text-slate-400">/ {{ $service->unit }}</span>
                                        </div>
                                        <span class="text-[11px] font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-600 peer-checked:bg-brand-600 peer-checked:text-white transition-all">
                                            Pilih Satuan
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- SECTION C: Pilihan Layanan Kiloan -->
                <div id="container-kiloan" class="space-y-4 {{ $defaultType === 'kiloan' ? '' : 'hidden' }}">
                    <!-- Info Penimbangan Kiloan -->
                    <div class="p-4 bg-cyan-50/80 border border-cyan-200 rounded-2xl flex items-start gap-3 text-cyan-950 text-xs">
                        <i class="fa-solid fa-circle-info text-cyan-600 text-base mt-0.5 shrink-0"></i>
                        <p class="leading-relaxed">
                            <strong>Tidak Perlu Menimbang Sendiri:</strong> Pada layanan kiloan, Anda tidak perlu mengisi estimasi berat. Tim kurir Washora akan menjemput dan admin menimbang secara akurat di outlet kami.
                        </p>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Daftar Layanan Cuci Kiloan (Per Kg):</span>
                        <span class="text-[11px] text-slate-400">Pilih salah satu layanan kiloan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($kiloanServices as $service)
                            @php
                                $isKiloanSelected = ($selectedServiceId == $service->id) || ($loop->first && $defaultType === 'kiloan');
                            @endphp
                            <label class="cursor-pointer block relative">
                                <input type="radio" name="service_id" value="{{ $service->id }}"
                                    data-name="{{ $service->name }}"
                                    data-price="{{ number_format($service->price, 0, ',', '.') }}"
                                    data-unit="{{ $service->unit }}"
                                    data-category="Layanan Kiloan ({{ $service->category->name ?? 'Cuci Kiloan' }})"
                                    data-time="{{ $service->service_type === 'express' ? 'Express (' . $service->estimated_hours . ' Jam)' : 'Regular (' . $service->estimated_hours . ' Jam)' }}"
                                    data-type="Layanan Kiloan"
                                    class="peer sr-only kiloan-radio-item" {{ $isKiloanSelected ? 'checked' : '' }}
                                    onchange="onItemSelect()">
                                <div class="p-5 rounded-3xl border-2 border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/40 peer-checked:ring-4 peer-checked:ring-brand-500/10 transition-all flex flex-col justify-between h-full hover:border-slate-300">
                                    <div class="space-y-2.5">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-cyan-100 text-cyan-800' }}">
                                                {{ $service->service_type === 'express' ? '⚡ Express (' . $service->estimated_hours . ' Jam)' : '⏱️ Regular (' . $service->estimated_hours . ' Jam)' }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400">1 Mesin 1 Pelanggan</span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $service->name }}</h4>
                                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $service->description ?? 'Cuci bersih, wangi, higienis, dan diproses tanpa dicampur pakaian lain.' }}</p>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <div>
                                            <span class="text-xs font-black text-brand-700">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                            <span class="text-[11px] text-slate-400">/ {{ $service->unit }}</span>
                                        </div>
                                        <span class="text-[11px] font-bold px-3 py-1 rounded-xl bg-slate-100 text-slate-600 peer-checked:bg-brand-600 peer-checked:text-white transition-all">
                                            Pilih Kiloan
                                        </span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <p id="err-selection" class="text-rose-600 text-xs font-semibold hidden"></p>

                <div class="pt-4 border-t border-slate-100 space-y-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">Informasi Tambahan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Sampaikan kondisi barang agar tim kami dapat menanganinya dengan tepat.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="flex flex-col justify-between">
                            <label for="has_valuable_items" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 sm:h-9 flex items-start">
                                <span>Apakah terdapat barang berharga? <span class="text-rose-500">*</span></span>
                            </label>
                            <div>
                                <select id="has_valuable_items" name="has_valuable_items" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1" {{ old('has_valuable_items') === '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('has_valuable_items') === '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                <p id="err-has_valuable_items" class="text-rose-600 text-xs mt-1 hidden"></p>
                                @error('has_valuable_items')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-col justify-between">
                            <label for="has_color_bleeding_risk" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2 sm:h-9 flex items-start">
                                <span>Apakah terdapat bahan atau warna yang mudah luntur? <span class="text-rose-500">*</span></span>
                            </label>
                            <div>
                                <select id="has_color_bleeding_risk" name="has_color_bleeding_risk" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                                    <option value="">Pilih jawaban</option>
                                    <option value="1" {{ old('has_color_bleeding_risk') === '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('has_color_bleeding_risk') === '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                <p id="err-has_color_bleeding_risk" class="text-rose-600 text-xs mt-1 hidden"></p>
                                @error('has_color_bleeding_risk')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="customer_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Catatan Tambahan (Opsional)
                        </label>
                        <textarea id="customer_note" name="customer_note" rows="3" maxlength="500" placeholder="Tuliskan catatan atau instruksi khusus untuk pesanan Anda..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">{{ old('customer_note') }}</textarea>
                        @error('customer_note')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Button Tahap 1 -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="validateStep1AndProceed()" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-brand-600/25 transition-all flex items-center justify-center gap-2">
                        <span>Lanjutkan ke Isi Data Diri</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAHAP 2: ISI DATA DIRI
             (Nama, No. Telepon Aktif, Alamat Penjemputan)
             ========================================== -->
        <div id="step-content-2" class="space-y-6 hidden">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                        Isi Formulir Data Diri & Alamat Penjemputan
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Semua data wajib harus diisi dengan benar agar kurir dapat menjemput cucian Anda.</p>
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

                    <!-- Nomor Telepon Aktif / WhatsApp -->
                    <div>
                        <label for="whatsapp_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nomor Telepon / WhatsApp Aktif <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-xs font-bold text-slate-400">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                            </span>
                            <input type="tel" id="whatsapp_number" name="whatsapp_number" required inputmode="numeric" pattern="[0-9]*" maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('whatsapp_number', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Hanya angka 0–9. Konfirmasi timbangan dan rincian biaya akan dikirimkan ke nomor ini.</p>
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
                    <textarea id="pickup_address" name="pickup_address" rows="3" required placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, dan patokan (misal: Rumah pagar hitam samping toko)" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">{{ old('pickup_address') }}</textarea>
                    <p id="err-pickup_address" class="text-rose-600 text-xs mt-1 hidden"></p>
                    @error('pickup_address')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons Tahap 2 -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(1)" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs border border-slate-200 rounded-2xl transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Pilih Layanan</span>
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
             (Ringkasan, Tanpa Input Berat, Tombol Kirim)
             ========================================== -->
        <div id="step-content-3" class="space-y-6 hidden">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">3</span>
                        Konfirmasi Ringkasan Pemesanan
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pastikan seluruh data dan pilihan layanan sudah sesuai sebelum mengirim pesanan.</p>
                </div>

                <!-- Summary Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 1. Layanan yang Dipilih -->
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/70 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Layanan yang Dipilih</span>
                            <button type="button" onclick="goToStep(1)" class="text-[11px] font-bold text-brand-600 hover:underline">Ubah Pilihan</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Jenis Kategori:</span>
                                <span id="summary-category-type" class="font-extrabold text-brand-700 text-sm">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Layanan / Paket:</span>
                                <span id="summary-item-name" class="font-bold text-slate-800 text-sm">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Waktu Pengerjaan:</span>
                                <span id="summary-item-time" class="font-semibold text-slate-700">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Tarif Dasar / Estimasi Harga:</span>
                                <span id="summary-item-price" class="font-black text-slate-900 text-base">-</span>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-slate-200/60 space-y-2 text-xs">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Informasi Tambahan:</span>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Barang berharga:</span>
                                <span id="summary-has-valuable-items" class="font-semibold text-slate-700">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Bahan atau warna mudah luntur:</span>
                                <span id="summary-has-color-bleeding-risk" class="font-semibold text-slate-700">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Catatan tambahan:</span>
                                <span id="summary-customer-note" class="italic text-slate-600 block break-words">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Data Diri & Penjemputan -->
                    <div class="bg-slate-50 p-5 rounded-3xl border border-slate-200/70 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-200/60">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Data Pemesan</span>
                            <button type="button" onclick="goToStep(2)" class="text-[11px] font-bold text-brand-600 hover:underline">Ubah Data</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Lengkap:</span>
                                <span id="summary-customer-name" class="font-bold text-slate-800 text-sm">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor Telepon / WhatsApp:</span>
                                <span id="summary-customer-phone" class="font-bold text-slate-800">-</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Alamat Lengkap Penjemputan:</span>
                                <span id="summary-customer-address" class="font-medium text-slate-700 leading-relaxed block">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Explanation Note on Weighing & Payment -->
                <div class="p-5 bg-brand-50/70 border border-brand-200/80 rounded-3xl space-y-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-brand-700 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        Informasi Penimbangan & Pembayaran
                    </h4>
                    <p class="text-xs text-brand-900 leading-relaxed space-y-1">
                        <span class="block">1. <strong>Tanpa Input Berat:</strong> Untuk layanan kiloan, Anda tidak perlu menginputkan berat cucian. Pakaian akan ditimbang secara akurat dan transparan oleh tim admin Washora di outlet.</span>
                        <span class="block">2. <strong>Konfirmasi WhatsApp:</strong> Total harga resmi dan rincian berat aktual akan dikonfirmasikan langsung melalui pesan WhatsApp sebelum proses pencucian dimulai.</span>
                        <span class="block text-amber-900 bg-amber-100/70 p-2 rounded-xl border border-amber-200 mt-2">
                            <i class="fa-solid fa-info-circle mr-1 text-amber-700"></i>
                            <strong>Pembayaran:</strong> Pembayaran dilakukan secara langsung melalui admin setelah pesanan diperiksa dan harga akhir ditentukan. Admin akan menghubungi Anda melalui WhatsApp untuk memberikan informasi lebih lanjut mengenai total biaya dan metode pembayaran.
                        </span>
                    </p>
                </div>

                <!-- Terms and Agreement Checkbox -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="agree_terms" required class="mt-0.5 w-4 h-4 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        <span class="text-xs text-slate-700 leading-relaxed">
                            Saya menyetujui syarat & ketentuan layanan penjemputan dan pencucian Washora. Saya mengonfirmasi bahwa data yang diisi telah benar.
                        </span>
                    </label>
                    <p id="err-agree_terms" class="text-rose-600 text-xs mt-1 hidden"></p>
                </div>

                <!-- Action Buttons Tahap 3 -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(2)" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs border border-slate-200 rounded-2xl transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Data Diri</span>
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

        document.getElementById('step-content-1').classList.toggle('hidden', step !== 1);
        document.getElementById('step-content-2').classList.toggle('hidden', step !== 2);
        document.getElementById('step-content-3').classList.toggle('hidden', step !== 3);

        updateTabStyles(step);
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
                tab.className = 'step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 transition-all cursor-pointer';
                badge.className = 'w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs font-black shrink-0 shadow-xs';
                badge.innerHTML = '<i class="fa-solid fa-check"></i>';
                title.className = 'text-xs sm:text-sm font-bold truncate text-slate-800';
            } else {
                tab.className = 'step-tab flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-2xl bg-slate-50 border border-slate-200 text-slate-400 transition-all';
                badge.className = 'w-8 h-8 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-black shrink-0';
                badge.textContent = `0${i}`;
                title.className = 'text-xs sm:text-sm font-extrabold truncate text-slate-500';
            }
        }
    }

    function switchServiceCategory(type) {
        const cPkg = document.getElementById('container-package');
        const cSat = document.getElementById('container-satuan');
        const cKil = document.getElementById('container-kiloan');

        cPkg.classList.toggle('hidden', type !== 'package');
        cSat.classList.toggle('hidden', type !== 'satuan');
        cKil.classList.toggle('hidden', type !== 'kiloan');

        // Automatically select the first visible item in this category if none in this category is selected
        if (type === 'package') {
            const firstPkg = document.querySelector('.package-radio-item');
            if (firstPkg && !document.querySelector('.package-radio-item:checked')) {
                firstPkg.checked = true;
            }
        } else if (type === 'satuan') {
            const firstSat = document.querySelector('.satuan-radio-item');
            if (firstSat && !document.querySelector('.satuan-radio-item:checked')) {
                firstSat.checked = true;
            }
        } else if (type === 'kiloan') {
            const firstKil = document.querySelector('.kiloan-radio-item');
            if (firstKil && !document.querySelector('.kiloan-radio-item:checked')) {
                firstKil.checked = true;
            }
        }

        onItemSelect();
    }

    function onItemSelect() {
        document.getElementById('err-selection').classList.add('hidden');
    }

    function getSelectedItem() {
        const itemType = document.querySelector('input[name="item_type"]:checked').value;
        let selected = null;
        if (itemType === 'package') {
            selected = document.querySelector('.package-radio-item:checked');
        } else if (itemType === 'satuan') {
            selected = document.querySelector('.satuan-radio-item:checked');
        } else {
            selected = document.querySelector('.kiloan-radio-item:checked');
        }
        return { itemType, selected };
    }

    function validateStep1AndProceed() {
        const { itemType, selected } = getSelectedItem();
        const errSelection = document.getElementById('err-selection');
        const valuableItemsInput = document.getElementById('has_valuable_items');
        const colorBleedingRiskInput = document.getElementById('has_color_bleeding_risk');
        let isValid = true;

        if (!selected) {
            errSelection.textContent = 'Silakan pilih salah satu paket atau layanan laundry terlebih dahulu.';
            errSelection.classList.remove('hidden');
            isValid = false;
        } else {
            errSelection.classList.add('hidden');
        }

        const valuableItemsError = document.getElementById('err-has_valuable_items');
        valuableItemsError.classList.toggle('hidden', valuableItemsInput.value !== '');
        if (valuableItemsInput.value === '') {
            valuableItemsError.textContent = 'Silakan pilih jawaban untuk barang berharga.';
            isValid = false;
        }

        const colorBleedingRiskError = document.getElementById('err-has_color_bleeding_risk');
        colorBleedingRiskError.classList.toggle('hidden', colorBleedingRiskInput.value !== '');
        if (colorBleedingRiskInput.value === '') {
            colorBleedingRiskError.textContent = 'Silakan pilih jawaban untuk bahan atau warna yang mudah luntur.';
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        goToStep(2);
    }

    function validateStep2AndProceed() {
        const nameInput = document.getElementById('recipient_name');
        const phoneInput = document.getElementById('whatsapp_number');
        const addressInput = document.getElementById('pickup_address');

        let isValid = true;

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
            err.textContent = 'Nomor telepon / WhatsApp aktif wajib diisi.';
            err.classList.remove('hidden');
            isValid = false;
        } else if (!/^[0-9]+$/.test(phoneVal)) {
            const err = document.getElementById('err-whatsapp_number');
            err.textContent = 'Nomor telepon hanya boleh berisi angka (0–9) tanpa huruf atau simbol.';
            err.classList.remove('hidden');
            isValid = false;
        } else if (phoneVal.length < 8 || phoneVal.length > 20) {
            const err = document.getElementById('err-whatsapp_number');
            err.textContent = 'Nomor telepon tidak valid (minimal 8 digit dan maksimal 20 digit angka).';
            err.classList.remove('hidden');
            isValid = false;
        }

        if (!addressInput.value.trim() || addressInput.value.trim().length < 5) {
            const err = document.getElementById('err-pickup_address');
            err.textContent = 'Alamat lengkap penjemputan cucian wajib diisi (minimal 5 karakter).';
            err.classList.remove('hidden');
            isValid = false;
        }

        if (isValid) {
            populateStep3Summary();
            goToStep(3);
        }
    }

    function populateStep3Summary() {
        const { itemType, selected } = getSelectedItem();

        if (selected) {
            const categoryLabel = selected.dataset.category || (itemType === 'package' ? 'Paket Bundling' : (itemType === 'satuan' ? 'Layanan Satuan' : 'Layanan Kiloan'));
            document.getElementById('summary-category-type').textContent = categoryLabel;
            document.getElementById('summary-item-name').textContent = selected.dataset.name;
            document.getElementById('summary-item-time').textContent = selected.dataset.time;

            if (itemType === 'kiloan') {
                document.getElementById('summary-item-price').textContent = `Rp ${selected.dataset.price} / Kg (Timbang di outlet)`;
            } else if (itemType === 'satuan') {
                document.getElementById('summary-item-price').textContent = `Rp ${selected.dataset.price} / ${selected.dataset.unit}`;
            } else {
                document.getElementById('summary-item-price').textContent = `Rp ${selected.dataset.price} / paket`;
            }
        }

        document.getElementById('summary-has-valuable-items').textContent =
            document.getElementById('has_valuable_items').value === '1' ? 'Ya' : 'Tidak';
        document.getElementById('summary-has-color-bleeding-risk').textContent =
            document.getElementById('has_color_bleeding_risk').value === '1' ? 'Ya' : 'Tidak';
        document.getElementById('summary-customer-name').textContent = document.getElementById('recipient_name').value.trim();
        document.getElementById('summary-customer-phone').textContent = document.getElementById('whatsapp_number').value.trim();
        document.getElementById('summary-customer-address').textContent = document.getElementById('pickup_address').value.trim();

        const note = document.getElementById('customer_note').value.trim();
        document.getElementById('summary-customer-note').textContent = note || '-';
    }

    document.getElementById('order-form').addEventListener('submit', function (e) {
        const agreeCheckbox = document.getElementById('agree_terms');
        const errAgree = document.getElementById('err-agree_terms');
        if (!agreeCheckbox.checked) {
            e.preventDefault();
            errAgree.textContent = 'Anda harus menyetujui syarat & ketentuan sebelum mengirimkan pesanan.';
            errAgree.classList.remove('hidden');
            return false;
        }
        errAgree.classList.add('hidden');
    });

    // Make completed tabs clickable
    document.getElementById('step-tab-1').addEventListener('click', () => goToStep(1));
    document.getElementById('step-tab-2').addEventListener('click', () => validateStep1AndProceed());
</script>
@endsection
