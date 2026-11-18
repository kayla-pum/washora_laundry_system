# Flowchart Pengelolaan Pesanan Administrator

Alur ini mengikuti route administrator, middleware `auth` dan `admin`, serta `Admin\OrderController`. Form timbang dan konfirmasi ditampilkan pada halaman detail untuk pesanan berstatus `pending`.

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
    validasiKonfirmasi -- "Ya" --> konfirmasi["Dalam transaksi database: perbarui jumlah, harga, subtotal item, total pesanan, berat, estimasi, waktu dan admin konfirmasi; ubah status menjadi confirmed; catat riwayat"]
    konfirmasi --> lihatProgress["Admin memilih status proses dan catatan opsional"]
    pending -- "Tidak" --> lihatProgress
    lihatProgress --> validasiStatus{"Status termasuk pilihan yang diizinkan?"}
    validasiStatus -- "Tidak" --> errorStatus[/Tampilkan kesalahan validasi/]
    errorStatus --> lihatProgress
    validasiStatus -- "Ya" --> simpanStatus["Simpan status pesanan dan catatan riwayat status"]
    simpanStatus --> pelanggan["Pelanggan melihat status dan riwayat melalui detail akun atau halaman tracking"]
    pelanggan --> selesai([Selesai])
```

Konfirmasi menghitung harga dari jumlah aktual dan harga satuan yang dikirim administrator serta menyimpan semua perubahan konfirmasi dalam transaksi database. Setelah konfirmasi, administrator dapat memperbarui status ke nilai yang didukung (`confirmed`, `processing`, `washing`, `finishing`, `ready`, `completed`, atau `cancelled`). Tautan notifikasi WhatsApp dibuat untuk dibuka oleh administrator; pesan tidak dikirim otomatis oleh aplikasi.
