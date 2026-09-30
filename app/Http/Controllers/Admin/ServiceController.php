<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $categoryId = $request->input('category_id', 'all');
        $type = $request->input('service_type', 'all');

        $query = Service::with('category')->latest();

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if ($categoryId !== 'all' && is_numeric($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if ($type !== 'all' && in_array($type, ['regular', 'express'])) {
            $query->where('service_type', $type);
        }

        $services = $query->paginate(10)->withQueryString();
        $categories = ServiceCategory::where('status', 'active')->get();

        return view('admin.services.index', compact('services', 'categories', 'search', 'categoryId', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'in:kg,pcs,pair'],
            'estimated_hours' => ['required', 'integer', 'min:1'],
            'service_type' => ['required', 'in:regular,express'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        Service::create($validated);

        return back()->with('success', 'Layanan laundry baru berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'unit' => ['required', 'in:kg,pcs,pair'],
            'estimated_hours' => ['required', 'integer', 'min:1'],
            'service_type' => ['required', 'in:regular,express'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $service->update($validated);

        return back()->with('success', 'Layanan laundry berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->orderItems()->count() > 0) {
            return back()->with('error', 'Layanan tidak dapat dihapus karena tercatat dalam '.$service->orderItems()->count().' riwayat transaksi. Nonaktifkan status layanan ini.');
        }

        $service->delete();

        return back()->with('success', 'Layanan laundry berhasil dihapus.');
    }
}
