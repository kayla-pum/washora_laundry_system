<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
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

    public function test_customer_can_login_with_remember_me(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->post('/user/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($user);
        $user->refresh();
        $this->assertNotNull($user->getRememberToken());
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
            'has_valuable_items' => '1',
            'has_color_bleeding_risk' => '0',
            'customer_note' => 'Pisahkan baju berwarna putih',
        ]);

        $order = Order::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->status);
        $this->assertNull($order->total_weight); // User does NOT input weight
        $this->assertNull($order->total_price); // Admin verifies weight & confirms total price
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'has_valuable_items' => 1,
            'has_color_bleeding_risk' => 0,
            'customer_note' => 'Pisahkan baju berwarna putih',
        ]);

        $response->assertRedirect(route('user.orders.success', $order));

        $successResponse = $this->actingAs($user)->get(route('user.orders.success', $order));
        $successResponse->assertStatus(200);
        $successResponse->assertSee('Pesanan Berhasil Dikirim');
        $successResponse->assertSee($order->order_code);

        $admin = User::where('role', 'admin')->first();
        $adminResponse = $this->actingAs($admin)->get(route('admin.orders.show', $order));
        $adminResponse->assertStatus(200);
        $adminResponse->assertSeeInOrder([
            'Barang berharga:',
            'Ya',
            'Bahan atau warna mudah luntur:',
            'Tidak',
            'Catatan tambahan:',
            'Pisahkan baju berwarna putih',
        ]);
    }

    public function test_customer_must_answer_additional_care_questions_and_note_is_optional(): void
    {
        $user = User::where('role', 'user')->first();
        $service = Service::first();
        $orderCount = Order::count();

        $missingAnswersResponse = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'service',
            'service_id' => $service->id,
            'recipient_name' => $user->name,
            'whatsapp_number' => '081234567890',
            'pickup_address' => 'Jl. Kebon Jeruk No. 15, RT 01/RW 03',
        ]);

        $missingAnswersResponse->assertSessionHasErrors([
            'has_valuable_items',
            'has_color_bleeding_risk',
        ]);
        $this->assertSame($orderCount, Order::count());

        $validResponse = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'service',
            'service_id' => $service->id,
            'recipient_name' => $user->name,
            'whatsapp_number' => '081234567890',
            'pickup_address' => 'Jl. Kebon Jeruk No. 15, RT 01/RW 03',
            'has_valuable_items' => '0',
            'has_color_bleeding_risk' => '1',
        ]);

        $order = Order::where('user_id', $user->id)->latest()->first();
        $validResponse->assertRedirect(route('user.orders.success', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'has_valuable_items' => 0,
            'has_color_bleeding_risk' => 1,
            'customer_note' => null,
        ]);

        $admin = User::where('role', 'admin')->first();
        $adminResponse = $this->actingAs($admin)->get(route('admin.orders.show', $order));
        $adminResponse->assertSee('<p class="text-amber-900 italic">-</p>', false);
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
        $response->assertSee('Apakah terdapat barang berharga?');
        $response->assertSee('Apakah terdapat bahan atau warna yang mudah luntur?');
        $response->assertSee('Pilih jawaban');
        $response->assertSee('Tuliskan catatan atau instruksi khusus untuk pesanan Anda...');
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
            'is_published' => true, // Directly published to homepage without admin approval
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

    public function test_order_creation_rejects_alphabetic_and_invalid_phone_number(): void
    {
        $user = User::where('role', 'user')->first();
        $service = Service::first();

        // Attempt order creation with alphabetic phone number
        $response = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'service',
            'service_id' => $service->id,
            'recipient_name' => $user->name,
            'whatsapp_number' => '0812abcdEFGH',
            'pickup_address' => 'Jl. Mawar No. 12',
        ]);

        $response->assertSessionHasErrors(['whatsapp_number']);

        // Attempt order creation with phone number containing symbols
        $responseSymbols = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'service',
            'service_id' => $service->id,
            'recipient_name' => $user->name,
            'whatsapp_number' => '+62-812-3456-7890',
            'pickup_address' => 'Jl. Mawar No. 12',
        ]);

        $responseSymbols->assertSessionHasErrors(['whatsapp_number']);
    }

    public function test_order_success_page_displays_direct_payment_information(): void
    {
        $user = User::where('role', 'user')->first();
        $order = Order::where('user_id', $user->id)->first();

        $response = $this->actingAs($user)->get(route('user.orders.success', $order));
        $response->assertStatus(200);
        $response->assertSee('Pembayaran dilakukan secara langsung melalui admin setelah pesanan diperiksa dan harga akhir ditentukan.');
        $response->assertSee('Admin akan menghubungi Anda melalui WhatsApp untuk memberikan informasi lebih lanjut mengenai total biaya dan metode pembayaran.');
    }

    public function test_customer_can_submit_review_from_dashboard_and_appears_immediately_on_homepage(): void
    {
        $user = User::where('role', 'user')->first();
        $uniqueComment = 'Pelayanan super cepat dan wangi tahan lama '.uniqid();

        $response = $this->actingAs($user)->post(route('user.reviews.store'), [
            'rating' => 5,
            'comment' => $uniqueComment,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'rating' => 5,
            'comment' => $uniqueComment,
            'is_published' => true,
        ]);

        // Review must appear on the homepage immediately without admin approval
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee($uniqueComment);
        $homeResponse->assertSee($user->name);
    }

    public function test_footer_displays_official_whatsapp_number_and_instagram_link(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('https://wa.me/6288906296474', false);
        $response->assertSee('https://www.instagram.com/space.kays/', false);
        $response->assertSee('0889-0629-6474');
    }

    public function test_customer_can_order_satuan_with_piece_quantity_and_admin_sees_it(): void
    {
        $user = User::where('role', 'user')->first();
        $satuanService = Service::where('unit', 'pcs')->first();
        $this->assertNotNull($satuanService);

        // 1. Customer places a satuan order with 4 pcs
        $response = $this->actingAs($user)->post('/user/orders', [
            'item_type' => 'satuan',
            'service_id' => $satuanService->id,
            'piece_quantity' => 4,
            'recipient_name' => $user->name,
            'whatsapp_number' => '081234567890',
            'pickup_address' => 'Jl. Kebon Jeruk No. 15, RT 01/RW 03',
            'has_valuable_items' => '0',
            'has_color_bleeding_risk' => '0',
            'customer_note' => '4 pcs bedcover harap dipisah',
        ]);

        $order = Order::where('user_id', $user->id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->status);

        $orderItem = $order->items->first();
        $this->assertNotNull($orderItem);
        $this->assertEquals(4, (int) $orderItem->quantity);
        $this->assertEquals(4 * $satuanService->price, (float) $orderItem->subtotal);

        $response->assertRedirect(route('user.orders.success', $order));

        // 2. Customer sees pcs quantity in order success and detail page
        $successResponse = $this->actingAs($user)->get(route('user.orders.success', $order));
        $successResponse->assertStatus(200);
        $successResponse->assertSee('4 pcs');

        $userOrderResponse = $this->actingAs($user)->get(route('user.orders.show', $order));
        $userOrderResponse->assertStatus(200);
        $userOrderResponse->assertSee('4 pcs');

        // 3. Admin sees the customer quantity in order details & order index
        $admin = User::where('role', 'admin')->first();
        $adminShowResponse = $this->actingAs($admin)->get(route('admin.orders.show', $order));
        $adminShowResponse->assertStatus(200);
        $adminShowResponse->assertSee('Banyaknya Pesanan Pelanggan:');
        $adminShowResponse->assertSee('4 pcs');
        $adminShowResponse->assertSee('Banyaknya Pesanan (Satuan):');

        $adminIndexResponse = $this->actingAs($admin)->get(route('admin.orders.index'));
        $adminIndexResponse->assertStatus(200);
        $adminIndexResponse->assertSee('4 pcs');

        // 4. Admin confirms the order with the verified quantity
        $confirmResponse = $this->actingAs($admin)->post('/admin/orders/'.$order->id.'/confirm', [
            'item_quantities' => [
                $orderItem->id => 4,
            ],
            'item_prices' => [
                $orderItem->id => $satuanService->price,
            ],
            'estimated_completed_at' => Carbon::now()->addHours(24)->format('Y-m-d H:i:s'),
            'admin_note' => 'Jumlah barang sesuai 4 pcs.',
        ]);

        $confirmResponse->assertRedirect();
        $order->refresh();
        $this->assertEquals('confirmed', $order->status);
        $this->assertEquals(4 * $satuanService->price, (float) $order->total_price);
    }
}
