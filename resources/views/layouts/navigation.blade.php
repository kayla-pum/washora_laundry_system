<header class="sticky top-0 z-40 w-full bg-white/90 backdrop-blur-md border-b border-slate-100 transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-600 via-brand-500 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-brand-500/25 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-shirt text-xl"></i>
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
                <a href="{{ route('home') }}#paket" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Paket Hemat</a>
                <a href="{{ route('home') }}#cara-kerja" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Cara Kerja</a>
                <a href="{{ route('home') }}#keunggulan" class="px-4 py-2 rounded-full hover:text-brand-600 hover:bg-white transition-all">Keunggulan</a>
                <a href="{{ route('tracking') }}" class="px-4 py-2 rounded-full text-brand-600 hover:bg-white font-semibold transition-all flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    Cek Resi
                </a>
            </nav>

            <!-- Right: Role Badges & Login Actions -->
            <div class="hidden md:flex items-center gap-2.5">
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-purple-50 text-purple-700 border border-purple-200 rounded-full text-xs font-semibold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                                Mode: Admin
                            </span>
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold shadow-md shadow-slate-900/10 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-gauge text-slate-400"></i>
                                Dashboard Admin
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-cyan-50 text-cyan-700 border border-cyan-200 rounded-full text-xs font-semibold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-cyan-600"></span>
                                Pelanggan
                            </span>
                            <a href="{{ route('user.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-md shadow-brand-600/20 transition-all flex items-center gap-2">
                                <i class="fa-solid fa-user"></i>
                                Akun Saya
                            </a>
                        </div>
                    @endif
                @else
                    <!-- 2 Distinct Roles Showcase Access -->
                    <div class="flex items-center p-1 bg-slate-100 rounded-2xl border border-slate-200/80 gap-1 text-xs font-semibold">
                        <!-- User Portal Link -->
                        <a href="{{ route('user.login') }}" title="Akses Area Pelanggan" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-white transition-all">
                            <div class="w-5 h-5 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center text-[10px]">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <span>Pelanggan</span>
                        </a>

                        <!-- Admin Portal Link -->
                        <a href="{{ route('admin.login') }}" title="Akses Area Administrator" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-white transition-all">
                            <div class="w-5 h-5 rounded-lg bg-slate-200 text-slate-800 flex items-center justify-center text-[10px]">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <span>Admin</span>
                        </a>
                    </div>

                    <!-- Direct Login CTA -->
                    <a href="{{ route('user.login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-lg shadow-brand-600/25 hover:shadow-brand-600/35 transition-all">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>Masuk</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('user.login') }}" class="px-3.5 py-2 rounded-xl bg-brand-600 text-white text-xs font-semibold">
                    Masuk
                </a>
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white/95 backdrop-blur-md px-4 pt-3 pb-6 space-y-3">
        <div class="flex flex-col space-y-2 text-sm font-medium text-slate-700">
            <a href="{{ route('home') }}#beranda" class="p-2 rounded-lg hover:bg-slate-50">Beranda</a>
            <a href="{{ route('home') }}#layanan" class="p-2 rounded-lg hover:bg-slate-50">Layanan</a>
            <a href="{{ route('home') }}#paket" class="p-2 rounded-lg hover:bg-slate-50">Paket Hemat</a>
            <a href="{{ route('home') }}#cara-kerja" class="p-2 rounded-lg hover:bg-slate-50">Cara Kerja</a>
            <a href="{{ route('home') }}#keunggulan" class="p-2 rounded-lg hover:bg-slate-50">Keunggulan</a>
            <a href="{{ route('tracking') }}" class="p-2 rounded-lg text-brand-600 font-semibold hover:bg-brand-50">Cek Status Resi</a>
        </div>
        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2">
            <a href="{{ route('user.login') }}" class="p-2.5 text-center bg-brand-50 text-brand-700 font-semibold rounded-xl text-xs flex items-center justify-center gap-2">
                <i class="fa-solid fa-user"></i> Portal User
            </a>
            <a href="{{ route('admin.login') }}" class="p-2.5 text-center bg-slate-100 text-slate-800 font-semibold rounded-xl text-xs flex items-center justify-center gap-2">
                <i class="fa-solid fa-shield-halved"></i> Portal Admin
            </a>
        </div>
    </div>
</header>
