# 👥 Panduan Setup Admin dan Staf
**Kantor Kecamatan Waesama**

## 📋 Daftar Isi
- [Persiapan](#persiapan)
- [Cara Import Data](#cara-import-data)
- [Data Login](#data-login)
- [Verifikasi](#verifikasi)
- [Troubleshooting](#troubleshooting)

---

## 🚀 Persiapan

### File yang Diperlukan:
1. **`insert-roles.sql`** - Role dasar (Admin, Pegawai, Warga)
2. **`insert-admin-staf.sql`** - Data admin dan staf lengkap

### Persyaratan:
- Database MySQL/MariaDB sudah berjalan
- Tabel `roles` dan `users` sudah ada (dari migration)
- Akses ke phpMyAdmin atau MySQL command line

---

## 📥 Cara Import Data

### Metode 1: Via phpMyAdmin (Recommended)

#### Langkah 1: Import Role
1. Login ke **phpMyAdmin**
2. Pilih **database aplikasi**
3. Klik tab **"SQL"**
4. Copy-paste isi file `insert-roles.sql`
5. Klik **"Go"**
6. Pastikan muncul pesan sukses

#### Langkah 2: Import Admin & Staf
1. Masih di tab **"SQL"**
2. Copy-paste isi file `insert-admin-staf.sql`
3. Klik **"Go"**
4. Pastikan muncul pesan sukses

### Metode 2: Via MySQL Command Line

```bash
# Masuk ke MySQL
mysql -u username -p

# Pilih database
USE nama_database;

# Import role
source /path/to/insert-roles.sql;

# Import admin dan staf
source /path/to/insert-admin-staf.sql;
```

### Metode 3: Via Laravel Artisan

```bash
# Import role
php artisan db:seed --class=RoleSeeder

# Import user (jika ada UserSeeder)
php artisan db:seed --class=UserSeeder
```

---

## 🔑 Data Login

### 1. ADMINISTRATOR
```
Email: admin@kecamatangwaesama.id
Password: password
Role: Admin
Akses: Penuh (semua fitur)
```

### 2. PEGAWAI/STAF

#### Kepala Kecamatan
```
Email: kecamatan@kecamatangwaesama.id
Password: password
Role: Pegawai
```

#### Sekretaris Kecamatan
```
Email: sekretaris@kecamatangwaesama.id
Password: password
Role: Pegawai
```

#### Staf Pelayanan
```
Email: pelayanan@kecamatangwaesama.id
Password: password
Role: Pegawai
```

#### Staf Administrasi
```
Email: admin.staf@kecamatangwaesama.id
Password: password
Role: Pegawai
```

#### Operator Sistem
```
Email: operator@kecamatangwaesama.id
Password: password
Role: Pegawai
```

### 3. WARGA CONTOH

#### Warga 1
```
Email: warga1@example.com
Password: password
Role: Warga
```

#### Warga 2
```
Email: warga2@example.com
Password: password
Role: Warga
```

---

## ✅ Verifikasi

### 1. Cek Data di Database

```sql
-- Cek semua user dan role
SELECT 
    u.id,
    u.name,
    u.email,
    r.name as role_name,
    u.created_at
FROM users u
LEFT JOIN roles r ON u.role_id = r.id
ORDER BY u.role_id, u.name;
```

### 2. Cek Jumlah User per Role

```sql
SELECT 
    r.name as role_name,
    COUNT(u.id) as total_users
FROM roles r
LEFT JOIN users u ON r.id = u.role_id
GROUP BY r.id, r.name
ORDER BY r.id;
```

### 3. Test Login

1. **Buka aplikasi di browser**
2. **Klik "Login"**
3. **Test dengan akun admin:**
   - Email: `admin@kecamatangwaesama.id`
   - Password: `password`
4. **Pastikan berhasil login dan dapat akses dashboard**

---

## 🔧 Troubleshooting

### Error: "Duplicate entry for key 'users_email_unique'"
**Solusi:**
```sql
-- Hapus user yang duplikat
DELETE FROM users WHERE email = 'admin@kecamatangwaesama.id';
-- Kemudian jalankan ulang insert-admin-staf.sql
```

### Error: "Role tidak ditemukan"
**Solusi:**
1. Pastikan `insert-roles.sql` sudah dijalankan terlebih dahulu
2. Cek tabel roles:
```sql
SELECT * FROM roles;
```

### Error: "Cannot add foreign key constraint"
**Solusi:**
```sql
-- Nonaktifkan foreign key check sementara
SET FOREIGN_KEY_CHECKS = 0;
-- Jalankan insert
source insert-admin-staf.sql;
-- Aktifkan kembali
SET FOREIGN_KEY_CHECKS = 1;
```

### Login Gagal
**Cek:**
1. Email dan password benar
2. User ada di database
3. Role_id tidak NULL
4. Email sudah verified (email_verified_at tidak NULL)

---

## 🔒 Keamanan

### ⚠️ PENTING - Ubah Password Default!

1. **Login dengan akun admin**
2. **Masuk ke Profile/Settings**
3. **Ubah password dari 'password' ke password yang kuat**
4. **Lakukan hal yang sama untuk semua akun staf**

### Rekomendasi Password:
- Minimal 8 karakter
- Kombinasi huruf besar, kecil, angka, dan simbol
- Tidak menggunakan informasi pribadi
- Unik untuk setiap akun

---

## 📞 Bantuan

### Jika Masih Bermasalah:

1. **Cek log error:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Reset semua data:**
   ```sql
   -- Hapus semua user
   DELETE FROM users;
   -- Hapus semua role
   DELETE FROM roles;
   -- Jalankan ulang kedua file SQL
   ```

3. **Hubungi developer** dengan informasi:
   - Error message lengkap
   - Screenshot jika ada
   - Langkah yang sudah dicoba

---

## 📝 Catatan

- **NIK yang digunakan adalah contoh**, sesuaikan dengan data sebenarnya
- **Email domain @kecamatangwaesama.id** bisa disesuaikan
- **Data warga contoh** bisa dihapus jika tidak diperlukan
- **Backup database** sebelum melakukan import

---

**© 2025 Kantor Kecamatan Waesama**