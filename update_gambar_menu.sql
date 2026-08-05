-- =========================================================
-- update_gambar_menu.sql
-- Jalankan file ini SETELAH database.sql (via Command Prompt):
--   mysql -u root -p db_bekakak_ayam < update_gambar_menu.sql
-- =========================================================

USE db_bekakak_ayam;

ALTER TABLE menu ADD COLUMN IF NOT EXISTS gambar VARCHAR(255) DEFAULT NULL;

UPDATE menu SET gambar = 'ayam_bakar.jpg'      WHERE nama = 'Ayam Bakar';
UPDATE menu SET gambar = 'ayam_kremes.jpg'     WHERE nama = 'Ayam Kremes';
UPDATE menu SET gambar = 'nila_bakar.jpg'      WHERE nama = 'Nila Bakar';
UPDATE menu SET gambar = 'nila_kremes.jpg'     WHERE nama = 'Nila Kremes';
UPDATE menu SET gambar = 'lele_bakar.jpg'      WHERE nama = 'Lele Bakar';
UPDATE menu SET gambar = 'lele_kremes.jpg'     WHERE nama = 'Lele Kremes';
UPDATE menu SET gambar = 'kerongkongan.jpg'    WHERE nama = 'Kerongkongan';
-- Paha Ayam sengaja dikosongkan dulu (foto lama pakai watermark iStock, ganti foto asli nanti)
UPDATE menu SET gambar = 'ati_ampela.jpg'      WHERE nama = 'Ati Ampela';
UPDATE menu SET gambar = 'kulit_ayam.jpg'      WHERE nama = 'Kulit Ayam';
UPDATE menu SET gambar = 'tahu.jpg'            WHERE nama = 'Tahu';
UPDATE menu SET gambar = 'tempe.jpg'           WHERE nama = 'Tempe';
UPDATE menu SET gambar = 'sayur_asem.jpg'      WHERE nama = 'Sayur Asem';
UPDATE menu SET gambar = 'sayur_lodeh.jpg'     WHERE nama = 'Sayur Lodeh';
UPDATE menu SET gambar = 'tumis_kangkung.jpg'  WHERE nama = 'Tumis Kangkung';
