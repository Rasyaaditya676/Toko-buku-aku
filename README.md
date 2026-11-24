# 📚 PustakaKita - Toko Buku Online (E-Commerce Bookstore)

Aplikasi Toko Buku Online berbasis web yang dibangun menggunakan **Framework Laravel 11**, **MySQL**, dan **Tailwind CSS**. Aplikasi ini dirancang untuk memenuhi standar Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak / Pemrograman Web dengan arsitektur MVC (Model-View-Controller) yang aman, modern, dan responsif.

---

## 🌟 Fitur Utama Sistem

Aplikasi ini memiliki 2 aktor pengguna dengan hak akses terpisah:

### 1. 🛡️ Aktor Admin (Panel Pengelola Toko)
* **CRUD Kategori Buku**: Tambah, edit (modal pop-up), dan hapus kategori buku dengan pembuatan *slug* otomatis serta proteksi relasi buku.
* **CRUD Data Buku**: Tambah, edit, dan hapus katalog buku lengkap dengan judul, penulis, penerbit, ISBN, stok, harga, dan upload gambar sampul.
* **Manajemen User**: Melihat daftar seluruh pengguna yang terdaftar beserta riwayat pesanannya.
* **Manajemen Pesanan**: Memantau seluruh pesanan pelanggan secara *real-time* dan memperbarui status pengiriman (*Pending, Diproses, Dikirim, Selesai*).
* **Layanan Kontak**: Membaca dan membalas pesan masuk dari pelanggan.

### 2. 👤 Aktor User (Pelanggan / Pembeli)
* **Autentikasi Multi-Role**: Registrasi akun dan login dengan redirect otomatis sesuai role.
* **Katalog & Pencarian**: Pencarian buku berdasarkan judul/penulis/penerbit dan filter kategori menggunakan relasi Eloquent (`whereHas`).
* **Detail Buku**: Sinopsis, info stok, dan tombol kuantitas interaktif (`+` dan `-`) berbasis JavaScript.
* **Keranjang Belanja (Add to Cart)**: Tambah item, ubah jumlah pesanan, dan hitung subtotal otomatis.
* **Checkout & Pembayaran Online**: Pengisian alamat pengiriman dan pembayaran online (Transfer Bank BCA, Mandiri, dan QRIS) dengan transaksi database (`DB::transaction`).
* **Dashboard Pelanggan**: Pantau ringkasan total belanja dan riwayat status pesanan.
* **Halaman About Us & Kontak Admin**: Profil toko dan formulir pesan dengan deteksi jam operasional kerja admin (09.00 - 21.00 WIB).

---

## 🔑 Akun Demo untuk Pengujian

| Peran (Role) | Alamat Email | Kata Sandi (Password) |
| :--- | :--- | :--- |
| **Administrator** | `admin@bookstore.com` | `password` |
| **Pelanggan (User)** | `user@bookstore.com` | `password` |

---

## 🛠️ Persyaratan Sistem & Instalasi

1. **Persyaratan:**
   * PHP >= 8.2
   * Composer
   * MySQL (via XAMPP / Laragon)

2. **Langkah Menjalankan Proyek:**
   ```bash
   # 1. Clone repositori
   git clone https://github.com/Rasyaaditya676/Toko-buku-aku.git
   cd Toko-buku-aku

   # 2. Install dependensi
   composer install

   # 3. Salin file environment dan atur database
   cp .env.example .env
   php artisan key:generate

   # Atur database di file .env:
   # DB_DATABASE=toko_buku
   # DB_USERNAME=root
   # DB_PASSWORD=

   # 4. Import database toko_buku.sql atau jalankan migrasi
   php artisan migrate --seed

   # 5. Buat tautan symlink storage gambar
   php artisan storage:link

   # 6. Jalankan server lokal
   php artisan serve
   ```
   Akses aplikasi di browser pada: `http://localhost:8000`

---

## 📂 Dokumentasi & Cuplikan Layar

Tersedia folder dokumentasi visual hasil tangkapan layar antarmuka sistem pada folder:
`halaman web toko-buku/`

---
*Dikembangkan untuk Uji Kompetensi Keahlian (UKK) / Sertifikasi Kompetensi Pemrograman Web.*
