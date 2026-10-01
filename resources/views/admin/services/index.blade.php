@extends('layouts.admin')

@section('title', 'Daftar Layanan Laundry - Washora')
@section('page-title', 'Manajemen Layanan Laundry')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Katalog Layanan Laundry</h1>
            <p class="text-xs text-slate-400">Atur tarif, satuan pengerjaan (Kg/Pcs/Pasang), tipe (Regular/Express), dan estimasi jam.</p>
        </div>
        <button onclick="document.getElementById('modal-add-service').classList.remove('hidden')" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Layanan Baru</span>
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex flex-wrap items-center justify-between gap-3 text-xs">
        <form action="{{ route('admin.services.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama layanan..." class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            
            <select name="category_id" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($categoryId == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="service_type" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                <option value="all">Semua Tipe</option>
                <option value="regular" {{ $type === 'regular' ? 'selected' : '' }}>Regular</option>
                <option value="express" {{ $type === 'express' ? 'selected' : '' }}>Express</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold">Filter</button>
        </form>
    </div>

    <!-- Services Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">Nama Layanan</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Tarif Dasar</th>
                        <th class="py-4 px-6">Satuan</th>
                        <th class="py-4 px-6">Estimasi Jam</th>
                        <th class="py-4 px-6">Tipe Pengerjaan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($services as $svc)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900 text-sm">{{ $svc->name }}</p>
                                <p class="text-[11px] text-slate-400 truncate max-w-xs">{{ $svc->description ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-700">
                                {{ $svc->category->name ?? '-' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-brand-700 text-sm">
                                Rp {{ number_format($svc->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 uppercase font-bold text-slate-500">
                                {{ $svc->unit }}
                            </td>
                            <td class="py-4 px-6 font-semibold">
                                {{ $svc->estimated_hours }} Jam
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $svc->service_type === 'express' ? 'bg-amber-100 text-amber-800' : 'bg-brand-50 text-brand-700' }}">
                                    {{ ucfirst($svc->service_type) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $svc->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $svc->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <button onclick="openEditService({{ json_encode($svc) }})" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-[11px] transition-colors">
                                    Edit
                                </button>
                                <form action="{{ route('admin.services.destroy', $svc) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus layanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">Belum ada data layanan laundry.</td>
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

<!-- Modal Add Service -->
<div id="modal-add-service" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Tambah Layanan Laundry Baru</h3>
            <button onclick="document.getElementById('modal-add-service').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Kategori Layanan</label>
                <select name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Layanan</label>
                <input type="text" name="name" required placeholder="Contoh: Cuci Komplit Setrika Express" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Satuan (Rp)</label>
                    <input type="number" name="price" required min="0" placeholder="10000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Satuan</label>
                    <select name="unit" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="kg">kg (Kilogram)</option>
                        <option value="pcs">pcs (Satuan Buah)</option>
                        <option value="pair">pair (Pasang)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam)</label>
                    <input type="number" name="estimated_hours" required min="1" value="24" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Tipe Pengerjaan</label>
                    <select name="service_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="regular">Regular</option>
                        <option value="express">Express</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Layanan</label>
                <textarea name="description" rows="2" placeholder="Keterangan singkat pengerjaan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add-service').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Service -->
<div id="modal-edit-service" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Edit Layanan Laundry</h3>
            <button onclick="document.getElementById('modal-edit-service').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-edit-service" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Kategori Layanan</label>
                <select id="edit-svc-category" name="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Layanan</label>
                <input type="text" id="edit-svc-name" name="name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Satuan (Rp)</label>
                    <input type="number" id="edit-svc-price" name="price" required min="0" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Satuan</label>
                    <select id="edit-svc-unit" name="unit" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="kg">kg (Kilogram)</option>
                        <option value="pcs">pcs (Satuan Buah)</option>
                        <option value="pair">pair (Pasang)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam)</label>
                    <input type="number" id="edit-svc-hours" name="estimated_hours" required min="1" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Tipe Pengerjaan</label>
                    <select id="edit-svc-type" name="service_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                        <option value="regular">Regular</option>
                        <option value="express">Express</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Layanan</label>
                <textarea id="edit-svc-desc" name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select id="edit-svc-status" name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-edit-service').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
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
        document.getElementById('modal-edit-service').classList.remove('hidden');
    }
</script>
@endsection
