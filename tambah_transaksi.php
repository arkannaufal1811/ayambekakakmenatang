<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_id = (int) ($_POST['menu_id'] ?? 0);
    $qty = max(1, (int) ($_POST['qty'] ?? 1));

    $stmt = mysqli_prepare($koneksi, "SELECT nama, harga FROM menu WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $menu_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $menu = mysqli_fetch_assoc($res);

    if ($menu) {
        $subtotal = $menu['harga'] * $qty;
        $no_struk = 'STR' . date('ymd') . rand(100, 999);

        $insert = mysqli_prepare(
            $koneksi,
            "INSERT INTO transaksi (no_struk, menu_id, nama_menu, harga, qty, subtotal) VALUES (?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $insert,
            'sisiii',
            $no_struk,
            $menu_id,
            $menu['nama'],
            $menu['harga'],
            $qty,
            $subtotal
        );
        mysqli_stmt_execute($insert);
    }
}

mysqli_close($koneksi);
header('Location: laporan.php');
exit;
