@extends('layouts.user')

@section('title', 'Buat Pesanan Laundry Baru - Washora')

@section('user-content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Form Pemesanan Laundry</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pilih layanan atau paket hemat. Kurir kami akan menjemput ke lokasi Anda.</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
            &larr; Kembali
        </a>
    </div>

    <!-- Important User Notice Box -->
    <div class="p-4 bg-brand-50 border border-brand-200 rounded-3xl flex items-start gap-3.5 text-brand-900 shadow-xs">
        <div class="w-9 h-9 rounded-2xl bg-brand-600 text-white flex items-center justify-center shrink-0 text-base shadow-sm">
            <i class="fa-solid fa-scale-balanced"></i>
        </div>
        <div class="text-xs space-y-1">
            <p class="font-bold text-sm text-brand-950">Informasi Penimbangan & Total Biaya</p>
            <p class="text-brand-800 leading-relaxed">
                Anda <strong>tidak perlu memasukkan berat laundry</strong> saat membuat pesanan ini. Berat akurat serta total tarif resmi akan dihitung, diverifikasi, dan dikonfirmasikan oleh Admin Washora setelah cucian tiba di outlet kami melalui WhatsApp.
            </p>
        </div>
    </div>

    <form action="{{ route('user.orders.store') }}" method="POST" class="space-y-8" id="order-form">
        @csrf

        <!-- 1. Selection Item Type: Service or Package -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                        Pilih Kategori Pemesanan
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Pilih ingin memesan Layanan Satuan/Kiloan atau Paket Bundling Hemat</p>
                </div>
            </div>

            <!-- Tab Radio Selector -->
            <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-100 rounded-2xl">
                <label class="cursor-pointer">
                    <input type="radio" name="item_type" value="service" id="type-service" class="peer sr-only" {{ empty($selectedPackageId) ? 'checked' : '' }} onchange="toggleItemType('service')">
                    <div class="py-3 px-4 text-center rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-white peer-checked:text-brand-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-jug-detergent"></i>
                        <span>Layanan Regular / Express</span>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="item_type" value="package" id="type-package" class="peer sr-only" {{ !empty($selectedPackageId) ? 'checked' : '' }} onchange="toggleItemType('package')">
                    <div class="py-3 px-4 text-center rounded-xl text-xs font-bold text-slate-600 peer-checked:bg-white peer-checked:text-brand-600 peer-checked:shadow-sm transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-box-archive"></i>
                        <span>Paket Bundling Hemat</span>
                    </div>
                </label>
            </div>

            <!-- Service Selection Box -->
            <div id="section-service" class="space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Pilih Layanan Laundry:</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-1">
                    @foreach($categories as $category)
                        @foreach($category->activeServices as $service)
                            <label class="cursor-pointer">
                                <input type="radio" name="service_id" value="{{ $service->id }}" class="peer sr-only" {{ ($selectedServiceId == $service->id || ($loop->parent->first && $loop->first && empty($selectedPackageId))) ? 'checked' : '' }}>
                                <div class="p-4 rounded-2xl border border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/50 peer-checked:ring-2 peer-checked:ring-brand-200 transition-all flex flex-col justify-between h-full hover:bg-slate-50">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $service->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $service->service_type === 'express' ? 'Express ' . $service->estimated_hours . ' Jam' : 'Regular ' . $service->estimated_hours . ' Jam' }}
                                            </span>
                                            <span class="text-[11px] font-semibold text-slate-400">{{ $category->name }}</span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm mt-2">{{ $service->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $service->description }}</p>
                                    </div>
                                    <div class="pt-3 mt-3 border-t border-slate-200/60 flex items-center justify-between">
                                        <span class="text-xs font-extrabold text-brand-700">
                                            Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->unit }}
                                        </span>
                                        <span class="text-[11px] font-semibold text-slate-400">Pilih</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    @endforeach
                </div>
                @error('service_id')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Package Selection Box -->
            <div id="section-package" class="space-y-4 hidden">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Pilih Paket Hemat Laundry:</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($packages as $pkg)
                        <label class="cursor-pointer">
                            <input type="radio" name="package_id" value="{{ $pkg->id }}" class="peer sr-only" {{ ($selectedPackageId == $pkg->id || ($loop->first && !empty($selectedPackageId))) ? 'checked' : '' }}>
                            <div class="p-4 rounded-2xl border border-slate-200 peer-checked:border-brand-600 peer-checked:bg-brand-50/50 peer-checked:ring-2 peer-checked:ring-brand-200 transition-all flex flex-col justify-between h-full hover:bg-slate-50">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $pkg->name }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $pkg->description }}</p>
                                    <p class="text-[11px] text-brand-600 font-semibold mt-1">Est. Pengerjaan {{ $pkg->estimated_hours }} Jam</p>
                                </div>
                                <div class="pt-3 mt-3 border-t border-slate-200/60 flex items-center justify-between">
                                    <span class="text-sm font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                                    <span class="text-[11px] font-semibold text-slate-400">Pilih</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('package_id')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- 2. Customer & Pickup Address Information -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
            <div>
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs font-bold">2</span>
                    Data Penjemputan & Kontak
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Pastikan nomor WhatsApp dan alamat akurat untuk memudahkan kurir.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <div>
                    <label for="recipient_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Pemesan</label>
                    <input type="text" id="recipient_name" name="recipient_name" required value="{{ old('recipient_name', auth()->user()->name) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    @error('recipient_name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="whatsapp_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor WhatsApp (Aktif)</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" required value="{{ old('whatsapp_number', auth()->user()->phone ?? '') }}" placeholder="081234567890" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                    @error('whatsapp_number')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="pickup_address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Lengkap Penjemputan Cucian</label>
                <textarea id="pickup_address" name="pickup_address" rows="3" required placeholder="Contoh: Jl. Diponegoro No. 12, RT 02/RW 04, Kel. Sukamaju (Pagar Hitam, Samping Alfamart)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">{{ old('pickup_address') }}</textarea>
                @error('pickup_address')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Customer Note -->
            <div>
                <label for="customer_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan Tambahan untuk Laundry (Opsional)</label>
                <input type="text" id="customer_note" name="customer_note" value="{{ old('customer_note') }}" placeholder="Contoh: Tolong pisahkan pakaian putih, gunakan pewangi lavender, jemput jam 2 siang" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all">
                @error('customer_note')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit & Info -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-white rounded-3xl border border-slate-200/90 shadow-xs">
            <div class="text-xs text-slate-500 text-center sm:text-left">
                <p class="font-bold text-slate-800">Status awal pesanan: <span class="text-amber-600">Pending (Menunggu Verifikasi)</span></p>
                <p>Kurir akan segera datang menjemput pakaian kotor Anda.</p>
            </div>

            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-extrabold rounded-2xl shadow-lg shadow-brand-600/25 hover:shadow-brand-600/35 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Kirim Pesanan Laundry</span>
            </button>
        </div>
    </form>
</div>

<script>
    function toggleItemType(type) {
        const secSvc = document.getElementById('section-service');
        const secPkg = document.getElementById('section-package');
        if (type === 'service') {
            secSvc.classList.remove('hidden');
            secPkg.classList.add('hidden');
        } else {
            secSvc.classList.add('hidden');
            secPkg.classList.remove('hidden');
        }
    }

    // Initialize state on load
    document.addEventListener('DOMContentLoaded', () => {
        const isPkg = document.getElementById('type-package').checked;
        toggleItemType(isPkg ? 'package' : 'service');
    });
</script>
@endsection
