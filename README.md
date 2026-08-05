# Bekakak Ayam Mang Atang — Website UMKM (PHP + MySQL)

Website untuk admin/produsen mengelola: **Beranda**, **Tentang Kami**, **Menu & Harga**, dan **Laporan/Billing** (login khusus admin, tersimpan di database MySQL) — dilengkapi tombol pesan ke **ShopeeFood** & **GoFood**.

## 1. Struktur File
```
bekakak-php/
├── database.sql          <- skrip bikin database & tabel (jalankan via Command Prompt)
├── config/db.php         <- koneksi ke MySQL
├── includes/header.php   <- navbar (dipakai semua halaman)
├── includes/footer.php   <- footer (dipakai semua halaman)
├── assets/style.css      <- semua CSS
├── assets/script.js      <- semua JavaScript
├── index.php             <- Beranda
├── tentang.php           <- Tentang Kami
├── menu.php              <- Menu & Harga (ambil data dari tabel `menu`)
├── login.php             <- Login admin
├── logout.php
├── laporan.php           <- Dashboard Laporan & Billing (khusus admin, wajib login)
├── tambah_transaksi.php  <- proses simpan transaksi baru
├── hapus_transaksi.php   <- proses hapus transaksi
└── struk.php             <- cetak struk/billing per transaksi
```

## 2. Yang perlu di-install
Install salah satu paket server lokal yang sudah menyertakan **Apache + PHP + MySQL**:
- **XAMPP** (https://www.apachefriends.org) — paling umum dipakai di sekolah, atau
- **Laragon** (https://laragon.org)

## 3. Setup Database lewat Command Prompt
1. Buka XAMPP Control Panel, nyalakan **Apache** dan **MySQL**.
2. Buka **Command Prompt**, masuk ke folder `mysql\bin` di instalasi XAMPP, contoh:
   ```
   cd C:\xampp\mysql\bin
   ```
3. Login ke MySQL (default XAMPP: user `root`, tanpa password, tinggal Enter):
   ```
   mysql -u root -p
   ```
4. Setelah masuk prompt `mysql>`, jalankan (ganti path sesuai lokasi project kamu):
   ```
   source C:/xampp/htdocs/bekakak-ayam-mang-atang/database.sql
   ```
   Atau, tanpa masuk prompt dulu, langsung dari Command Prompt biasa:
   ```
   mysql -u root -p < "C:\xampp\htdocs\bekakak-ayam-mang-atang\database.sql"
   ```
5. Cek database sudah dibuat:
   ```
   mysql -u root -p -e "SHOW DATABASES;"
   ```
   Harus muncul `db_bekakak_ayam` di daftarnya.

   *(Alternatif tanpa Command Prompt: import `database.sql` lewat phpMyAdmin di `http://localhost/phpmyadmin`, menu Import.)*

## 4. Menjalankan Website
1. Copy seluruh folder `bekakak-php` ke dalam `C:\xampp\htdocs\`, boleh diganti nama misalnya `bekakak-ayam-mang-atang`.
2. Pastikan Apache & MySQL menyala di XAMPP Control Panel.
3. Buka browser, akses:
   ```
   http://localhost/bekakak-ayam-mang-atang/index.php
   ```

## 5. Login Admin (Laporan & Billing)
- URL: `http://localhost/bekakak-ayam-mang-atang/login.php`
- Username: `admin`
- Password: `admin123`

⚠️ Setelah presentasi/demo, sebaiknya ganti password ini (lewat phpMyAdmin, tabel `admin`, generate hash baru dengan fungsi PHP `password_hash()`).

## 6. Kalau koneksi database gagal
Cek `config/db.php` — sesuaikan `DB_USER` / `DB_PASS` kalau setting MySQL kamu beda dari default XAMPP (default: user `root`, password kosong).

## 7. Menambah / mengubah menu & harga
Tinggal edit langsung lewat phpMyAdmin pada tabel `menu`, atau jalankan query `UPDATE`/`INSERT` lewat Command Prompt MySQL. Halaman `menu.php` otomatis ambil data terbaru dari database, tidak perlu edit kode.

## 8. Tautan ShopeeFood & GoFood
Saat ini tombol mengarah ke halaman umum ShopeeFood/GoFood. Ganti dengan link resto/merchant asli di:
- `index.php`, `menu.php`, `includes/footer.php` — cari teks `https://shopeefood.co.id` dan `https://www.gofood.co.id`.
