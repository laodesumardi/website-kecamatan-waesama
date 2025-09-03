-- ===================================
-- CREATE ROLES ONLY
-- Kantor Kecamatan Waesama
-- ===================================

-- Pastikan tabel roles sudah ada dari migration
-- php artisan migrate

-- ===================================
-- INSERT ROLES
-- ===================================
INSERT INTO roles (name, display_name, description, created_at, updated_at) 
VALUES 
('Admin', 'Administrator', 'Administrator sistem dengan akses penuh', NOW(), NOW()),
('Pegawai', 'Pegawai Kecamatan', 'Pegawai/staf kecamatan dengan akses terbatas', NOW(), NOW()),
('Warga', 'Warga', 'Warga/masyarakat dengan akses publik', NOW(), NOW())
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description),
    updated_at = NOW();

-- ===================================
-- VERIFIKASI ROLES
-- ===================================
SELECT * FROM roles ORDER BY id;

-- ===================================
-- INFORMASI
-- ===================================
/*
ROLE YANG TELAH DIBUAT:

1. Admin (ID: 1)
   - Administrator sistem
   - Akses penuh ke semua fitur

2. Pegawai (ID: 2)
   - Pegawai/staf kecamatan
   - Akses terbatas sesuai tugas

3. Warga (ID: 3)
   - Warga/masyarakat
   - Akses publik (pengajuan surat, antrian, pengaduan)

LANGKAH SELANJUTNYA:
1. Jalankan file ini terlebih dahulu
2. Kemudian jalankan insert-admin-staf.sql
*/