-- =========================================================
-- upgrade_multi_item.sql
-- Upgrade: 1 struk bisa berisi banyak menu sekaligus.
-- Data transaksi lama (tabel `transaksi`) otomatis dipindah
-- jadi 1 pesanan per baris lama, tidak hilang.
--
-- Jalankan via Command Prompt (posisi folder di bekakak-php):
--   "C:\xampp\mysql\bin\mysql.exe" -u root -p db_bekakak_ayam < upgrade_multi_item.sql
-- =========================================================

USE db_bekakak_ayam;

CREATE TABLE IF NOT EXISTS pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_struk VARCHAR(20) NOT NULL UNIQUE,
  total INT NOT NULL DEFAULT 0,
  waktu DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pesanan_detail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pesanan_id INT NOT NULL,
  menu_id INT NULL,
  nama_menu VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  subtotal INT NOT NULL,
  FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE,
  FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE SET NULL
);

-- Migrasi data transaksi lama (kalau tabel & datanya ada) jadi 1 pesanan per baris lama
INSERT IGNORE INTO pesanan (no_struk, total, waktu)
SELECT no_struk, subtotal, waktu FROM transaksi;

INSERT INTO pesanan_detail (pesanan_id, menu_id, nama_menu, harga, qty, subtotal)
SELECT p.id, t.menu_id, t.nama_menu, t.harga, t.qty, t.subtotal
FROM transaksi t
JOIN pesanan p ON p.no_struk = t.no_struk
WHERE NOT EXISTS (
  SELECT 1 FROM pesanan_detail pd WHERE pd.pesanan_id = p.id
);
