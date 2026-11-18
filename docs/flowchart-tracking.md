# Flowchart Pelacakan Pesanan

Pelacakan tersedia untuk umum pada route `GET /tracking`. Kode pesanan dicari persis setelah spasi di awal dan akhir dihapus.

```mermaid
flowchart TD
    mulai([Mulai]) --> halaman["Pelanggan membuka halaman tracking"]
    halaman --> masukkan[/Masukkan kode pesanan/]
    masukkan --> cari[/Kirim pencarian/]
    cari --> kosong{"Kode tidak kosong?"}
    kosong -- "Tidak" --> halaman
    kosong -- "Ya" --> validasi["Sistem membersihkan spasi dan mencari kode pesanan"]
    validasi --> ditemukan{"Pesanan ditemukan?"}
    ditemukan -- "Ya" --> tampil["Tampilkan status, rincian item, progres, dan informasi biaya/estimasi yang tersedia"]
    tampil --> privasi["Alamat penjemputan dan catatan hanya ditampilkan kepada pemilik pesanan atau administrator"]
    privasi --> selesai([Selesai])
    ditemukan -- "Tidak" --> tidakAda[/Tampilkan informasi Pesanan Tidak Ditemukan/]
    tidakAda --> selesai
```

Kolom kode pada halaman tracking wajib diisi di browser. Jika kosong, halaman tidak menjalankan pencarian. Status pesanan yang ditemukan mencakup riwayat status; alamat penjemputan dan catatan pelanggan disamarkan bagi pengunjung yang bukan pemilik pesanan atau administrator.
