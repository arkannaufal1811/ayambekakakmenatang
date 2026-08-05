<?php
// includes/header.php
// Variabel opsional yang bisa diisi halaman sebelum include ini:
//   $page_title  -> judul tab browser
//   $active      -> nama halaman aktif untuk highlight navbar ('beranda','tentang','menu','laporan')
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($page_title)) $page_title = 'Bekakak Ayam Mang Atang';
if (!isset($active)) $active = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,600&family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
  <nav class="nav">
    <a href="index.php" class="brand">
      <img src="assets/img/logo.jpg" alt="Logo Warung Bekakak Ayam Mang Atang" class="brand-mark">
      Bekakak Ayam<br>Mang Atang
    </a>
    <ul class="navlinks" id="navlinks">
      <li><a href="index.php" class="<?= $active === 'beranda' ? 'active' : '' ?>">Beranda</a></li>
      <li><a href="tentang.php" class="<?= $active === 'tentang' ? 'active' : '' ?>">Tentang Kami</a></li>
      <li><a href="menu.php" class="<?= $active === 'menu' ? 'active' : '' ?>">Menu & Harga</a></li>
      <li><a href="laporan.php" class="<?= $active === 'laporan' ? 'active' : '' ?>">Laporan Admin</a></li>
    </ul>
    <div class="navcta">
      <a class="btn" href="menu.php">Lihat Menu</a>
      <button class="menu-toggle" id="menuToggle" aria-label="Buka menu navigasi">☰</button>
    </div>
  </nav>
</header>
