@extends('layouts.admin')

@section('title', 'Manajemen Testimoni Pelanggan - Washora')
@section('page-title', 'Manajemen Ulasan & Testimoni')

@section('admin-content')
<div class="space-y-6">
    <!-- Header with Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Testimoni</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Seluruh ulasan dari pelanggan</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Disetujui (Publik)</p>
            <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['published'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Tampil di beranda website</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Menunggu Persetujuan</p>
            <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $stats['pending'] }}</h3>
            <p class="text-[11px] text-slate-400 mt-0.5">Perlu verifikasi admin</p>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Testimoni Pelanggan</h2>
            <p class="text-xs text-slate-400">Kelola dan moderasi ulasan yang diberikan pelanggan setelah pesanan selesai.</p>
        </div>

        <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-wrap items-center gap-2 text-xs">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, pesan, kode..." class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            <select name="status" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="published" {{ $status === 'published' ? 'selected' : '' }}>Disetujui (Publik)</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold transition-colors">
                Filter
            </button>
            @if($search !== '' || $status !== 'all')
                <a href="{{ route('admin.reviews.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table of Reviews -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Pelanggan</th>
                        <th class="py-4 px-6">No. Pesanan</th>
                        <th class="py-4 px-6">Rating</th>
                        <th class="py-4 px-6 max-w-xs">Isi Testimoni</th>
                        <th class="py-4 px-6">Status Publik</th>
                        <th class="py-4 px-6">Tanggal Kirim</th>
                        <th class="py-4 px-6 text-right">Aksi Moderasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($reviews as $rev)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $rev->customer_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $rev->user->email ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-mono font-bold text-slate-800">
                                @if($rev->order)
                                    <a href="{{ route('admin.orders.show', $rev->order) }}" class="text-brand-600 hover:underline">
                                        #{{ $rev->order->order_code }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-1 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rev->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-regular fa-star text-slate-300"></i>
                                        @endif
                                    @endfor
                                    <span class="text-slate-700 font-bold ml-1 text-xs">{{ $rev->rating }}.0</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <p class="text-slate-700 leading-relaxed italic">
                                    "{{ $rev->comment }}"
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                @if($rev->is_published)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i>
                                        <span>Disetujui (Tampil)</span>
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1 w-max">
                                        <i class="fa-solid fa-clock text-[10px]"></i>
                                        <span>Menunggu Persetujuan</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $rev->created_at->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                                <!-- Toggle Approve / Hide Button -->
                                <form action="{{ route('admin.reviews.toggle', $rev) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($rev->is_published)
                                        <button type="submit" title="Sembunyikan dari Publik" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition-colors inline-flex items-center gap-1">
                                            <i class="fa-solid fa-eye-slash text-xs"></i>
                                            <span>Sembunyikan</span>
                                        </button>
                                    @else
                                        <button type="submit" title="Setujui Testimoni" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] shadow-xs transition-colors inline-flex items-center gap-1">
                                            <i class="fa-solid fa-check text-xs"></i>
                                            <span>Setujui</span>
                                        </button>
                                    @endif
                                </form>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.reviews.destroy', $rev) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Testimoni" class="px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px] transition-colors inline-flex items-center">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2 text-xl">
                                    <i class="fa-regular fa-comment-dots"></i>
                                </div>
                                <p class="font-bold text-slate-700 text-sm">Belum Ada Testimoni Pelanggan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Ulasan dari pelanggan yang menyelesaikan pesanan akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
