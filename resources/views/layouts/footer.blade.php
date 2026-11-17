<footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-3">
                        <img src="{{ asset('images/washoralogo.png') }}" alt= "Logo Washora" class="w-10 h-10 object-contain shrink-0">
                    <span class="text-2xl font-extrabold tracking-tight text-white">Washora</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Sistem informasi dan layanan laundry modern terintegrasi. Bersih, wangi, higienis dengan tracking status pesanan secara real-time dan konfirmasi transparan via WhatsApp.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <a href="https://wa.me/6288906296474" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Washora" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-emerald-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/space.kays/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Washora" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-pink-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" aria-label="Facebook Washora" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-400 hover:text-white flex items-center justify-center transition-colors">
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

            <!-- Menu Navigasi Footer -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-white">Menu</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li>
                        <a href="{{ route('home') }}" class="group hover:text-cyan-400 flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-brand-400 group-hover:text-cyan-400 transition-colors shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            <span>Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="group hover:text-cyan-400 flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-brand-400 group-hover:text-cyan-400 transition-colors shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"/>
                                <path d="M16 6a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/>
                                <path d="M12 18a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                                <path d="M12 15a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                                <rect width="18" height="20" x="3" y="2" rx="2"/>
                            </svg>
                            <span>Layanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tracking') }}" class="group hover:text-cyan-400 flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-brand-400 group-hover:text-cyan-400 transition-colors shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.3-4.3"/>
                            </svg>
                            <span>Cek Resi & Status Laundry</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="group hover:text-cyan-400 flex items-center gap-2.5 transition-colors">
                            <svg class="w-4 h-4 text-brand-400 group-hover:text-cyan-400 transition-colors shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <span>Syarat & Ketentuan</span>
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
                        <a href="https://wa.me/6288906296474" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-400 transition-colors">0889-0629-6474</a>
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
            <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                <span>Clean &bull; Fresh &bull; Fast</span>
                <a href="{{ route('terms') }}" class="hover:text-cyan-400 transition-colors">Syarat & Ketentuan</a>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 text-slate-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Sistem Online
                </span>
            </div>
        </div>
    </div>
</footer>
