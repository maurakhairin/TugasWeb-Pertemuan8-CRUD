# CRUD Inventaris — Tugas Rutin 8

Aplikasi CRUD sederhana untuk manajemen data produk/inventaris,
dibuat dengan PHP native + PDO (MySQL), untuk memenuhi Tugas Rutin 8
mata kuliah Pemrograman Web.

## Fitur

**Sesuai requirement:**
- Database `inventaris_db` dengan 3 tabel + Foreign Key (produk → kategori, produk → supplier)
- Data seed minimal 5 baris per tabel
- Koneksi database pakai PDO dengan pola **Singleton** (`config/Database.php`)
- Halaman daftar produk dengan **JOIN** ke tabel kategori & supplier
- Form tambah produk dengan **dropdown** kategori & supplier
- Fitur **update** (form pre-filled) & **delete** (ada konfirmasi lewat `confirm()`)
- Semua query yang melibatkan input pengguna memakai **prepared statement**
- Semua output ditampilkan lewat **htmlspecialchars()**
- **Flash message** sukses/gagal dengan pola Post-Redirect-Get

**Fitur bonus (semua disertakan):**
- ✅ Transaction saat hapus data + log aktivitas (`delete.php`, `log_aktivitas.php`)
- ✅ Fitur pencarian nama produk
- ✅ Pagination daftar produk
- ✅ Export laporan ke CSV (`export.php`)

## Struktur Folder

```
crud-inventaris/
├── config/
│   └── Database.php        -> koneksi PDO (Singleton)
├── includes/
│   ├── init.php             -> session + load Database + flash (TANPA HTML)
│   ├── header.php           -> bagian atas tampilan (navbar, dst.)
│   ├── footer.php           -> bagian bawah tampilan
│   └── flash.php            -> fungsi setFlash() / showFlash()
├── assets/
│   └── style.css
├── database/
│   └── schema.sql            -> struktur tabel + data awal (seed)
├── index.php                  -> daftar produk (JOIN + search + pagination)
├── create.php                 -> form tambah produk
├── store.php                  -> proses simpan produk baru
├── edit.php                    -> form edit produk (pre-filled)
├── update.php                  -> proses update produk
├── delete.php                   -> proses hapus produk (transaction + log)
├── log_aktivitas.php            -> riwayat penghapusan produk
├── export.php                    -> export laporan ke CSV
└── README.md
```

## Cara Menjalankan (XAMPP)

1. Salin seluruh folder `crud-inventaris` ke dalam folder `htdocs` XAMPP,
   contoh: `C:\xampp\htdocs\crud-inventaris\`
2. Nyalakan **Apache** dan **MySQL** lewat XAMPP Control Panel.
3. Buka `http://localhost/phpmyadmin`, klik tab **SQL**, tempel seluruh
   isi file `database/schema.sql`, lalu klik **Go**.
   (Ini otomatis membuat database `inventaris_db`, semua tabel, dan
   data contoh.)
4. Kalau username/password MySQL Anda berbeda dari default XAMPP,
   sesuaikan di `config/Database.php` (default: user `root`, password
   kosong — biasanya tidak perlu diubah).
5. Buka `http://localhost/crud-inventaris/index.php` di browser.

## Tips Debugging (kalau ada error)

- **"Koneksi database gagal"** → pastikan MySQL sudah di-Start di XAMPP,
  dan nama database di `config/Database.php` (`inventaris_db`) sudah
  sesuai dengan yang dibuat lewat `schema.sql`.
- **Halaman blank / error 500** → aktifkan dulu error reporting PHP
  supaya pesan errornya terlihat, dengan menambahkan dua baris ini di
  paling atas `includes/init.php` sementara masa development:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```
- **Dropdown kategori/supplier kosong** → cek apakah `schema.sql`
  sudah benar-benar dijalankan sampai selesai (termasuk bagian INSERT
  data awal-nya).

## Screenshot Aplikasi

*(Tambahkan screenshot halaman daftar produk, form tambah, dan log
aktivitas di sini sebelum push ke GitHub — ini bagian dari ketentuan
pengumpulan tugas.)*

## Catatan Pengumpulan Tugas

Sesuai ketentuan Tugas Rutin 8:
- Push source code + `database/schema.sql` ke GitHub
- Nama repository: `TugasWeb-Pertemuan8-CRUD`
- Repository bersifat **Public**
- README menyertakan screenshot aplikasi + langkah import database (sudah ada di atas, tambahkan screenshot-nya)
- Kumpulkan link repository lewat LMS UNIMED
