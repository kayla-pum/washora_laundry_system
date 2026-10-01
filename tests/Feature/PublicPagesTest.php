<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_landing_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Washora');
        $response->assertSee('Layanan');
        $response->assertSee('Paket Hemat');
        $response->assertSee('Cara Kerja');
    }

    public function test_services_catalog_page_loads_successfully(): void
    {
        $response = $this->get('/layanan');

        $response->assertStatus(200);
        $response->assertSee('Katalog Resmi');
    }

    public function test_tracking_page_finds_valid_order(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $response = $this->get('/tracking?code='.$order->order_code);
        $response->assertStatus(200);
        $response->assertSee($order->order_code);
    }
}
