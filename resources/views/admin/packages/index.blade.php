@extends('layouts.admin')

@section('title', 'Manajemen Paket Hemat - Washora')
@section('page-title', 'Manajemen Paket Laundry Hemat')

@section('admin-content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Daftar Paket Bundling Hemat</h1>
            <p class="text-xs text-slate-400">Kelola paket langganan kuota kiloan, bedding combo, dan sepatu clean pack.</p>
        </div>
        <button onclick="document.getElementById('modal-add-package').classList.remove('hidden')" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-600/20 transition-all flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Paket Baru</span>
        </button>
    </div>

    <!-- Packages Grid / Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $pkg)
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $pkg->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $pkg->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <span class="text-xs text-slate-400 font-semibold">{{ $pkg->estimated_hours }} Jam Pengerjaan</span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base">{{ $pkg->name }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $pkg->description }}</p>

                    <div class="p-3 bg-brand-50/60 rounded-2xl border border-brand-100">
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">Harga Paket</p>
                        <p class="text-xl font-black text-brand-700">Rp {{ number_format($pkg->price, 0, ',', '.') }}</p>
                    </div>

                    <!-- Included Services -->
                    @if($pkg->services->count() > 0)
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase text-slate-400">Layanan Termasuk:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($pkg->services as $s)
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md text-[10px] font-medium">
                                        {{ $s->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <button onclick="openEditPackage({{ json_encode($pkg) }})" class="px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors">
                        Edit Paket
                    </button>
                    <form action="{{ route('admin.packages.destroy', $pkg) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 rounded-3xl text-center text-slate-400 border border-slate-200">
                Belum ada data paket hemat.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Add Package -->
<div id="modal-add-package" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Tambah Paket Laundry Hemat Baru</h3>
            <button onclick="document.getElementById('modal-add-package').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Paket</label>
                <input type="text" name="name" required placeholder="Contoh: Paket Mahasiswa 20 Kg" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Paket (Rp)</label>
                    <input type="number" name="price" required min="0" placeholder="135000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam)</label>
                    <input type="number" name="estimated_hours" required min="1" value="24" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Paket</label>
                <textarea name="description" rows="2" placeholder="Rincian kuota dan keunggulan paket" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1.5">Layanan yang Termasuk dalam Paket:</label>
                <div class="max-h-36 overflow-y-auto space-y-1.5 p-2 bg-slate-50 rounded-xl border border-slate-200">
                    @foreach($allServices as $svc)
                        <label class="flex items-center gap-2 p-1 text-slate-700 cursor-pointer hover:bg-white rounded">
                            <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" class="rounded text-brand-600">
                            <span>{{ $svc->name }} (Rp {{ number_format($svc->price, 0, ',', '.') }})</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-add-package').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan Paket</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Package -->
<div id="modal-edit-package" class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-base">Edit Paket Laundry</h3>
            <button onclick="document.getElementById('modal-edit-package').classList.add('hidden')" class="p-1 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-edit-package" method="POST" class="space-y-4 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Paket</label>
                <input type="text" id="edit-pkg-name" name="name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Harga Paket (Rp)</label>
                    <input type="number" id="edit-pkg-price" name="price" required min="0" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 uppercase mb-1">Estimasi Pengerjaan (Jam)</label>
                    <input type="number" id="edit-pkg-hours" name="estimated_hours" required min="1" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                </div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Deskripsi Paket</label>
                <textarea id="edit-pkg-desc" name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium"></textarea>
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Status</label>
                <select id="edit-pkg-status" name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-edit-package').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditPackage(pkg) {
        document.getElementById('form-edit-package').action = '/admin/packages/' + pkg.id;
        document.getElementById('edit-pkg-name').value = pkg.name;
        document.getElementById('edit-pkg-price').value = parseInt(pkg.price);
        document.getElementById('edit-pkg-hours').value = pkg.estimated_hours;
        document.getElementById('edit-pkg-desc').value = pkg.description || '';
        document.getElementById('edit-pkg-status').value = pkg.status;
        document.getElementById('modal-edit-package').classList.remove('hidden');
    }
</script>
@endsection
