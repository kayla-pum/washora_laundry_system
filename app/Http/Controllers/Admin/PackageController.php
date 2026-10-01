<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Package::with(['services'])->latest();

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $packages = $query->paginate(10)->withQueryString();
        $allServices = Service::where('status', 'active')->get();

        return view('admin.packages.index', compact('packages', 'allServices', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'estimated_hours' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:servies,id'],
        ]);

        DB::transaction(function () use ($validated) {
            $package = Package::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'estimated_hours' => $validated['estimated_hours'],
                'status' => $validated['status'],
            ]);

            if (! empty($validated['service_ids'])) {
                foreach ($validated['service_ids'] as $svcId) {
                    PackageItem::create([
                        'package_id' => $package->id,
                        'service_id' => $svcId,
                    ]);
                }
            }
        });

        return back()->with('success', 'Paket laundry hemat berhasil ditambahkan.');
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'estimated_hours' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:servies,id'],
        ]);

        DB::transaction(function () use ($package, $validated) {
            $package->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'estimated_hours' => $validated['estimated_hours'],
                'status' => $validated['status'],
            ]);

            // Sync package items
            PackageItem::where('package_id', $package->id)->delete();
            if (! empty($validated['service_ids'])) {
                foreach ($validated['service_ids'] as $svcId) {
                    PackageItem::create([
                        'package_id' => $package->id,
                        'service_id' => $svcId,
                    ]);
                }
            }
        });

        return back()->with('success', 'Paket laundry berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        if ($package->orderItems()->count() > 0) {
            return back()->with('error', 'Paket tidak dapat dihapus karena tercatat dalam transaksi pelanggan. Nonaktifkan status paket ini.');
        }

        $package->delete();

        return back()->with('success', 'Paket laundry berhasil dihapus.');
    }
}
