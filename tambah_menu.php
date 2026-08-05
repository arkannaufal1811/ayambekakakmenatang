<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$harga = (int) ($_POST['harga'] ?? 0);

if ($nama === '' || $kategori === '' || $harga <= 0) {
    mysqli_close($koneksi);
    header('Location: kelola_menu.php?error=kosong');
    exit;
}

$namaFile = null;

// ---- proses upload foto (opsional) ----
if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $tipeDiizinkan = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];
    $tipeAsli = mime_content_type($_FILES['gambar']['tmp_name']);

    if (!isset($tipeDiizinkan[$tipeAsli])) {
        mysqli_close($koneksi);
        header('Location: kelola_menu.php?error=foto_tipe');
        exit;
    }
    if ($_FILES['gambar']['size'] > 3 * 1024 * 1024) {
        mysqli_close($koneksi);
        header('Location: kelola_menu.php?error=foto_besar');
        exit;
    }

    // bikin nama file aman: slug-nama + waktu unik
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '_', $nama), '_'));
    $namaFile = $slug . '_' . time() . '.' . $tipeDiizinkan[$tipeAsli];

    $tujuan = __DIR__ . '/assets/img/menu/' . $namaFile;
    move_uploaded_file($_FILES['gambar']['tmp_name'], $tujuan);
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO menu (kategori, nama, harga, gambar, best_seller, urutan) VALUES (?, ?, ?, ?, 0, 999)");
mysqli_stmt_bind_param($stmt, 'ssis', $kategori, $nama, $harga, $namaFile);
mysqli_stmt_execute($stmt);

mysqli_close($koneksi);
header('Location: kelola_menu.php?sukses=tambah');
exit;
