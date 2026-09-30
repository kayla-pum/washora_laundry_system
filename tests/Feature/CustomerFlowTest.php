<?php

namespace Tests\Feature;

use App\Models\Order;
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

        $response->assertRedirect(route('user.orders.show', $order));
    }
}
