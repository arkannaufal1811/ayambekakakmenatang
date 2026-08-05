<?php
require 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM pesanan WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$p = mysqli_fetch_assoc($res);

if (!$p) {
    mysqli_close($koneksi);
    die('Struk tidak ditemukan.');
}

$stmt2 = mysqli_prepare($koneksi, "SELECT * FROM pesanan_detail WHERE pesanan_id = ?");
mysqli_stmt_bind_param($stmt2, 'i', $id);
mysqli_stmt_execute($stmt2);
$res2 = mysqli_stmt_get_result($stmt2);
$items = [];
while ($it = mysqli_fetch_assoc($res2)) $items[] = $it;

mysqli_close($koneksi);

$page_title = 'Struk ' . $p['no_struk'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="struk-page">
    <div class="receipt">
      <h4>BEKAKAK AYAM MANG ATANG</h4>
      <div class="sub">Buka 12.00–21.00 WIB</div>
      <hr>
      <div class="rline"><span>No. Struk</span><span><?= htmlspecialchars($p['no_struk']) ?></span></div>
      <div class="rline" style="color:#6b5c4a;"><span>Waktu</span><span><?= date('d/m/Y H:i', strtotime($p['waktu'])) ?></span></div>
      <hr>
      <?php foreach ($items as $it): ?>
        <div class="rline"><span><?= htmlspecialchars($it['nama_menu']) ?> x<?= $it['qty'] ?></span><span><?= rupiah($it['subtotal']) ?></span></div>
      <?php endforeach; ?>
      <hr>
      <div class="rline total"><span>TOTAL</span><span><?= rupiah($p['total']) ?></span></div>
      <hr>
      <div style="text-align:center;">
        <div style="font-size:11px;margin-bottom:6px;">Scan buat bayar QRIS:</div>
        <img src="assets/img/qris.jpg" alt="QRIS" style="width:130px;height:130px;object-fit:contain;margin:0 auto;">
      </div>
      <div class="sub" style="margin-top:14px;">Terima kasih sudah mampir 🙏</div>

      <div class="struk-actions">
        <a class="btn" style="border-color:#241a12;color:#241a12;" href="laporan.php">Kembali</a>
        <button class="btn btn-ember" data-print type="button">Cetak</button>
      </div>
    </div>
  </div>
  <script src="assets/script.js"></script>
</body>
</html>
