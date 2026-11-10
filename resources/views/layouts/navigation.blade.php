<header class="sticky top-0 z-40 w-full bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/washoralogo.png') }}" alt="Washora Logo" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-1.5">
                        Washora
                        <span class="inline-block w-2 h-2 rounded-full bg-cyan-500"></span>
                    </span>
                    <p class="text-[11px] font-semibold text-slate-400 -mt-1 tracking-wider uppercase">Smart Laundry System</p>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-1 bg-slate-100/70 p-1.5 rounded-full border border-slate-200/60 text-sm font-medium text-slate-600">
                <a href="{{ route('home') }}#beranda" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Beranda</a>
                <a href="{{ route('home') }}#layanan" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Layanan</a>
                <a href="{{ route('user.orders.create') }}" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white font-semibold transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-check text-xs text-brand-600"></i>
                    <span>Reservasi</span>
                </a>
                <a href="{{ route('home') }}#cara-kerja" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Cara Kerja</a>
            </nav>

            <!-- Right Actions: Search Icon + Simplified Auth -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Search Icon (Pencarian Informasi & Cek Resi) -->
                <button type="button" onclick="openSearchModal()" title="Pencarian & Cek Resi (Ctrl+K)" aria-label="Pencarian informasi dan cek status pesanan" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-brand-50 hover:text-brand-600 text-slate-600 flex items-center justify-center transition-all border border-slate-200/60 shadow-xs focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </button>

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-sm transition-all">
                                <span class="w-2 h-2 rounded-full bg-purple-400 animate-pulse"></span>
                                <i class="fa-solid fa-gauge text-slate-400 text-xs"></i>
                                <span>Dashboard Admin</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Keluar" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center text-xs transition-colors border border-slate-200/60">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 transition-all">
                                <i class="fa-solid fa-user text-xs"></i>
                                <span>{{ Str::limit(auth()->user()->name, 14) }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Keluar" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center text-xs transition-colors border border-slate-200/60">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <!-- Simplified Auth Dropdown: Konsolidasi Akses Admin & Pengguna -->
                    <div class="relative" id="auth-dropdown-wrapper">
                        <button type="button" onclick="toggleAuthDropdown()" id="auth-dropdown-btn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-600/20 hover:shadow-brand-600/30 transition-all focus:outline-none">
                            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                            <span>Masuk</span>
                            <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 opacity-80" id="auth-dropdown-chevron"></i>
                        </button>

                        <!-- Floating Portal Selector Dropdown -->
                        <div id="auth-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50">
                            <div class="px-3 py-2 border-b border-slate-100">
                                <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Pilih Akses Masuk</p>
                            </div>
                            <div class="mt-1 space-y-1">
                                <a href="{{ route('user.login') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-brand-50 group transition-colors">
                                    <div class="w-9 h-9 rounded-xl bg-brand-100 text-brand-600 group-hover:bg-brand-600 group-hover:text-white flex items-center justify-center text-xs transition-colors shrink-0">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-slate-800 group-hover:text-brand-700">Pelanggan</span>
                                        <span class="text-[11px] text-slate-500">Pesan & pantau cucian</span>
                                    </div>
                                </a>
                                <a href="{{ route('admin.login') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-100 group transition-colors">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-800 group-hover:bg-slate-900 group-hover:text-white flex items-center justify-center text-xs transition-colors shrink-0">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-slate-800 group-hover:text-slate-900">Administrator</span>
                                        <span class="text-[11px] text-slate-500">Portal operasional laundry</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile Action Items -->
            <div class="flex items-center gap-2 lg:hidden">
                <!-- Mobile Search Button -->
                <button type="button" onclick="openSearchModal()" title="Pencarian" class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 hover:text-brand-600 flex items-center justify-center text-sm transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <!-- Mobile Hamburger Toggle -->
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white/95 backdrop-blur-md px-4 pt-3 pb-6 space-y-3">
        <div class="flex flex-col space-y-1.5 text-sm font-medium text-slate-700">
            <a href="{{ route('home') }}#beranda" class="px-3 py-2 rounded-xl hover:bg-slate-50">Beranda</a>
            <a href="{{ route('home') }}#layanan" class="px-3 py-2 rounded-xl hover:bg-slate-50">Layanan</a>
            <a href="{{ route('user.orders.create') }}" class="px-3 py-2 rounded-xl text-brand-600 font-semibold hover:bg-brand-50 flex items-center justify-between">
                <span>Reservasi Laundry</span>
                <span class="text-[10px] uppercase font-extrabold px-2 py-0.5 rounded-full bg-brand-100 text-brand-700">Pesan</span>
            </a>
            <a href="{{ route('home') }}#cara-kerja" class="px-3 py-2 rounded-xl hover:bg-slate-50">Cara Kerja</a>
            <button type="button" onclick="openSearchModal()" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 flex items-center justify-between">
                <span>Cari Informasi & Cek Resi</span>
                <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
            </button>
        </div>

        <div class="pt-3 border-t border-slate-100">
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
            @else
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('user.login') }}" class="p-2.5 text-center bg-brand-50 text-brand-700 font-semibold rounded-xl text-xs flex items-center justify-center gap-2 hover:bg-brand-100 transition-colors">
                        <i class="fa-solid fa-user text-xs"></i> Masuk Pelanggan
                    </a>
                    <a href="{{ route('admin.login') }}" class="p-2.5 text-center bg-slate-100 text-slate-800 font-semibold rounded-xl text-xs flex items-center justify-center gap-2 hover:bg-slate-200 transition-colors">
                        <i class="fa-solid fa-shield-halved text-xs"></i> Masuk Admin
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>

<!-- Global Search & Order Tracking Modal -->
<div id="search-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="modal-search-title">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm transition-opacity" onclick="closeSearchModal()"></div>

    <!-- Modal Box -->
    <div class="fixed inset-0 flex items-start justify-center p-4 sm:p-6 lg:p-8 pt-20 sm:pt-24 pointer-events-none">
        <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-100 pointer-events-auto overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <!-- Modal Header with Form -->
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                        <span id="modal-search-title">Pencarian & Cek Resi Washora</span>
                    </div>
                    <button type="button" onclick="closeSearchModal()" class="w-7 h-7 rounded-full bg-slate-200/70 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('tracking') }}" method="GET" class="relative flex items-center gap-2" id="global-search-form">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input type="text" name="code" id="global-search-input" required placeholder="Masukkan Kode Resi (cth: WSH-20260929-001) / Cari..." class="w-full pl-11 pr-4 py-3 bg-white rounded-2xl border border-slate-200 text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 shadow-xs">
                    </div>
                    <button type="submit" class="px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-brand-600/25 transition-all shrink-0">
                        Cek Resi
                    </button>
                </form>
            </div>

            <!-- Quick Actions / Navigation Hints -->
            <div class="p-5 space-y-3">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Akses Cepat</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <a href="{{ route('tracking') }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-brand-50 border border-slate-100 hover:border-brand-200 transition-all flex items-center gap-3 group">
                        <div class="w-8 h-8 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 group-hover:text-brand-700 block">Lacak Status Pesanan</span>
                            <span class="text-[10px] text-slate-400">Cek proses cucian real-time</span>
                        </div>
                    </a>

                    <a href="{{ route('user.orders.create') }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-brand-50 border border-slate-100 hover:border-brand-200 transition-all flex items-center gap-3 group">
                        <div class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 group-hover:text-cyan-700 block">Reservasi Laundry</span>
                            <span class="text-[10px] text-slate-400">Pesan antar-jemput cucian</span>
                        </div>
                    </a>

                    <a href="{{ route('services') }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-brand-50 border border-slate-100 hover:border-brand-200 transition-all flex items-center gap-3 group">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 group-hover:text-amber-700 block">Katalog Layanan & Tarif</span>
                            <span class="text-[10px] text-slate-400">Daftar harga satuan & kiloan</span>
                        </div>
                    </a>

                    <a href="{{ route('home') }}#cara-kerja" onclick="closeSearchModal()" class="p-3 rounded-2xl bg-slate-50 hover:bg-brand-50 border border-slate-100 hover:border-brand-200 transition-all flex items-center gap-3 group">
                        <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800 group-hover:text-purple-700 block">Cara Kerja Washora</span>
                            <span class="text-[10px] text-slate-400">Alur pemesanan mudah</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer Hint -->
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <span>Tekan <kbd class="px-1.5 py-0.5 rounded bg-white border border-slate-200 text-slate-600 font-mono text-[10px] shadow-2xs">Esc</kbd> untuk menutup</span>
                <span>Washora Smart Laundry</span>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAuthDropdown() {
        const menu = document.getElementById('auth-dropdown-menu');
        const chevron = document.getElementById('auth-dropdown-chevron');
        if (menu) {
            menu.classList.toggle('hidden');
            if (chevron) {
                chevron.classList.toggle('rotate-180');
            }
        }
    }

    // Close auth dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const wrapper = document.getElementById('auth-dropdown-wrapper');
        const menu = document.getElementById('auth-dropdown-menu');
        const chevron = document.getElementById('auth-dropdown-chevron');
        if (wrapper && menu && !wrapper.contains(event.target)) {
            menu.classList.add('hidden');
            if (chevron) {
                chevron.classList.remove('rotate-180');
            }
        }
    });

    function openSearchModal() {
        const modal = document.getElementById('search-modal');
        const input = document.getElementById('global-search-input');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                if (input) input.focus();
            }, 50);
        }
    }

    function closeSearchModal() {
        const modal = document.getElementById('search-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Shortcut Ctrl+K or Cmd+K & Escape handling
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
