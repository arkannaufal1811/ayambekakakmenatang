<?php
// Tampilkan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ambil variabel environment dari Railway
$host = getenv('MYSQLHOST') ?: getenv('MYSQL_HOST');
$user = getenv('MYSQLUSER') ?: getenv('MYSQL_USER');
$pass = getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD');
$db   = getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE');
$port = getenv('MYSQLPORT') ?: getenv('MYSQL_PORT') ?: 3306;

// Jika variabel tidak ditemukan di env, set manual (atau cegah koneksi socket)
if (!$host) {
    // Ganti 'localhost' jadi '127.0.01' agar tidak memakai unix socket
    $host = '127.0.0.1'; 
}

// Koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db, (int)$port);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");
?>
