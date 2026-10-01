<footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-500 to-cyan-400 text-white flex items-center justify-center shadow-lg shadow-brand-500/20">
                        <i class="fa-solid fa-shirt text-lg"></i>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">Washora</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Sistem informasi dan layanan laundry modern terintegrasi. Bersih, wangi, higienis dengan tracking status pesanan secara real-time dan konfirmasi transparan via WhatsApp.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </div>
            </div>

            <!-- Layanan Kami -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-white">Layanan Laundry</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Cuci Komplit Setrika</a></li>
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Cuci Kering Lipat</a></li>
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Express 6 & 3 Jam</a></li>
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Bedcover & Selimut</a></li>
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Deep Clean Sepatu</a></li>
                    <li><a href="{{ route('home') }}#layanan" class="hover:text-cyan-400 transition-colors">Boneka & Stroller</a></li>
                </ul>
            </div>

            <!-- Akses Role Portal -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-white">Akses Sistem Role</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>
                        <a href="{{ route('user.login') }}" class="hover:text-cyan-400 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-user text-xs text-brand-400"></i>
                            Portal Pelanggan (User)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.register') }}" class="hover:text-cyan-400 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-user-plus text-xs text-brand-400"></i>
                            Daftar Akun Baru
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tracking') }}" class="hover:text-cyan-400 flex items-center gap-2 transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-xs text-cyan-400"></i>
                            Cek Resi & Status Laundry
                        </a>
                    </li>
                    <li class="pt-2">
                        <a href="{{ route('admin.login') }}" class="hover:text-purple-400 flex items-center gap-2 transition-colors text-slate-400">
                            <i class="fa-solid fa-shield-halved text-xs text-purple-400"></i>
                            Portal Administrator (Admin)
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Jam Operasional & Kontak -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-white">Jam Operasional</h4>
                <p class="text-sm text-slate-400">
                    <span class="text-white font-medium">Senin - Minggu</span><br>
                    07.00 - 21.00 WIB
                </p>
                <div class="pt-2 text-sm text-slate-400 space-y-1">
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-xs text-emerald-400"></i>
                        0812-3456-7890
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-xs text-rose-400"></i>
                        Jl. Pelajar Pejuang 45 No. 88
                    </p>
                </div>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
            <p>&copy; {{ date('Y') }} Washora Laundry Information System. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <span>Clean &bull; Fresh &bull; Fast</span>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 text-slate-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Sistem Online
                </span>
            </div>
        </div>
    </div>
</footer>
