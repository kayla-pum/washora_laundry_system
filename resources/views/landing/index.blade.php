@extends('layouts.app')

@section('title', 'Washora - Sistem Informasi & Layanan Laundry Modern')

@section('content')
    <!-- Public Navbar -->
    @include('layouts.navigation')

    <!-- ==========================================
         1. HERO SECTION (#beranda)
         ========================================== -->
    <section id="beranda" class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-brand-50/60 via-white to-slate-50">
        <!-- Decorative Glow & Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Column: Copy & CTAs -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-100/80 border border-brand-200 text-brand-700 text-xs font-bold">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>Smart Laundry System Terpercaya</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                        Solusi Laundry Modern, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-brand-500 to-cyan-500">Bersih, Cepat & Praktis.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Pesan laundry tanpa ribet menimbang di rumah. Nikmati layanan antar-jemput, tracking pengerjaan realtime, serta konfirmasi akurat & transparan langsung ke WhatsApp Anda.
                    </p>

                    <!-- Dual Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-2">
                        <a href="{{ route('user.orders.create') }}" class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl shadow-brand-600/25 hover:shadow-brand-600/35 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>Pesan Sekarang</span>
                        </a>

                        <button type="button" onclick="openSearchModal()" class="w-full sm:w-auto px-6 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-base border border-slate-200 shadow-sm hover:border-slate-300 transition-all flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                            <span>Lacak Status Cucian</span>
                        </button>
                    </div>

                    <!-- Quick Highlights -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs font-semibold text-slate-500">
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> 1 Mesin 1 Pelanggan
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Detergen Ramah Lingkungan
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-700">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Notifikasi WhatsApp
                        </span>
                    </div>
                </div>

                <!-- Right Column: Interactive Card / Showcase -->
                <div class="lg:col-span-5">
                    <div class="relative max-w-md mx-auto">
                        <!-- Main Card -->
                        <div class="bg-white rounded-3xl p-6 shadow-2xl shadow-slate-200/80 border border-slate-100 relative z-20">
                            <!-- Header of widget -->
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm">Live Order Tracking</h3>
                                        <p class="text-[11px] text-slate-400">Pantau status laundry Anda</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-cyan-50 text-cyan-700 text-[11px] font-bold border border-cyan-200">
                                    Demo #WSH-003
                                </span>
                            </div>

                            <!-- Live Stepper Demo in Hero -->
                            <div class="py-5 space-y-4">
                                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                                    <span class="text-brand-600">Proses: Sedang Dicuci</span>
                                    <span class="text-slate-400">Est. 3 Jam Lagi</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-brand-600 to-cyan-400 h-2.5 rounded-full w-4/6"></div>
                                </div>

                                <div class="grid grid-cols-4 text-[10px] font-bold text-slate-400 text-center gap-1">
                                    <span class="text-brand-600">Pending</span>
                                    <span class="text-brand-600">Confirmed</span>
                                    <span class="text-cyan-600 font-extrabold">Washing 🫧</span>
                                    <span>Ready</span>
                                </div>

                                <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 space-y-2 text-xs">
                                    <div class="flex justify-between text-slate-600">
                                        <span>Layanan:</span>
                                        <span class="font-bold text-slate-800">Cuci Komplit Express 6 Jam</span>
                                    </div>
                                    <div class="flex justify-between text-slate-600">
                                        <span>Berat Riil:</span>
                                        <span class="font-bold text-slate-800">4.0 Kg</span>
                                    </div>
                                    <div class="flex justify-between text-slate-600">
                                        <span>Total Biaya:</span>
                                        <span class="font-bold text-brand-700">Rp 60.000</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Order Resi Input Box -->
                            <form action="{{ route('tracking') }}" method="GET" class="pt-2">
                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                                        <input type="text" name="code" placeholder="Ketik Kode Pesanan (Contoh: WSH-...)" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                                    </div>
                                    <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors">
                                        Lacak
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Floating Badges -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 z-30">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-shield-virus"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">100% Higienis</p>
                                <p class="text-[10px] text-slate-500">Air filter & disinfektan</p>
                            </div>
                        </div>

                        <div class="absolute -top-6 -right-6 bg-white p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 z-30">
                            <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Express 3-6 Jam</p>
                                <p class="text-[10px] text-slate-500">Pilihan super kilat</p>
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
    <section id="keunggulan" class="py-20 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Kenapa Memilih Kami</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Keunggulan Standar Premium Washora</h2>
                <p class="text-slate-600 text-sm mt-2">Komitmen kami memberikan pengalaman laundry terbaik, mudah, transparan, dan terpercaya bagi Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 1. Pelayanan Praktis -->
                <div class="bg-slate-50 hover:bg-white p-7 rounded-3xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all space-y-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-600 group-hover:bg-brand-600 group-hover:text-white flex items-center justify-center text-xl transition-colors">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Pelayanan Praktis Tanpa Timbang</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Anda tidak perlu repot menimbang sendiri dari rumah. Kurir kami menjemput dan tim profesional Washora menimbang secara presisi di outlet.
                    </p>
                </div>

                <!-- 2. Pilihan Reguler & Express -->
                <div class="bg-slate-50 hover:bg-white p-7 rounded-3xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all space-y-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 group-hover:bg-amber-500 group-hover:text-white flex items-center justify-center text-xl transition-colors">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Pilihan Fleksibel Reguler & Express</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pilihan waktu pengerjaan fleksibel mulai dari pengerjaan hemat reguler hingga express kilat 3 - 6 jam untuk kebutuhan mendesak Anda.
                    </p>
                </div>

                <!-- 3. Penanganan Terorganisir & Higienis -->
                <div class="bg-slate-50 hover:bg-white p-7 rounded-3xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all space-y-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center text-xl transition-colors">
                        <i class="fa-solid fa-hands-bubbles"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Pakaian Terorganisir & 100% Higienis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Prinsip 1 mesin 1 pelanggan memastikan pakaian tidak pernah dicampur atau tertukar. Dicuci detergen antibakteri ramah serat kain.
                    </p>
                </div>

                <!-- 4. Informasi Status Realtime -->
                <div class="bg-slate-50 hover:bg-white p-7 rounded-3xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all space-y-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white flex items-center justify-center text-xl transition-colors">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Informasi Status Pesanan Realtime</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pantau progres cucian Anda dari penjemputan, pencucian, setrika, hingga selesai melalui kode pesanan dan konfirmasi WhatsApp.
                    </p>
                </div>

                <!-- 5. Layanan Penjemputan Pakaian -->
                <div class="bg-slate-50 hover:bg-white p-7 rounded-3xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all space-y-3.5 group md:col-span-2 lg:col-span-2">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center text-xl transition-colors shrink-0">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Layanan Antar-Jemput Mudah</h3>
                            <p class="text-xs text-slate-500 leading-relaxed mt-1">
                                Cukup isi formulir pemesanan online dari rumah atau kantor. Kurir Washora siap menjemput cucian kotor dan mengantarkannya kembali dalam keadaan rapi, wangi, dan siap pakai.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         3. LAYANAN SECTION (#layanan)
         (Wajib Setelah Keunggulan)
         ========================================== -->
    <section id="layanan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Pilihan Layanan Laundry</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Layanan Berkualitas & Higienis</h2>
                <p class="text-slate-600 text-sm mt-2">Tersedia pilihan pengerjaan Regular maupun Express dengan penanganan profesional untuk berbagai jenis bahan.</p>

                <!-- Filter Button Regular / Express -->
                <div class="flex justify-center mt-8 mb-4">
                    <div class="inline-flex items-center bg-white border border-slate-200 rounded-full p-1.5 shadow-xs">
                        <button
                            type="button"
                            id="btn-all"
                            onclick="filterLayanan('all')"
                            class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold bg-brand-600 text-white shadow-sm transition-all"
                        >
                            Semua
                        </button>
                        <button
                            type="button"
                            id="btn-regular"
                            onclick="filterLayanan('regular')"
                            class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold text-slate-600 hover:text-slate-900 transition-all"
                        >
                            Regular
                        </button>
                        <button
                            type="button"
                            id="btn-express"
                            onclick="filterLayanan('express')"
                            class="filter-btn px-6 py-2.5 rounded-full text-xs font-bold text-slate-600 hover:text-slate-900 transition-all"
                        >
                            ⚡ Express
                        </button>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="services-grid">
                @foreach($featuredServices as $service)
                    <div class="service-card bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between group" data-service-type="{{ strtolower($service->service_type) }}">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-700' }}">
                                    {{ $service->service_type === 'express' ? '⚡ Express (' . $service->estimated_hours . ' Jam)' : '⏱️ Regular (' . $service->estimated_hours . ' Jam)' }}
                                </span>
                                <span class="text-xs font-semibold text-slate-400">
                                    {{ $service->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                                {{ $service->name }}
                            </h3>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                {{ $service->description ?? 'Layanan pencucian profesional dengan detergen antibakteri dan aroma wangi segar tahan lama.' }}
                            </p>
                        </div>

                        <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-slate-400">Tarif Layanan</p>
                                <p class="text-lg font-black text-brand-600">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                    <span class="text-xs font-medium text-slate-400">/ {{ $service->unit }}</span>
                                </p>
                            </div>

                            <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" class="px-4 py-2 rounded-xl bg-slate-100 group-hover:bg-brand-600 group-hover:text-white text-slate-700 text-xs font-bold transition-all flex items-center gap-1.5">
                                <span>Pilih</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Package Bundles Showcase if available -->
            @if(isset($packages) && $packages->isNotEmpty())
                <div class="mt-16 pt-12 border-t border-slate-200">
                    <div class="text-center max-w-2xl mx-auto mb-10">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Pilihan Paket Hemat</span>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-1">Paket Hemat Laundry Pilihan</h3>
                        <p class="text-slate-500 text-xs mt-1">Solusi praktis dan hemat untuk kebutuhan rutin mingguan atau bulanan Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($packages as $pkg)
                            <div class="bg-white rounded-3xl p-6 border border-slate-200 hover:border-brand-400 hover:shadow-xl transition-all flex flex-col justify-between">
                                <div class="space-y-4">
                                    <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-base">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $pkg->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">{{ $pkg->description }}</p>
                                    </div>
                                    <div class="py-2.5 px-3 bg-brand-50/70 rounded-2xl border border-brand-100/60">
                                        <p class="text-[10px] text-slate-500 font-medium">Tarif Paket</p>
                                        <p class="text-xl font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-brand-600 font-semibold mt-0.5">Est. {{ $pkg->estimated_hours }} Jam</p>
                                    </div>
                                </div>

                                <div class="pt-4 mt-3">
                                    <a href="{{ route('user.orders.create', ['package_id' => $pkg->id]) }}" class="w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold text-center block transition-all shadow-sm">
                                        Pesan Paket
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Link Lihat Selengkapnya -->
            <div class="text-center mt-12">
                <a href="{{ route('services') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-white hover:bg-brand-50 text-brand-600 border border-brand-200 hover:border-brand-400 font-bold text-sm shadow-xs hover:shadow-md transition-all">
                    <span>Lihat Selengkapnya</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================
         4. CARA KERJA SECTION (#cara-kerja)
         (Wajib Setelah Layanan - 5 Langkah)
         ========================================== -->
    <section id="cara-kerja" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <!-- Glow accents -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-brand-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-400">Alur Pemesanan Mudah</span>
                <h2 class="text-3xl font-extrabold text-white mt-2">5 Langkah Praktis Mencuci di Washora</h2>
                <p class="text-slate-400 text-sm mt-2">Pesan mudah dari rumah tanpa ribet menimbang sendiri. Tim kami memastikan setiap tahap berjalan higienis dan transparan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Langkah 1: Pilih Layanan -->
                <div class="bg-slate-800/70 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4 flex flex-col justify-between hover:border-cyan-500/50 transition-all">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 flex items-center justify-center font-black text-sm">
                                01
                            </span>
                            <i class="fa-solid fa-list-check text-slate-500 text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">1. Pilih Layanan</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Pelanggan memilih jenis layanan (Kiloan/Satuan) atau paket hemat yang diinginkan.
                        </p>
                    </div>
                </div>

                <!-- Langkah 2: Isi Data Pemesanan -->
                <div class="bg-slate-800/70 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4 flex flex-col justify-between hover:border-brand-500/50 transition-all">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-brand-500/20 text-brand-400 border border-brand-500/30 flex items-center justify-center font-black text-sm">
                                02
                            </span>
                            <i class="fa-solid fa-file-signature text-slate-500 text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">2. Isi Data Pemesanan</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Masukkan nama, nomor WhatsApp aktif, alamat penjemputan, dan catatan khusus cucian Anda.
                        </p>
                    </div>
                </div>

                <!-- Langkah 3: Penjemputan dan Pemeriksaan -->
                <div class="bg-slate-800/70 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4 flex flex-col justify-between hover:border-amber-500/50 transition-all">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center font-black text-sm">
                                03
                            </span>
                            <i class="fa-solid fa-truck text-slate-500 text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">3. Penjemputan & Pemeriksaan</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Kurir menjemput cucian, admin memeriksa dan menimbang pakaian secara akurat di outlet.
                        </p>
                    </div>
                </div>

                <!-- Langkah 4: Proses Laundry -->
                <div class="bg-slate-800/70 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4 flex flex-col justify-between hover:border-purple-500/50 transition-all">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center font-black text-sm">
                                04
                            </span>
                            <i class="fa-solid fa-water text-slate-500 text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">4. Proses Laundry</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Pakaian diproses higienis (1 mesin 1 pelanggan) sesuai layanan pilihan (Regular atau Express).
                        </p>
                    </div>
                </div>

                <!-- Langkah 5: Pesanan Selesai -->
                <div class="bg-slate-800/70 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4 flex flex-col justify-between hover:border-emerald-500/50 transition-all">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-10 h-10 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-black text-sm">
                                05
                            </span>
                            <i class="fa-solid fa-circle-check text-slate-500 text-lg"></i>
                        </div>
                        <h3 class="text-base font-bold text-white">5. Pesanan Selesai</h3>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Pelanggan menerima notifikasi bahwa pakaian bersih, rapi, dan siap diantar atau diambil di outlet.
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
    <section id="testimoni" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Ulasan & Pengalaman</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Testimoni Pelanggan Washora</h2>
                <p class="text-slate-600 text-sm mt-2">Pengalaman nyata dari para pelanggan setia yang mempercayakan kebutuhan pakaian bersih mereka kepada kami.</p>
            </div>

            @if(isset($testimonials) && $testimonials->isNotEmpty())
                <!-- Real Testimonials Grid from Database -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($testimonials as $testi)
                        <div class="bg-slate-50 rounded-3xl p-7 border border-slate-200/80 flex flex-col justify-between hover:shadow-lg transition-all">
                            <div class="space-y-3">
                                <!-- Star Rating -->
                                <div class="flex items-center gap-1 text-amber-400 text-xs">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testi->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star text-slate-300"></i>
                                        @endif
                                    @endfor
                                    <span class="text-slate-500 text-[11px] font-bold ml-1">{{ $testi->rating }}.0</span>
                                </div>

                                <p class="text-xs text-slate-700 leading-relaxed italic">
                                    "{{ $testi->comment ?? $testi->review_text }}"
                                </p>
                            </div>

                            <div class="pt-5 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">
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
                <div class="max-w-2xl mx-auto bg-slate-50 border border-dashed border-slate-200 rounded-3xl p-10 text-center space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 border border-brand-100 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-regular fa-comment-dots"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="text-base font-bold text-slate-900">Ulasan Pelanggan Akan Segera Hadir</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                            Kami mengutamakan transparansi ulasan asli. Ulasan pelanggan akan ditampilkan secara otomatis setelah pesanan selesai diproses.
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('user.orders.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition-all shadow-xs">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>Jadilah yang Pertama Mencoba Layanan Kami</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Big CTA Callout -->
    <section class="py-16 bg-gradient-to-r from-brand-600 via-brand-700 to-cyan-600 text-white">
        <div class="max-w-5xl mx-auto px-4 text-center space-y-6">
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight">Siap Menikmati Pakaian Bersih, Rapi & Wangi Hari Ini?</h2>
            <p class="text-brand-100 text-sm sm:text-base max-w-2xl mx-auto">
                Buat pesanan Anda sekarang tanpa repot menimbang. Kurir kami siap menjemput pakaian kotor Anda!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('user.orders.create') }}" class="px-8 py-4 rounded-2xl bg-white text-brand-700 font-extrabold text-sm shadow-xl hover:bg-slate-50 transition-all">
                    Pesan Sekarang
                </a>
                <a href="{{ route('user.register') }}" class="px-7 py-4 rounded-2xl bg-brand-800/60 hover:bg-brand-800 text-white font-bold text-sm border border-white/20 transition-all">
                    Daftar Akun Pelanggan Baru
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
            btn.classList.remove('bg-brand-600', 'text-white', 'shadow-sm');
            btn.classList.add('text-slate-600');
        });

        const activeBtn = document.getElementById(
            type === 'all' ? 'btn-all' : (type === 'regular' ? 'btn-regular' : 'btn-express')
        );

        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600');
            activeBtn.classList.add('bg-brand-600', 'text-white', 'shadow-sm');
        }
    }
</script>
@endsection
