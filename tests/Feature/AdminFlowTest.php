<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_admin_can_login_and_access_admin_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->post(route('user.login.submit'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $dashboard = $this->actingAs($admin)->get('/admin/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Dashboard Administrator');
    }

    public function test_admin_login_url_displays_the_unified_login_form(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk()
            ->assertSee('Selamat Datang Kembali')
            ->assertSee('Masuk untuk mengelola dan memantau layanan laundry Anda.')
            ->assertSee('Alamat Email')
            ->assertSee('Kata Sandi')
            ->assertSee('Ingat saya')
            ->assertSee('action="'.route('user.login.submit').'"', false)
            ->assertDontSee('Portal Masuk Pelanggan')
            ->assertDontSee('Administrator / Petugas Laundry')
            ->assertDontSee('Masuk ke Portal Administrator');
    }

    public function test_users_cannot_access_the_other_role_dashboard(): void
    {
        $user = User::where('role', 'user')->first();
        $admin = User::where('role', 'admin')->first();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('user.dashboard'));

        $this->actingAs($admin)
            ->get(route('user.dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_guests_receive_a_generic_message_for_protected_dashboards(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'))
            ->assertSessionHas('warning', 'Silakan masuk terlebih dahulu untuk melanjutkan.');

        $this->get(route('user.dashboard'))
            ->assertRedirect(route('user.login'))
            ->assertSessionHas('warning', 'Silakan masuk terlebih dahulu untuk melanjutkan.');
    }

    public function test_admin_can_verify_weight_and_confirm_order(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pendingOrder = Order::where('status', 'pending')->first();

        $response = $this->actingAs($admin)->post('/admin/orders/'.$pendingOrder->id.'/confirm', [
            'total_weight' => 5.0,
            'estimated_completed_at' => Carbon::now()->addHours(24)->format('Y-m-d H:i:s'),
            'admin_note' => 'Berat terverifikasi di outlet 5.0 kg.',
        ]);

        $pendingOrder->refresh();
        $this->assertEquals('confirmed', $pendingOrder->status);
        $this->assertEquals($admin->id, $pendingOrder->confirmed_by);
        $this->assertNotNull($pendingOrder->total_price);
    }
}
