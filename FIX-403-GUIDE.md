# Panduan Mengatasi Error 403 Forbidden

## Error yang Terjadi
```
403 Forbidden
Access to this resource on the server is denied!
```

## Penyebab Umum Error 403
1. **File permissions salah** - Directory atau file tidak memiliki permission yang tepat
2. **Document Root salah** - Server tidak mengarah ke folder `public`
3. **File index.php hilang** - File utama tidak ditemukan
4. **File .htaccess bermasalah** - Konfigurasi rewrite salah
5. **Ownership file salah** - File tidak dimiliki oleh user yang tepat
6. **Directory browsing disabled** - Server tidak mengizinkan akses directory

## Langkah Perbaikan via PuTTY

### 1. Koneksi ke Server
```bash
# Buka PuTTY dan connect ke server
# Masuk ke directory website
cd /path/to/your/website
# atau
cd /var/www/html/kecamatangwaesama
```

### 2. Jalankan Script Perbaikan
```bash
# Berikan permission execute ke script
chmod +x fix-403.sh

# Jalankan script perbaikan
./fix-403.sh
```

### 3. Perbaikan Manual (Jika Script Gagal)

#### A. Cek dan Perbaiki File Permissions
```bash
# Cek current permissions
ls -la

# Set directory permissions ke 755
find . -type d -exec chmod 755 {} \;

# Set file permissions ke 644
find . -type f -exec chmod 644 {} \;

# Set executable untuk artisan
chmod +x artisan

# Set permissions khusus untuk storage dan cache
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

#### B. Cek Document Root Server
```bash
# Untuk Apache, cek konfigurasi
sudo nano /etc/apache2/sites-available/000-default.conf
# atau
sudo nano /etc/apache2/sites-available/your-site.conf

# Pastikan DocumentRoot mengarah ke:
# DocumentRoot /path/to/your/website/public
```

#### C. Cek dan Perbaiki .htaccess
```bash
# Cek apakah .htaccess ada di public
ls -la public/.htaccess

# Jika tidak ada, buat file .htaccess
nano public/.htaccess
```

Isi file `.htaccess` di folder `public`:
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

# Prevent access to sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Prevent directory browsing
Options -Indexes
```

#### D. Cek File index.php
```bash
# Pastikan index.php ada di public
ls -la public/index.php

# Jika tidak ada, copy dari root
cp index.php public/
```

#### E. Perbaiki Ownership (Jika Diperlukan)
```bash
# Ganti ownership ke www-data (untuk Ubuntu/Debian)
sudo chown -R www-data:www-data .

# Atau untuk CentOS/RHEL
sudo chown -R apache:apache .

# Atau sesuai user web server Anda
```

### 4. Restart Web Server
```bash
# Untuk Apache
sudo systemctl restart apache2
# atau
sudo service apache2 restart

# Untuk Nginx
sudo systemctl restart nginx
# atau
sudo service nginx restart
```

### 5. Clear Laravel Cache
```bash
# Clear semua cache Laravel
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting Lanjutan

### Cek Error Log Server
```bash
# Untuk Apache
sudo tail -f /var/log/apache2/error.log

# Untuk Nginx
sudo tail -f /var/log/nginx/error.log

# Cek log Laravel
tail -f storage/logs/laravel.log
```

### Test Konfigurasi Server
```bash
# Test Apache configuration
sudo apache2ctl configtest

# Test Nginx configuration
sudo nginx -t

# Cek status service
sudo systemctl status apache2
# atau
sudo systemctl status nginx
```

### Verifikasi PHP
```bash
# Cek PHP version
php -v

# Cek PHP modules
php -m | grep -E '(rewrite|mod_rewrite)'

# Test PHP di public directory
echo "<?php phpinfo(); ?>" > public/test.php
# Akses: https://web.kecamatangwaesama.id/test.php
# Hapus setelah test: rm public/test.php
```

## Konfigurasi Server yang Benar

### Apache Virtual Host
```apache
<VirtualHost *:80>
    ServerName web.kecamatangwaesama.id
    DocumentRoot /path/to/website/public
    
    <Directory /path/to/website/public>
        AllowOverride All
        Require all granted
        Options -Indexes
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/kecamatangwaesama_error.log
    CustomLog ${APACHE_LOG_DIR}/kecamatangwaesama_access.log combined
</VirtualHost>
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name web.kecamatangwaesama.id;
    root /path/to/website/public;
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\. {
        deny all;
    }
}
```

## Checklist Akhir

- [ ] Document Root mengarah ke folder `public`
- [ ] File permissions: directories 755, files 644
- [ ] File `public/index.php` ada dan dapat diakses
- [ ] File `public/.htaccess` ada dan konfigurasi benar
- [ ] Ownership file sesuai dengan user web server
- [ ] PHP version minimal 8.1
- [ ] mod_rewrite Apache enabled (atau Nginx configured)
- [ ] Web server sudah di-restart
- [ ] Laravel cache sudah di-clear
- [ ] Error log tidak menunjukkan error

## Kontak Support
Jika masih mengalami masalah, hubungi administrator server atau hosting provider untuk:
1. Verifikasi konfigurasi server
2. Cek permission level user
3. Verifikasi DNS dan SSL certificate
4. Review security settings

---
**Catatan**: Pastikan backup website sebelum melakukan perubahan konfigurasi server.