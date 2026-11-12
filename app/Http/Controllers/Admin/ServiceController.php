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
        $orderType = $request->input('order_type', 'all');
        $serviceType = $request->input('service_type', 'all');
        $status = $request->input('status', 'all');
        $featured = $request->input('featured', 'all');
        $activeTab = $request->input('tab', 'all-services');

        $query = Service::with('category')->withCount('orderItems');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId !== 'all' && is_numeric($categoryId)) {
            $query->where('category_id', (int) $categoryId);
        }

        if ($orderType === 'kiloan') {
            $query->where('unit', 'kg');
        } elseif ($orderType === 'satuan') {
            $query->whereIn('unit', ['pcs', 'pair']);
        }

        if ($serviceType !== 'all' && in_array($serviceType, ['regular', 'express'], true)) {
            $query->where('service_type', $serviceType);
        }

        if ($status !== 'all' && in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        if ($featured === 'featured') {
            $query->where('is_featured', true);
        } elseif ($featured === 'not_featured') {
            $query->where('is_featured', false);
        }

        $services = $query->orderBy('is_featured', 'desc')
            ->orderBy('featured_order', 'asc')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $categories = ServiceCategory::where('status', 'active')->orderBy('name')->get();

        $featuredServices = Service::where('is_featured', true)
            ->with('category')
            ->orderBy('featured_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $availableForFeatured = Service::where('status', 'active')
            ->where('is_featured', false)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'featuredServices',
            'availableForFeatured',
            'search',
            'categoryId',
            'orderType',
            'serviceType',
            'status',
            'featured',
            'activeTab'
        ));
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
            'is_featured' => ['nullable', 'boolean'],
            'featured_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $isFeatured = $request->boolean('is_featured');

        if ($isFeatured && $validated['status'] !== 'active') {
            return back()->withInput()->with('error', 'Hanya layanan berstatus aktif yang dapat dijadikan sebagai sorotan homepage.');
        }

        if ($isFeatured) {
            $validated['is_featured'] = true;
            $validated['featured_order'] = ! empty($validated['featured_order'])
                ? (int) $validated['featured_order']
                : ((Service::where('is_featured', true)->max('featured_order') ?? 0) + 1);
        } else {
            $validated['is_featured'] = false;
            $validated['featured_order'] = null;
        }

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
            'is_featured' => ['nullable', 'boolean'],
            'featured_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $isFeatured = $request->boolean('is_featured');

        // Rule: Hanya layanan aktif yang boleh menjadi sorotan
        if ($validated['status'] === 'inactive') {
            $validated['is_featured'] = false;
            $validated['featured_order'] = null;
        } elseif ($isFeatured) {
            $validated['is_featured'] = true;
            $validated['featured_order'] = ! empty($validated['featured_order'])
                ? (int) $validated['featured_order']
                : ($service->featured_order ?? ((Service::where('is_featured', true)->max('featured_order') ?? 0) + 1));
        } else {
            $validated['is_featured'] = false;
            $validated['featured_order'] = null;
        }

        $service->update($validated);

        return back()->with('success', 'Layanan laundry berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->orderItems()->exists()) {
            return back()->with('error', 'Layanan "'.$service->name.'" tidak dapat dihapus karena sudah tercatat dalam riwayat transaksi pelanggan. Anda dapat menonaktifkan layanan ini agar riwayat transaksi tetap aman.');
        }

        if ($service->packageItems()->exists()) {
            return back()->with('error', 'Layanan "'.$service->name.'" tidak dapat dihapus karena masih digunakan dalam paket hemat.');
        }

        $service->delete();

        return back()->with('success', 'Layanan laundry berhasil dihapus.');
    }

    public function toggleStatus(Service $service)
    {
        $newStatus = $service->status === 'active' ? 'inactive' : 'active';

        $data = ['status' => $newStatus];

        // Jika dinonaktifkan, otomatis lepas dari sorotan homepage
        if ($newStatus === 'inactive' && $service->is_featured) {
            $data['is_featured'] = false;
            $data['featured_order'] = null;
            $service->update($data);

            return back()->with('success', 'Layanan "'.$service->name.'" dinonaktifkan dan otomatis dilepas dari sorotan homepage.');
        }

        $service->update($data);

        $statusLabel = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', 'Status layanan "'.$service->name.'" berhasil '.$statusLabel.'.');
    }

    public function toggleFeatured(Service $service)
    {
        if ($service->is_featured) {
            $service->update([
                'is_featured' => false,
                'featured_order' => null,
            ]);

            return back()->with('success', 'Layanan "'.$service->name.'" berhasil dihapus dari daftar sorotan homepage.');
        }

        if ($service->status !== 'active') {
            return back()->with('error', 'Hanya layanan berstatus aktif yang dapat dipilih sebagai sorotan homepage.');
        }

        $nextOrder = (Service::where('is_featured', true)->max('featured_order') ?? 0) + 1;

        $service->update([
            'is_featured' => true,
            'featured_order' => $nextOrder,
        ]);

        return back()->with('success', 'Layanan "'.$service->name.'" berhasil ditambahkan ke sorotan homepage (Urutan #'.$nextOrder.').');
    }

    public function addFeatured(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:servies,id'],
            'featured_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $service = Service::findOrFail($validated['service_id']);

        if ($service->status !== 'active') {
            return back()->with('error', 'Hanya layanan berstatus aktif yang dapat dijadikan sebagai sorotan homepage.');
        }

        $order = ! empty($validated['featured_order'])
            ? (int) $validated['featured_order']
            : ((Service::where('is_featured', true)->max('featured_order') ?? 0) + 1);

        $service->update([
            'is_featured' => true,
            'featured_order' => $order,
        ]);

        return back()->with('success', 'Layanan "'.$service->name.'" berhasil ditambahkan ke sorotan homepage.');
    }

    public function removeFeatured(Service $service)
    {
        $service->update([
            'is_featured' => false,
            'featured_order' => null,
        ]);

        return back()->with('success', 'Layanan "'.$service->name.'" berhasil dilepas dari daftar sorotan homepage.');
    }

    public function reorderFeatured(Request $request)
    {
        // Direct move up / move down
        if ($request->has('service_id') && $request->has('direction')) {
            $service = Service::where('id', $request->input('service_id'))
                ->where('is_featured', true)
                ->firstOrFail();

            $direction = $request->input('direction');
            $featuredServices = Service::where('is_featured', true)
                ->orderBy('featured_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $currentIndex = $featuredServices->search(fn ($item) => $item->id === $service->id);

            if ($direction === 'up' && $currentIndex > 0) {
                $swapWith = $featuredServices[$currentIndex - 1];
                $tempOrder = $swapWith->featured_order ?? ($currentIndex);
                $swapWith->update(['featured_order' => $service->featured_order ?? ($currentIndex + 1)]);
                $service->update(['featured_order' => $tempOrder]);
            } elseif ($direction === 'down' && $currentIndex < $featuredServices->count() - 1) {
                $swapWith = $featuredServices[$currentIndex + 1];
                $tempOrder = $swapWith->featured_order ?? ($currentIndex + 2);
                $swapWith->update(['featured_order' => $service->featured_order ?? ($currentIndex + 1)]);
                $service->update(['featured_order' => $tempOrder]);
            }

            return back()->with('success', 'Urutan sorotan homepage berhasil diperbarui.');
        }

        // Batch update orders array: [service_id => order_number]
        if ($request->has('orders') && is_array($request->input('orders'))) {
            foreach ($request->input('orders') as $serviceId => $order) {
                Service::where('id', $serviceId)
                    ->where('is_featured', true)
                    ->update(['featured_order' => (int) $order]);
            }

            return back()->with('success', 'Seluruh urutan sorotan homepage berhasil disimpan.');
        }

        return back();
    }
}
