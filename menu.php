<?php
$page_title = 'Menu & Harga — Bekakak Ayam Mang Atang';
$active = 'menu';
require 'config/db.php';
require 'includes/header.php';

function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

$query = "SELECT * FROM menu ORDER BY urutan ASC, id ASC";
$result = mysqli_query($koneksi, $query);

$grouped = [];
while ($row = mysqli_fetch_assoc($result)) {
    $grouped[$row['kategori']][] = $row;
}
?>

<main>
  <section>
    <div class="wrap">
      <div class="section-head">
        <p class="eyebrow">Papan Menu</p>
        <h2>Menu &amp; Daftar Harga</h2>
        <p>Semua harga per porsi, siap dipanggang dan digoreng segar setiap hari. Pesan langsung ke warung, atau lewat ShopeeFood &amp; GoFood.</p>
      </div>

      <div class="menu-board">
        <?php foreach ($grouped as $kategori => $items): ?>
          <div class="menu-cat">
            <h3><?= htmlspecialchars($kategori) ?></h3>
            <?php foreach ($items as $it): ?>
              <div class="menu-row">
                <div class="menu-item-name">
                  <?php if (!empty($it['gambar'])): ?>
                    <img class="menu-thumb" src="assets/img/menu/<?= htmlspecialchars($it['gambar']) ?>" alt="<?= htmlspecialchars($it['nama']) ?>">
                  <?php else: ?>
                    <span class="menu-thumb-empty">🍢</span>
                  <?php endif; ?>
                  <?= htmlspecialchars($it['nama']) ?>
                  <?php if ($it['best_seller']): ?><span class="best-tag">FAVORIT</span><?php endif; ?>
                </div>
                <div class="dots"></div>
                <div class="price"><?= rupiah($it['harga']) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="order-cta">
        <p>Mau pesan tanpa datang langsung? Warung Bekakak Ayam Mang Atang juga bisa dijangkau lewat aplikasi favoritmu.</p>
        <a href="https://shopeefood.co.id" target="_blank" rel="noopener" class="btn" style="background:#ee4d2d;border-color:#ee4d2d;color:#fff;">🛵 ShopeeFood</a>
        <a href="https://gofood.link/a/BbnHr4s" target="_blank" rel="noopener" class="btn btn-leaf">🟢 GoFood</a>
      </div>

      <div class="qris-panel">
        <img src="assets/img/qris.jpg" alt="QRIS Bekakak Ayam Mang Atang" class="qris-img">
        <div>
          <p class="eyebrow" style="margin-bottom:8px;">Bayar Praktis</p>
          <h3 style="font-family:'Fraunces',serif;font-size:20px;margin-bottom:8px;">Scan QRIS buat Bayar</h3>
          <p style="color:var(--smoke);font-size:14px;line-height:1.6;margin:0;">Pesan langsung ke warung atau lewat WhatsApp? Tinggal scan kode QRIS ini pakai aplikasi bank/e-wallet apa aja — GoPay, OVO, Dana, ShopeePay, m-banking, semua bisa.</p>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
mysqli_close($koneksi);
require 'includes/footer.php';
?>
