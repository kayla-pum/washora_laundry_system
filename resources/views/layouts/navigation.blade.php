<header class="sticky top-0 z-40 w-full bg-white border-b border-slate-100 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo (Bagian Kiri) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/washoralogo.png') }}" alt="Washora Logo" class="w-10 h-10 object-contain shrink-0 group-hover:scale-105 transition-transform">
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold text-slate-900 tracking-tight leading-tight">Washora</span>
                    <span class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase">Smart Laundry System</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Bagian Tengah: Teks biasa, tanpa kapsul/rounded/border) -->
            <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}#beranda" class="hover:text-brand-600 transition-colors">Beranda</a>
                <a href="{{ route('home') }}#keunggulan" class="hover:text-brand-600 transition-colors">Keunggulan</a>
                <a href="{{ route('home') }}#layanan" class="hover:text-brand-600 transition-colors">Layanan</a>
                <a href="{{ route('home') }}#cara-kerja" class="hover:text-brand-600 transition-colors">Cara Kerja</a>
                <a href="{{ route('home') }}#testimoni" class="hover:text-brand-600 transition-colors">Testimoni</a>
            </nav>

            <!-- Actions (Bagian Kanan: Ikon Search & Tombol Masuk) -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Search Icon untuk Melacak Nomor Pesanan -->
                <button type="button" onclick="openSearchModal()" title="Lacak Nomor Pesanan (Ctrl+K)" aria-label="Lacak status nomor pesanan" class="w-10 h-10 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-600 text-slate-600 flex items-center justify-center transition-all border border-slate-200/70 shadow-2xs focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>

                @guest
                    <a href="{{ route('user.login') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 hover:shadow-brand-600/30 transition-all">
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                        <span>Masuk</span>
                    </a>
                @endguest

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-sm transition-all">
                                <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                                <i class="fa-solid fa-gauge text-slate-400 text-xs"></i>
                                <span>Dashboard Admin</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Keluar" aria-label="Keluar" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center text-xs transition-colors border border-slate-200/60">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition-all">
                                <i class="fa-solid fa-user text-xs"></i>
                                <span>{{ Str::limit(auth()->user()->name, 14) }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Keluar" aria-label="Keluar" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center text-xs transition-colors border border-slate-200/60">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Mobile Action Items -->
            <div class="flex items-center gap-2 lg:hidden">
                <!-- Mobile Search Button -->
                <button type="button" onclick="openSearchModal()" title="Lacak Pesanan" aria-label="Lacak Pesanan" class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 hover:text-brand-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <!-- Mobile Hamburger Toggle -->
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" aria-label="Buka Menu" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-3">
        <div class="flex flex-col space-y-2 text-sm font-semibold text-slate-700">
            <a href="{{ route('home') }}#beranda" class="px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-brand-600 transition-colors">Beranda</a>
            <a href="{{ route('home') }}#keunggulan" class="px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-brand-600 transition-colors">Keunggulan</a>
            <a href="{{ route('home') }}#layanan" class="px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-brand-600 transition-colors">Layanan</a>
            <a href="{{ route('home') }}#cara-kerja" class="px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-brand-600 transition-colors">Cara Kerja</a>
            <a href="{{ route('home') }}#testimoni" class="px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-brand-600 transition-colors">Testimoni</a>
            <button type="button" onclick="openSearchModal()" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 flex items-center justify-between">
                <span>Lacak Nomor Pesanan</span>
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
            </button>
        </div>

        <div class="pt-3 border-t border-slate-100">
            @guest
                <a href="{{ route('user.login') }}" class="block p-3 text-center bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-xs shadow-md shadow-brand-600/20 transition-all">
                    <i class="fa-solid fa-arrow-right-to-bracket text-xs mr-1"></i> Masuk
                </a>
            @endguest

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="flex items-center justify-between gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex-1 p-2.5 text-center bg-slate-900 text-white font-bold rounded-xl text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-gauge"></i> Dashboard Admin
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center justify-between gap-2">
                        <a href="{{ route('user.dashboard') }}" class="flex-1 p-2.5 text-center bg-brand-600 text-white font-bold rounded-xl text-xs flex items-center justify-center gap-2">
                            <i class="fa-solid fa-user"></i> Akun Saya
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold">
                                Keluar
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</header>

<!-- Global Search & Order Tracking Modal -->
<div id="search-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-search-title">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-xs transition-opacity" onclick="closeSearchModal()"></div>

    <!-- Modal Box -->
    <div class="fixed inset-0 flex items-start justify-center p-4 sm:p-6 lg:p-8 pt-20 sm:pt-24 pointer-events-none">
        <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 pointer-events-auto overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 bg-slate-50/60">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-brand-600">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span id="modal-search-title">Lacak Status Pesanan Laundry</span>
                    </div>
                    <button type="button" onclick="closeSearchModal()" aria-label="Tutup" class="w-7 h-7 rounded-full bg-slate-200/70 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <p class="text-xs text-slate-500">Masukkan kode pesanan Washora untuk memeriksa status pengerjaan secara real-time.</p>

                <!-- Form Cari Pesanan -->
                <form action="{{ route('tracking') }}" method="GET" class="mt-4 flex items-center gap-2" id="global-search-form">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-receipt absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input type="text" name="code" id="global-search-input" required placeholder="Contoh: WSH-20261112-001" class="w-full pl-11 pr-4 py-3 bg-white rounded-2xl border border-slate-200 text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 shadow-xs">
                    </div>
                    <button type="submit" class="px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-brand-600/25 transition-all shrink-0">
                        Cari Pesanan
                    </button>
                </form>
            </div>

            <!-- Hint / Quick Info -->
            <div class="p-5 space-y-3 bg-white text-xs">
                <div class="p-3.5 bg-brand-50/70 border border-brand-100 rounded-2xl text-slate-600 space-y-1">
                    <p class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-brand-600"></i>
                        Format Nomor Pesanan
                    </p>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Kode pesanan tertera pada bukti pemesanan atau pesan konfirmasi Anda, dengan format <strong class="text-slate-800">WSH-TAHUNBULANTANGGAL-NOMOR</strong>.
                    </p>
                </div>

                <div class="flex items-center justify-between text-[11px] text-slate-400 pt-2">
                    <span>Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-600 font-mono text-[10px]">Esc</kbd> untuk menutup</span>
                    <a href="{{ route('tracking') }}" class="font-bold text-brand-600 hover:underline">Halaman Pelacakan &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openSearchModal() {
        const modal = document.getElementById('search-modal');
        const input = document.getElementById('global-search-input');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                if (input) input.focus();
            }, 60);
        }
    }

    function closeSearchModal() {
        const modal = document.getElementById('search-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            const modal = document.getElementById('search-modal');
            if (modal && modal.classList.contains('hidden')) {
                openSearchModal();
            } else {
                closeSearchModal();
            }
        } else if (e.key === 'Escape') {
            closeSearchModal();
        }
    });
</script>
