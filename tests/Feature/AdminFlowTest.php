<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Review;
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

    public function test_login_urls_display_the_unified_login_form(): void
    {
        foreach ([route('user.login'), route('admin.login')] as $loginRoute) {
            $response = $this->get($loginRoute);

            $response->assertOk()
                ->assertSee('Selamat Datang Kembali')
                ->assertSee('Masuk untuk mengelola dan memantau layanan laundry Anda.')
                ->assertSee('Alamat Email')
                ->assertSee('Kata Sandi')
                ->assertSee('Ingat saya')
                ->assertSee('Masuk')
                ->assertSee('action="'.route('user.login.submit').'"', false)
                ->assertDontSee('Portal Masuk Pelanggan')
                ->assertDontSee('Administrator / Petugas Laundry')
                ->assertDontSee('Masuk ke Portal Administrator');
        }
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

    public function test_guests_are_redirected_to_the_unified_login_form(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('user.login'));

        $this->get(route('user.dashboard'))
            ->assertRedirect(route('user.login'));
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

    public function test_admin_can_download_report_pdf(): void
    {
        $admin = User::where('role', 'admin')->first();

        foreach (['today', '7days', '1month', '3months', '7months', '1year'] as $period) {
            $response = $this->actingAs($admin)->get(route('admin.reports.pdf', ['period' => $period]));
            $response->assertStatus(200);
            $response->assertHeader('content-type', 'application/pdf');
        }
    }

    public function test_admin_can_export_transactions_pdf(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.transactions.export', ['period' => '7months']));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_moderate_customer_reviews(): void
    {
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        $review = Review::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'rating' => 5,
            'comment' => 'Pelayanan cuci cepat dan sangat bersih!',
            'is_published' => false,
        ]);

        // View reviews index
        $indexResponse = $this->actingAs($admin)->get(route('admin.reviews.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($review->customer_name);

        // Toggle approve
        $toggleResponse = $this->actingAs($admin)->patch(route('admin.reviews.toggle', $review));
        $toggleResponse->assertRedirect();
        $review->refresh();
        $this->assertTrue($review->is_published);

        // Delete review
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.reviews.destroy', $review));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
