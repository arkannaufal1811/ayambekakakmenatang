<?php
/**
 * config/db.php
 * Koneksi ke database MySQL.
 * Sesuaikan DB_USER / DB_PASS kalau setting MySQL kamu berbeda dari default XAMPP/Laragon.
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // default XAMPP kosong, isi kalau MySQL kamu pakai password
define('DB_NAME', 'db_bekakak_ayam');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error() .
        '<br>Pastikan MySQL sudah jalan dan database "db_bekakak_ayam" sudah dibuat (lihat README.md).');
}

mysqli_set_charset($koneksi, 'utf8mb4');
