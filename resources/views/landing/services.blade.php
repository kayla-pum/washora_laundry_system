@extends('layouts.app')

@section('title', 'Katalog Layanan & Tarif - Washora')

@section('content')
    @include('layouts.navigation')

    <div class="py-14 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-bold">Katalog Resmi</span>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Daftar Lengkap Layanan & Paket</h1>
                <p class="text-slate-600 text-sm">
                    Harga transparan tanpa biaya tersembunyi. Timbang dan periksa langsung di outlet dengan konfirmasi WhatsApp.
                </p>
            </div>

            <!-- Categories and Services Loop -->
            <div class="space-y-12">
                @foreach($categories as $category)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2.5">
                                    <i class="fa-solid fa-layer-group text-brand-600 text-base"></i>
                                    {{ $category->name }}
                                </h2>
                                <p class="text-xs text-slate-500 mt-1">{{ $category->description }}</p>
                            </div>
                            <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-semibold text-slate-600 w-fit">
                                {{ $category->activeServices->count() }} Pilihan Layanan
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach($category->activeServices as $service)
                                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/70 hover:bg-white hover:border-brand-300 hover:shadow-md transition-all flex flex-col justify-between">
                                    <div class="space-y-2.5">
                                        <div class="flex items-center justify-between">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-100 text-brand-700' }}">
                                                {{ $service->service_type === 'express' ? '⚡ Express (' . $service->estimated_hours . ' Jam)' : '⏱️ Regular (' . $service->estimated_hours . ' Jam)' }}
                                            </span>
                                            <span class="text-[11px] font-bold text-slate-400 uppercase">{{ $service->unit }}</span>
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-sm">{{ $service->name }}</h3>
                                        <p class="text-xs text-slate-500 leading-relaxed">{{ $service->description }}</p>
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 uppercase font-semibold">Tarif</span>
                                            <p class="text-base font-black text-brand-700">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                        </div>
                                        <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" class="px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold transition-colors">
                                            Pilih
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Packages Section -->
                <div class="bg-gradient-to-br from-brand-900 to-slate-900 text-white rounded-3xl p-6 sm:p-10 space-y-8">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="px-3.5 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-xs font-bold">Paket Hemat</span>
                        <h2 class="text-2xl sm:text-3xl font-black">Paket Bundling & Hemat Washora</h2>
                        <p class="text-xs sm:text-sm text-slate-300">Solusi laundry terencana dengan potongan harga spesial.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($packages as $pkg)
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/10 flex flex-col justify-between space-y-4">
                                <div>
                                    <h3 class="font-bold text-white text-base">{{ $pkg->name }}</h3>
                                    <p class="text-xs text-slate-300 mt-1.5 leading-relaxed">{{ $pkg->description }}</p>
                                    <div class="mt-4 pt-3 border-t border-white/10">
                                        <p class="text-[10px] text-cyan-300 uppercase font-bold">Harga Paket</p>
                                        <p class="text-xl font-black text-white">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('user.orders.create', ['package_id' => $pkg->id]) }}" class="w-full py-2 bg-cyan-400 hover:bg-cyan-300 text-slate-950 rounded-xl text-xs font-bold text-center block transition-colors">
                                    Ambil Paket
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection
