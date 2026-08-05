-- =========================================================
-- update_kepala_ayam.sql (revisi)
-- Yang berubah: PAHA AYAM -> KEPALA AYAM (bukan Kerongkongan)
-- Kerongkongan TIDAK disentuh, tetap seperti semula.
--
-- Jalankan via Command Prompt:
--   cd C:\xampp\htdocs\bekakak-ayam-mang-atang-php\bekakak-php
--   mysql -u root -p db_bekakak_ayam < update_kepala_ayam.sql
-- =========================================================

USE db_bekakak_ayam;

-- Jaga-jaga kalau revisi sebelumnya sempat kepasang duluan: kembalikan Kerongkongan
UPDATE menu
SET nama = 'Kerongkongan',
    gambar = 'kerongkongan.jpg'
WHERE nama = 'Kepala Ayam';

-- Update yang benar: Paha Ayam -> Kepala Ayam
UPDATE menu
SET nama = 'Kepala Ayam',
    gambar = 'kepala_ayam.jpg'
WHERE nama = 'Paha Ayam';
