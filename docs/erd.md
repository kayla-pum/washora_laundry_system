# ERD Washora

Diagram ini dirangkum dari migration pada `database/migrations/` dan relasi Eloquent pada `app/Models/`. Nama tabel dan kolom mempertahankan nama yang digunakan proyek; termasuk `servies`.

## Tabel utama aplikasi

```mermaid
erDiagram
    USERS o|--o{ ORDERS : pelanggan
    USERS o|--o{ ORDERS : mengonfirmasi
    USERS o|--o{ ORDER_STATUS_HISTORIES : mengubah
    USERS o|--o{ REVIEWS : menulis
    SERVICE_CATEGORIES ||--o{ SERVIES : mengelompokkan
    PACKAGES ||--o{ PACKAGE_ITEMS : berisi
    SERVIES ||--o{ PACKAGE_ITEMS : dicantumkan
    ORDERS ||--o{ ORDER_ITEMS : memiliki
    SERVIES o|--o{ ORDER_ITEMS : dipilih
    PACKAGES o|--o{ ORDER_ITEMS : dipesan
    ORDERS ||--o{ ORDER_STATUS_HISTORIES : mencatat
    ORDERS o|--o{ REVIEWS : diulas

    USERS {
        int id PK
        string name
        string email UK
        string password
        string phone
        enum role
        string remember_token
        timestamp created_at
        timestamp updated_at
    }
    SERVICE_CATEGORIES {
        int id PK
        string name
        text description
        enum status
        timestamp created_at
        timestamp updated_at
    }
    SERVIES {
        int id PK
        int category_id FK
        string name
        text description
        decimal price
        enum unit
        int estimated_hours
        enum service_type
        enum status
        boolean is_featured
        int featured_order
        timestamp created_at
        timestamp updated_at
    }
    PACKAGES {
        int id PK
        string name
        text description
        decimal price
        int estimated_hours
        enum status
        timestamp created_at
        timestamp updated_at
    }
    PACKAGE_ITEMS {
        int id PK
        int package_id FK
        int service_id FK
        timestamp created_at
        timestamp updated_at
    }
    ORDERS {
        int id PK
        string order_code UK
        int user_id FK
        string customer_name
        string customer_phone
        text pickup_address
        boolean has_valuable_items
        boolean has_color_bleeding_risk
        text customer_note
        decimal total_weight
        decimal total_price
        datetime estimated_completed_at
        enum status
        datetime confirmed_at
        int confirmed_by FK
        timestamp created_at
        timestamp updated_at
    }
    ORDER_ITEMS {
        int id PK
        int order_id FK
        enum item_type
        int service_id FK
        int package_id FK
        string item_name
        string unit
        decimal quantity
        decimal unit_price
        decimal subtotal
        text notes
        timestamp created_at
        timestamp updated_at
    }
    ORDER_STATUS_HISTORIES {
        int id PK
        int order_id FK
        string status
        text note
        int changed_by FK
        timestamp created_at
    }
    REVIEWS {
        int id PK
        int user_id FK
        int order_id FK
        string customer_name
        tinyint rating
        text comment
        boolean is_published
        timestamp created_at
        timestamp updated_at
    }
```

### Fungsi dan hubungan

| Tabel | Fungsi dan keterkaitan |
|---|---|
| `users` | Menyimpan akun pelanggan dan administrator, dibedakan oleh `role`. Menjadi referensi pemesan, pengonfirmasi, penulis ulasan, dan pencatat perubahan status. |
| `service_categories` | Kategori katalog. Satu kategori memiliki banyak baris `servies`. |
| `servies` | Katalog layanan dengan satuan `kg`, `pcs`, atau `pair`; jenis layanan `regular` atau `express`; dan atribut sorotan. Nama tabel ini memang ditulis `servies` di migration. |
| `packages` | Paket laundry yang dapat dipesan. |
| `package_items` | Tabel penghubung paket dengan layanan; kedua FK membentuk relasi many-to-many antara `packages` dan `servies`. |
| `orders` | Data utama pesanan, kode unik, informasi penjemputan, nilai akhir, estimasi, status, serta akun yang membuat/mengonfirmasi pesanan. |
| `order_items` | Rincian layanan atau paket pada pesanan, termasuk nama snapshot, jumlah, harga, subtotal, dan catatan. |
| `order_status_histories` | Catatan perubahan status pesanan beserta pengguna yang mencatatnya dan waktu perubahan. |
| `reviews` | Ulasan pelanggan dan status publikasinya; ulasan dapat terkait ke akun dan/atau pesanan. |

Tipe yang dipersingkat pada diagram mengikuti definisi migration: `id` menggunakan integer auto-increment; harga dan subtotal memakai `decimal(12,2)`, berat/jumlah memakai `decimal(8,2)`, rating memakai `unsignedTinyInteger`, dan kolom teks/panjang mengikuti definisi masing-masing migration. `users.email` dan `orders.order_code` unik. Kolom yang ditambahkan sebagai nullable atau memiliki default: `users.phone`; `servies.description`, `featured_order`; `packages.description`; `orders.user_id`, `customer_name`, `customer_phone`, `customer_note`, `total_weight`, `total_price`, `estimated_completed_at`, `confirmed_at`, `confirmed_by`, `has_valuable_items`, `has_color_bleeding_risk`; `order_items.service_id`, `package_id`, `notes`; `order_status_histories.changed_by`; dan `reviews.user_id`, `order_id`. Kolom deskripsi kategori juga nullable.

FK `orders.user_id`, `orders.confirmed_by`, `order_status_histories.changed_by`, dan FK pada `reviews` bersifat nullable. Form pemesanan yang aktif tetap berada di route pelanggan dengan middleware `auth` dan `customer`. `orders.customer_name` dan `orders.customer_phone` tersedia pada skema, tetapi proses pemesanan saat ini tidak mengisi kedua kolom tersebut. Relasi `Order::review()` didefinisikan `hasOne`, sementara migration tidak memberi constraint unik pada `reviews.order_id`; alur kirim ulasan pelanggan memeriksa ulasan yang sudah ada, tetapi keunikan tidak dijamin oleh database.

## Tabel pendukung Laravel

Tabel berikut berasal dari migration framework dan tidak memiliki relasi FK yang didefinisikan di migration proyek:

| Tabel | Kunci dan kolom utama | Kegunaan |
|---|---|---|
| `password_reset_tokens` | `email` (PK), `token`, `created_at` | Penyimpanan token reset kata sandi Laravel. |
| `sessions` | `id` (PK), `user_id` (nullable, indexed), `ip_address`, `user_agent`, `payload`, `last_activity` | Penyimpanan sesi. `user_id` bukan FK dalam migration ini. |
| `cache` | `key` (PK), `value`, `expiration` | Cache berbasis database. |
| `cache_locks` | `key` (PK), `owner`, `expiration` | Lock untuk cache database. |
| `jobs` | `id` (PK), `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at` | Antrean pekerjaan database. |
| `job_batches` | `id` (PK), `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at` | Metadata batch antrean. |
| `failed_jobs` | `id` (PK), `uuid` (unik), `connection`, `queue`, `payload`, `exception`, `failed_at` | Pekerjaan antrean yang gagal. |

Laravel juga membuat tabel `migrations` untuk mencatat migration yang sudah dijalankan saat `php artisan migrate`; tabel tersebut bukan dibuat oleh file migration aplikasi di repository ini. File `.env.example` memilih MySQL, serta driver database untuk session, cache, dan queue.
