# Panduan Upload Manual Project ke Server

## Persiapan File untuk Upload

### 1. File yang HARUS diupload:
```
- Semua folder dan file project KECUALI:
  - node_modules/
  - vendor/ (akan diinstall ulang di server)
  - .env (buat baru di server)
  - storage/logs/* (file log lama)
  - storage/framework/cache/*
  - storage/framework/sessions/*
  - storage/framework/views/*
```

### 2. Struktur Upload ke Server:
```
public_html/
├── .htaccess (dari root project)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── public/ (isi folder ini pindah ke root public_html)
├── artisan
├── composer.json
├── composer.lock
└── package.json
```

## Langkah-langkah Upload Manual

### Step 1: Persiapan File Lokal
1. Buat folder backup lokal
2. Copy semua file project kecuali yang dikecualikan di atas
3. Pastikan file .htaccess root sudah ada

### Step 2: Upload via Control Panel/FTP
1. **Login ke Control Panel Hosting**
2. **Masuk ke File Manager**
3. **Navigasi ke folder public_html**
4. **Backup file lama** (jika ada):
   - Rename folder lama menjadi `backup_[tanggal]`

### Step 3: Upload File Project
1. **Upload file .htaccess** ke root public_html
2. **Upload folder app, bootstrap, config, database, resources, routes, storage**
3. **Upload file artisan, composer.json, composer.lock, package.json**
4. **Upload isi folder public/** langsung ke root public_html:
   - .htaccess (dari folder public)
   - css/
   - js/
   - favicon.svg
   - robots.txt
   - webhook.php
5. **Upload file index-root.php dan rename menjadi index.php** di root public_html
   - File ini sudah disesuaikan untuk deployment di root directory
   - Menggantikan index.php dari folder public yang path-nya berbeda

### Step 4: Konfigurasi Environment
1. **Buat file .env** di root public_html:
```env
APP_NAME="Kantor Camat Waesama"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://kecamatangwaesama.id

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Step 5: Install Dependencies (via Terminal/SSH)
Jika ada akses SSH:
```bash
cd /path/to/public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Step 6: Konfigurasi Database
1. **Import database** (jika belum ada)
2. **Update konfigurasi database** di .env
3. **Test koneksi database**

### Step 7: Set Permissions
```bash
chmod 644 .htaccess
chmod 644 index.php
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

## Troubleshooting Upload Manual

### Masalah 1: 403 Forbidden
**Solusi:**
1. Pastikan file index.php ada di root public_html
2. Cek permissions folder (755) dan file (644)
3. Pastikan .htaccess tidak memblokir akses

### Masalah 2: 500 Internal Server Error
**Solusi:**
1. Cek file .env sudah benar
2. Pastikan APP_KEY sudah di-generate
3. Cek log error di control panel
4. Pastikan composer dependencies terinstall

### Masalah 3: Route Not Found
**Solusi:**
1. Clear cache: `php artisan cache:clear`
2. Clear route cache: `php artisan route:clear`
3. Clear config cache: `php artisan config:clear`
4. Clear view cache: `php artisan view:clear`

### Masalah 4: Database Connection Error
**Solusi:**
1. Cek konfigurasi database di .env
2. Pastikan database sudah dibuat
3. Test koneksi database dari control panel

## Checklist Setelah Upload

- [ ] File .htaccess ada di root public_html
- [ ] File index.php ada di root public_html
- [ ] File .env sudah dikonfigurasi
- [ ] Database sudah diimport dan terkonfigurasi
- [ ] Permissions folder storage dan bootstrap/cache sudah benar
- [ ] Composer dependencies sudah terinstall
- [ ] Cache sudah di-clear
- [ ] Website bisa diakses tanpa error

## Kontak Support
Jika masih ada masalah setelah mengikuti panduan ini, hubungi support hosting dengan informasi:
1. Error message yang muncul
2. Langkah yang sudah dilakukan
3. Screenshot error (jika ada)

---
**Catatan:** Panduan ini dibuat khusus untuk deployment manual tanpa menggunakan Git/GitHub.