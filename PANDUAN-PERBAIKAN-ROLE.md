# PANDUAN PERBAIKAN ROLE - KANTOR CAMAT WAESAMA

## 🚨 MASALAH: "Role tidak ditemukan. Silakan hubungi administrator."

### Penyebab Masalah:
- Tabel `roles` kosong atau tidak memiliki data
- User tidak memiliki `role_id` yang valid
- Migrasi role belum dijalankan

---

## 🔧 SOLUSI CEPAT

### Opsi 1: Menggunakan SQL Langsung (Tercepat)

1. **Buka phpMyAdmin atau database manager**
2. **Pilih database aplikasi**
3. **Jalankan SQL berikut:**

```sql
-- Insert role yang diperlukan
INSERT INTO roles (name, display_name, description, created_at, updated_at) VALUES
('Admin', 'Administrator', 'Administrator sistem dengan akses penuh ke semua fitur', NOW(), NOW()),
('Pegawai', 'Pegawai', 'Pegawai kantor camat yang dapat mengelola layanan masyarakat', NOW(), NOW()),
('Warga', 'Warga', 'Warga yang dapat mengakses layanan publik', NOW(), NOW());
```

4. **Update user yang belum memiliki role:**

```sql
-- Berikan role Warga sebagai default untuk semua user
UPDATE users SET role_id = 3 WHERE role_id IS NULL;

-- Berikan role Admin ke user pertama (opsional)
UPDATE users SET role_id = 1 WHERE id = 1;
```

### Opsi 2: Menggunakan Laravel Artisan

```bash
# Jalankan seeder role
php artisan db:seed --class=RoleSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

### Opsi 3: Menggunakan File SQL yang Disediakan

#### File SQL yang Tersedia:
1. **`insert-roles.sql`** - Insert role dasar (Admin, Pegawai, Warga)
2. **`insert-admin-staf.sql`** - Insert data admin dan staf lengkap
3. **`fix-roles-complete.sql`** - Perbaikan komprehensif role dan user

#### Import Lengkap dengan Data Admin/Staf:
1. **Upload file `insert-roles.sql` dan `insert-admin-staf.sql` ke server**
2. **Import melalui phpMyAdmin atau command line:**

```bash
# Via command line - import role terlebih dahulu
mysql -u username -p database_name < insert-roles.sql
# Kemudian import admin dan staf
mysql -u username -p database_name < insert-admin-staf.sql
```

---

## 📋 VERIFIKASI PERBAIKAN

### 1. Periksa Data Role

```sql
SELECT * FROM roles;
```

**Hasil yang diharapkan:**
```
id | name    | display_name  | description
1  | Admin   | Administrator | Administrator sistem...
2  | Pegawai | Pegawai      | Pegawai kantor camat...
3  | Warga   | Warga        | Warga yang dapat...
```

### 2. Periksa User dan Role

```sql
SELECT u.id, u.name, u.email, r.name as role_name, r.display_name 
FROM users u 
LEFT JOIN roles r ON u.role_id = r.id;
```

### 3. Test Login

1. **Buka website**
2. **Coba login dengan akun yang ada**
3. **Pastikan tidak ada error "Role tidak ditemukan"**

---

## 🛠️ TROUBLESHOOTING

### Jika Masih Error Setelah Insert Role:

#### 1. Periksa Struktur Tabel

```sql
DESCRIBE roles;
DESCRIBE users;
```

#### 2. Periksa Foreign Key

```sql
-- Pastikan kolom role_id ada di tabel users
SHOW COLUMNS FROM users LIKE 'role_id';
```

#### 3. Reset Role untuk Semua User

```sql
-- Berikan role default ke semua user
UPDATE users SET role_id = 3; -- 3 = Warga
```

#### 4. Buat User Admin Baru

```sql
-- Insert user admin baru
INSERT INTO users (name, email, email_verified_at, password, role_id, created_at, updated_at) 
VALUES (
    'Administrator', 
    'admin@kecamatangwaesama.id', 
    NOW(), 
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    1, 
    NOW(), 
    NOW()
);
```

**Login dengan:**
- Email: `admin@kecamatangwaesama.id`
- Password: `password`

---

## 🚀 DEPLOYMENT KE SERVER PRODUCTION

### Via PuTTY/SSH:

```bash
# 1. Login ke server
ssh username@server

# 2. Masuk ke direktori website
cd ~/public_html
# atau
cd /var/www/html

# 3. Jalankan seeder
php artisan db:seed --class=RoleSeeder

# 4. Clear cache
php artisan config:clear
php artisan cache:clear
```

### Via phpMyAdmin:

1. **Login ke cPanel/hosting panel**
2. **Buka phpMyAdmin**
3. **Pilih database**
4. **Klik tab "SQL"**
5. **Copy-paste SQL dari file `insert-roles.sql`**
6. **Klik "Go" untuk eksekusi**

---

## 📝 CATATAN PENTING

### Role yang Tersedia:

1. **Admin (ID: 1)**
   - Akses penuh ke semua fitur
   - Dapat mengelola user, role, dan sistem

2. **Pegawai (ID: 2)**
   - Dapat mengelola layanan masyarakat
   - Akses ke fitur operasional

3. **Warga (ID: 3)**
   - Akses ke layanan publik
   - Dapat mengajukan surat, antrian, pengaduan

### Data Login yang Tersedia:

Setelah menjalankan `insert-admin-staf.sql`:

#### 1. ADMIN
- **Email:** admin@kecamatangwaesama.id
- **Password:** password
- **Role:** Admin (akses penuh sistem)

#### 2. PEGAWAI/STAF
- **Kepala Kecamatan:** kecamatan@kecamatangwaesama.id / password
- **Sekretaris:** sekretaris@kecamatangwaesama.id / password
- **Staf Pelayanan:** pelayanan@kecamatangwaesama.id / password
- **Staf Administrasi:** admin.staf@kecamatangwaesama.id / password
- **Operator Sistem:** operator@kecamatangwaesama.id / password

#### 3. WARGA CONTOH
- **Warga 1:** warga1@example.com / password
- **Warga 2:** warga2@example.com / password

> **⚠️ PENTING:** Semua password default adalah 'password'. Disarankan untuk mengubah password setelah login pertama.

### Default Assignment:
- User baru otomatis mendapat role "Warga"
- Admin harus assign role secara manual untuk Pegawai

---

## 🆘 BANTUAN DARURAT

### Jika Semua Solusi Gagal:

1. **Backup database terlebih dahulu**
2. **Jalankan migrasi ulang:**

```bash
php artisan migrate:fresh --seed
```

⚠️ **PERINGATAN:** Ini akan menghapus semua data!

3. **Atau hubungi developer untuk bantuan lebih lanjut**

---

## 📞 KONTAK SUPPORT

- **Developer:** [Nama Developer]
- **Email:** [email@domain.com]
- **WhatsApp:** [Nomor WhatsApp]

---

**© 2024 Kantor Camat Waesama - Role Management Guide**