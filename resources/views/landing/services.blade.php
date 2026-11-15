@extends('layouts.app')

@section('title', 'Katalog Layanan & Tarif - Washora')

@section('content')
    @include('layouts.navigation')

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white border border-slate-200 text-slate-700 text-xs font-semibold">
                    Katalog Resmi
                </span>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Daftar Lengkap Layanan & Paket</h1>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                    Harga transparan tanpa biaya tersembunyi. Timbang dan periksa langsung di outlet dengan konfirmasi nota digital via WhatsApp.
                </p>
            </div>

            <!-- Categories and Services Loop -->
            <div class="space-y-8">
                @foreach($categories as $category)
                    <div class="bg-white rounded-xl p-5 sm:p-6 border border-slate-200 shadow-xs space-y-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 border-b border-slate-100 gap-2">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-layer-group text-brand-600 text-sm"></i>
                                    {{ $category->name }}
                                </h2>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $category->description }}</p>
                            </div>
                            <span class="px-2.5 py-1 bg-slate-100 rounded-md text-xs font-medium text-slate-600 w-fit">
                                {{ $category->activeServices->count() }} Pilihan Layanan
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($category->activeServices as $service)
                                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 hover:bg-white hover:border-brand-400 transition-colors flex flex-col justify-between space-y-3">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-slate-200 text-slate-700' }}">
                                                {{ $service->service_type === 'express' ? 'Express (' . $service->estimated_hours . ' Jam)' : 'Reguler (' . $service->estimated_hours . ' Jam)' }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400 uppercase">{{ $service->unit }}</span>
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-sm">{{ $service->name }}</h3>
                                        <p class="text-xs text-slate-500 leading-relaxed">{{ $service->description }}</p>
                                    </div>

                                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 uppercase font-medium">Tarif</span>
                                            <p class="text-base font-bold text-slate-900">
                                                Rp {{ number_format($service->price, 0, ',', '.') }}
                                                <span class="text-xs font-normal text-slate-500">/ {{ $service->unit }}</span>
                                            </p>
                                        </div>
                                        <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" class="px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-md text-xs font-semibold transition-colors">
                                            Pilih
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Packages Section -->
                @if(isset($packages) && $packages->isNotEmpty())
                    <div class="bg-slate-900 text-white rounded-xl p-6 sm:p-8 space-y-6">
                        <div class="text-center max-w-xl mx-auto space-y-1">
                            <span class="px-2.5 py-0.5 rounded bg-slate-800 text-cyan-300 text-xs font-semibold">Paket Hemat</span>
                            <h2 class="text-xl sm:text-2xl font-bold">Paket Bundling & Hemat Washora</h2>
                            <p class="text-xs text-slate-300">Solusi laundry terencana dengan potongan harga hemat.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($packages as $pkg)
                                <div class="bg-slate-800 rounded-lg p-4 border border-slate-700 flex flex-col justify-between space-y-3">
                                    <div class="space-y-2">
                                        <h3 class="font-bold text-white text-sm">{{ $pkg->name }}</h3>
                                        <p class="text-xs text-slate-300 leading-relaxed">{{ $pkg->description }}</p>
                                        <div class="pt-2">
                                            <p class="text-[10px] text-slate-400 uppercase font-medium">Tarif Paket</p>
                                            <p class="text-lg font-bold text-white">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('user.orders.create', ['package_id' => $pkg->id]) }}" class="w-full py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-md text-xs font-semibold text-center block transition-colors">
                                        Ambil Paket
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection
