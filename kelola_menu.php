<?php
$page_title = 'Kelola Menu — Bekakak Ayam Mang Atang';
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

$sukses = $_GET['sukses'] ?? '';
$error = $_GET['error'] ?? '';

require 'includes/header.php';

$menuList = [];
$q = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY kategori ASC, urutan ASC, id ASC");
while ($r = mysqli_fetch_assoc($q)) $menuList[] = $r;
mysqli_close($koneksi);
?>

<main>
  <section class="panel-section" style="border-top:none;">
    <div class="wrap" style="padding-top:40px;">

      <div class="dash-top">
        <div>
          <p class="eyebrow">Khusus Admin / Produsen</p>
          <h2 style="margin-top:14px;">Kelola Menu</h2>
        </div>
        <a href="laporan.php" class="btn">← Kembali ke Laporan</a>
      </div>

      <?php if ($sukses === 'tambah'): ?>
        <div class="alert alert-ok">Menu baru berhasil ditambahkan.</div>
      <?php elseif ($sukses === 'hapus'): ?>
        <div class="alert alert-ok">Menu berhasil dihapus.</div>
      <?php endif; ?>
      <?php if ($error === 'dipakai'): ?>
        <div class="alert alert-error">Menu ini tidak bisa dihapus karena sudah pernah ada di riwayat pesanan. Kamu bisa nonaktifkan lain waktu, atau biarkan saja di daftar.</div>
      <?php elseif ($error === 'kosong'): ?>
        <div class="alert alert-error">Nama menu, kategori, dan harga wajib diisi.</div>
      <?php elseif ($error === 'foto_tipe'): ?>
        <div class="alert alert-error">Format foto harus JPG, PNG, atau WEBP.</div>
      <?php elseif ($error === 'foto_besar'): ?>
        <div class="alert alert-error">Ukuran foto maksimal 3MB.</div>
      <?php endif; ?>

      <div class="panel">
        <h3>Tambah Menu Baru</h3>
        <form method="POST" action="tambah_menu.php" enctype="multipart/form-data" style="display:grid;grid-template-columns:1.2fr 1fr 1fr auto;gap:10px;align-items:end;">
          <div>
            <label style="display:block;font-size:12px;color:var(--smoke);margin-bottom:6px;">Nama Menu</label>
            <input type="text" name="nama" required placeholder="Contoh: Sate Ati">
          </div>
          <div>
            <label style="display:block;font-size:12px;color:var(--smoke);margin-bottom:6px;">Kategori</label>
            <input type="text" name="kategori" required placeholder="Contoh: Jeroan & Pelengkap" list="kategori-list">
            <datalist id="kategori-list">
              <?php foreach (array_unique(array_column($menuList, 'kategori')) as $k): ?>
                <option value="<?= htmlspecialchars($k) ?>">
              <?php endforeach; ?>
            </datalist>
          </div>
          <div>
            <label style="display:block;font-size:12px;color:var(--smoke);margin-bottom:6px;">Harga (Rp)</label>
            <input type="number" name="harga" required min="0" placeholder="10000">
          </div>
          <button class="btn btn-ember" type="submit">+ Tambah</button>
          <div style="grid-column:1 / -1;">
            <label style="display:block;font-size:12px;color:var(--smoke);margin-bottom:6px;">Foto Menu (opsional, JPG/PNG maks 3MB)</label>
            <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp">
          </div>
        </form>
      </div>

      <div class="panel">
        <h3>Daftar Menu (<?= count($menuList) ?> item)</h3>
        <table>
          <thead>
            <tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th></th></tr>
          </thead>
          <tbody>
            <?php foreach ($menuList as $m): ?>
              <tr>
                <td>
                  <?php if (!empty($m['gambar'])): ?>
                    <img src="assets/img/menu/<?= htmlspecialchars($m['gambar']) ?>" class="menu-thumb" alt="">
                  <?php else: ?>
                    <span class="menu-thumb-empty">🍢</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($m['nama']) ?><?php if ($m['best_seller']): ?> <span class="best-tag">FAVORIT</span><?php endif; ?></td>
                <td style="color:var(--smoke);font-size:13px;"><?= htmlspecialchars($m['kategori']) ?></td>
                <td class="mono"><?= rupiah($m['harga']) ?></td>
                <td>
                  <a class="rowbtn danger" href="hapus_menu.php?id=<?= $m['id'] ?>" data-confirm="Hapus menu <?= htmlspecialchars($m['nama']) ?>?">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
    <div style="height:40px;"></div>
  </section>
</main>

<?php require 'includes/footer.php'; ?>
