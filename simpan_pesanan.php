<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$menuIds = $_POST['menu_id'] ?? [];
$qtys = $_POST['qty'] ?? [];

if (empty($menuIds)) {
    mysqli_close($koneksi);
    header('Location: laporan.php');
    exit;
}

mysqli_begin_transaction($koneksi);

try {
    $no_struk = 'STR' . date('ymd') . rand(100, 999);

    $insertPesanan = mysqli_prepare($koneksi, "INSERT INTO pesanan (no_struk, total) VALUES (?, 0)");
    mysqli_stmt_bind_param($insertPesanan, 's', $no_struk);
    mysqli_stmt_execute($insertPesanan);
    $pesananId = mysqli_insert_id($koneksi);

    $totalPesanan = 0;

    for ($i = 0; $i < count($menuIds); $i++) {
        $menuId = (int) $menuIds[$i];
        $qty = max(1, (int) ($qtys[$i] ?? 1));

        $stmt = mysqli_prepare($koneksi, "SELECT nama, harga FROM menu WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $menuId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $menu = mysqli_fetch_assoc($res);

        if (!$menu) continue;

        $subtotal = $menu['harga'] * $qty;
        $totalPesanan += $subtotal;

        $insertDetail = mysqli_prepare(
            $koneksi,
            "INSERT INTO pesanan_detail (pesanan_id, nama_menu, harga, qty, subtotal) VALUES (?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $insertDetail,
            'isiii',
            $pesananId,
            $menu['nama'],
            $menu['harga'],
            $qty,
            $subtotal
        );
        mysqli_stmt_execute($insertDetail);
    }

    $updateTotal = mysqli_prepare($koneksi, "UPDATE pesanan SET total = ? WHERE id = ?");
    mysqli_stmt_bind_param($updateTotal, 'ii', $totalPesanan, $pesananId);
    mysqli_stmt_execute($updateTotal);

    mysqli_commit($koneksi);
} catch (mysqli_sql_exception $e) {
    mysqli_rollback($koneksi);
}

mysqli_close($koneksi);
header('Location: laporan.php');
exit;
