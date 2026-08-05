<?php
$host = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'frYLhKUxtPywqHDZPMVZzvLEtdaFVCOY';

// UBAH BARIS INI:
$db   = 'db_bekakak_ayam'; // Ubah jadi db_bekakak_ayam

$port = getenv('MYSQLPORT') ?: 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);
