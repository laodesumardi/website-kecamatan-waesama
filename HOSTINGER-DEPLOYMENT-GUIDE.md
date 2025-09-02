# 🚀 Panduan Deployment ke Hostinger - Menimpa Project Lama

## 📋 Persiapan Sebelum Deployment

### 1. Persiapan File Production (✅ SUDAH SELESAI)
```bash
# Build assets untuk production
npm run build

# Cache konfigurasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimasi autoloader
composer dump-autoload --optimize
```

### 2. File yang Perlu Disiapkan
- ✅ Assets sudah di-build di `public/build/`
- ✅ Cache konfigurasi sudah dibuat
- 📁 Semua file project siap untuk upload

---

## 🔄 Langkah-Langkah Deployment

### STEP 1: Backup Project Lama di Hostinger

#### A. Backup Database
1. **Login ke cPanel Hostinger**
2. **Buka phpMyAdmin**
3. **Pilih database yang akan ditimpa**
4. **Klik tab "Export"**
5. **Pilih "Quick" export method**
6. **Klik "Go" untuk download backup**
7. **Simpan file backup dengan nama: `backup_database_[tanggal].sql`**

#### B. Backup File Project
1. **Buka File Manager di cPanel**
2. **Masuk ke folder `public_html`**
3. **Select All files (Ctrl+A)**
4. **Klik "Compress" → "Create Archive"**
5. **Beri nama: `backup_project_[tanggal].zip`**
6. **Download backup ke komputer**

### STEP 2: Hapus File Lama

1. **Di File Manager, masuk ke `public_html`**
2. **Select All files (Ctrl+A)**
3. **Klik "Delete" untuk menghapus semua file lama**
4. **Konfirmasi penghapusan**

### STEP 3: Upload Project Baru

#### A. Compress Project Lokal
1. **Di komputer, buka folder project: `d:\laragon\www\kantor-camat-waesama`**
2. **Select semua file dan folder KECUALI:**
   - `node_modules/`
   - `.git/`
   - `.env` (akan dibuat manual)
   - `storage/logs/*.log`
3. **Compress menjadi ZIP**

#### B. Upload ke Hostinger
1. **Di File Manager cPanel, masuk ke `public_html`**
2. **Klik "Upload"**
3. **Upload file ZIP project**
4. **Setelah upload selesai, klik "Extract"**
5. **Hapus file ZIP setelah extract**

### STEP 4: Konfigurasi Database

#### A. Buat Database Baru (Opsional)
1. **Di cPanel, buka "MySQL Databases"**
2. **Buat database baru atau gunakan yang lama**
3. **Catat nama database, username, dan password**

#### B. Import Database
1. **Buka phpMyAdmin**
2. **Pilih database yang akan digunakan**
3. **Klik tab "Import"**
4. **Upload file SQL dari project: `database-migration-complete.sql`**
5. **Klik "Go" untuk import**

### STEP 5: Konfigurasi Environment (.env)

1. **Di File Manager, buka folder project**
2. **Copy file `.env.example` menjadi `.env`**
3. **Edit file `.env` dengan konfigurasi production:**

```env
APP_NAME="Kantor Camat Waesama"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY
APP_DEBUG=false
APP_TIMEZONE=Asia/Makassar
APP_URL=https://yourdomain.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@yourdomain.com
MAIL_FROM_NAME="Kantor Camat Waesama"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

### STEP 6: Generate Application Key

1. **Di cPanel, buka "Terminal" atau gunakan SSH**
2. **Masuk ke folder project:**
```bash
cd public_html
```
3. **Generate application key:**
```bash
php artisan key:generate
```

### STEP 7: Set Permissions

```bash
# Set permission untuk storage
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Set ownership (jika diperlukan)
chown -R username:username storage/
chown -R username:username bootstrap/cache/
```

### STEP 8: Clear Cache dan Migrate

```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Jalankan migrasi (jika belum)
php artisan migrate --force

# Seed data (jika diperlukan)
php artisan db:seed --force

# Cache ulang untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔧 Konfigurasi Server (Hostinger)

### A. Document Root
Pastikan document root mengarah ke folder `public` dari Laravel:
- **Jika menggunakan subdomain:** `/public_html/subdomain/public`
- **Jika menggunakan domain utama:** Pindahkan isi folder `public` ke `public_html`

### B. PHP Version
1. **Di cPanel, buka "PHP Configuration"**
2. **Pilih PHP 8.1 atau 8.2**
3. **Enable extensions yang diperlukan:**
   - `mbstring`
   - `openssl`
   - `pdo`
   - `tokenizer`
   - `xml`
   - `ctype`
   - `json`
   - `bcmath`
   - `fileinfo`
   - `gd`

### C. .htaccess Configuration
Pastikan file `.htaccess` di folder `public` berisi:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## ✅ Testing Deployment

### 1. Test Halaman Utama
- Buka `https://yourdomain.com`
- Pastikan halaman welcome tampil dengan benar
- Check responsive design di mobile

### 2. Test Authentication
- Test login/register
- Test forgot password
- Test dashboard access

### 3. Test Fitur Utama
- **Admin:** Test CRUD penduduk, surat, berita
- **Pegawai:** Test layanan surat, antrian
- **Warga:** Test pengajuan surat, pengaduan

### 4. Test Upload Files
- Test upload foto berita
- Test import Excel penduduk
- Test generate PDF surat

### 5. Test Notifications
- Test real-time notifications
- Test email notifications

---

## 🚨 Troubleshooting

### Error 500 - Internal Server Error
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear

# Check permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Database Connection Error
1. **Check .env database credentials**
2. **Test database connection di phpMyAdmin**
3. **Pastikan database sudah di-import**

### Assets Not Loading
1. **Check APP_URL di .env**
2. **Pastikan folder public/build/ ada**
3. **Run `npm run build` ulang jika perlu**

### Permission Denied
```bash
# Set correct permissions
find storage/ -type f -exec chmod 664 {} \;
find storage/ -type d -exec chmod 775 {} \;
find bootstrap/cache/ -type f -exec chmod 664 {} \;
find bootstrap/cache/ -type d -exec chmod 775 {} \;
```

---

## 📞 Support

Jika mengalami masalah:
1. **Check error logs:** `storage/logs/laravel.log`
2. **Check server error logs di cPanel**
3. **Pastikan semua requirements PHP terpenuhi**
4. **Test di local environment dulu**

---

## 🎉 Selamat!

Project **Sistem Informasi Kantor Camat Waesama** sudah berhasil di-deploy ke Hostinger!

**URL Akses:**
- **Public:** `https://yourdomain.com`
- **Admin Login:** `https://yourdomain.com/login`

**Default Admin Account:**
- **Email:** `admin@waesama.com`
- **Password:** `password123`

**Jangan lupa ganti password default setelah login pertama!**