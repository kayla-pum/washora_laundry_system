<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::where('role', 'admin')->first();
    }

    public function test_admin_can_view_services_index_and_featured_tab(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.services.index'));

        $response->assertOk();
        $response->assertSee('Manajemen Layanan & Sorotan');
        $response->assertSee('Tambah Layanan Baru');
        $response->assertSee('Pengaturan Layanan Sorotan Beranda');
        $response->assertSee('Seluruh Layanan');
        $response->assertSee('Kiloan');
        $response->assertSee('Satuan');
    }

    public function test_admin_can_create_new_kiloan_service(): void
    {
        $category = ServiceCategory::first();

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'category_id' => $category->id,
            'name' => 'Cuci Kering Express 3 Jam',
            'description' => 'Cuci kering bersih dalam 3 jam.',
            'price' => 12000,
            'unit' => 'kg',
            'estimated_hours' => 3,
            'service_type' => 'express',
            'status' => 'active',
            'is_featured' => 1,
            'featured_order' => 10,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('servies', [
            'name' => 'Cuci Kering Express 3 Jam',
            'unit' => 'kg',
            'service_type' => 'express',
            'is_featured' => 1,
            'featured_order' => 10,
        ]);
    }

    public function test_admin_can_create_new_satuan_service(): void
    {
        $category = ServiceCategory::first();

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'category_id' => $category->id,
            'name' => 'Cuci Helm Full Face',
            'description' => 'Deep clean busa helm antibakteri.',
            'price' => 25000,
            'unit' => 'pcs',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('servies', [
            'name' => 'Cuci Helm Full Face',
            'unit' => 'pcs',
            'service_type' => 'regular',
        ]);
    }

    public function test_admin_can_update_service(): void
    {
        $service = Service::first();

        $response = $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'category_id' => $service->category_id,
            'name' => 'Nama Layanan Diperbarui',
            'description' => 'Deskripsi baru.',
            'price' => 18000,
            'unit' => $service->unit,
            'estimated_hours' => 12,
            'service_type' => 'regular',
            'status' => 'active',
            'is_featured' => 1,
            'featured_order' => 5,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $service->refresh();
        $this->assertEquals('Nama Layanan Diperbarui', $service->name);
        $this->assertEquals(18000, (int) $service->price);
        $this->assertEquals(12, $service->estimated_hours);
        $this->assertTrue($service->is_featured);
    }

    public function test_admin_can_toggle_service_status(): void
    {
        $service = Service::where('status', 'active')->first();

        $response = $this->actingAs($this->admin)->patch(route('admin.services.status', $service));
        $response->assertRedirect();

        $service->refresh();
        $this->assertEquals('inactive', $service->status);
        $this->assertFalse($service->is_featured);

        // Toggle back to active
        $response = $this->actingAs($this->admin)->patch(route('admin.services.status', $service));
        $service->refresh();
        $this->assertEquals('active', $service->status);
    }

    public function test_cannot_make_inactive_service_featured(): void
    {
        $inactiveService = Service::create([
            'category_id' => ServiceCategory::first()->id,
            'name' => 'Layanan Nonaktif',
            'price' => 10000,
            'unit' => 'kg',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'inactive',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.services.featured.toggle', $inactiveService));
        $response->assertSessionHas('error');

        $inactiveService->refresh();
        $this->assertFalse($inactiveService->is_featured);
    }

    public function test_admin_can_add_and_remove_service_from_featured_without_deleting_service(): void
    {
        $service = Service::where('status', 'active')->where('is_featured', false)->first();
        $this->assertNotNull($service);

        // Add to featured
        $response = $this->actingAs($this->admin)->post(route('admin.services.featured.add'), [
            'service_id' => $service->id,
            'featured_order' => 99,
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $service->refresh();
        $this->assertTrue($service->is_featured);
        $this->assertEquals(99, $service->featured_order);

        // Remove from featured without deleting data
        $response = $this->actingAs($this->admin)->delete(route('admin.services.featured.remove', $service));
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $service->refresh();
        $this->assertFalse($service->is_featured);
        $this->assertNull($service->featured_order);
        $this->assertDatabaseHas('servies', ['id' => $service->id]);
    }

    public function test_admin_can_reorder_featured_services(): void
    {
        $feat1 = Service::where('is_featured', true)->orderBy('featured_order')->first();
        $feat2 = Service::where('is_featured', true)->where('id', '!=', $feat1->id)->orderBy('featured_order')->first();

        $response = $this->actingAs($this->admin)->post(route('admin.services.featured.reorder'), [
            'orders' => [
                $feat1->id => 10,
                $feat2->id => 20,
            ],
        ]);

        $response->assertRedirect();
        $feat1->refresh();
        $feat2->refresh();

        $this->assertEquals(10, $feat1->featured_order);
        $this->assertEquals(20, $feat2->featured_order);
    }

    public function test_admin_cannot_delete_service_with_order_transactions(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $orderItem = OrderItem::where('item_type', 'service')->first();
        $serviceWithOrder = $orderItem->service;
        $this->assertNotNull($serviceWithOrder);

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $serviceWithOrder));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('servies', ['id' => $serviceWithOrder->id]);
    }

    public function test_admin_can_delete_service_without_order_transactions(): void
    {
        $serviceNew = Service::create([
            'category_id' => ServiceCategory::first()->id,
            'name' => 'Layanan Belum Ada Order',
            'price' => 20000,
            'unit' => 'kg',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $serviceNew));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('servies', ['id' => $serviceNew->id]);
    }

    public function test_homepage_displays_dynamic_featured_services_with_lihat_selengkapnya(): void
    {
        $featuredCount = Service::where('status', 'active')->where('is_featured', true)->count();
        $this->assertGreaterThan(0, $featuredCount);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Lihat Selengkapnya');
        $response->assertSee(route('services'));

        $firstFeatured = Service::where('status', 'active')->where('is_featured', true)->orderBy('featured_order')->first();
        $response->assertSee($firstFeatured->name);
    }
}
