<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'Administrator Washora',
            'email' => 'admin@washora.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        $user1 = User::create([
            'name' => 'Rian Pratama',
            'email' => 'user@washora.com',
            'password' => Hash::make('password'),
            'phone' => '085712345678',
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Anisa Rahmawati',
            'email' => 'anisa@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '087811223344',
            'role' => 'user',
        ]);

        $user3 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '081399887766',
            'role' => 'user',
        ]);

        $user4 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '082155443322',
            'role' => 'user',
        ]);

        // 2. Create Service Categories
        $catKiloan = ServiceCategory::create([
            'name' => 'Cuci Kiloan',
            'description' => 'Layanan laundry pakaian harian hemat per kilogram, bersih, wangi & higienis.',
            'status' => 'active',
        ]);

        $catSatuan = ServiceCategory::create([
            'name' => 'Cuci Satuan & Formal',
            'description' => 'Pakaian formal seperti jas, gaun, kemeja sutra, dan batik dengan penanganan khusus.',
            'status' => 'active',
        ]);

        $catBedding = ServiceCategory::create([
            'name' => 'Bedding, Selimut & Linen',
            'description' => 'Pencucian bedcover tebal, sprei, selimut, dan bantal menggunakan mesin kapasitas besar.',
            'status' => 'active',
        ]);

        $catSepatu = ServiceCategory::create([
            'name' => 'Sepatu, Tas & Aksesoris',
            'description' => 'Deep cleaning sepatu sneakers, kulit, suede, serta tas ransel dan topi.',
            'status' => 'active',
        ]);

        $catBoneka = ServiceCategory::create([
            'name' => 'Boneka & Perlengkapan Bayi',
            'description' => 'Pencucian boneka berbagai ukuran dan stroller dengan detergen hipoalergenik.',
            'status' => 'active',
        ]);

        // 3. Create Services
        $svcKiloanReg = Service::create([
            'category_id' => $catKiloan->id,
            'name' => 'Cuci Komplit + Setrika Wangi (Regular)',
            'description' => 'Cuci bersih, setrika uap rapi, parfum premium, packing rapi. 1 mesin 1 pelanggan.',
            'price' => 8000,
            'unit' => 'kg',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcKiloanExp = Service::create([
            'category_id' => $catKiloan->id,
            'name' => 'Cuci Komplit Express 6 Jam',
            'description' => 'Prioritas pengerjaan kilat selesai hanya dalam 6 jam. Cocok untuk kebutuhan mendesak.',
            'price' => 15000,
            'unit' => 'kg',
            'estimated_hours' => 6,
            'service_type' => 'express',
            'status' => 'active',
        ]);

        $svcKiloanLipat = Service::create([
            'category_id' => $catKiloan->id,
            'name' => 'Cuci Kering Lipat (Non Setrika)',
            'description' => 'Cuci bersih, kering 100%, dilipat rapi dengan parfum segar tanpa disetrika.',
            'price' => 6000,
            'unit' => 'kg',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcBedcoverKing = Service::create([
            'category_id' => $catBedding->id,
            'name' => 'Cuci Bedcover King / Super King',
            'description' => 'Pencucian bedcover ukuran besar bebas tungau dan debu tebal.',
            'price' => 35000,
            'unit' => 'pcs',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcSelimut = Service::create([
            'category_id' => $catBedding->id,
            'name' => 'Cuci Selimut Tebal / Fleece',
            'description' => 'Cuci lembut bahan selimut lembut tanpa merusak serat kain.',
            'price' => 25000,
            'unit' => 'pcs',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcSepatuSneaker = Service::create([
            'category_id' => $catSepatu->id,
            'name' => 'Deep Clean Sneakers & Casual Shoes',
            'description' => 'Pembersihan mendalam upper, midsole, outsole, insole, dan tali sepatu.',
            'price' => 35000,
            'unit' => 'pair',
            'estimated_hours' => 48,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcSepatuLeather = Service::create([
            'category_id' => $catSepatu->id,
            'name' => 'Leather & Suede Premium Care',
            'description' => 'Treatment khusus bahan kulit dan suede dengan kondisioner pelindung.',
            'price' => 50000,
            'unit' => 'pair',
            'estimated_hours' => 48,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcBonekaJumbo = Service::create([
            'category_id' => $catBoneka->id,
            'name' => 'Cuci Boneka Jumbo (> 70 cm)',
            'description' => 'Pencucian boneka besar higienis bebas kuman menggunakan disinfektan aman.',
            'price' => 30000,
            'unit' => 'pcs',
            'estimated_hours' => 48,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        $svcBonekaSedang = Service::create([
            'category_id' => $catBoneka->id,
            'name' => 'Cuci Boneka Sedang / Kecil',
            'description' => 'Cuci boneka ukuran biasa, bulu kembali lembut dan wangi.',
            'price' => 15000,
            'unit' => 'pcs',
            'estimated_hours' => 24,
            'service_type' => 'regular',
            'status' => 'active',
        ]);

        // 4. Create Packages
        $pkgMhs = Package::create([
            'name' => 'Paket Hemat Kiloan 20 Kg',
            'description' => 'Kuota 20 Kg cuci komplit setrika rapi. Berlaku 30 hari, lebih hemat 15%.',
            'price' => 135000,
            'estimated_hours' => 24,
            'status' => 'active',
        ]);
        PackageItem::create(['package_id' => $pkgMhs->id, 'service_id' => $svcKiloanReg->id]);

        $pkgFamily = Package::create([
            'name' => 'Paket Smart Family 50 Kg',
            'description' => 'Kuota 50 Kg cuci komplit setrika keluarga + Gratis antar jemput 3x.',
            'price' => 325000,
            'estimated_hours' => 24,
            'status' => 'active',
        ]);
        PackageItem::create(['package_id' => $pkgFamily->id, 'service_id' => $svcKiloanReg->id]);

        $pkgBedding = Package::create([
            'name' => 'Paket Bedding & Sleep Refresh',
            'description' => 'Termasuk 2 Bedcover King + 2 Selimut Tebal + 4 Sarung Bantal.',
            'price' => 95000,
            'estimated_hours' => 36,
            'status' => 'active',
        ]);
        PackageItem::create(['package_id' => $pkgBedding->id, 'service_id' => $svcBedcoverKing->id]);
        PackageItem::create(['package_id' => $pkgBedding->id, 'service_id' => $svcSelimut->id]);

        $pkgShoes = Package::create([
            'name' => 'Paket 3 Pasang Sepatu Clean & Glow',
            'description' => 'Deep Clean 3 pasang sepatu jenis apa saja + Free Unyellowing Treatment.',
            'price' => 85000,
            'estimated_hours' => 48,
            'status' => 'active',
        ]);
        PackageItem::create(['package_id' => $pkgShoes->id, 'service_id' => $svcSepatuSneaker->id]);

        // 5. Create Sample Orders
        // Order 1: Pending (Baru masuk dari user, belum ditimbang)
        $order1 = Order::create([
            'order_code' => 'WSH-'.date('Ymd').'-001',
            'user_id' => $user1->id,
            'pickup_address' => 'Jl. Mawar No. 14B, Kel. Sukajadi, RT 02/RW 05',
            'customer_note' => 'Tolong jemput sekitar jam 15.00. Pakaian seragam putih mohon dipisah.',
            'total_weight' => null,
            'total_price' => null,
            'estimated_completed_at' => null,
            'status' => 'pending',
            'confirmed_at' => null,
            'confirmed_by' => null,
            'created_at' => Carbon::now()->subHours(2),
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'item_type' => 'service',
            'service_id' => $svcKiloanReg->id,
            'item_name' => $svcKiloanReg->name,
            'unit' => 'kg',
            'quantity' => 1,
            'unit_price' => $svcKiloanReg->price,
            'subtotal' => 0,
            'notes' => 'Belum ditimbang oleh admin',
        ]);

        OrderStatusHistory::create([
            'order_id' => $order1->id,
            'status' => 'pending',
            'note' => 'Pesanan berhasil dibuat oleh pelanggan. Menunggu penjemputan & verifikasi admin.',
            'changed_by' => $user1->id,
            'created_at' => Carbon::now()->subHours(2),
        ]);

        // Order 2: Confirmed
        $order2 = Order::create([
            'order_code' => 'WSH-'.date('Ymd').'-002',
            'user_id' => $user2->id,
            'pickup_address' => 'Apartemen Grand Sudirman Tower B Lantai 12 No 1204',
            'customer_note' => 'Pewangi lavender ya kak.',
            'total_weight' => 5.5,
            'total_price' => 44000,
            'estimated_completed_at' => Carbon::now()->addHours(18),
            'status' => 'confirmed',
            'confirmed_at' => Carbon::now()->subHour(),
            'confirmed_by' => $admin->id,
            'created_at' => Carbon::now()->subHours(3),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'item_type' => 'service',
            'service_id' => $svcKiloanReg->id,
            'item_name' => $svcKiloanReg->name,
            'unit' => 'kg',
            'quantity' => 5.5,
            'unit_price' => 8000,
            'subtotal' => 44000,
            'notes' => 'Berat riil 5.5 kg',
        ]);

        OrderStatusHistory::create([
            'order_id' => $order2->id,
            'status' => 'pending',
            'note' => 'Pesanan dibuat oleh pelanggan.',
            'changed_by' => $user2->id,
            'created_at' => Carbon::now()->subHours(3),
        ]);

        OrderStatusHistory::create([
            'order_id' => $order2->id,
            'status' => 'confirmed',
            'note' => 'Laundry diterima di outlet. Berat: 5.5 Kg. Total biaya: Rp 44.000.',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subHour(),
        ]);

        // Order 3: Washing
        $order3 = Order::create([
            'order_code' => 'WSH-'.date('Ymd').'-003',
            'user_id' => $user1->id,
            'pickup_address' => 'Jl. Anggrek No. 8, Perum Bunga Indah',
            'customer_note' => 'Ada noda saus di kemeja biru.',
            'total_weight' => 4.0,
            'total_price' => 60000,
            'estimated_completed_at' => Carbon::now()->addHours(3),
            'status' => 'washing',
            'confirmed_at' => Carbon::now()->subHours(4),
            'confirmed_by' => $admin->id,
            'created_at' => Carbon::now()->subHours(5),
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'item_type' => 'service',
            'service_id' => $svcKiloanExp->id,
            'item_name' => $svcKiloanExp->name,
            'unit' => 'kg',
            'quantity' => 4.0,
            'unit_price' => 15000,
            'subtotal' => 60000,
            'notes' => 'Layanan Express 6 Jam',
        ]);

        OrderStatusHistory::create([
            'order_id' => $order3->id,
            'status' => 'pending',
            'note' => 'Pesanan dibuat oleh pelanggan.',
            'changed_by' => $user1->id,
            'created_at' => Carbon::now()->subHours(5),
        ]);
        OrderStatusHistory::create([
            'order_id' => $order3->id,
            'status' => 'confirmed',
            'note' => 'Laundry ditimbang 4.0 Kg (Express).',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subHours(4),
        ]);
        OrderStatusHistory::create([
            'order_id' => $order3->id,
            'status' => 'washing',
            'note' => 'Pakaian sedang dicuci menggunakan mesin pembersih ozon dan detergen anti noda.',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subHours(1),
        ]);

        // Order 4: Ready for pickup
        $order4 = Order::create([
            'order_code' => 'WSH-'.date('Ymd', strtotime('-1 day')).'-012',
            'user_id' => $user3->id,
            'pickup_address' => 'Jl. Diponegoro No. 45',
            'customer_note' => 'Sepatu putih Nike Air Force 1 & Adidas Ultraboost.',
            'total_weight' => 2.0,
            'total_price' => 70000,
            'estimated_completed_at' => Carbon::now()->subHours(2),
            'status' => 'ready',
            'confirmed_at' => Carbon::now()->subDays(2),
            'confirmed_by' => $admin->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'item_type' => 'service',
            'service_id' => $svcSepatuSneaker->id,
            'item_name' => $svcSepatuSneaker->name,
            'unit' => 'pair',
            'quantity' => 2,
            'unit_price' => 35000,
            'subtotal' => 70000,
            'notes' => '2 pasang sneakers deep clean',
        ]);

        OrderStatusHistory::create([
            'order_id' => $order4->id,
            'status' => 'pending',
            'note' => 'Pesanan dibuat.',
            'changed_by' => $user3->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);
        OrderStatusHistory::create([
            'order_id' => $order4->id,
            'status' => 'confirmed',
            'note' => 'Dikonfirmasi 2 pasang sepatu.',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);
        OrderStatusHistory::create([
            'order_id' => $order4->id,
            'status' => 'ready',
            'note' => 'Sepatu selesai dikeringkan dan dipacking box khusus. Siap diambil / diantar.',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subHours(2),
        ]);

        // Order 5: Completed
        $order5 = Order::create([
            'order_code' => 'WSH-'.date('Ymd', strtotime('-3 days')).'-008',
            'user_id' => $user1->id,
            'pickup_address' => 'Jl. Mawar No. 14B, Kel. Sukajadi',
            'customer_note' => 'Bedcover motif floral.',
            'total_weight' => 1.0,
            'total_price' => 35000,
            'estimated_completed_at' => Carbon::now()->subDays(2),
            'status' => 'completed',
            'confirmed_at' => Carbon::now()->subDays(3),
            'confirmed_by' => $admin->id,
            'created_at' => Carbon::now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'item_type' => 'service',
            'service_id' => $svcBedcoverKing->id,
            'item_name' => $svcBedcoverKing->name,
            'unit' => 'pcs',
            'quantity' => 1,
            'unit_price' => 35000,
            'subtotal' => 35000,
            'notes' => 'Bedcover King 1 pcs',
        ]);

        OrderStatusHistory::create([
            'order_id' => $order5->id,
            'status' => 'completed',
            'note' => 'Pesanan telah diterima oleh pelanggan. Transaksi selesai.',
            'changed_by' => $admin->id,
            'created_at' => Carbon::now()->subDays(2),
        ]);
    }
}
