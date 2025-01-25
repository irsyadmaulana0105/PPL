# Pecos - Aplikasi Pemesanan Online via QR Code

Pecos adalah aplikasi pemesanan online yang memungkinkan pengguna melakukan pemesanan makanan dan minuman melalui kode QR yang berisi nomor meja. Setelah memindai QR code, pengguna akan diarahkan ke website yang menampilkan menu makanan, minuman, dan snack untuk pemesanan. Aplikasi ini dibangun menggunakan PHP dengan pendekatan Model-View-Controller (MVC).

## Fitur Utama

### Portal Pengguna
- Memindai kode QR untuk mengakses menu.
- Pemesanan makanan, minuman, dan snack.
- Ringkasan pesanan yang dapat dilihat dan dikonfirmasi.

### Manajemen Menu
- Admin dapat menambahkan, mengedit, dan menghapus item menu.
- Kategori menu (makanan, minuman, snack).
- Filter dan pencarian menu.

### Pembelian
- Pengguna dapat memilih dan memesan berbagai item dari menu yang tersedia.
- Ringkasan pesanan sebelum melakukan konfirmasi.
- Pembayaran untuk pesanan yang dilakukan.

### Pembayaran
- Integrasi dengan sistem pembayaran (misalnya, Midtrans atau PayPal).
- Konfirmasi pembayaran.

### Admin Panel
- Admin dapat mengelola menu, pesanan, dan transaksi.
- Statistik pemesanan dan penjualan.

## Teknologi
- **Backend**: PHP (MVC)
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL

## Instalasi

### Prerequisites
- PHP 8.x
- Laravel 11.x (jika menggunakan Laravel)
- MySQL atau PostgreSQL

### Langkah-langkah Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/username/pecos.git
