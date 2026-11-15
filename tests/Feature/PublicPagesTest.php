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

    public function test_terms_and_conditions_page_loads_successfully_without_auth(): void
    {
        $response = $this->get('/syarat-ketentuan');

        $response->assertStatus(200);
        $response->assertSee('Syarat & Ketentuan Layanan Washora', false);
        $response->assertSee('Waktu Pengerjaan Layanan', false);
        $response->assertSee('Kondisi Barang Sebelum Proses Pencucian', false);
        $response->assertSee('Ketentuan Khusus Layanan Kiloan & Satuan', false);
        $response->assertSee('Barang yang Tidak Dapat Diterima', false);
        $response->assertSee('Tanggung Jawab Terhadap Barang', false);
        $response->assertSee('Ketentuan Pengajuan Komplain', false);
        $response->assertSee('Kebijakan Ganti Rugi Kerusakan atau Kehilangan', false);
        $response->assertSee('Barang yang Tidak Diambil', false);
        $response->assertSee('Kembali ke Beranda', false);
    }

    public function test_footer_contains_terms_route_and_menu_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('terms'));
        $response->assertSee(route('home'));
        $response->assertSee(route('services'));
        $response->assertSee(route('tracking'));
        $response->assertSee('Syarat & Ketentuan', false);
        $response->assertSee('Cek Resi & Status Laundry', false);
    }

    public function test_keunggulan_section_displays_five_core_benefits(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Pelayanan Praktis Tanpa Timbang', false);
        $response->assertSee('Pilihan Fleksibel Reguler & Express', false);
        $response->assertSee('Pakaian Terorganisir & Higienis', false);
        $response->assertSee('Informasi Status Pesanan Realtime', false);
        $response->assertSee('Layanan Antar-Jemput Mudah', false);
    }
}
