-- =========================================================
-- database.sql
-- Bekakak Ayam Mang Atang — Skrip pembuatan database
-- Cara pakai (lihat README.md untuk detail lengkap):
--   mysql -u root -p < database.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_bekakak_ayam
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE db_bekakak_ayam;

-- ---------------------------------------------------------
-- Tabel admin (untuk login halaman Laporan)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun default -> username: admin | password: admin123
-- (hash bcrypt di bawah ini valid untuk password_verify() di PHP)
-- SEGERA GANTI password ini setelah login pertama kali!
INSERT INTO admin (username, password) VALUES
('admin', '$2b$12$iMk536RK.Q7Z6TCAqp.tJuSDqaPNVMEVrbs3.XksiuUdSe6iW4e9O')
ON DUPLICATE KEY UPDATE username = username;

-- ---------------------------------------------------------
-- Tabel menu (daftar harga)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori VARCHAR(50) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  best_seller TINYINT(1) NOT NULL DEFAULT 0,
  urutan INT NOT NULL DEFAULT 0
);

INSERT INTO menu (kategori, nama, harga, best_seller, urutan) VALUES
('Bakar & Kremes', 'Ayam Bakar', 16000, 1, 1),
('Bakar & Kremes', 'Ayam Kremes', 16000, 1, 2),
('Bakar & Kremes', 'Nila Bakar', 20000, 0, 3),
('Bakar & Kremes', 'Nila Kremes', 20000, 0, 4),
('Bakar & Kremes', 'Lele Bakar', 12000, 0, 5),
('Bakar & Kremes', 'Lele Kremes', 12000, 0, 6),
('Jeroan & Pelengkap', 'Kerongkongan', 10000, 0, 7),
('Jeroan & Pelengkap', 'Paha Ayam', 7000, 0, 8),
('Jeroan & Pelengkap', 'Ati Ampela', 5000, 0, 9),
('Jeroan & Pelengkap', 'Kulit Ayam', 4000, 0, 10),
('Sayur & Gorengan', 'Tahu', 2000, 0, 11),
('Sayur & Gorengan', 'Tempe', 1000, 0, 12),
('Sayur & Gorengan', 'Sayur Asem', 5000, 0, 13),
('Sayur & Gorengan', 'Sayur Lodeh', 5000, 0, 14),
('Sayur & Gorengan', 'Tumis Kangkung', 7000, 0, 15);

-- ---------------------------------------------------------
-- Tabel transaksi (laporan & billing)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_struk VARCHAR(20) NOT NULL UNIQUE,
  menu_id INT NOT NULL,
  nama_menu VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  subtotal INT NOT NULL,
  waktu DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (menu_id) REFERENCES menu(id)
);
