<p align="center">
  <img src="public/images/washoralogo.png" alt="Logo Washora" width="100">
</p>

<h1 align="center">Washora — Sistem Informasi Laundry</h1>

<p align="center">Aplikasi berbasis website untuk pemesanan dan pengelolaan layanan laundry.</p>

<p align="center">
  <a href="https://washora-laundry-system.wasmer.app">Website demo</a>
  ·
  <a href="https://github.com/kayla-pum/washora_laundry_system">Repository</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/Laravel-13.17%2B-FF2D20?logo=laravel&logoColor=white" alt="Laravel 13.17+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.x-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Vite-8.x-646CFF?logo=vite&logoColor=white" alt="Vite 8">
</p>

## Tentang Washora

Washora adalah website untuk memesan layanan laundry dan memantau progres pesanan, sementara administrator mengelola katalog, pesanan, transaksi, dan laporan. Sistem ini dibuat untuk membantu proses laundry yang sebelumnya dilakukan secara manual menjadi lebih teratur, mudah dipantau, dan memiliki catatan pesanan.

## Fitur Utama

### Pelanggan

- Registrasi akun dan login.
- Melihat kategori, layanan, paket, dan layanan unggulan yang aktif.
- Memesan layanan kiloan, satuan (buah atau pasang), atau paket; pilihan reguler dan express mengikuti layanan yang tersedia.
- Mengisi alamat penjemputan, nomor telepon/WhatsApp, informasi barang, dan catatan pesanan.
- Melihat riwayat, rincian, status, dan biaya pesanan.
- Melacak pesanan menggunakan kode pesanan tanpa harus login.
- Mengirim ulasan dan testimoni. Ulasan yang dikirim langsung dipublikasikan; administrator dapat menyembunyikan atau menghapusnya.

### Administrator

- Melihat ringkasan operasional pada dashboard.
- Melihat data pelanggan dan riwayat pesanan.
- Mengelola kategori, layanan, paket, serta layanan unggulan dan urutannya.
- Memeriksa dan mengonfirmasi pesanan dengan memperbarui berat/jumlah, harga, dan estimasi selesai.
- Memperbarui status pesanan; perubahan dicatat dalam riwayat status.
- Melihat transaksi, mencetak invoice, dan melihat rekapitulasi laporan.
- Mencetak laporan atau mengunduh laporan transaksi dalam format PDF.
- Meninjau, menyembunyikan, dan menghapus testimoni.

## Tampilan Website

Gambar berikut merupakan dokumentasi antarmuka yang tersedia di `public/images/`.

### Pelanggan

<table>
  <tr>
    <td align="center"><img src="public/images/login.png" alt="Halaman login Washora" width="260"><br>Login</td>
    <td align="center"><img src="public/images/DashboardUser.png" alt="Dashboard pelanggan" width="420"><br>Dashboard pelanggan</td>
  </tr>
  <tr>
    <td align="center"><img src="public/images/Pemesanan1User.png" alt="Form pemesanan tahap pilih layanan" width="300"><br>Pilih layanan</td>
    <td align="center"><img src="public/images/Pemesanan2User.png" alt="Form pemesanan tahap data diri" width="300"><br>Data pemesanan</td>
  </tr>
  <tr>
    <td align="center"><img src="public/images/pemesanan3User.png" alt="Form pemesanan tahap konfirmasi" width="300"><br>Konfirmasi pesanan</td>
    <td align="center"><img src="public/images/Riwayatpesanan.png" alt="Riwayat pesanan pelanggan" width="420"><br>Riwayat pesanan</td>
  </tr>
</table>

### Administrator

<table>
  <tr>
    <td align="center"><img src="public/images/DashboardAdmin.png" alt="Dashboard administrator" width="420"><br>Dashboard</td>
    <td align="center"><img src="public/images/Data%20PesananAdmin.png" alt="Pengelolaan pesanan administrator" width="420"><br>Pengelolaan pesanan</td>
  </tr>
  <tr>
    <td align="center"><img src="public/images/DaftarLayananAdmin.png" alt="Pengelolaan layanan administrator" width="420"><br>Pengelolaan layanan</td>
    <td align="center"><img src="public/images/RekapppdfAdmin.png" alt="Rekapitulasi laporan administrator" width="420"><br>Rekapitulasi laporan</td>
  </tr>
</table>

## Teknologi yang Digunakan

Versi di bawah mengikuti batasan versi pada manifest proyek. Dependency frontend tidak dikunci dalam `package-lock.json`.

| Teknologi | Versi pada proyek | Kegunaan |
|---|---|---|
| PHP | `^8.3` | Bahasa pemrograman sisi server |
| Laravel | `^13.17` | Framework aplikasi web |
| MySQL | Driver `mysql` pada konfigurasi contoh | Basis data; konfigurasi Laravel juga menyediakan driver MariaDB dan SQLite |
| Composer | Tidak ditentukan di manifest | Mengelola dependency PHP |
| Node.js dan npm | Tidak dipatok di manifest | Mengelola dependency dan membangun aset frontend |
| Vite | `^8.0` | Server pengembangan dan bundler aset frontend |
| Tailwind CSS | `^4.0` | Styling antarmuka |
| Laravel DomPDF | `^3.1` | Membuat dokumen laporan PDF |

## Persyaratan Sistem

- PHP 8.3 atau lebih baru beserta ekstensi PHP yang dibutuhkan Laravel dan driver database yang dipilih (misalnya `pdo_mysql` untuk MySQL).
- Composer.
- MySQL atau MariaDB yang dapat diakses aplikasi; konfigurasi contoh menggunakan MySQL pada port `3306`. SQLite juga tersedia sebagai driver dalam konfigurasi Laravel.
- Node.js dan npm yang kompatibel dengan Vite 8, hanya diperlukan untuk memasang dependency frontend dan membangun aset.
- Git untuk mengambil repository.

## Panduan Instalasi

1. Clone repository dan masuk ke direktori proyek:

   ```bash
   git clone https://github.com/kayla-pum/washora_laundry_system.git
   cd washora_laundry_system
   ```

2. Pasang dependency PHP:

   ```bash
   composer install
   ```

3. Pasang dependency frontend:

   ```bash
   npm install
   ```

4. Buat file `.env` dari contoh. Di PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

   Di macOS/Linux atau Git Bash:

   ```bash
   cp .env.example .env
   ```

5. Atur koneksi database di `.env` sesuai lingkungan lokal, lalu buat database yang namanya sesuai dengan nilai `DB_DATABASE`.
6. Buat application key:

   ```bash
   php artisan key:generate
   ```

7. Jalankan migration dan seeder yang tersedia:

   ```bash
   php artisan migrate --seed
   ```

8. Bangun aset frontend dan jalankan server lokal:

   ```bash
   npm run build
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000` di browser.

## Panduan Penggunaan

### Pelanggan

1. Buka halaman beranda, lalu pilih **Masuk** untuk login atau **Daftar Akun Baru** untuk registrasi.
2. Setelah login, buka **Dashboard** untuk melihat ringkasan pesanan dan transaksi.
3. Pilih **Pesan Laundry**, lalu tentukan jenis pesanan:
   - **Paket Bundling** untuk paket laundry yang tersedia.
   - **Layanan Satuan** untuk barang yang dihitung per buah atau pasang.
   - **Layanan Kiloan** untuk layanan yang dihitung per kilogram.
4. Isi nama, nomor WhatsApp, alamat penjemputan, informasi barang berharga atau risiko warna luntur, serta catatan tambahan.
5. Periksa kembali ringkasan pesanan, lalu kirim formulir.
6. Catat kode pesanan yang ditampilkan. Gunakan kode tersebut pada halaman **Pelacakan** atau buka menu **Pesanan Saya** untuk melihat riwayat dan rincian pesanan.
7. Setelah pesanan berstatus `completed`, pelanggan dapat memberikan rating dan testimoni pada halaman rincian pesanan.

### Administrator

1. Masuk melalui `/admin/login` menggunakan akun administrator.
2. Buka **Dashboard** untuk melihat pesanan menunggu verifikasi, proses laundry, pesanan siap diambil atau diantar, dan omset.
3. Buka **Pesanan Laundry**, pilih pesanan, lalu pada status `pending` masukkan berat atau jumlah aktual, harga satuan, estimasi selesai, dan catatan verifikasi.
4. Konfirmasi pesanan untuk mengubah status menjadi `confirmed`.
5. Gunakan menu status pada halaman detail untuk memperbarui pesanan menjadi `processing`, `washing`, `finishing`, `ready`, `completed`, atau `cancelled`.
6. Kelola kategori, layanan, paket, dan layanan unggulan dari menu **Katalog & Layanan**.
7. Buka **Data Pelanggan** untuk melihat pelanggan beserta riwayat pesanan.
8. Buka **Transaksi & Struk** untuk melihat transaksi dan mencetak invoice.
9. Buka **Laporan & Rekap** untuk melihat rekap periode, mencetak laporan, atau mengunduh PDF.
10. Buka **Testimoni Pelanggan** untuk menyembunyikan atau menghapus ulasan.

### Pelacakan Pesanan

Pengunjung dapat membuka halaman **Pelacakan**, memasukkan kode dengan format `WSH-YYYYMMDD-XXX`, lalu memilih **Cari Pesanan**. Sistem menampilkan status, rincian layanan, berat atau jumlah, estimasi selesai, biaya, dan riwayat perubahan status jika kode ditemukan.

## Akun Demo

Akun berikut disediakan oleh seeder proyek:

| Peran | Email | Kata sandi |
|---|---|---|
| Pelanggan | [user@washora.com](mailto:user@washora.com) | `password` |
| Administrator | [admin@washora.com](mailto:admin@washora.com) | `password` |

## Pengembang

Washora dikembangkan sebagai proyek tugas akhir pembelajaran Rekayasa Perangkat Lunak (RPL).

## ERD Sistem

ERD berikut dirangkum dari migration pada `database/migrations/` dan relasi Eloquent pada `app/Models/`. Nama tabel mempertahankan nama aktual proyek, termasuk tabel `servies`.

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

### Penjelasan tabel utama

| Tabel | Fungsi |
|---|---|
| `users` | Menyimpan akun pelanggan dan administrator. `role` membedakan hak akses, dan tabel ini menjadi pemesan, pengonfirmasi, penulis ulasan, serta pencatat status. |
| `service_categories` | Mengelompokkan layanan laundry. Satu kategori memiliki banyak layanan. |
| `servies` | Menyimpan katalog layanan, satuan, jenis regular/express, estimasi pengerjaan, status, dan pengaturan layanan unggulan. |
| `packages` | Menyimpan paket bundling beserta harga dan estimasi pengerjaan. |
| `package_items` | Menghubungkan paket dengan satu atau beberapa layanan. |
| `orders` | Menyimpan pesanan utama, alamat penjemputan, berat, harga, estimasi selesai, status, dan administrator pengonfirmasi. |
| `order_items` | Menyimpan rincian layanan atau paket pada pesanan beserta jumlah, harga satuan, subtotal, dan catatan. |
| `order_status_histories` | Mencatat perubahan status beserta pengguna yang mengubahnya. |
| `reviews` | Menyimpan ulasan pelanggan, rating, dan status publikasi testimoni. |

Harga dan subtotal menggunakan `decimal(12,2)`, sedangkan berat dan jumlah menggunakan `decimal(8,2)`. `users.email` dan `orders.order_code` bersifat unik. Kolom `user_id` pada pesanan dan ulasan dapat bernilai `null`, sedangkan pesanan aktif tetap memerlukan akun pelanggan pada alur pemesanan. `orders.customer_name` dan `orders.customer_phone` tersedia pada database, tetapi proses pemesanan saat ini belum mengisinya. Relasi pesanan dengan ulasan berbentuk one-to-one pada model, tetapi migration tidak memberikan constraint unik pada `reviews.order_id`.

### Tabel pendukung Laravel

| Tabel | Fungsi |
|---|---|
| `password_reset_tokens` | Menyimpan token reset kata sandi berdasarkan email. |
| `sessions` | Menyimpan sesi pengguna dan aktivitas. |
| `cache` | Menyimpan nilai cache dan waktu kedaluwarsa. |
| `cache_locks` | Menyimpan lock untuk cache database. |
| `jobs` | Menyimpan pekerjaan antrean. |
| `job_batches` | Menyimpan metadata batch antrean. |
| `failed_jobs` | Menyimpan antrean yang gagal dijalankan. |
| `migrations` | Dicatat oleh Laravel sebagai daftar migration yang telah dijalankan. |

## Flowchart Pemesanan Pelanggan

Alur berikut sesuai dengan route pelanggan yang dilindungi middleware `auth` dan `customer`, serta `User\OrderController`.

**Kode Mermaid:**

```mermaid
flowchart TD
    mulai([Mulai]) --> buka["Pelanggan membuka website"]
    buka --> katalog["Sistem menampilkan layanan dan paket aktif"]
    katalog --> pilih["Pelanggan memilih Pesan Laundry"]
    pilih --> login{"Sudah login sebagai pelanggan?"}
    login -- "Belum" --> masuk["Login atau registrasi pelanggan"]
    masuk --> form
    login -- "Sudah" --> form["Sistem menampilkan formulir pemesanan"]
    form --> tipe{"Jenis pilihan"}
    tipe -- "Kiloan" --> layanan["Pilih layanan kiloan"]
    tipe -- "Satuan" --> layananSatuan["Pilih layanan satuan"]
    tipe -- "Paket" --> paket["Pilih paket"]
    layanan --> data
    layananSatuan --> jumlah["Masukkan jumlah buah atau pasang"]
    jumlah --> data["Isi nama, nomor telepon/WhatsApp, alamat, informasi barang, dan catatan opsional"]
    paket --> data
    data --> kirim[/Kirim formulir pemesanan/]
    kirim --> validasi{"Validasi server berhasil?"}
    validasi -- "Tidak" --> error[/Tampilkan pesan validasi pada formulir/]
    error --> data
    validasi -- "Ya" --> simpan["Dalam transaksi database: perbarui nomor telepon akun; buat pesanan pending, item, dan riwayat status"]
    simpan --> biaya["Berat, total harga akhir, dan estimasi selesai menunggu konfirmasi administrator"]
    biaya --> hasil[/Tampilkan konfirmasi dan kode pesanan/]
    hasil --> selesai([Selesai])
```

Pelanggan harus login untuk mengirim pesanan. Layanan kiloan belum memiliki subtotal akhir dan menunggu penimbangan admin, sedangkan layanan satuan menyimpan jumlah dan subtotal awal. Paket menyimpan satu item paket beserta harga paket.

## Flowchart Pengelolaan Pesanan Administrator

Alur berikut sesuai dengan route administrator, middleware `auth` dan `admin`, serta `Admin\OrderController`.

**Kode Mermaid:**

```mermaid
flowchart TD
    mulai([Mulai]) --> buka["Administrator membuka halaman login"]
    buka --> kirimLogin[/Kirim email dan kata sandi/]
    kirimLogin --> validLogin{"Autentikasi berhasil sebagai administrator?"}
    validLogin -- "Tidak" --> loginGagal[/Tampilkan kesalahan login/]
    loginGagal --> buka
    validLogin -- "Ya" --> daftar["Buka daftar pesanan"]
    daftar --> detail["Pilih dan periksa detail pesanan"]
    detail --> pending{"Status pesanan pending?"}
    pending -- "Ya" --> timbang["Masukkan berat atau jumlah aktual, harga satuan, estimasi selesai, dan catatan opsional"]
    timbang --> validasiKonfirmasi{"Validasi konfirmasi berhasil?"}
    validasiKonfirmasi -- "Tidak" --> errorKonfirmasi[/Tampilkan kesalahan validasi/]
    errorKonfirmasi --> timbang
    validasiKonfirmasi -- "Ya" --> konfirmasi["Dalam transaksi database: perbarui item dan total pesanan; ubah status menjadi confirmed; catat riwayat"]
    konfirmasi --> lihatProgress["Admin memilih status proses dan catatan opsional"]
    pending -- "Tidak" --> lihatProgress
    lihatProgress --> validasiStatus{"Status termasuk pilihan yang diizinkan?"}
    validasiStatus -- "Tidak" --> errorStatus[/Tampilkan kesalahan validasi/]
    errorStatus --> lihatProgress
    validasiStatus -- "Ya" --> simpanStatus["Simpan status pesanan dan catatan riwayat status"]
    simpanStatus --> pelanggan["Pelanggan melihat status melalui detail pesanan atau halaman pelacakan"]
    pelanggan --> selesai([Selesai])
```

Setelah pesanan dikonfirmasi, administrator dapat memilih status `confirmed`, `processing`, `washing`, `finishing`, `ready`, `completed`, atau `cancelled`. Setiap perubahan dicatat dalam riwayat status. Tautan WhatsApp dibuka oleh administrator dan tidak dikirim otomatis oleh sistem.

## Flowchart Pelacakan Pesanan

Pelacakan tersedia untuk umum pada route `GET /tracking`.


```mermaid
flowchart TD
    mulai([Mulai]) --> halaman["Pelanggan membuka halaman tracking"]
    halaman --> masukkan[/Masukkan kode pesanan/]
    masukkan --> cari[/Kirim pencarian/]
    cari --> kosong{"Kode tidak kosong?"}
    kosong -- "Tidak" --> halaman
    kosong -- "Ya" --> validasi["Sistem membersihkan spasi dan mencari kode pesanan"]
    validasi --> ditemukan{"Pesanan ditemukan?"}
    ditemukan -- "Ya" --> tampil["Tampilkan status, rincian item, progres, dan biaya/estimasi yang tersedia"]
    tampil --> privasi["Alamat penjemputan dan catatan hanya ditampilkan kepada pemilik atau administrator"]
    privasi --> selesai([Selesai])
    ditemukan -- "Tidak" --> tidakAda[/Tampilkan Pesanan Tidak Ditemukan/]
    tidakAda --> selesai
```

Kode pesanan dicari setelah spasi di awal dan akhir dihapus. Alamat penjemputan serta catatan pelanggan disamarkan bagi pengunjung yang bukan pemilik pesanan atau administrator.
