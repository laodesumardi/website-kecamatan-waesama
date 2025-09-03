-- ===================================
-- INSERT DATA ADMIN DAN STAF
-- Kantor Kecamatan Waesama
-- ===================================

-- Pastikan role sudah ada terlebih dahulu
-- Jalankan insert-roles.sql atau fix-roles-complete.sql sebelum file ini

-- ===================================
-- 1. INSERT USER ADMIN
-- ===================================
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
    'Administrator',
    'admin@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    1, -- Admin role
    '0000000000000000',
    'Kantor Kecamatan Waesama',
    '081234567890',
    NOW(),
    NOW()
) ON DUPLICATE KEY UPDATE
    role_id = 1,
    updated_at = NOW();

-- ===================================
-- 2. INSERT USER PEGAWAI/STAF
-- ===================================
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
-- Kepala Kecamatan
(
    'Kepala Kecamatan',
    'kecamatan@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2, -- Pegawai role
    '1111111111111111',
    'Kantor Kecamatan Waesama',
    '081234567891',
    NOW(),
    NOW()
),
-- Sekretaris Kecamatan
(
    'Sekretaris Kecamatan',
    'sekretaris@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2, -- Pegawai role
    '2222222222222222',
    'Kantor Kecamatan Waesama',
    '081234567892',
    NOW(),
    NOW()
),
-- Staf Pelayanan
(
    'Staf Pelayanan',
    'pelayanan@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2, -- Pegawai role
    '3333333333333333',
    'Kantor Kecamatan Waesama',
    '081234567893',
    NOW(),
    NOW()
),
-- Staf Administrasi
(
    'Staf Administrasi',
    'admin.staf@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2, -- Pegawai role
    '4444444444444444',
    'Kantor Kecamatan Waesama',
    '081234567894',
    NOW(),
    NOW()
),
-- Operator Sistem
(
    'Operator Sistem',
    'operator@kecamatangwaesama.id',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    2, -- Pegawai role
    '5555555555555555',
    'Kantor Kecamatan Waesama',
    '081234567895',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role_id = VALUES(role_id),
    updated_at = NOW();

-- ===================================
-- 3. INSERT USER WARGA CONTOH
-- ===================================
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
-- Warga Contoh 1
(
    'Warga Contoh 1',
    'warga1@example.com',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    3, -- Warga role
    '6666666666666666',
    'Desa Waesama',
    '081234567896',
    NOW(),
    NOW()
),
-- Warga Contoh 2
(
    'Warga Contoh 2',
    'warga2@example.com',
    NOW(),
    '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa', -- password: password
    3, -- Warga role
    '7777777777777777',
    'Desa Waesama',
    '081234567897',
    NOW(),
    NOW()
)
ON DUPLICATE KEY UPDATE
    role_id = VALUES(role_id),
    updated_at = NOW();

-- ===================================
-- 4. VERIFIKASI DATA
-- ===================================
-- Cek semua user yang telah dibuat
SELECT 
    u.id,
    u.name,
    u.email,
    r.name as role_name,
    u.nik,
    u.phone,
    u.created_at
FROM users u
LEFT JOIN roles r ON u.role_id = r.id
ORDER BY u.role_id, u.name;

-- Cek jumlah user per role
SELECT 
    r.name as role_name,
    COUNT(u.id) as total_users
FROM roles r
LEFT JOIN users u ON r.id = u.role_id
GROUP BY r.id, r.name
ORDER BY r.id;

-- ===================================
-- INFORMASI LOGIN
-- ===================================
/*
DATA LOGIN YANG TELAH DIBUAT:

1. ADMIN:
   Email: admin@kecamatangwaesama.id
   Password: password

2. PEGAWAI/STAF:
   - Kepala Kecamatan: kecamatan@kecamatangwaesama.id / password
   - Sekretaris: sekretaris@kecamatangwaesama.id / password
   - Staf Pelayanan: pelayanan@kecamatangwaesama.id / password
   - Staf Administrasi: admin.staf@kecamatangwaesama.id / password
   - Operator Sistem: operator@kecamatangwaesama.id / password

3. WARGA:
   - Warga 1: warga1@example.com / password
   - Warga 2: warga2@example.com / password

CATATAN:
- Semua password default adalah 'password'
- Disarankan untuk mengubah password setelah login pertama
- NIK yang digunakan adalah contoh, sesuaikan dengan data sebenarnya
*/