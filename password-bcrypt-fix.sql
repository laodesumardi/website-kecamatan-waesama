-- =====================================================
-- PERBAIKAN PASSWORD BCRYPT UNTUK LARAVEL
-- =====================================================
-- File ini berisi hash password yang benar untuk Laravel
-- Password: "password" (untuk semua user)
-- Hash Bcrypt: $2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa

-- Jika Anda sudah menjalankan insert-admin-staf.sql dengan password lama,
-- gunakan query UPDATE berikut untuk memperbaiki password:

UPDATE users SET password = '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa' 
WHERE password = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

-- Atau update semua user dengan password yang sama:
UPDATE users SET password = '$2y$10$/LP2fR7cZrKQvasFL.CcUOrpIw1NF2NOB0gGTWKvPYc6BabSrFwIa';

-- Verifikasi perubahan:
SELECT id, name, email, password FROM users;

-- =====================================================
-- CARA MEMBUAT HASH PASSWORD BCRYPT BARU
-- =====================================================
-- Jika Anda ingin membuat password baru, gunakan perintah PHP berikut:
-- php -r "echo password_hash('password_baru', PASSWORD_BCRYPT);"

-- Contoh untuk password yang berbeda:
-- Password: admin123
-- php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"

-- Password: staff123  
-- php -r "echo password_hash('staff123', PASSWORD_BCRYPT);"

-- Password: warga123
-- php -r "echo password_hash('warga123', PASSWORD_BCRYPT);"

-- =====================================================
-- CATATAN PENTING
-- =====================================================
-- 1. Hash password akan berbeda setiap kali dibuat (karena salt random)
-- 2. Gunakan password yang kuat untuk production
-- 3. Ganti password default setelah login pertama
-- 4. File insert-admin-staf.sql dan fix-roles-complete.sql sudah diperbaiki