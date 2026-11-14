<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_customer_can_login_and_access_dashboard(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->post('/user/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('user.dashboard'));

        $dashboardResponse = $this->actingAs($user)->get('/user/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee($user->name);
    }

    public function test_customer_can_create_pending_order_without_weight(): void
    {
        $user = User::where('role', 'user')->first();
        $service = Service::first();

        $response = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'service',
            'service_id' => $service->id,
            'recipient_name' => $user->name,
            'whatsapp_number' => '081234567890',
            'pickup_address' => 'Jl. Kebon Jeruk No. 15, RT 01/RW 03',
            'customer_note' => 'Pisahkan baju berwarna putih',
        ]);

        $order = Order::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->status);
        $this->assertNull($order->total_weight); // User does NOT input weight
        $this->assertNull($order->total_price); // Admin verifies weight & confirms total price

        $response->assertRedirect(route('user.orders.success', $order));

        $successResponse = $this->actingAs($user)->get(route('user.orders.success', $order));
        $successResponse->assertStatus(200);
        $successResponse->assertSee('Pesanan Berhasil Dikirim');
        $successResponse->assertSee($order->order_code);
    }

    public function test_order_create_page_displays_three_steps_indicator(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->get(route('user.orders.create'));
        $response->assertStatus(200);
        $response->assertSee('Pilih Layanan');
        $response->assertSee('Isi Data Diri');
        $response->assertSee('Konfirmasi');
        $response->assertSee('Paket Bundling');
        $response->assertSee('Layanan Satuan');
        $response->assertSee('Layanan Kiloan');
    }

    public function test_customer_can_submit_review_for_completed_order(): void
    {
        $user = User::where('role', 'user')->first();
        $order = Order::where('user_id', $user->id)->first();
        $order->update(['status' => 'completed']);

        $response = $this->actingAs($user)->post(route('user.orders.review', $order), [
            'rating' => 5,
            'comment' => 'Pakaian sangat wangi dan rapi luar biasa!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'user_id' => $user->id,
            'rating' => 5,
            'is_published' => false, // Requires admin approval
        ]);
    }

    public function test_customer_cannot_review_pending_order(): void
    {
        $user = User::where('role', 'user')->first();
        $order = Order::where('user_id', $user->id)->first();
        $order->update(['status' => 'pending']);

        $response = $this->actingAs($user)->post(route('user.orders.review', $order), [
            'rating' => 5,
            'comment' => 'Mencoba review sebelum selesai.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_customer_cannot_submit_duplicate_review(): void
    {
        $user = User::where('role', 'user')->first();
        $order = Order::where('user_id', $user->id)->first();
        $order->update(['status' => 'completed']);

        // First review
        Review::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'customer_name' => $user->name,
            'rating' => 4,
            'comment' => 'Review pertama.',
            'is_published' => false,
        ]);

        // Second review attempt
        $response = $this->actingAs($user)->post(route('user.orders.review', $order), [
            'rating' => 5,
            'comment' => 'Review kedua yang harusnya ditolak.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_unauthorized_user_cannot_view_another_order_success_page(): void
    {
        $user1 = User::where('role', 'user')->first();
        $user2 = User::where('role', 'user')->skip(1)->first();
        $order = Order::where('user_id', $user1->id)->first();

        $response = $this->actingAs($user2)->get(route('user.orders.success', $order));
        $response->assertStatus(403);
    }
}
