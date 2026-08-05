<?php
$page_title = 'Laporan Admin — Bekakak Ayam Mang Atang';
$active = 'laporan';
require 'config/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

function rupiah($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

require 'includes/header.php';

// ---- ambil daftar menu untuk form pesanan (dikirim juga ke JS) ----
$menuList = [];
$q = mysqli_query($koneksi, "SELECT id, nama, harga FROM menu ORDER BY urutan ASC, id ASC");
while ($r = mysqli_fetch_assoc($q)) $menuList[] = $r;

// ---- ambil semua pesanan beserta itemnya ----
$pesananList = [];
$q2 = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY waktu DESC");
while ($p = mysqli_fetch_assoc($q2)) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM pesanan_detail WHERE pesanan_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $p['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $items = [];
    while ($it = mysqli_fetch_assoc($res)) $items[] = $it;
    $p['items'] = $items;
    $pesananList[] = $p;
}

// ---- statistik ----
$totalOmzet = 0;
$tally = [];
foreach ($pesananList as $p) {
    $totalOmzet += $p['total'];
    foreach ($p['items'] as $it) {
        $tally[$it['nama_menu']] = ($tally[$it['nama_menu']] ?? 0) + $it['qty'];
    }
}
arsort($tally);
$topItem = $tally ? array_key_first($tally) : '—';

mysqli_close($koneksi);
?>

<main>
  <section class="panel-section" style="border-top:none;">
    <div class="wrap" style="padding-top:40px;">

      <div class="dash-top">
        <div>
          <p class="eyebrow">Khusus Admin / Produsen</p>
          <h2 style="margin-top:14px;">Laporan &amp; Billing Penjualan</h2>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
          <span style="color:var(--smoke);font-size:13px;">Login sebagai <strong style="color:var(--cream);"><?= htmlspecialchars($_SESSION['admin_username']) ?></strong></span>
          <a href="kelola_menu.php" class="btn">🍽️ Kelola Menu</a>
          <a href="logout.php" class="btn">Keluar</a>
        </div>
      </div>

      <div class="dash-stats">
        <div class="dcard">
          <p class="eyebrow" style="margin-bottom:6px;">Total Omzet</p>
          <b class="mono"><?= rupiah($totalOmzet) ?></b>
        </div>
        <div class="dcard">
          <p class="eyebrow" style="margin-bottom:6px;">Total Struk</p>
          <b><?= count($pesananList) ?></b>
        </div>
        <div class="dcard">
          <p class="eyebrow" style="margin-bottom:6px;">Menu Terlaris</p>
          <b style="font-size:18px;"><?= htmlspecialchars($topItem) ?></b>
        </div>
      </div>

      <div class="panel">
        <h3>Buat Pesanan Baru</h3>
        <form method="POST" action="simpan_pesanan.php" id="formPesanan">
          <div id="itemRows"></div>
          <button type="button" class="btn" id="btnTambahBaris" style="margin-top:6px;">+ Tambah Item</button>

          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px;padding-top:16px;border-top:1px dashed var(--line);">
            <span style="color:var(--smoke);font-size:14px;">Estimasi Total: <strong class="mono" id="estimasiTotal" style="color:var(--turmeric);">Rp 0</strong></span>
            <button class="btn btn-ember" type="submit">Simpan Pesanan &amp; Buat Struk</button>
          </div>
        </form>
      </div>

      <div class="panel">
        <h3>Riwayat Struk</h3>
        <?php if (empty($pesananList)): ?>
          <div class="empty-state">Belum ada pesanan tercatat. Buat pesanan pertama di atas.</div>
        <?php else: ?>
          <?php foreach ($pesananList as $p): ?>
            <details class="pesanan-card">
              <summary>
                <span class="mono"><?= htmlspecialchars($p['no_struk']) ?></span>
                <span style="color:var(--smoke);font-size:12px;"><?= date('d/m/Y H:i', strtotime($p['waktu'])) ?></span>
                <span style="color:var(--smoke);font-size:12px;"><?= count($p['items']) ?> item</span>
                <span class="mono" style="color:var(--turmeric);margin-left:auto;"><?= rupiah($p['total']) ?></span>
              </summary>
              <table style="margin-top:12px;">
                <thead><tr><th>Menu</th><th>Qty</th><th>Subtotal</th></tr></thead>
                <tbody>
                  <?php foreach ($p['items'] as $it): ?>
                    <tr>
                      <td><?= htmlspecialchars($it['nama_menu']) ?></td>
                      <td><?= $it['qty'] ?></td>
                      <td class="mono"><?= rupiah($it['subtotal']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <div style="display:flex;gap:8px;margin-top:14px;">
                <a class="rowbtn" href="struk.php?id=<?= $p['id'] ?>" target="_blank">Cetak Struk</a>
                <a class="rowbtn danger" href="hapus_pesanan.php?id=<?= $p['id'] ?>" data-confirm="Hapus struk <?= htmlspecialchars($p['no_struk']) ?> beserta semua itemnya?">Hapus Struk</a>
              </div>
            </details>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

    </div>
    <div style="height:40px;"></div>
  </section>
</main>

<script>
  window.MENU_DATA = <?= json_encode($menuList) ?>;
</script>

<?php require 'includes/footer.php'; ?>
