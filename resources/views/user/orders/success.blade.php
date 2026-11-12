@extends('layouts.app')

@section('title', 'Pesanan Berhasil Dikirim - Washora')

@section('content')
    @include('layouts.navigation')

    <div class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Card -->
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-xl text-center space-y-6">
                <!-- Green Success Icon -->
                <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-4xl shadow-inner animate-in zoom-in-75 duration-300">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

                <!-- Title & Subtitle -->
                <div class="space-y-2">
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                        Status Awal: Menunggu Verifikasi
                    </span>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pesanan Berhasil Dikirim</h1>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Terima kasih! Pesanan Anda telah tercatat dalam sistem kami dan segera diproses oleh tim Washora.
                    </p>
                </div>

                <!-- Order Code Badge Box -->
                <div class="p-5 bg-brand-50/70 border border-brand-100 rounded-3xl space-y-1">
                    <p class="text-xs uppercase font-extrabold text-slate-400 tracking-wider">Kode Pesanan Anda</p>
                    <p class="text-3xl font-black text-brand-700 tracking-tight">#{{ $order->order_code }}</p>
                    <p class="text-[11px] text-slate-500">Gunakan kode ini untuk melacak status pengerjaan cucian Anda kapan saja.</p>
                </div>

                <!-- Order Summary Box -->
                <div class="text-left bg-slate-50 p-6 rounded-3xl border border-slate-100 space-y-4 text-xs">
                    <h3 class="font-bold text-slate-900 uppercase text-[11px] tracking-wider border-b border-slate-200 pb-2">
                        Ringkasan Informasi Pemesanan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-slate-600">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Pemesan:</span>
                            <span class="font-bold text-slate-800 text-xs">{{ $order->user->name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor WhatsApp:</span>
                            <span class="font-bold text-slate-800 text-xs">{{ $order->user->phone ?? '-' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Layanan / Paket:</span>
                            @foreach($order->items as $item)
                                <div class="font-bold text-slate-900 text-sm mt-0.5">
                                    {{ $item->item_name }}
                                    <span class="text-xs font-medium text-slate-500">(Rp {{ number_format($item->unit_price, 0, ',', '.') }} / {{ $item->unit }})</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Alamat Penjemputan:</span>
                            <span class="font-medium text-slate-800 text-xs mt-0.5 block">{{ $order->pickup_address }}</span>
                        </div>
                        @if($order->customer_note)
                            <div class="sm:col-span-2">
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Catatan Khusus:</span>
                                <span class="italic text-slate-700 text-xs mt-0.5 block">"{{ $order->customer_note }}"</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Next Steps Explanation -->
                <div class="text-left bg-white p-5 rounded-3xl border border-slate-200/80 space-y-3">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-brand-600 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info"></i>
                        Proses Selanjutnya
                    </h4>
                    <ul class="space-y-2.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">1</span>
                            <span><strong>Penjemputan:</strong> Kurir kami akan segera mendatangi alamat Anda untuk menjemput pakaian kotor.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">2</span>
                            <span><strong>Penimbangan Akurat:</strong> Admin akan memeriksa dan menimbang cucian di outlet Washora secara transparan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">3</span>
                            <span><strong>Konfirmasi WhatsApp:</strong> Rincian berat riil dan konfirmasi total biaya resmi akan langsung dikirim ke WhatsApp Anda.</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons: Kembali ke Beranda & Lacak Pesanan -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs border border-slate-200 shadow-xs hover:border-slate-300 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-house text-slate-500"></i>
                        <span>Kembali ke Beranda</span>
                    </a>

                    <a href="{{ route('tracking', ['code' => $order->order_code]) }}" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-lg shadow-brand-600/25 hover:shadow-brand-600/35 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Lacak Pesanan</span>
                    </a>

                    <a href="{{ route('user.orders.show', $order) }}" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Detail Pesanan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
@endsection
