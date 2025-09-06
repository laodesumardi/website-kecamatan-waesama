# Panduan Deployment Aplikasi Kantor Camat Waesama

## Persiapan Hosting

### 1. Persyaratan Server
- PHP 8.2 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Composer
- Apache/Nginx dengan mod_rewrite enabled

### 2. File Permissions yang Diperlukan
Pastikan folder berikut memiliki permission 755 atau 775:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

### 3. Konfigurasi Environment
1. Copy file `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   ```

2. **PENTING: Edit file .env dan pastikan APP_KEY tidak kosong**
   
   Jika APP_KEY kosong atau tidak ada, tambahkan baris berikut:
   ```
   APP_KEY=
   ```
   
3. Update konfigurasi database di `.env`:
   ```
   DB_HOST=your_database_host
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
4. Update `APP_URL` dengan domain Anda
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
   
   **Troubleshooting Error "No APP_KEY variable was found":**
   - Pastikan file .env ada di root directory
   - Pastikan baris APP_KEY= ada dalam file .env (meskipun kosong)
   - Jika masih error, tambahkan manual: `APP_KEY=base64:` lalu jalankan `php artisan key:generate`

### 4. Instalasi Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### 5. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 6. Optimasi untuk Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize
```

### 7. Konfigurasi Web Server

#### Apache
- Pastikan DocumentRoot mengarah ke folder `public/`
- File `.htaccess` sudah dikonfigurasi dengan benar

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/app/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 8. Keamanan
- Pastikan folder `storage/`, `bootstrap/cache/`, dan file `.env` tidak dapat diakses dari web
- Update password database secara berkala
- Gunakan HTTPS untuk production

### 9. Troubleshooting

#### Error 500
- Periksa file log di `storage/logs/laravel.log`
- Pastikan file permissions sudah benar
- Pastikan semua dependencies terinstall

#### Database Connection Error
- Periksa konfigurasi database di `.env`
- Pastikan database server berjalan
- Periksa kredensial database

#### File Permission Error
```bash
sudo chown -R www-data:www-data /path/to/your/app
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### 10. Maintenance Mode
Untuk mengaktifkan maintenance mode:
```bash
php artisan down
```

Untuk menonaktifkan:
```bash
php artisan up
```

## Quick Deployment

### Opsi 1: Script Deployment Otomatis (Recommended)

Gunakan script deployment yang sudah disediakan:

**Untuk Linux/Unix/macOS:**
```bash
chmod +x deploy-hosting.sh
./deploy-hosting.sh
```

**Untuk Windows PowerShell:**
```powershell
.\deploy-hosting.ps1
```

Script ini akan otomatis:
- Backup file .env yang ada
- Setup file .env dari .env.example
- Generate APP_KEY dengan troubleshooting otomatis
- Install dependencies
- Clear cache dan session (mengatasi error 419) - menggunakan manual clear untuk session karena `session:clear` tidak tersedia di Laravel 11
- Run migrations
- Set permissions yang tepat

### Opsi 3: Fix Error 419 Page Expired

Jika mengalami error 419 Page Expired setelah deployment:

**Untuk Linux/Unix/macOS:**
```bash
chmod +x fix-419-error.sh
./fix-419-error.sh
```

**Untuk Windows PowerShell:**
```powershell
.\fix-419-error.ps1
```

Script ini akan:
- Clear semua cache dan session
- Verifikasi konfigurasi session
- Set file permissions yang tepat
- Regenerate cache
- Verifikasi APP_KEY dan APP_URL

### Opsi 2: Manual Deployment

Untuk deployment manual, jalankan perintah berikut:

```bash
# Upload files ke server
# Kemudian jalankan:
cp .env.example .env
php artisan key:generate
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Kontak Support
Jika mengalami masalah, hubungi tim development.