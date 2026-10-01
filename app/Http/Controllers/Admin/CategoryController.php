<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = ServiceCategory::withCount('services')->latest();

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->withQueryString();

        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        ServiceCategory::create($validated);

        return back()->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function update(Request $request, ServiceCategory $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $category->update($validated);

        return back()->with('success', 'Kategori layanan berhasil diperbarui.');
    }

    public function destroy(ServiceCategory $category)
    {
        if ($category->services()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki '.$category->services()->count().' layanan terkait. Nonaktifkan saja jika tidak digunakan.');
        }

        $category->delete();

        return back()->with('success', 'Kategori layanan berhasil dihapus.');
    }
}
