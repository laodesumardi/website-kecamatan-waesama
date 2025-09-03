-- =====================================================
-- SCRIPT PERBAIKAN ROLE LENGKAP
-- Kantor Camat Waesama
-- =====================================================

-- 1. PERIKSA STATUS TABEL DAN DATA
-- =====================================================

-- Periksa apakah tabel roles ada
SHOW TABLES LIKE 'roles';

-- Periksa struktur tabel roles
DESCRIBE roles;

-- Periksa data role yang ada
SELECT * FROM roles;

-- Periksa struktur tabel users
DESCRIBE users;

-- Periksa user dan role mereka
SELECT u.id, u.name, u.email, u.role_id, r.name as role_name, r.display_name 
FROM users u 
LEFT JOIN roles r ON u.role_id = r.id 
ORDER BY u.id;

-- =====================================================
-- 2. PERBAIKAN DATA ROLE
-- =====================================================

-- Hapus data role yang mungkin corrupt (HATI-HATI!)
-- DELETE FROM roles;

-- Insert role yang diperlukan dengan ID spesifik
INSERT INTO roles (id, name, display_name, description, created_at, updated_at) VALUES
(1, 'Admin', 'Administrator', 'Administrator sistem dengan akses penuh ke semua fitur', NOW(), NOW()),
(2, 'Pegawai', 'Pegawai', 'Pegawai kantor camat yang dapat mengelola layanan masyarakat', NOW(), NOW()),
(3, 'Warga', 'Warga', 'Warga yang dapat mengakses layanan publik', NOW(), NOW())
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    description = VALUES(description),
    updated_at = NOW();

-- Atau gunakan INSERT IGNORE untuk menghindari error duplikasi
-- INSERT IGNORE INTO roles (name, display_name, description, created_at, updated_at) VALUES
-- ('Admin', 'Administrator', 'Administrator sistem dengan akses penuh ke semua fitur', NOW(), NOW()),
-- ('Pegawai', 'Pegawai', 'Pegawai kantor camat yang dapat mengelola layanan masyarakat', NOW(), NOW()),
-- ('Warga', 'Warga', 'Warga yang dapat mengakses layanan publik', NOW(), NOW());

-- =====================================================
-- 3. PERBAIKAN USER ROLE ASSIGNMENT
-- =====================================================

-- Update user yang tidak memiliki role (NULL) menjadi Warga
UPDATE users 
SET role_id = 3, updated_at = NOW() 
WHERE role_id IS NULL;

-- Update user yang memiliki role_id tidak valid
UPDATE users 
SET role_id = 3, updated_at = NOW() 
WHERE role_id NOT IN (1, 2, 3);

-- =====================================================
-- 4. BUAT USER ADMIN DAN STAF DEFAULT
-- =====================================================

-- Cek apakah sudah ada user dengan role Admin
SELECT COUNT(*) as admin_count FROM users WHERE role_id = 1;

-- User Admin Default
INSERT INTO users (
    name, 
    email, 
    email_verified_at, 
    password, 
    role_id, 
    nik,
    address,
    phone,
    created_at, 
    updated_at
) VALUES (
    'Administrator Sistem', 
    'admin@kecamatangwaesama.id', 
    NOW(), 
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password 
    1,
    '0000000000000000',
    'Kantor Kecamatan Waesama',
    '081234567890',
    NOW(), 
    NOW()
) ON DUPLICATE KEY UPDATE
    role_id = 1,
    updated_at = NOW();

-- User Pegawai/Staf Default
INSERT INTO users (
    name, 
    email, 
    email_verified_at, 
    password, 
    role_id,
    nik,
    address,
    phone,
    created_at, 
    updated_at
) VALUES 
(
    'Kepala Kecamatan',
    'kecamatan@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2,
    '1111111111111111',
    'Kantor Kecamatan Waesama',
    '081234567891',
    NOW(),
    NOW()
),
(
    'Sekretaris Kecamatan',
    'sekretaris@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2,
    '2222222222222222',
    'Kantor Kecamatan Waesama',
    '081234567892',
    NOW(),
    NOW()
),
(
    'Staf Pelayanan',
    'pelayanan@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2,
    '3333333333333333',
    'Kantor Kecamatan Waesama',
    '081234567893',
    NOW(),
    NOW()
),
(
    'Staf Administrasi',
    'admin.staf@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2,
    '4444444444444444',
    'Kantor Kecamatan Waesama',
    '081234567894',
    NOW(),
    NOW()
),
(
    'Operator Sistem',
    'operator@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2,
    '5555555555555555',
    'Kantor Kecamatan Waesama',
    '081234567895',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role_id = VALUES(role_id),
    updated_at = NOW();

-- User Warga Contoh
INSERT INTO users (
    name, 
    email, 
    email_verified_at, 
    password, 
    role_id,
    nik,
    address,
    phone,
    created_at, 
    updated_at
) VALUES 
(
    'Warga Contoh 1',
    'warga1@example.com',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    3,
    '7301010101010001',
    'Desa Waesama, Kec. Waesama',
    '081234567896',
    NOW(),
    NOW()
),
(
    'Warga Contoh 2',
    'warga2@example.com',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    3,
    '7301010101010002',
    'Desa Waesama, Kec. Waesama',
    '081234567897',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role_id = VALUES(role_id),
    updated_at = NOW();

-- Atau update user pertama menjadi admin
-- UPDATE users SET role_id = 1, updated_at = NOW() WHERE id = 1;

-- =====================================================
-- 5. VERIFIKASI HASIL PERBAIKAN
-- =====================================================

-- Tampilkan semua role
SELECT 
    id,
    name,
    display_name,
    description,
    created_at,
    updated_at
FROM roles 
ORDER BY id;

-- Tampilkan user dengan role mereka
SELECT 
    u.id,
    u.name,
    u.email,
    u.role_id,
    r.name as role_name,
    r.display_name as role_display_name,
    u.created_at
FROM users u 
LEFT JOIN roles r ON u.role_id = r.id 
ORDER BY u.id;

-- Hitung jumlah user per role
SELECT 
    r.name as role_name,
    r.display_name,
    COUNT(u.id) as user_count
FROM roles r 
LEFT JOIN users u ON r.id = u.role_id 
GROUP BY r.id, r.name, r.display_name
ORDER BY r.id;

-- Cek user yang masih tidak memiliki role valid
SELECT 
    u.id,
    u.name,
    u.email,
    u.role_id
FROM users u 
LEFT JOIN roles r ON u.role_id = r.id 
WHERE r.id IS NULL;

-- =====================================================
-- 6. QUERY MAINTENANCE (GUNAKAN JIKA DIPERLUKAN)
-- =====================================================

-- Reset auto increment untuk tabel roles
-- ALTER TABLE roles AUTO_INCREMENT = 4;

-- Tambah constraint foreign key jika belum ada
-- ALTER TABLE users 
-- ADD CONSTRAINT fk_users_role_id 
-- FOREIGN KEY (role_id) REFERENCES roles(id) 
-- ON DELETE SET NULL ON UPDATE CASCADE;

-- Update role untuk user spesifik berdasarkan email
-- UPDATE users SET role_id = 1 WHERE email = 'admin@kecamatangwaesama.id';
-- UPDATE users SET role_id = 2 WHERE email LIKE '%pegawai%';
-- UPDATE users SET role_id = 3 WHERE role_id IS NULL OR role_id NOT IN (1,2);

-- =====================================================
-- 7. BACKUP DAN RESTORE (EMERGENCY)
-- =====================================================

-- Backup data role (jalankan sebelum perubahan besar)
-- CREATE TABLE roles_backup AS SELECT * FROM roles;
-- CREATE TABLE users_backup AS SELECT * FROM users;

-- Restore dari backup (jika diperlukan)
-- DROP TABLE roles;
-- CREATE TABLE roles AS SELECT * FROM roles_backup;
-- DROP TABLE users;
-- CREATE TABLE users AS SELECT * FROM users_backup;

-- =====================================================
-- SELESAI - SCRIPT PERBAIKAN ROLE
-- =====================================================

-- Pesan konfirmasi
SELECT 'Perbaikan role selesai! Silakan test login aplikasi.' as status;

-- Tampilkan ringkasan
SELECT 
    (SELECT COUNT(*) FROM roles) as total_roles,
    (SELECT COUNT(*) FROM users) as total_users,
    (SELECT COUNT(*) FROM users WHERE role_id = 1) as admin_users,
    (SELECT COUNT(*) FROM users WHERE role_id = 2) as pegawai_users,
    (SELECT COUNT(*) FROM users WHERE role_id = 3) as warga_users,
    (SELECT COUNT(*) FROM users WHERE role_id IS NULL) as users_without_role;