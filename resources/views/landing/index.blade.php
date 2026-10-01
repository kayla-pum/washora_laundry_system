@extends('layouts.app')

@section('title', 'Washora - Sistem Informasi & Layanan Laundry Modern')

@section('content')
    <!-- Public Navbar -->
    @include('layouts.navigation')

    <!-- Hero Section -->
    <section id="beranda" class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-brand-50/60 via-white to-slate-50">
        <!-- Decorative Glow & Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Column: Copy & CTAs -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                        Solusi Laundry Modern, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-brand-500 to-cyan-500">Bersih, Cepat & Praktis.</span>
                    </h1>

                    <p class="text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Pesan laundry tanpa ribet menimbang di rumah. Nikmati layanan antar-jemput, tracking pengerjaan realtime, serta konfirmasi akurat & transparan langsung ke WhatsApp Anda.
                    </p>

                    <!-- Dual Role & Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-2">
                        <a href="{{ route('user.orders.create') }}" class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-base shadow-xl shadow-brand-600/25 hover:shadow-brand-600/35 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>Pesan Laundry Sekarang</span>
                        </a>

                        <a href="{{ route('tracking') }}" class="w-full sm:w-auto px-6 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-base border border-slate-200 shadow-sm hover:border-slate-300 transition-all flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                            <span>Lacak Status Cucian</span>
                        </a>
                    </div>

                    <!-- Quick Role Showcase Note -->
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

                        <!-- Floating Badge 1 -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 z-30">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-shield-virus"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">100% Higienis</p>
                                <p class="text-[10px] text-slate-500">Air filter & disinfektan</p>
                            </div>
                        </div>

                        <!-- Floating Badge 2 -->
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

    <!-- Quick Role Access Cards Section -->
    <section class="py-12 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Sistem 2 Role Terintegrasi</span>
                <h2 class="text-2xl font-bold text-slate-900 mt-1">Pilih Portal Akses Sesuai Kebutuhan Anda</h2>
                <p class="text-sm text-slate-500 mt-1">Washora dirancang khusus untuk kenyamanan pelanggan dan kemudahan manajemen operasional laundry.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <!-- Customer Role Card -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-brand-50/50 to-white border border-brand-100 hover:border-brand-300 transition-all hover:shadow-lg group">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center shadow-md shadow-brand-600/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-brand-100 text-brand-700 rounded-full text-xs font-bold">Portal Pelanggan</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mt-4">Pelanggan / Customer</h3>
                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                        Pesan laundry secara online, lacak progres pencucian realtime, lihat riwayat nota, tanpa perlu timbang sendiri di rumah.
                    </p>
                    <div class="mt-5 flex items-center gap-3">
                        <a href="{{ route('user.login') }}" class="px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition-all shadow-sm">
                            Masuk Pelanggan
                        </a>
                        <a href="{{ route('user.register') }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold transition-all">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>

                <!-- Admin Role Card -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-slate-900 to-slate-800 text-white border border-slate-700 hover:border-slate-600 transition-all hover:shadow-xl group">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500 text-slate-950 flex items-center justify-center shadow-md shadow-cyan-500/20 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-shield-halved text-xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-slate-800 text-cyan-400 border border-slate-700 rounded-full text-xs font-bold">Portal Admin</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mt-4">Administrator / Pengelola</h3>
                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">
                        Verifikasi berat & kalkulasi harga, update status pencucian, kirim notifikasi WhatsApp otomatis, kelola layanan, dan lihat laporan omset.
                    </p>
                    <div class="mt-5 flex items-center gap-3">
                        <a href="{{ route('admin.login') }}" class="px-4 py-2.5 rounded-xl bg-cyan-400 hover:bg-cyan-300 text-slate-950 text-xs font-bold transition-all shadow-sm">
                            Masuk Portal Admin
                        </a>
                        <span class="text-[11px] text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-lock text-[10px]"></i> Akses Terproteksi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Pilihan Layanan Laundry</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Daftar Layanan Berkualitas & Higienis</h2>
                <p class="text-slate-600 text-sm mt-2">Tersedia pilihan pengerjaan Regular maupun Express dengan penanganan khusus untuk berbagai jenis bahan.</p>
            </div>

            <!-- Categories Tabs & Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredServices as $service)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between group">
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

            <div class="text-center mt-10">
                <a href="{{ route('services') }}" class="inline-flex items-center gap-2 text-sm font-bold text-brand-600 hover:text-brand-700 hover:underline">
                    <span>Lihat Semua Daftar Layanan & Kategori Lengkap</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="paket" class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Paket Hemat Laundry</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Lebih Banyak, Lebih Hemat & Praktis</h2>
                <p class="text-slate-600 text-sm mt-2">Paket bundling cucian kiloan & satuan untuk kebutuhan mahasiswa, keluarga, bedding, dan koleksi sepatu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($packages as $pkg)
                    <div class="bg-gradient-to-b from-slate-50 to-white rounded-3xl p-6 border border-slate-200 hover:border-brand-400 hover:shadow-xl transition-all flex flex-col justify-between relative overflow-hidden">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-base">
                                <i class="fa-solid fa-box-archive"></i>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 text-base">{{ $pkg->name }}</h3>
                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $pkg->description }}</p>
                            </div>

                            <div class="py-3 px-3.5 bg-brand-50/70 rounded-2xl border border-brand-100/60">
                                <p class="text-[11px] text-slate-500 font-medium">Harga Spesial Paket</p>
                                <p class="text-2xl font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-brand-600 font-semibold mt-0.5">Est. Pengerjaan {{ $pkg->estimated_hours }} Jam</p>
                            </div>
                        </div>

                        <div class="pt-5 mt-4">
                            <a href="{{ route('user.orders.create', ['package_id' => $pkg->id]) }}" class="w-full py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold text-center block transition-all shadow-md shadow-brand-600/20">
                                Pesan Paket Ini
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works Section (Cara Kerja 4 Langkah) -->
    <section id="cara-kerja" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold uppercase tracking-wider text-cyan-400">Alur Pemesanan Mudah</span>
                <h2 class="text-3xl font-extrabold text-white mt-2">4 Langkah Praktis Mencuci di Washora</h2>
                <p class="text-slate-400 text-sm mt-2">Anda tidak perlu menimbang cucian sendiri di rumah. Biarkan tim profesional kami yang mengurus semuanya.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 flex items-center justify-center font-black text-lg">
                        01
                    </div>
                    <h3 class="text-base font-bold text-white">1. Pesan Online</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pilih jenis layanan atau paket, isi alamat penjemputan dan nomor WhatsApp. Tidak perlu input berat pakaian.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-brand-500/20 text-brand-400 border border-brand-500/30 flex items-center justify-center font-black text-lg">
                        02
                    </div>
                    <h3 class="text-base font-bold text-white">2. Jemput & Timbang</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Kurir menjemput cucian. Admin menimbang berat aktual di outlet dan mengonfirmasi total biaya resmi via WhatsApp.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center font-black text-lg">
                        03
                    </div>
                    <h3 class="text-base font-bold text-white">3. Proses Cuci Bersih</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pakaian dicuci (1 mesin 1 pelanggan), dikeringkan, disetrika uap rapi, dan dipacking higienis. Pantau realtime!
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl p-6 border border-slate-700/80 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-black text-lg">
                        04
                    </div>
                    <h3 class="text-base font-bold text-white">4. Antar / Siap Diambil</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Setelah status menjadi Ready, cucian siap diantar ke rumah atau diambil di outlet dengan wangi segar tahan lama.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-extrabold uppercase tracking-wider text-brand-600">Kenapa Memilih Kami</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Keunggulan Standar Premium Washora</h2>
                <p class="text-slate-600 text-sm mt-2">Komitmen kami memberikan pengalaman laundry terbaik dan terpercaya bagi Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-hands-bubbles"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Anti Campur (1 Mesin 1 Pelanggan)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pakaian Anda tidak pernah dicampur dengan cucian pelanggan lain. Menjamin kebersihan maksimal, higienis, dan tidak tertukar.
                    </p>
                </div>

                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Notifikasi WhatsApp Otomatis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Rincian berat cucian, total tarif, estimasi jam selesai, hingga pemberitahuan saat cucian siap diambil langsung dikirim ke WhatsApp Anda.
                    </p>
                </div>

                <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Jaminan Tepat Waktu (On-Time)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Dengan sistem antrean otomatis dan pantauan estimasi selesai, laundry Anda dipastikan selesai tepat pada jadwal yang dijanjikan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Big CTA Callout -->
    <section class="py-16 bg-gradient-to-r from-brand-600 via-brand-700 to-cyan-600 text-white">
        <div class="max-w-5xl mx-auto px-4 text-center space-y-6">
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight">Siap Menikmati Pakaian Bersih, Rapi & Wangi Hari Ini?</h2>
            <p class="text-brand-100 text-sm sm:text-base max-w-2xl mx-auto">
                Buat pesanan pertama Anda sekarang tanpa repot menimbang. Kurir kami siap menjemput pakaian kotor Anda!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('user.orders.create') }}" class="px-8 py-4 rounded-2xl bg-white text-brand-700 font-extrabold text-sm shadow-xl hover:bg-slate-50 transition-all">
                    Buat Pesanan Laundry Sekarang
                </a>
                <a href="{{ route('user.register') }}" class="px-7 py-4 rounded-2xl bg-brand-800/60 hover:bg-brand-800 text-white font-bold text-sm border border-white/20 transition-all">
                    Daftar Akun Pelanggan Baru
                </a>
            </div>
        </div>
    </section>

    <!-- Public Footer -->
    @include('layouts.footer')
@endsection
