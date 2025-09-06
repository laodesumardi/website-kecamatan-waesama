# Troubleshooting Guide - Laravel Hosting Errors

## Error 419 - Page Expired (CSRF Token Mismatch)

### Masalah
Error 419 Page Expired terjadi ketika CSRF token tidak valid atau expired:
```
419
Page Expired
```

### Penyebab Umum
1. Session expired atau tidak tersimpan dengan benar
2. Konfigurasi session driver tidak sesuai dengan hosting
3. Cookie domain/path tidak sesuai
4. Cache konfigurasi yang outdated
5. File permissions storage/framework/sessions

### Solusi

#### 1. Clear Cache dan Session
```bash
php artisan config:clear
php artisan cache:clear
# Note: session:clear tidak tersedia di Laravel 11
# Gunakan cara manual untuk clear session:
rm -rf storage/framework/sessions/*
php artisan view:clear
php artisan route:clear
```

#### 2. Periksa Konfigurasi Session di .env
```bash
# Untuk shared hosting, gunakan file driver
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Pastikan APP_URL sesuai dengan domain
APP_URL=https://yourdomain.com

# Cookie settings
SESSION_DOMAIN=.yourdomain.com
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

#### 3. Set File Permissions untuk Session
```bash
chmod -R 755 storage/framework/sessions
chown -R www-data:www-data storage/framework/sessions
```

#### 4. Update config/session.php (jika diperlukan)
```php
// Pastikan session path dapat ditulis
'files' => storage_path('framework/sessions'),

// Cookie domain sesuai dengan hosting
'domain' => env('SESSION_DOMAIN', null),
```

#### 5. Regenerate Cache
```bash
php artisan config:cache
php artisan route:cache
```

### Pencegahan
- Selalu set APP_URL yang benar di .env
- Gunakan HTTPS di production
- Pastikan session storage dapat ditulis
- Test form submission setelah deployment

---

# Error 500 Internal Server Error

## Langkah-langkah Diagnosis Error 500

### 1. Periksa Log Error
```bash
# Periksa log Laravel
tail -f storage/logs/laravel.log

# Periksa log Apache/Nginx
tail -f /var/log/apache2/error.log
# atau
tail -f /var/log/nginx/error.log

# Periksa log PHP
tail -f /var/log/php/error.log
```

### 2. Periksa Konfigurasi Environment

#### File .env harus ada dan berisi:
```bash
# Pastikan file .env ada
ls -la .env

# Periksa isi file .env
cat .env
```

#### Konfigurasi wajib:
- `APP_KEY` harus diisi (bukan kosong atau GENERATE_NEW_KEY_HERE)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` sesuai dengan domain
- Database credentials benar

### 3. Generate Application Key
```bash
php artisan key:generate --force
```

### 4. Periksa File Permissions
```bash
# Set permissions yang benar
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env

# Set ownership (sesuaikan dengan user web server)
chown -R www-data:www-data .
```

### 5. Error: Table 'roles' already exists

#### Masalah:
```
SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'roles' already exists
```

#### Penyebab:
File migrasi duplikat `2025_09_05_172353_create_roles_table.php` yang mencoba membuat tabel 'roles' yang sudah ada.

#### Solusi:
```bash
# 1. Hapus file migrasi duplikat
rm database/migrations/2025_09_05_172353_create_roles_table.php

# 2. Periksa status migrasi
php artisan migrate:status

# 3. Jika tabel sudah ada, hapus record migrasi duplikat dari database
# Masuk ke MySQL/database dan jalankan:
# DELETE FROM migrations WHERE migration = '2025_09_05_172353_create_roles_table';

# 4. Jalankan migrasi ulang
php artisan migrate
```

#### Pencegahan:
- Pastikan tidak ada file migrasi duplikat
- Gunakan `php artisan make:migration` dengan nama yang unik
- Periksa existing migrations sebelum membuat yang baru

## Error: Unable to set application key. No APP_KEY variable was found

### Masalah
Error ini terjadi saat menjalankan `php artisan key:generate` di server hosting:
```
Unable to set application key. No APP_KEY variable was found in the .env file.
```

### Penyebab
1. File `.env` tidak ada di server
2. File `.env` ada tapi tidak memiliki baris `APP_KEY=`
3. File `.env` corrupt atau tidak readable

### Solusi

1. **Periksa keberadaan file .env:**
   ```bash
   ls -la .env
   cat .env | grep APP_KEY
   ```

2. **Jika file .env tidak ada:**
   ```bash
   cp .env.example .env
   ```

3. **Jika APP_KEY tidak ada dalam .env:**
   ```bash
   echo "APP_KEY=" >> .env
   php artisan key:generate
   ```

4. **Jika masih error, tambahkan manual:**
   ```bash
   sed -i 's/APP_KEY=/APP_KEY=base64:/' .env
   php artisan key:generate
   ```

5. **Verifikasi hasil:**
   ```bash
   cat .env | grep APP_KEY
   ```

### Pencegahan
- Selalu pastikan file `.env.example` memiliki `APP_KEY=`
- Dokumentasikan langkah deployment dengan jelas
- Test deployment di staging environment terlebih dahulu

# atau untuk cPanel/shared hosting:
chown -R username:username .
```

### 5. Clear dan Rebuild Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Periksa Dependencies
```bash
# Install dependencies production
composer install --optimize-autoloader --no-dev

# Update autoloader
composer dump-autoload --optimize
```

### 7. Periksa Database Connection
```bash
# Test koneksi database
php artisan tinker
# Kemudian jalankan:
# DB::connection()->getPdo();
```

### 8. Periksa PHP Version
```bash
# Pastikan PHP 8.2 atau lebih tinggi
php -v

# Periksa ekstensi PHP yang diperlukan
php -m | grep -E '(pdo|mysql|mbstring|openssl|tokenizer|xml|ctype|json|bcmath|fileinfo)'
```

### 9. Periksa Web Server Configuration

#### Apache:
- DocumentRoot harus mengarah ke folder `public/`
- mod_rewrite harus enabled
- File .htaccess harus ada di folder public/

#### Nginx:
- Root directive mengarah ke folder `public/`
- try_files directive dikonfigurasi dengan benar

### 10. Debug Mode Sementara

**HANYA untuk debugging, jangan biarkan aktif di production!**

```bash
# Edit .env sementara
APP_DEBUG=true
LOG_LEVEL=debug

# Clear cache
php artisan config:clear
```

Setelah melihat error detail, **SEGERA** kembalikan:
```bash
APP_DEBUG=false
LOG_LEVEL=error
php artisan config:cache
```

## Common Issues dan Solusi

### Issue 1: "No application encryption key has been specified"
**Solusi:**
```bash
php artisan key:generate --force
```

### Issue 0: Table Not Found Error (SQLSTATE[42S02])
Jika mendapat error "Base table or view not found":

**Solusi:**
1. **Periksa konfigurasi database di .env**:
   ```bash
   # Pastikan nama database sesuai dengan hosting
   DB_DATABASE=u798974089_db_ws
   DB_USERNAME=u798974089_db_ws
   DB_PASSWORD=your_actual_password
   ```

2. **Jalankan migrasi database**:
   ```bash
   php artisan migrate --force
   ```

3. **Periksa status migrasi**:
   ```bash
   php artisan migrate:status
   ```

4. **Jika migrasi gagal, reset dan jalankan ulang**:
   ```bash
   php artisan migrate:reset --force
   php artisan migrate --force
   ```

5. **Seed data jika diperlukan**:
   ```bash
   php artisan db:seed --force
   ```

### Issue 2: "Class not found" atau "Autoload error"
**Solusi:**
```bash
composer dump-autoload --optimize
php artisan config:clear
```

### Issue 3: Database connection error
**Solusi:**
1. Periksa credentials di .env
2. Pastikan database server berjalan
3. Test koneksi manual

### Issue 4: Permission denied
**Solusi:**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data .
```

### Issue 5: "Route not found" atau 404 untuk semua route
**Solusi:**
1. Periksa DocumentRoot mengarah ke folder public/
2. Pastikan mod_rewrite enabled (Apache)
3. Periksa file .htaccess ada dan benar

### Issue 6: Memory limit exceeded
**Solusi:**
```bash
# Tambahkan di .htaccess atau php.ini
php_value memory_limit 256M
```

## Checklist Deployment

- [ ] File .env ada dan dikonfigurasi dengan benar
- [ ] APP_KEY sudah digenerate
- [ ] Dependencies terinstall (composer install --no-dev)
- [ ] File permissions benar (755 untuk storage/ dan bootstrap/cache/)
- [ ] Database credentials benar
- [ ] Migrasi database sudah dijalankan
- [ ] Cache sudah dibuild untuk production
- [ ] DocumentRoot mengarah ke folder public/
- [ ] SSL certificate terpasang (untuk HTTPS)
- [ ] PHP version 8.2+
- [ ] Ekstensi PHP yang diperlukan terinstall

## Kontak Support

Jika masih mengalami masalah setelah mengikuti panduan ini:
1. Kumpulkan informasi error dari log
2. Screenshot error message
3. Informasi hosting (PHP version, web server, dll)
4. Hubungi tim development dengan informasi lengkap

## Testing Setelah Fix

1. Akses halaman utama: [URL_WEBSITE]
2. Test navigasi ke semua halaman
3. Test form submission
4. Periksa log untuk memastikan tidak ada error
5. Test dari berbagai device dan browser