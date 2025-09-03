-- SQL untuk menambahkan role ke database
-- Kantor Camat Waesama
-- Jalankan query ini di database untuk menambahkan role yang diperlukan

-- Hapus data role yang mungkin sudah ada (opsional)
-- DELETE FROM roles;

-- Insert role yang diperlukan
INSERT INTO roles (id, name, display_name, description, created_at, updated_at) VALUES
(1, 'Admin', 'Administrator', 'Administrator sistem dengan akses penuh ke semua fitur', NOW(), NOW()),
(2, 'Pegawai', 'Pegawai', 'Pegawai kantor camat yang dapat mengelola layanan masyarakat', NOW(), NOW()),
(3, 'Warga', 'Warga', 'Warga yang dapat mengakses layanan publik', NOW(), NOW());

-- Atau gunakan INSERT IGNORE untuk menghindari duplikasi
-- INSERT IGNORE INTO roles (name, display_name, description, created_at, updated_at) VALUES
-- ('Admin', 'Administrator', 'Administrator sistem dengan akses penuh ke semua fitur', NOW(), NOW()),
-- ('Pegawai', 'Pegawai', 'Pegawai kantor camat yang dapat mengelola layanan masyarakat', NOW(), NOW()),
-- ('Warga', 'Warga', 'Warga yang dapat mengakses layanan publik', NOW(), NOW());

-- Verifikasi data yang telah diinsert
SELECT * FROM roles;

-- Query untuk memeriksa apakah user sudah memiliki role
-- SELECT u.id, u.name, u.email, r.name as role_name, r.display_name 
-- FROM users u 
-- LEFT JOIN roles r ON u.role_id = r.id;

-- Jika ada user yang belum memiliki role, update dengan role default (Warga)
-- UPDATE users SET role_id = 3 WHERE role_id IS NULL;

-- Untuk memberikan role Admin ke user tertentu (ganti email sesuai kebutuhan)
-- UPDATE users SET role_id = 1 WHERE email = 'admin@kecamatangwaesama.id';

-- Untuk memberikan role Pegawai ke user tertentu
-- UPDATE users SET role_id = 2 WHERE email = 'pegawai@kecamatangwaesama.id';