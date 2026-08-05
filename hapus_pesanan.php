<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id > 0) {
    // pesanan_detail otomatis kehapus juga karena ON DELETE CASCADE
    $stmt = mysqli_prepare($koneksi, "DELETE FROM pesanan WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}

mysqli_close($koneksi);
header('Location: laporan.php');
exit;
