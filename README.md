# Product Information System

Mini project mata kuliah Pemrograman Web — Pertemuan 2 (PHP Fundamental & Data Structure).
Sistem sederhana untuk menampilkan katalog produk dan menambah produk baru lewat form.

## Struktur File

| File | Peran | Isi |
|---|---|---|
| `products.php` | **Data Layer** | Menyimpan data produk default (`$katalogDefault`) dalam bentuk multidimensional array. |
| `functions.php` | **Processing Layer** | Fungsi-fungsi bisnis: kalkulasi total nilai stok, penentuan status stok, validasi input form, dan pembuatan ID produk baru. |
| `index.php` | **Presentation Layer** | Menangani form tambah produk (`$_POST` → validasi) dan menampilkan hasilnya dalam tabel HTML. |
| `README.md` | Dokumentasi | File ini. |

## Cara Menjalankan

1. Install server lokal (XAMPP atau Laragon).
2. Taruh ketiga file PHP (`products.php`, `functions.php`, `index.php`) ke dalam folder:
   - XAMPP → `C:\xampp\htdocs\`
   - Laragon → `C:\laragon\www\`
3. Nyalakan **Apache** dari XAMPP/Laragon Control Panel.
4. Buka browser, akses: `http://localhost/index.php`

## Fitur

- **Lihat Katalog**: Menampilkan daftar produk beserta harga, stok, dan status stok (Aman/Menipis/Kritis).
- **Tambah Produk**: Form untuk menambahkan produk baru, dengan validasi:
  - Nama & kategori tidak boleh kosong.
  - Harga harus angka desimal dan lebih besar dari 0 (`FILTER_VALIDATE_FLOAT`).
  - Stok harus angka bulat dan tidak boleh negatif (`FILTER_VALIDATE_INT`).
- **Total Nilai Aset Gudang**: Dihitung otomatis dari `harga x stok` setiap produk.
- **Indikator Status Stok**:
  - Stok `< 3` → **Kritis** (merah)
  - Stok `≤ 10` → **Menipis** (kuning)
  - Selain itu → **Aman** (hijau)

## Keterbatasan (Catatan Jujur)

Produk yang ditambahkan lewat form **tidak tersimpan secara permanen**, karena project ini
belum terhubung ke database (MySQL). Begitu halaman di-refresh, data kembali ke isi default
di `products.php`. Ini adalah langkah awal sebelum materi berikutnya: menyambungkan PHP ke
MySQL agar data benar-benar tersimpan secara permanen (alur: `User → Browser → PHP → MySQL → PHP → Browser`).

## Alur Kerja Kode (Ringkas)

```
index.php
 ├─ require_once products.php   -> ambil data default
 ├─ require_once functions.php  -> ambil fungsi-fungsi helper
 ├─ jika form di-submit (POST):
 │    ├─ tangkap data via $_POST
 │    ├─ validasiProduk()       -> cek error
 │    └─ jika valid, tambahkan ke array $katalog
 └─ render tabel HTML via foreach($katalog)
```
