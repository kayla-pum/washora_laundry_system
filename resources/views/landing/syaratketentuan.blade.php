@extends('layouts.app')

@section('title', 'Syarat & Ketentuan Layanan - Washora')

@section('content')
    @include('layouts.navigation')

    <main class="min-h-screen bg-slate-50 py-10 sm:py-14">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs & Navigasi Kembali -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-house text-[11px]"></i>
                        <span>Beranda</span>
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="text-brand-600">Syarat & Ketentuan</span>
                </nav>

                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 hover:text-brand-600 text-xs font-bold border border-slate-200/80 shadow-2xs transition-all">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <!-- Header Halaman -->
            <div class="bg-white rounded-xl p-6 sm:p-8 border border-slate-200 shadow-xs mb-6">
                <div class="max-w-3xl space-y-2.5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-brand-50 text-brand-700 text-xs font-semibold border border-brand-200">
                        <i class="fa-solid fa-file-contract text-brand-600"></i>
                        <span>Ketentuan Layanan Resmi</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight leading-tight">
                        Syarat & Ketentuan Layanan Washora
                    </h1>
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Halaman ini memuat syarat dan ketentuan resmi penggunaan seluruh jasa layanan laundry Washora, baik layanan Kiloan, Satuan, maupun Paket Bundling. Harap membaca ketentuan ini secara seksama demi kenyamanan, transparansi, dan keamanan pakaian Anda.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-check text-brand-600"></i>
                            Berlaku Efektif: 15 November 2026
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            Standar Operasional Higienis
                        </span>
                    </div>
                </div>
            </div>

            <!-- Callout PENTING: Pemeriksaan Saku & Barang Berharga -->
            <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-5 mb-6 text-amber-950 shadow-2xs">
                <div class="flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-md bg-amber-500 text-white flex items-center justify-center shrink-0 text-base">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="space-y-1 flex-1">
                        <h2 class="text-sm sm:text-base font-bold text-amber-950">
                            PENTING: Harap Periksa Seluruh Isi Saku Pakaian Anda
                        </h2>
                        <p class="text-xs sm:text-sm text-amber-900 leading-relaxed">
                            Sebelum pakaian diserahkan kepada kurir atau petugas outlet Washora, pelanggan <strong>wajib memeriksa dan mengosongkan seluruh saku pakaian</strong> dari uang tunai, perhiasan, logam, pulpen/spidol, peniti, pemantik api, maupun benda berharga lainnya. Washora tidak bertanggung jawab atas kehilangan atau kerusakan barang berharga yang tertinggal di dalam saku pakaian.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Navigasi Ringkas (Daftar Isi) -->
            <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-2xs mb-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-list-ol text-brand-600"></i>
                    Daftar Ketentuan Layanan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5 text-xs font-semibold text-slate-700">
                    <a href="#section-1" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">1</span>
                        <span>Ketentuan Umum & Operasional</span>
                    </a>
                    <a href="#section-2" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">2</span>
                        <span>Waktu Pengerjaan Layanan</span>
                    </a>
                    <a href="#section-3" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">3</span>
                        <span>Kondisi Barang Sebelum Cuci</span>
                    </a>
                    <a href="#section-4" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">4</span>
                        <span>Layanan Kiloan & Satuan</span>
                    </a>
                    <a href="#section-5" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">5</span>
                        <span>Barang yang Ditolak</span>
                    </a>
                    <a href="#section-6" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">6</span>
                        <span>Tanggung Jawab & Mutu</span>
                    </a>
                    <a href="#section-7" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">7</span>
                        <span>Ketentuan Komplain (1x24 Jam)</span>
                    </a>
                    <a href="#section-8" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">8</span>
                        <span>Ganti Rugi & Kompensasi</span>
                    </a>
                    <a href="#section-9" class="p-2 rounded-xl hover:bg-brand-50 hover:text-brand-600 transition-colors flex items-center gap-2">
                        <span class="w-5 h-5 rounded-md bg-brand-100 text-brand-700 text-[10px] font-bold flex items-center justify-center shrink-0">9</span>
                        <span>Barang yang Tidak Diambil</span>
                    </a>
                </div>
            </div>

            <!-- Konten Ketentuan (Numbered Sections) -->
            <div class="space-y-6">

                <!-- 1. Ketentuan Umum & Pemesanan -->
                <section id="section-1" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            01
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Ketentuan Umum & Pemesanan Layanan
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            1.1. Layanan Washora dapat diakses dan dipesan secara daring (online) melalui website resmi Washora, serta secara langsung (walk-in) di outlet operasional resmi Washora.
                        </p>
                        <p>
                            1.2. Jam operasional layanan penjemputan, pencucian, dan pengantaran berlangsung setiap hari <strong>Senin sampai Minggu pukul 07.00 - 21.00 WIB</strong>.
                        </p>
                        <p>
                            1.3. Saat melakukan pemesanan penjemputan, pelanggan wajib mencantumkan data diri yang benar, nomor WhatsApp yang aktif untuk konfirmasi, serta alamat penjemputan yang jelas dan dapat diakses oleh kurir.
                        </p>
                        <p>
                            1.4. Setiap pesanan resmi akan memperoleh <strong>Kode Pesanan Unik</strong> (contoh: WSH-001) yang digunakan untuk melacak status pesanan secara real-time di sistem Washora.
                        </p>
                    </div>
                </section>

                <!-- 2. Waktu Pengerjaan Layanan -->
                <section id="section-2" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            02
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Waktu Pengerjaan Layanan (Reguler & Express)
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            2.1. <strong>Layanan Reguler:</strong> Estimasi pengerjaan cucian reguler berkisar antara <strong>24 hingga 48 jam</strong> kerja sejak cucian diverifikasi dan ditimbang di outlet.
                        </p>
                        <p>
                            2.2. <strong>Layanan Express:</strong> Washora menyediakan opsi pengerjaan kilat <strong>Express 3 Jam</strong> dan <strong>Express 6 Jam</strong> khusus untuk pakaian harian dan kebutuhan mendesak pelanggan.
                        </p>
                        <p>
                            2.3. Penghitungan waktu pengerjaan resmi dimulai saat cucian tiba di outlet, ditimbang oleh petugas, dan rincian biaya telah disepakati oleh pelanggan.
                        </p>
                        <p>
                            2.4. Keadaan Kahar (<em>Force Majeure</em>): Keterlambatan akibat bencana alam, banjir, pemadaman listrik berkepanjangan oleh PLN tanpa pemberitahuan, atau cuaca ekstrem yang membahayakan kurir di jalan berada di luar kuasa operasional Washora. Pihak Washora akan mengabarkan status keterlambatan secepatnya kepada pelanggan.
                        </p>
                    </div>
                </section>

                <!-- 3. Kondisi Barang Sebelum Proses Pencucian -->
                <section id="section-3" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            03
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Kondisi Barang Sebelum Proses Pencucian
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            3.1. <strong>Pemeriksaan Saku:</strong> Pelanggan berkewajiban memeriksa seluruh saku pakaian sebelum diserahkan. Segala risiko kerusakan atau hilangnya benda berharga seperti uang, emas, kartu kredit, perhiasan, pulpen (yang dapat merusak warna pakaian), atau pemantik api bukan merupakan tanggung jawab pihak Washora.
                        </p>
                        <p>
                            3.2. <strong>Pakaian Luntur:</strong> Pelanggan wajib memberi tahu kurir atau staf jika terdapat pakaian yang berpotensi luntur. Jika pakaian tersebut dicampur dalam satu kantong kiloan tanpa pemberitahuan khusus, Washora tidak bertanggung jawab atas perpindahan warna ke pakaian lain milik pelanggan.
                        </p>
                        <p>
                            3.3. <strong>Kerapuhan & Cacat Awal:</strong> Kerusakan yang timbul akibat kerapuhan alami serat kain karena usia pakaian, kancing yang sudah kendur, resleting berkarat, atau bekas robekan lama yang membesar saat pencucian standar mesin bukan merupakan tanggung jawab Washora.
                        </p>
                    </div>
                </section>

                <!-- 4. Ketentuan Khusus Layanan Satuan dan Kiloan -->
                <section id="section-4" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            04
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Ketentuan Khusus Layanan Kiloan & Satuan
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3 pl-11">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1.5">
                            <h4 class="font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-scale-balanced text-brand-600"></i>
                                Layanan Kiloan
                            </h4>
                            <p class="text-xs text-slate-600">
                                Dihitung berdasarkan berat riil (Kg) saat ditimbang di outlet menggunakan timbangan digital resmi. Pelanggan tidak perlu menimbang sendiri dari rumah. Cucian kiloan dicuci dengan metode <strong>1 Mesin 1 Pelanggan</strong> tanpa mencampur pakaian pelanggan lain, namun tidak dilakukan inventarisasi detail per helai pakaian.
                            </p>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1.5">
                            <h4 class="font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-shirt text-brand-600"></i>
                                Layanan Satuan & Paket
                            </h4>
                            <p class="text-xs text-slate-600">
                                Berlaku untuk item pakaian khusus seperti jas, gaun/kebaya pesta, jaket kulit/kulit sintetis, sepatu (deep clean), tas, bedcover, selimut, boneka, dan stroller. Setiap barang dicatat secara individual, diperiksa kondisi fisiknya, dan mendapatkan treatment bahan kimia khusus serta teknik pencucian manual/khusus sesuai label perawatan pakaian (<em>care label</em>).
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 5. Barang yang Tidak Dapat Diterima (Pengecualian) -->
                <section id="section-5" class="bg-white rounded-2xl p-6 sm:p-7 border border-rose-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 text-sm font-black flex items-center justify-center shrink-0">
                            05
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-rose-950">
                            Barang yang Tidak Dapat Diterima (Pengecualian & Larangan)
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>Demi menjaga higienitas dan keamanan seluruh pelanggan, Washora berhak menolak:</p>
                        <ul class="list-disc list-inside space-y-1.5 text-slate-600 text-xs sm:text-sm">
                            <li>Pakaian yang terkontaminasi bahan kimia berbahaya, cat kental, zat asam, atau tumpahan oli mesin berat dalam jumlah banyak.</li>
                            <li>Pakaian atau kain yang terkontaminasi cairan biologis menular berbahaya, kotoran hewan berlebih, atau limbah medis infeksius.</li>
                            <li>Bahan pakaian yang sudah lapuk ekstrem atau sobek parah yang dapat hancur total bila terkena putaran air mesin cuci.</li>
                            <li>Pakaian atau barang antik berbahan bulu hewan asli atau bahan langka tanpa instruksi pencucian tertulis dan surat pembebasan risiko.</li>
                        </ul>
                    </div>
                </section>

                <!-- 6. Tanggung Jawab & Standar Mutu Washora -->
                <section id="section-6" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            06
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Tanggung Jawab Terhadap Barang & Standar Higienis
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            6.1. Washora menjunjung tinggi integritas operasional dengan menerapkan <strong>1 Mesin Cuci untuk 1 Pelanggan</strong>. Pakaian Anda tidak akan pernah dicampur dengan pakaian orang lain.
                        </p>
                        <p>
                            6.2. Seluruh proses pencucian menggunakan detergen premium bersertifikasi antibakteri, pelembut ramah serat kain, serta sistem penyaringan air (water filter) multi-tahap demi menjaga kecerahan warna pakaian.
                        </p>
                        <p>
                            6.3. Proses setrika menggunakan setrika uap bertekanan (steam iron) profesional yang menjamin pakaian halus, rapi, dan bebas dari bekas hangus.
                        </p>
                    </div>
                </section>

                <!-- 7. Ketentuan Komplain -->
                <section id="section-7" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            07
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Ketentuan Pengajuan Komplain (Maksimal 1 x 24 Jam)
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            7.1. Pelanggan berhak mengajukan komplain apabila terdapat ketidaksesuaian hasil cuci (misalnya kurang bersih atau aroma tidak segar) dalam batas waktu maksimal <strong>1 x 24 jam</strong> sejak pakaian diterima atau diantar.
                        </p>
                        <p>
                            7.2. <strong>Syarat Komplain Sah:</strong> Wajib menyertakan Nota/Nomor Pesanan resmi Washora, tag laundry yang masih menempel pada pakaian, serta melampirkan foto/video kondisi pakaian yang dikomplain.
                        </p>
                        <p>
                            7.3. Pakaian yang dikomplain harus dalam kondisi belum pernah dipakai kembali, belum dicuci ulang di tempat lain, dan belum disetrika ulang.
                        </p>
                        <p>
                            7.4. Komplain yang diajukan melebihi batas waktu 1 x 24 jam dinyatakan kedaluwarsa dan tidak dapat diproses lebih lanjut.
                        </p>
                    </div>
                </section>

                <!-- 8. Biaya Ganti Rugi -->
                <section id="section-8" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            08
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Kebijakan Ganti Rugi Kerusakan atau Kehilangan
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            8.1. Apabila terbukti terjadi kerusakan fisik atau kehilangan pakaian yang mutlak disebabkan oleh kelalaian petugas atau malafungsi mesin Washora, Washora bersedia memberikan kompensasi ganti rugi secara proporsional.
                        </p>
                        <p>
                            8.2. Besaran nilai penggantian ganti rugi maksimal adalah sebesar <strong>5 (lima) hingga maksimal 10 (sepuluh) kali lipat dari biaya jasa cuci barang yang bersangkutan</strong>, sesuai kode etik standar asosiasi pengusaha laundry di Indonesia.
                        </p>
                        <p>
                            8.3. Penyelesaian ganti rugi dilakukan secara musyawarah mufakat dengan mempertimbangkan faktor usia pemakaian dan penyusutan nilai wajar barang.
                        </p>
                        <p>
                            8.4. Washora tidak bertanggung jawab atas kerugian imateriil, nilai sentimental, atau kerugian tidak langsung yang melebihi batas ketentuan ganti rugi di atas.
                        </p>
                    </div>
                </section>

                <!-- 9. Barang yang Tidak Diambil -->
                <section id="section-9" class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-2xs space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 text-sm font-black flex items-center justify-center shrink-0">
                            09
                        </span>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900">
                            Ketentuan Barang yang Tidak Diambil (Unclaimed Laundry)
                        </h2>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2.5 pl-11">
                        <p>
                            9.1. Cucian yang telah selesai diproses dan telah diinfokan melalui notifikasi WhatsApp resmi wajib diambil atau dijadwalkan pengantarannya dalam jangka waktu maksimal <strong>30 (tiga puluh) hari kalender</strong>.
                        </p>
                        <p>
                            9.2. Apabila setelah 30 hari kalender cucian belum diambil, Washora dibebaskan dari tanggung jawab terhadap penurunan kualitas cucian akibat jamur penyimpanan atau bau apek.
                        </p>
                        <p>
                            9.3. Cucian yang tidak diambil dalam waktu lebih dari <strong>60 (enam puluh) hari kalender</strong> sejak pemberitahuan selesai, pelanggan dianggap melepaskan hak kepemilikan atas pakaian tersebut, dan Washora berhak menyumbangkannya ke yayasan sosial atau memusnahkannya demi menjaga kapasitas gudang.
                        </p>
                    </div>
                </section>
            </div>

            <!-- Bantuan & Layanan Pelanggan Card -->
            <div class="mt-8 bg-slate-900 rounded-xl p-6 sm:p-7 text-white border border-slate-800 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-5">
                <div class="space-y-1.5 text-center sm:text-left">
                    <span class="px-2.5 py-0.5 rounded bg-slate-800 text-cyan-300 text-[11px] font-semibold border border-slate-700">
                        Pusat Bantuan Washora
                    </span>
                    <h3 class="text-base sm:text-lg font-bold text-white">Ada Pertanyaan Mengenai Ketentuan Layanan?</h3>
                    <p class="text-xs text-slate-300 max-w-lg leading-relaxed">
                        Tim Customer Service kami siap membantu Anda setiap hari pukul 07.00 - 21.00 WIB untuk konsultasi jenis bahan, penjemputan, maupun rincian nota.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-2.5 shrink-0 w-full sm:w-auto">
                    <a href="https://wa.me/6288906296474?text=Halo%20Washora%2C%20saya%20ingin%20bertanya%20seputar%20syarat%20dan%20ketentuan%20layanan" target="_blank" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold flex items-center justify-center gap-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Hubungi WhatsApp</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold flex items-center justify-center gap-2 border border-slate-700 transition-colors">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
@endsection
