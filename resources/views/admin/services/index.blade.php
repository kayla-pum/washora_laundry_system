@extends('layouts.admin')

@section('title', 'Manajemen Layanan & Sorotan Homepage - Washora')
@section('page-title', 'Manajemen Layanan Laundry')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Manajemen Layanan & Sorotan</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola seluruh jasa layanan Washora (Kiloan & Satuan) serta tentukan layanan yang tampil pada section sorotan homepage.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <button onclick="document.getElementById('modal-add-service').classList.remove('hidden')" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Layanan Baru</span>
            </button>
            <button onclick="switchTab('featured-tab')" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-sm transition-all flex items-center gap-2">
                <i class="fa-solid fa-star text-amber-400"></i>
                <span>Atur Sorotan ({{ $featuredServices->count() }})</span>
            </button>
        </div>
    </div>

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-jug-detergent"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Layanan</p>
                <p class="text-xl font-black text-slate-900">{{ \App\Models\Service::count() }}</p>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Layanan Kiloan</p>
                <p class="text-xl font-black text-slate-900">{{ \App\Models\Service::where('unit', 'kg')->count() }}</p>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-shirt"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Layanan Satuan</p>
                <p class="text-xl font-black text-slate-900">{{ \App\Models\Service::whereIn('unit', ['pcs', 'pair'])->count() }}</p>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Sorotan Homepage</p>
                <p class="text-xl font-black text-slate-900">{{ $featuredServices->count() }} <span class="text-xs font-semibold text-slate-400">Layanan</span></p>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <button type="button" id="tab-btn-all" onclick="switchTab('all-services')" class="tab-trigger px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 bg-brand-600 text-white shadow-xs">
            <i class="fa-solid fa-list-check"></i>
            <span>Seluruh Layanan ({{ $services->total() }})</span>
        </button>
        <button type="button" id="tab-btn-featured" onclick="switchTab('featured-tab')" class="tab-trigger px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 bg-white text-slate-600 hover:text-slate-900 border border-slate-200">
            <i class="fa-solid fa-star text-amber-500"></i>
            <span>Layanan Sorotan Homepage</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">{{ $featuredServices->count() }}</span>
        </button>
    </div>

    <!-- ==================== TAB 1: ALL SERVICES ==================== -->
    <div id="tab-all-services" class="space-y-6">
        <!-- Filter & Search Bar -->
        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs">
            <form action="{{ route('admin.services.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-2.5 text-xs">
                <input type="hidden" name="tab" value="all-services">

                <div class="lg:col-span-2">
                    <label class="block font-bold text-slate-600 mb-1 text-[11px]">Pencarian</label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / deskripsi..." class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                    </div>
                </div>
                
                <div>
                    <label class="block font-bold text-slate-600 mb-1 text-[11px]">Kategori</label>
                    <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ ($categoryId == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 mb-1 text-[11px]">Jenis Pemesanan</label>
                    <select name="order_type" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="all">Semua Jenis</option>
                        <option value="kiloan" {{ $orderType === 'kiloan' ? 'selected' : '' }}>Kiloan (Kg)</option>
                        <option value="satuan" {{ $orderType === 'satuan' ? 'selected' : '' }}>Satuan (Pcs/Pasang)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 mb-1 text-[11px]">Kecepatan</label>
                    <select name="service_type" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="all">Semua Kecepatan</option>
                        <option value="regular" {{ $serviceType === 'regular' ? 'selected' : '' }}>Regular</option>
                        <option value="express" {{ $serviceType === 'express' ? 'selected' : '' }}>Express</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-600 mb-1 text-[11px]">Status & Sorotan</label>
                    <div class="flex gap-1.5">
                        <select name="status" class="w-full px-2 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-[11px]">
                            <option value="all">Semua Status</option>
                            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <button type="submit" class="px-3 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold shrink-0">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6">Layanan Laundry</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Jenis Pemesanan</th>
                            <th class="py-4 px-6">Tarif & Satuan</th>
                            <th class="py-4 px-6">Kecepatan & Estimasi</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-center">Sorotan Beranda</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($services as $svc)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Service Name & Desc -->
                                <td class="py-4 px-6">
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-slate-900 text-sm">{{ $svc->name }}</p>
                                            @if($svc->is_featured)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200" title="Ditampilkan di section sorotan homepage">
                                                    <i class="fa-solid fa-star text-amber-500 text-[9px]"></i>
                                                    #{{ $svc->featured_order ?? '-' }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-slate-400 line-clamp-1 max-w-xs">{{ $svc->description ?? '-' }}</p>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="py-4 px-6 font-semibold text-slate-700">
                                    {{ $svc->category->name ?? '-' }}
                                </td>

                                <!-- Jenis Pemesanan: Kiloan vs Satuan -->
                                <td class="py-4 px-6">
                                    @if($svc->unit === 'kg')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200/80">
                                            <i class="fa-solid fa-scale-balanced text-xs"></i>
                                            Kiloan (Kg)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                            <i class="fa-solid fa-shirt text-xs"></i>
                                            Satuan ({{ strtoupper($svc->unit) }})
                                        </span>
                                    @endif
                                </td>

                                <!-- Price & Unit -->
                                <td class="py-4 px-6">
                                    <p class="font-black text-brand-700 text-sm">
                                        Rp {{ number_format($svc->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">/ {{ $svc->unit }}</p>
                                </td>

                                <!-- Speed & Estimated Hours -->
                                <td class="py-4 px-6 space-y-1">
                                    <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-extrabold {{ $svc->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-700' }}">
                                        {{ $svc->service_type === 'express' ? '⚡ Express' : '⏱️ Regular' }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 font-semibold">{{ $svc->estimated_hours }} Jam</p>
                                </td>

                                <!-- Status (Active / Inactive Toggle) -->
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('admin.services.status', $svc) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($svc->status === 'active')
                                            <button type="submit" title="Klik untuk menonaktifkan layanan ini" class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition-colors inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                Aktif
                                            </button>
                                        @else
                                            <button type="submit" title="Klik untuk mengaktifkan layanan ini" class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors inline-flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Nonaktif
                                            </button>
                                        @endif
                                    </form>
                                </td>

                                <!-- Featured Toggle -->
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('admin.services.featured.toggle', $svc) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($svc->is_featured)
                                            <button type="submit" title="Klik untuk menghapus dari sorotan homepage" class="px-2.5 py-1 rounded-xl text-[11px] font-bold bg-amber-500 hover:bg-amber-600 text-white shadow-xs transition-colors inline-flex items-center gap-1.5">
                                                <i class="fa-solid fa-star text-[10px]"></i>
                                                Sorotan #{{ $svc->featured_order ?? '-' }}
                                            </button>
                                        @else
                                            <button type="submit" title="{{ $svc->status === 'active' ? 'Klik untuk jadikan sorotan homepage' : 'Layanan harus aktif terlebih dahulu' }}" class="px-2.5 py-1 rounded-xl text-[11px] font-bold bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 transition-colors inline-flex items-center gap-1">
                                                <i class="fa-regular fa-star text-[10px]"></i>
                                                Bukan Sorotan
                                            </button>
                                        @endif
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                                    <button onclick="openEditService({{ json_encode($svc) }})" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-[11px] transition-colors">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>
                                    
                                    @if($svc->order_items_count > 0)
                                        <button type="button" onclick="alert('Layanan tidak dapat dihapus karena sudah memiliki {{ $svc->order_items_count }} riwayat transaksi pelanggan. Anda dapat menonaktifkannya.')" class="p-1.5 bg-slate-100 text-slate-300 rounded-lg text-xs cursor-not-allowed" title="Terkait {{ $svc->order_items_count }} riwayat transaksi">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('admin.services.destroy', $svc) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan {{ $svc->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition-colors" title="Hapus Layanan">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300 block"></i>
                                    Tidak ada data layanan yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    <!-- ==================== TAB 2: HOMEPAGE SPOTLIGHT SETTINGS ==================== -->
    <div id="tab-featured" class="hidden space-y-6">
        <!-- Overview Banner -->
        <div class="p-5 bg-gradient-to-r from-brand-600 via-brand-500 to-cyan-500 rounded-3xl text-white shadow-lg shadow-brand-500/20">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-xs">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                        Live Homepage Showcase
                    </span>
                    <h2 class="text-xl font-black">Pengaturan Layanan Sorotan Beranda</h2>
                    <p class="text-xs text-white/90 max-w-2xl leading-relaxed">
                        Tentukan layanan apa saja yang tampil pada bagian sorotan layanan di Homepage Washora. Anda dapat menambah, menghapus, atau mengubah urutan tampil secara fleksibel. Hanya layanan berstatus aktif yang dapat ditampilkan.
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('home') }}#layanan" target="_blank" class="px-4 py-2.5 rounded-xl bg-white text-brand-700 hover:bg-slate-50 text-xs font-bold shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Lihat di Homepage</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Add Service to Spotlight Form -->
        <div class="p-6 bg-white rounded-3xl border border-slate-200/90 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-brand-600"></i>
                        Tambah Layanan ke Daftar Sorotan
                    </h3>
                    <p class="text-xs text-slate-400">Pilih dari layanan berstatus aktif yang belum masuk ke dalam sorotan beranda.</p>
                </div>
            </div>

            <form action="{{ route('admin.services.featured.add') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs items-end">
                @csrf
                <div class="sm:col-span-8">
                    <label class="block font-bold text-slate-700 uppercase mb-1 text-[11px]">Pilih Layanan Aktif</label>
                    <select name="service_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                        <option value="">-- Pilih Layanan untuk Ditampilkan di Sorotan --</option>
                        @foreach($availableForFeatured as $avail)
                            <option value="{{ $avail->id }}">
                                {{ $avail->name }} ({{ $avail->category->name ?? 'Umum' }} • Rp {{ number_format($avail->price, 0, ',', '.') }}/{{ $avail->unit }} • {{ ucfirst($avail->service_type) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 uppercase mb-1 text-[11px]">Urutan Tampil</label>
                    <input type="number" name="featured_order" min="1" value="{{ ($featuredServices->max('featured_order') ?? 0) + 1 }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold focus:ring-2 focus:ring-brand-500">
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-md shadow-brand-600/20 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-star"></i>
                        <span>Jadikan Sorotan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Featured Services Ordering List -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-list-ol text-amber-500"></i>
                        Daftar Layanan Sorotan Beranda Saat Ini ({{ $featuredServices->count() }})
                    </h3>
                    <p class="text-xs text-slate-400">Atur urutan tampilan layanan sorotan menggunakan tombol panah atau simpan nomor urutan.</p>
                </div>
                @if($featuredServices->isNotEmpty())
                    <form action="{{ route('admin.services.featured.reorder') }}" method="POST" id="form-batch-reorder" class="hidden sm:inline">
                        @csrf
                    </form>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 text-center w-20">Urutan</th>
                            <th class="py-4 px-6">Layanan Sorotan</th>
                            <th class="py-4 px-6">Kategori</th>
                            <th class="py-4 px-6">Jenis Pemesanan</th>
                            <th class="py-4 px-6">Tarif Layanan</th>
                            <th class="py-4 px-6">Kecepatan</th>
                            <th class="py-4 px-6 text-center">Ubah Urutan</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($featuredServices as $index => $feat)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Order Number -->
                                <td class="py-4 px-6 text-center">
                                    <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-black inline-flex items-center justify-center text-xs">
                                        #{{ $feat->featured_order ?? ($index + 1) }}
                                    </span>
                                </td>

                                <!-- Name & Description -->
                                <td class="py-4 px-6">
                                    <p class="font-bold text-slate-900 text-sm">{{ $feat->name }}</p>
                                    <p class="text-[11px] text-slate-400 line-clamp-1 max-w-sm">{{ $feat->description ?? '-' }}</p>
                                </td>

                                <!-- Category -->
                                <td class="py-4 px-6 font-semibold text-slate-700">
                                    {{ $feat->category->name ?? '-' }}
                                </td>

                                <!-- Jenis Pemesanan: Kiloan / Satuan -->
                                <td class="py-4 px-6">
                                    @if($feat->unit === 'kg')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-cyan-50 text-cyan-700">
                                            <i class="fa-solid fa-scale-balanced text-xs"></i> Kiloan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-purple-50 text-purple-700">
                                            <i class="fa-solid fa-shirt text-xs"></i> Satuan ({{ strtoupper($feat->unit) }})
                                        </span>
                                    @endif
                                </td>

                                <!-- Price -->
                                <td class="py-4 px-6">
                                    <p class="font-black text-brand-700 text-sm">
                                        Rp {{ number_format($feat->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[10px] uppercase font-bold text-slate-400">/ {{ $feat->unit }}</p>
                                </td>

                                <!-- Speed & Estimated Hours -->
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold {{ $feat->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-700' }}">
                                        {{ $feat->service_type === 'express' ? '⚡ Express' : '⏱️ Regular' }} ({{ $feat->estimated_hours }}j)
                                    </span>
                                </td>

                                <!-- Reorder Buttons -->
                                <td class="py-4 px-6 text-center space-x-1 whitespace-nowrap">
                                    @if($index > 0)
                                        <form action="{{ route('admin.services.featured.reorder') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $feat->id }}">
                                            <input type="hidden" name="direction" value="up">
                                            <button type="submit" title="Geser Urutan Naik" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors inline-flex items-center justify-center">
                                                <i class="fa-solid fa-arrow-up text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="w-7 h-7 inline-block"></span>
                                    @endif

                                    @if($index < $featuredServices->count() - 1)
                                        <form action="{{ route('admin.services.featured.reorder') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $feat->id }}">
                                            <input type="hidden" name="direction" value="down">
                                            <button type="submit" title="Geser Urutan Turun" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors inline-flex items-center justify-center">
                                                <i class="fa-solid fa-arrow-down text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="w-7 h-7 inline-block"></span>
                                    @endif
                                </td>

                                <!-- Remove from Spotlight (Without Deleting Service) -->
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route('admin.services.featured.remove', $feat) }}" method="POST" class="inline" onsubmit="return confirm('Hapus {{ $feat->name }} dari daftar sorotan homepage? Data layanan tidak akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-xl text-[11px] transition-colors inline-flex items-center gap-1.5" title="Hapus dari sorotan homepage">
                                            <i class="fa-solid fa-star-half-stroke text-xs text-rose-500"></i>
                                            <span>Lepas Sorotan</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <i class="fa-regular fa-star text-3xl mb-2 text-slate-300 block"></i>
                                    Belum ada layanan yang dipilih sebagai sorotan homepage.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ==================== MODAL ADD SERVICE ==================== -->
<div id="modal-add-service" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-5 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Tambah Layanan Laundry Baru</h3>
                <p class="text-xs text-slate-400">Tentukan rincian layanan, jenis pemesanan, dan opsi sorotan homepage.</p>
            </div>
            <button onclick="document.getElementById('modal-add-service').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            
            <!-- Category -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Kategori Layanan <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Service Name -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Layanan <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Cuci Komplit + Setrika Wangi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            </div>

            <!-- Jenis Pemesanan (Kiloan vs Satuan Selector) -->
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                <label class="block font-bold text-slate-700 uppercase text-[11px]">
                    Jenis Pemesanan & Satuan Harga <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="order_type_selector_add" value="kiloan" checked class="peer sr-only" onchange="handleOrderTypeChange('add', 'kiloan')">
                        <div class="p-2.5 rounded-xl border border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 text-center font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <span>Kiloan (Kg)</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="order_type_selector_add" value="satuan" class="peer sr-only" onchange="handleOrderTypeChange('add', 'satuan')">
                        <div class="p-2.5 rounded-xl border border-slate-200 peer-checked:border-purple-600 peer-checked:bg-purple-50 peer-checked:text-purple-700 text-center font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-shirt"></i>
                            <span>Satuan (Pcs / Pasang)</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Price -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Layanan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" required min="0" placeholder="Contoh: 10000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Unit -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Satuan Harga <span class="text-rose-500">*</span></label>
                    <select name="unit" id="add-svc-unit" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                        <option value="kg">kg (Kilogram)</option>
                        <option value="pcs">pcs (Satuan Buah)</option>
                        <option value="pair">pair (Pasang)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Estimated Hours -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam) <span class="text-rose-500">*</span></label>
                    <input type="number" name="estimated_hours" required min="1" value="24" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Service Speed Type -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Kecepatan Pengerjaan <span class="text-rose-500">*</span></label>
                    <select name="service_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                        <option value="regular">Regular</option>
                        <option value="express">Express</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Layanan</label>
                <textarea name="description" rows="2" placeholder="Keterangan singkat mengenai proses pengerjaan layanan..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <!-- Status & Homepage Spotlight Box -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Status Layanan <span class="text-rose-500">*</span></label>
                        <select name="status" id="add-svc-status" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl font-medium">
                            <option value="active">Aktif (Tersedia)</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Urutan Sorotan</label>
                        <input type="number" name="featured_order" min="1" placeholder="Opsional (otomatis)" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl font-medium">
                    </div>
                </div>

                <label class="flex items-center gap-2.5 cursor-pointer pt-1">
                    <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                    <span class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-500 text-xs"></i>
                        Tampilkan sebagai Sorotan di Homepage Washora
                    </span>
                </label>
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add-service').classList.add('hidden')" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-md shadow-brand-600/20 transition-all">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MODAL EDIT SERVICE ==================== -->
<div id="modal-edit-service" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-5 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Edit Layanan Laundry</h3>
                <p class="text-xs text-slate-400">Perbarui rincian tarif, deskripsi, jenis pemesanan, atau status sorotan.</p>
            </div>
            <button onclick="document.getElementById('modal-edit-service').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="form-edit-service" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')

            <!-- Category -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Kategori Layanan <span class="text-rose-500">*</span></label>
                <select id="edit-svc-category" name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Service Name -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Layanan <span class="text-rose-500">*</span></label>
                <input type="text" id="edit-svc-name" name="name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            </div>

            <!-- Jenis Pemesanan (Kiloan vs Satuan Selector) -->
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                <label class="block font-bold text-slate-700 uppercase text-[11px]">
                    Jenis Pemesanan & Satuan Harga <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" id="edit-type-kiloan" name="order_type_selector_edit" value="kiloan" class="peer sr-only" onchange="handleOrderTypeChange('edit', 'kiloan')">
                        <div class="p-2.5 rounded-xl border border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 text-center font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <span>Kiloan (Kg)</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" id="edit-type-satuan" name="order_type_selector_edit" value="satuan" class="peer sr-only" onchange="handleOrderTypeChange('edit', 'satuan')">
                        <div class="p-2.5 rounded-xl border border-slate-200 peer-checked:border-purple-600 peer-checked:bg-purple-50 peer-checked:text-purple-700 text-center font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-shirt"></i>
                            <span>Satuan (Pcs / Pasang)</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Price -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Layanan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" id="edit-svc-price" name="price" required min="0" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Unit -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Satuan Harga <span class="text-rose-500">*</span></label>
                    <select id="edit-svc-unit" name="unit" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                        <option value="kg">kg (Kilogram)</option>
                        <option value="pcs">pcs (Satuan Buah)</option>
                        <option value="pair">pair (Pasang)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Estimated Hours -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam) <span class="text-rose-500">*</span></label>
                    <input type="number" id="edit-svc-hours" name="estimated_hours" required min="1" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Speed Type -->
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Kecepatan Pengerjaan <span class="text-rose-500">*</span></label>
                    <select id="edit-svc-type" name="service_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
                        <option value="regular">Regular</option>
                        <option value="express">Express</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Layanan</label>
                <textarea id="edit-svc-desc" name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <!-- Status & Homepage Spotlight Box -->
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Status Layanan <span class="text-rose-500">*</span></label>
                        <select id="edit-svc-status" name="status" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl font-medium">
                            <option value="active">Aktif (Tersedia)</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase mb-1">Urutan Sorotan</label>
                        <input type="number" id="edit-svc-order" name="featured_order" min="1" class="w-full px-3.5 py-2 bg-white border border-slate-200 rounded-xl font-medium">
                    </div>
                </div>

                <label class="flex items-center gap-2.5 cursor-pointer pt-1">
                    <input type="checkbox" id="edit-svc-featured" name="is_featured" value="1" class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                    <span class="font-bold text-slate-800 text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-500 text-xs"></i>
                        Tampilkan sebagai Sorotan di Homepage Washora
                    </span>
                </label>
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-edit-service').classList.add('hidden')" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-md shadow-brand-600/20 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tabId) {
        const allTab = document.getElementById('tab-all-services');
        const featTab = document.getElementById('tab-featured');
        const btnAll = document.getElementById('tab-btn-all');
        const btnFeat = document.getElementById('tab-btn-featured');

        if (tabId === 'featured-tab') {
            allTab.classList.add('hidden');
            featTab.classList.remove('hidden');

            btnFeat.classList.add('bg-brand-600', 'text-white', 'shadow-xs');
            btnFeat.classList.remove('bg-white', 'text-slate-600');

            btnAll.classList.remove('bg-brand-600', 'text-white', 'shadow-xs');
            btnAll.classList.add('bg-white', 'text-slate-600');
        } else {
            featTab.classList.add('hidden');
            allTab.classList.remove('hidden');

            btnAll.classList.add('bg-brand-600', 'text-white', 'shadow-xs');
            btnAll.classList.remove('bg-white', 'text-slate-600');

            btnFeat.classList.remove('bg-brand-600', 'text-white', 'shadow-xs');
            btnFeat.classList.add('bg-white', 'text-slate-600');
        }
    }

    function handleOrderTypeChange(mode, type) {
        const unitSelect = document.getElementById(mode === 'add' ? 'add-svc-unit' : 'edit-svc-unit');
        if (!unitSelect) return;

        if (type === 'kiloan') {
            unitSelect.value = 'kg';
        } else {
            if (unitSelect.value === 'kg') {
                unitSelect.value = 'pcs';
            }
        }
    }

    function openEditService(svc) {
        document.getElementById('form-edit-service').action = '/admin/services/' + svc.id;
        document.getElementById('edit-svc-category').value = svc.category_id;
        document.getElementById('edit-svc-name').value = svc.name;
        document.getElementById('edit-svc-price').value = parseInt(svc.price);
        document.getElementById('edit-svc-unit').value = svc.unit;
        document.getElementById('edit-svc-hours').value = svc.estimated_hours;
        document.getElementById('edit-svc-type').value = svc.service_type;
        document.getElementById('edit-svc-desc').value = svc.description || '';
        document.getElementById('edit-svc-status').value = svc.status;
        
        // Order type selector radio
        if (svc.unit === 'kg') {
            document.getElementById('edit-type-kiloan').checked = true;
        } else {
            document.getElementById('edit-type-satuan').checked = true;
        }

        // Featured checkbox & order
        document.getElementById('edit-svc-featured').checked = Boolean(svc.is_featured);
        document.getElementById('edit-svc-order').value = svc.featured_order || '';

        document.getElementById('modal-edit-service').classList.remove('hidden');
    }

    // Auto switch to tab from query string if provided
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'featured-tab') {
            switchTab('featured-tab');
        }
    });
</script>
@endsection
