<?php
$host = "mysql.railway.internal";
$user = "root";
$pass = "frYLhKUxtPywqHDZPMVZzvLEtdaFVCOY";
$db   = "railway";
$port = 3306;

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
