<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Review;
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
        $response->assertSee('Keunggulan');
        $response->assertSee('Layanan');
        $response->assertSee('Cara Kerja');
        $response->assertSee('Testimoni');
        $response->assertSee('Pesan Sekarang');
        $response->assertSee(route('user.orders.create'));
        $response->assertDontSee('href="http://localhost#paket"', false);
    }

    public function test_services_catalog_page_loads_successfully(): void
    {
        $response = $this->get('/layanan');

        $response->assertStatus(200);
        $response->assertSee('Katalog Resmi');
    }

    public function test_landing_page_has_correct_section_order(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();

        $posHero = strpos($html, 'id="beranda"');
        $posKeunggulan = strpos($html, 'id="keunggulan"');
        $posLayanan = strpos($html, 'id="layanan"');
        $posCaraKerja = strpos($html, 'id="cara-kerja"');
        $posTestimoni = strpos($html, 'id="testimoni"');

        $this->assertNotFalse($posHero, 'Hero section #beranda must exist');
        $this->assertNotFalse($posKeunggulan, 'Keunggulan section #keunggulan must exist');
        $this->assertNotFalse($posLayanan, 'Layanan section #layanan must exist');
        $this->assertNotFalse($posCaraKerja, 'Cara Kerja section #cara-kerja must exist');
        $this->assertNotFalse($posTestimoni, 'Testimoni section #testimoni must exist');

        $this->assertTrue($posHero < $posKeunggulan, 'Hero must be before Keunggulan');
        $this->assertTrue($posKeunggulan < $posLayanan, 'Keunggulan must be before Layanan');
        $this->assertTrue($posLayanan < $posCaraKerja, 'Layanan must be before Cara Kerja');
        $this->assertTrue($posCaraKerja < $posTestimoni, 'Cara Kerja must be before Testimoni');
    }

    public function test_landing_page_displays_real_testimonials_when_available(): void
    {
        Review::create([
            'customer_name' => 'Siti Nurhaliza',
            'rating' => 5,
            'comment' => 'Pelayanan express sangat cepat dan wangi tahan lama!',
            'is_published' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('Pelayanan express sangat cepat');
    }

    public function test_tracking_page_finds_valid_order(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $response = $this->get('/tracking?code='.$order->order_code);
        $response->assertStatus(200);
        $response->assertSee($order->order_code);
    }

    public function test_tracking_protects_customer_privacy_for_guests(): void
    {
        $order = Order::first();
        $this->assertNotNull($order);

        $response = $this->get('/tracking?code='.$order->order_code);
        $response->assertStatus(200);
        $response->assertSee('Disamarkan demi privasi data pelanggan');
        $response->assertDontSee($order->pickup_address);
    }

    public function test_tracking_shows_not_found_message_for_invalid_code(): void
    {
        $response = $this->get('/tracking?code=WSH-99999999-999');
        $response->assertStatus(200);
        $response->assertSee('Pesanan Tidak Ditemukan');
    }
}
