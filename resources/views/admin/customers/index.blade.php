@extends('layouts.admin')

@section('title', 'Data Pelanggan - Washora')
@section('page-title', 'Manajemen Data Pelanggan')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Search -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Database Pelanggan Terdaftar</h1>
            <p class="text-xs text-slate-400">Daftar pelanggan, kontak WhatsApp, dan riwayat pesanan.</p>
        </div>

        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-2">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / email / WA..." class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-brand-500 w-64">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold">Cari</button>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Nama Pelanggan</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Kontak WhatsApp</th>
                        <th class="py-4 px-6">Total Pesanan</th>
                        <th class="py-4 px-6">Pesanan Aktif</th>
                        <th class="py-4 px-6">Total Transaksi Lunas</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($customers as $cust)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold text-xs flex items-center justify-center">
                                        {{ strtoupper(substr($cust->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $cust->name }}</p>
                                        <p class="text-[10px] text-slate-400">Terdaftar {{ $cust->created_at->translatedFormat('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $cust->email }}
                            </td>
                            <td class="py-4 px-6">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cust->phone ?? '') }}" target="_blank" class="text-emerald-600 hover:underline font-bold flex items-center gap-1.5">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span>{{ $cust->phone ?? '-' }}</span>
                                </a>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $cust->orders_count }} Pesanan
                            </td>
                            <td class="py-4 px-6">
                                @if($cust->active_orders_count > 0)
                                    <span class="px-2.5 py-1 bg-cyan-100 text-cyan-800 rounded-full font-bold text-[10px]">
                                        {{ $cust->active_orders_count }} Berjalan
                                    </span>
                                @else
                                    <span class="text-slate-400 font-semibold">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-black text-brand-700">
                                Rp {{ number_format($cust->total_spent ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.customers.show', $cust) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 font-bold rounded-xl text-[11px] transition-all">
                                    Riwayat Laundry
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">Tidak ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
