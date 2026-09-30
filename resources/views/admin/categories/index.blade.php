@extends('layouts.admin')

@section('title', 'Kategori Layanan - Washora')
@section('page-title', 'Manajemen Kategori Layanan')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Kategori Layanan Laundry</h1>
            <p class="text-xs text-slate-400">Kelola kelompok jenis cucian seperti Kiloan, Satuan, Bedding, Sepatu, dll.</p>
        </div>
        <button onclick="document.getElementById('modal-add-category').classList.remove('hidden')" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kategori Baru</span>
        </button>
    </div>

    <!-- Categories Grid / Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">Nama Kategori</th>
                        <th class="py-4 px-6">Deskripsi</th>
                        <th class="py-4 px-6">Jumlah Layanan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-400">#{{ $cat->id }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900 text-sm">
                                {{ $cat->name }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 max-w-sm">
                                {{ $cat->description ?? '-' }}
                            </td>
                            <td class="py-4 px-6 font-semibold">
                                <span class="px-2.5 py-1 bg-slate-100 rounded-lg text-slate-700 font-bold">
                                    {{ $cat->services_count }} Layanan
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $cat->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $cat->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <button onclick="openEditCategory({{ json_encode($cat) }})" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-[11px] transition-colors">
                                    Edit
                                </button>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kategori ini?')">
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
                            <td colspan="6" class="py-12 text-center text-slate-400">Belum ada kategori layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Modal Add Category -->
<div id="modal-add-category" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Tambah Kategori Baru</h3>
            <button onclick="document.getElementById('modal-add-category').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Kategori</label>
                <input type="text" name="name" required placeholder="Contoh: Sepatu & Tas" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi</label>
                <textarea name="description" rows="2" placeholder="Deskripsi singkat jenis layanan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add-category').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Category -->
<div id="modal-edit-category" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Edit Kategori Layanan</h3>
            <button onclick="document.getElementById('modal-edit-category').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-edit-category" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Kategori</label>
                <input type="text" id="edit-cat-name" name="name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi</label>
                <textarea id="edit-cat-description" name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium focus:ring-2 focus:ring-brand-500"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select id="edit-cat-status" name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-edit-category').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditCategory(cat) {
        document.getElementById('form-edit-category').action = '/admin/categories/' + cat.id;
        document.getElementById('edit-cat-name').value = cat.name;
        document.getElementById('edit-cat-description').value = cat.description || '';
        document.getElementById('edit-cat-status').value = cat.status;
        document.getElementById('modal-edit-category').classList.remove('hidden');
    }
</script>
@endsection
