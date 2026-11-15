@extends('layouts.app')

@section('title', 'Washora - Sistem Informasi & Layanan Laundry Modern')

@section('content')
    <!-- Public Navbar -->
    @include('layouts.navigation')

    <!-- ==========================================
         1. HERO SECTION (#beranda)
         ========================================== -->
    <section id="beranda" class="relative bg-slate-50/70 border-b border-slate-200/80 pt-10 pb-16 lg:pt-16 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Left Column: Copy & CTAs -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-slate-900 leading-tight">
                        Perawatan Pakaian Bersih, Rapi, & Higienis Tanpa Ribet
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Serahkan cucian Anda kepada tim profesional Washora. Kami melayani cuci kiloan dan satuan dengan fasilitas antar-jemput ke alamat Anda, penimbangan transparan di outlet, dan konfirmasi rincian nota langsung via WhatsApp.
                    </p>

                    <!-- Dual Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-2">
                        <a href="{{ route('user.orders.create') }}" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm shadow-xs transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus text-xs"></i>
                            <span>Pesan Penjemputan Sekarang</span>
                        </a>

                        <a href="{{ route('services') }}" class="w-full sm:w-auto px-5 py-3 rounded-lg bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm border border-slate-300 shadow-xs transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-list-ul text-brand-600 text-xs"></i>
                            <span>Lihat Layanan & Tarif</span>
                        </a>
                    </div>

                    <!-- Operational Highlights -->
                    <div class="pt-3 border-t border-slate-200/80 flex flex-wrap items-center justify-center lg:justify-start gap-x-6 gap-y-2 text-xs font-medium text-slate-600">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-600 text-[11px]"></i> 1 Mesin 1 Pelanggan
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-600 text-[11px]"></i> Tanpa Timbang di Rumah
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check text-emerald-600 text-[11px]"></i> Konfirmasi Nota via WhatsApp
                        </span>
                    </div>
                </div>

                <!-- Right Column: Operational Info & Direct Tracking Card -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-6">
                        
                        <!-- Track Order Box -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                                    <span>Lacak Status Cucian Anda</span>
                                </h2>
                                <span class="text-[11px] font-medium text-slate-400">Real-time</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Masukkan kode pesanan Washora untuk memeriksa tahap pengerjaan pakaian Anda secara langsung.
                            </p>

                            <form action="{{ route('tracking') }}" method="GET" class="flex gap-2">
                                <div class="relative flex-1">
                                    <i class="fa-solid fa-receipt absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                                    <input type="text" name="code" required placeholder="Contoh: WSH-20261112-001" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                                </div>
                                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition-colors shrink-0">
                                    Cek Resi
                                </button>
                            </form>
                        </div>

                        <!-- Outlet Operational Summary -->
                        <div class="pt-5 border-t border-slate-100 space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Informasi Operasional Outlet
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 space-y-1">
                                    <p class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5">
                                        <i class="fa-regular fa-clock text-brand-600"></i> Jam Buka
                                    </p>
                                    <p class="font-bold text-slate-800">07.00 - 21.00 WIB</p>
                                    <p class="text-[10px] text-slate-400">Buka Setiap Hari</p>
                                </div>

                                <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 space-y-1">
                                    <p class="text-[11px] font-semibold text-slate-500 flex items-center gap-1.5">
                                        <i class="fa-solid fa-bolt text-amber-600"></i> Pilihan Waktu
                                    </p>
                                    <p class="font-bold text-slate-800">Reguler & Express</p>
                                    <p class="text-[10px] text-slate-400">Express 3 & 6 Jam</p>
                                </div>
                            </div>

                            <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-between text-xs">
                                <div>
                                    <p class="font-bold text-slate-800">Butuh Bantuan atau Konsultasi?</p>
                                    <p class="text-[11px] text-slate-500">Hubungi CS kami di 0812-3456-7890</p>
                                </div>
                                <a href="https://wa.me/6281234567890?text=Halo%20Washora%2C%20saya%20ingin%20bertanya%20layanan%20laundry" target="_blank" class="px-3 py-1.5 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-xs flex items-center gap-1.5 transition-colors shrink-0">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>Chat WA</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==========================================
         2. KEUNGGULAN SECTION (#keunggulan)
         (Wajib Tepat Setelah Hero)
         ========================================== -->
    <section id="keunggulan" class="py-14 sm:py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12 space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-semibold">
                    Keunggulan Layanan
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Kenapa Mempercayakan Pakaian Anda pada Washora?</h2>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">Standar kerja yang kami terapkan untuk memastikan pakaian Anda bersih, higienis, terawat, dan selesai tepat waktu.</p>
            </div>

            <!-- 5 Balanced Advantage Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-5">
                <!-- 1. Pelayanan Praktis Tanpa Timbang -->
                <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-9 h-9 rounded-lg bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Pelayanan Praktis Tanpa Timbang
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Tidak perlu repot menimbang sendiri di rumah. Kurir kami menjemput dan penimbangan dilakukan akurat di outlet dengan timbangan digital terkalibrasi.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium text-brand-600 pt-2 border-t border-slate-100 flex items-center gap-1">
                        <i class="fa-solid fa-check text-[10px]"></i> Akurat di Outlet
                    </p>
                </div>

                <!-- 2. Pilihan Fleksibel Reguler & Express -->
                <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-700 border border-amber-100 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Pilihan Fleksibel Reguler & Express
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pilihan durasi fleksibel mulai dari paket reguler hemat (24-48 jam) hingga express kilat 3 jam dan 6 jam saat Anda butuh pakaian cepat bersih.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium text-amber-700 pt-2 border-t border-slate-100 flex items-center gap-1">
                        <i class="fa-solid fa-check text-[10px]"></i> Opsi 3 & 6 Jam
                    </p>
                </div>

                <!-- 3. Pakaian Terorganisir & Higienis -->
                <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-hands-bubbles"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Pakaian Terorganisir & Higienis
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Prinsip 1 mesin 1 pelanggan menjamin pakaian tidak pernah dicampur dengan orang lain. Dicuci menggunakan air terfiltrasi dan detergen antibakteri.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium text-emerald-700 pt-2 border-t border-slate-100 flex items-center gap-1">
                        <i class="fa-solid fa-check text-[10px]"></i> 1 Mesin 1 Pelanggan
                    </p>
                </div>

                <!-- 4. Informasi Status Pesanan Realtime -->
                <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-700 border border-cyan-100 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-satellite-dish"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Informasi Status Pesanan Realtime
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pantau tahapan pencucian secara langsung melalui kode resi di website dan konfirmasi rincian nota digital melalui WhatsApp resmi kami.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium text-cyan-700 pt-2 border-t border-slate-100 flex items-center gap-1">
                        <i class="fa-solid fa-check text-[10px]"></i> Tracking Web & WA
                    </p>
                </div>

                <!-- 5. Layanan Antar-Jemput Mudah -->
                <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4 sm:col-span-2 lg:col-span-1 sm:max-w-md sm:mx-auto lg:max-w-none w-full">
                    <div class="space-y-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Layanan Antar-Jemput Mudah
                        </h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pemesanan online praktis dari rumah atau kantor. Kurir Washora sigap menjemput dan mengantarkan kembali pakaian dalam keadaan bersih, rapi, dan harum.
                        </p>
                    </div>
                    <p class="text-[11px] font-medium text-indigo-700 pt-2 border-t border-slate-100 flex items-center gap-1">
                        <i class="fa-solid fa-check text-[10px]"></i> Jemput ke Alamat
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         3. LAYANAN SECTION (#layanan)
         (Wajib Setelah Keunggulan)
         ========================================== -->
    <section id="layanan" class="py-14 sm:py-16 bg-slate-50/70 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold">
                    Layanan & Tarif
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Pilihan Layanan Laundry Unggulan</h2>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">Tarif transparan tanpa biaya tersembunyi. Disesuaikan dengan kebutuhan pakaian harian hingga barang khusus.</p>

                <!-- Filter Button Regular / Express -->
                <div class="flex justify-center pt-4">
                    <div class="inline-flex items-center bg-white border border-slate-200 rounded-lg p-1 shadow-xs">
                        <button
                            type="button"
                            id="btn-all"
                            onclick="filterLayanan('all')"
                            class="filter-btn px-4 py-1.5 rounded-md text-xs font-semibold bg-brand-600 text-white transition-colors"
                        >
                            Semua
                        </button>
                        <button
                            type="button"
                            id="btn-regular"
                            onclick="filterLayanan('regular')"
                            class="filter-btn px-4 py-1.5 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            Reguler
                        </button>
                        <button
                            type="button"
                            id="btn-express"
                            onclick="filterLayanan('express')"
                            class="filter-btn px-4 py-1.5 rounded-md text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors"
                        >
                            Express
                        </button>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="services-grid">
                @foreach($featuredServices as $service)
                    <div class="service-card bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-all flex flex-col justify-between" data-service-type="{{ strtolower($service->service_type) }}">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $service->service_type === 'express' ? 'Express (' . $service->estimated_hours . ' Jam)' : 'Reguler (' . $service->estimated_hours . ' Jam)' }}
                                </span>
                                <span class="text-xs font-medium text-slate-400">
                                    {{ $service->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900">
                                {{ $service->name }}
                            </h3>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                {{ $service->description ?? 'Layanan pencucian profesional dengan detergen antibakteri dan aroma wangi segar.' }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] uppercase font-semibold text-slate-400">Tarif</p>
                                <p class="text-lg font-bold text-slate-900">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-slate-500">/ {{ $service->unit }}</span>
                                </p>
                            </div>

                            <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-700 text-xs font-semibold transition-colors flex items-center gap-1.5">
                                <span>Pilih</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Package Bundles Showcase if available -->
            @if(isset($packages) && $packages->isNotEmpty())
                <div class="mt-12 pt-10 border-t border-slate-200">
                    <div class="text-center max-w-xl mx-auto mb-8 space-y-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-brand-600">Pilihan Paket Hemat</span>
                        <h3 class="text-xl font-bold text-slate-900">Paket Hemat Laundry Pilihan</h3>
                        <p class="text-slate-500 text-xs">Pilihan paket hemat untuk kebutuhan laundry rutin mingguan atau bulanan Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($packages as $pkg)
                            <div class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-400 hover:shadow-xs transition-colors flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center text-sm">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $pkg->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">{{ $pkg->description }}</p>
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                                        <p class="text-[10px] text-slate-400 font-medium uppercase">Tarif Paket</p>
                                        <p class="text-lg font-bold text-slate-900">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Est. Pengerjaan {{ $pkg->estimated_hours }} Jam</p>
                                    </div>
                                </div>

                                <a href="{{ route('user.orders.create', ['package_id' => $pkg->id]) }}" class="w-full py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold text-center block transition-colors">
                                    Pesan Paket
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Link Lihat Selengkapnya -->
            <div class="text-center mt-10">
                <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg bg-white hover:bg-slate-50 text-brand-600 border border-slate-300 font-semibold text-xs transition-colors shadow-xs">
                    <span>Lihat Selengkapnya</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================
         4. CARA KERJA SECTION (#cara-kerja)
         (Wajib Setelah Layanan - 5 Langkah)
         ========================================== -->
    <section id="cara-kerja" class="py-14 sm:py-16 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-semibold">
                    Alur Pemesanan
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">5 Langkah Praktis Mencuci di Washora</h2>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">Proses pemesanan mudah tanpa perlu timbang sendiri dari rumah. Transparan, higienis, dan terpercaya.</p>
            </div>

            <!-- 5 Steps Flow -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 lg:gap-5">
                <!-- Langkah 1: Pilih Layanan -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-md bg-brand-600 text-white flex items-center justify-center font-bold text-xs">
                                01
                            </span>
                            <i class="fa-solid fa-list-check text-slate-400 text-sm"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">1. Pilih Layanan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pilih kategori layanan (Kiloan/Satuan) atau paket hemat yang sesuai kebutuhan pakaian Anda.
                        </p>
                    </div>
                </div>

                <!-- Langkah 2: Isi Data Pemesanan -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-md bg-brand-600 text-white flex items-center justify-center font-bold text-xs">
                                02
                            </span>
                            <i class="fa-solid fa-file-pen text-slate-400 text-sm"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">2. Isi Data Pemesanan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Cantumkan nama, nomor WhatsApp aktif, alamat penjemputan, serta catatan khusus untuk pakaian Anda.
                        </p>
                    </div>
                </div>

                <!-- Langkah 3: Penjemputan & Timbang -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-md bg-brand-600 text-white flex items-center justify-center font-bold text-xs">
                                03
                            </span>
                            <i class="fa-solid fa-truck text-slate-400 text-sm"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">3. Penjemputan & Pemeriksaan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Kurir menjemput pakaian kotor, tim outlet menimbang secara akurat dan mengabarkan nota rincian via WA.
                        </p>
                    </div>
                </div>

                <!-- Langkah 4: Proses Laundry -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-md bg-brand-600 text-white flex items-center justify-center font-bold text-xs">
                                04
                            </span>
                            <i class="fa-solid fa-water text-slate-400 text-sm"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">4. Proses Laundry</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Cucian diproses secara higienis (1 mesin 1 pelanggan) dengan detergen antibakteri dan setrika uap rapi.
                        </p>
                    </div>
                </div>

                <!-- Langkah 5: Pesanan Selesai -->
                <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="w-7 h-7 rounded-md bg-emerald-600 text-white flex items-center justify-center font-bold text-xs">
                                05
                            </span>
                            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">5. Pesanan Selesai</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pakaian bersih, wangi, dan rapi diantar kembali ke lokasi Anda atau siap diambil di outlet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         5. TESTIMONI SECTION (#testimoni)
         (Wajib Tepat Setelah Cara Kerja)
         ========================================== -->
    <section id="testimoni" class="py-14 sm:py-16 bg-slate-50/70 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold">
                    Ulasan Pelanggan
                </span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Testimoni Pelanggan Washora</h2>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">Pengalaman nyata dari pelanggan yang mempercayakan kebutuhan pakaian bersih mereka kepada kami.</p>
            </div>

            @if(isset($testimonials) && $testimonials->isNotEmpty())
                <!-- Real Testimonials Grid from Database -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($testimonials as $testi)
                        <div class="bg-white rounded-xl p-5 border border-slate-200 flex flex-col justify-between shadow-2xs">
                            <div class="space-y-3">
                                <!-- Star Rating -->
                                <div class="flex items-center gap-1 text-amber-500 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testi->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star text-slate-300"></i>
                                        @endif
                                    @endfor
                                    <span class="text-slate-500 text-[11px] font-semibold ml-1">{{ $testi->rating }}.0</span>
                                </div>

                                <p class="text-xs text-slate-700 leading-relaxed italic">
                                    "{{ $testi->comment ?? $testi->review_text }}"
                                </p>
                            </div>

                            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-700 font-semibold flex items-center justify-center text-xs border border-brand-100">
                                        {{ strtoupper(substr($testi->customer_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-xs text-slate-900">{{ $testi->customer_name }}</h4>
                                        <p class="text-[10px] text-slate-400">Pelanggan Terverifikasi</p>
                                    </div>
                                </div>
                                @if($testi->created_at)
                                    <span class="text-[10px] text-slate-400">
                                        {{ $testi->created_at->translatedFormat('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Clean & Elegant Empty State Placeholder (No Fake Data) -->
                <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-xl p-8 text-center space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center mx-auto text-lg">
                        <i class="fa-regular fa-comments"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-slate-900">Ulasan Pelanggan Akan Segera Hadir</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Kami mengutamakan ulasan nyata dari pelanggan. Ulasan yang telah disetujui akan ditampilkan secara otomatis di sini.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('user.orders.create') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold transition-colors">
                            <i class="fa-solid fa-cart-plus text-xs"></i>
                            <span>Pesan Layanan Sekarang</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Professional Callout Section -->
    <section class="py-12 bg-slate-900 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-5">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Siap Menikmati Pakaian Bersih, Rapi & Wangi Hari Ini?</h2>
            <p class="text-slate-300 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                Buat pesanan penjemputan sekarang tanpa repot menimbang dari rumah. Kurir Washora siap menjemput cucian kotor Anda.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-1">
                <a href="{{ route('user.orders.create') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs transition-colors shadow-xs">
                    Pesan Sekarang
                </a>
                <a href="{{ route('user.register') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition-colors">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </section>

    <!-- Public Footer -->
    @include('layouts.footer')

<script>
    function filterLayanan(type) {
        const cards = document.querySelectorAll('.service-card');

        cards.forEach(card => {
            const serviceType = card.dataset.serviceType;

            if (type === 'all' || serviceType === type) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });

        // Reset button states
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-brand-600', 'text-white');
            btn.classList.add('text-slate-600');
        });

        const activeBtn = document.getElementById(
            type === 'all' ? 'btn-all' : (type === 'regular' ? 'btn-regular' : 'btn-express')
        );

        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600');
            activeBtn.classList.add('bg-brand-600', 'text-white');
        }
    }
</script>
@endsection
