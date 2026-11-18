# Flowchart Pemesanan Pelanggan

Alur ini mengikuti route `/layanan`, route pelanggan yang dilindungi middleware `auth` dan `customer`, serta `User\OrderController`. Form mengirim satu layanan atau satu paket per pesanan.

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
    validasi -- "Ya" --> simpan["Dalam transaksi database: perbarui nomor telepon akun bila berubah; buat pesanan berstatus pending, kode unik, item, dan riwayat status"]
    simpan --> biaya["Berat, total harga akhir, dan estimasi selesai menunggu pemeriksaan administrator"]
    biaya --> hasil[/Tampilkan konfirmasi dan kode pesanan/]
    hasil --> selesai([Selesai])
```

Pelanggan harus memiliki sesi login untuk membuka formulir dan mengirim pesanan. Layanan kiloan dibuat dengan jumlah awal `1` dan subtotal `0` sambil menunggu penimbangan; layanan satuan menyimpan jumlah serta subtotal awal; paket menyimpan satu item paket dengan harga paket. Total akhir dan estimasi selesai ditentukan saat administrator mengonfirmasi pesanan. Input nama pemesan divalidasi pada formulir, tetapi kode penyimpanan pesanan saat ini tidak menyalinnya ke kolom `orders.customer_name`.
