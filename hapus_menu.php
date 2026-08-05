<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
$hasil = 'hapus';

if ($id > 0) {
    try {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM menu WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
    } catch (mysqli_sql_exception $e) {
        // kemungkinan besar gagal karena menu ini masih terpakai di riwayat pesanan lama (foreign key)
        $hasil = null;
    }
}

mysqli_close($koneksi);

if ($hasil === 'hapus') {
    header('Location: kelola_menu.php?sukses=hapus');
} else {
    header('Location: kelola_menu.php?error=dipakai');
}
exit;
