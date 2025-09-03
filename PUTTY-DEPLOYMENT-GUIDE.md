# Panduan Deployment menggunakan PuTTY

Panduan ini akan membantu Anda melakukan deployment aplikasi Kantor Camat Waesama ke server menggunakan PuTTY.

## Prasyarat

1. **PuTTY** - Download dari [https://www.putty.org/](https://www.putty.org/)
2. **WinSCP** (opsional) - Untuk transfer file GUI
3. **Akses SSH ke server** - IP address, username, dan password/private key
4. **Server dengan PHP 8.1+, MySQL, dan Composer**

## Langkah 1: Koneksi ke Server

### Menggunakan PuTTY
1. Buka PuTTY
2. Masukkan **Host Name (or IP address)**: `your-server-ip`
3. **Port**: `22` (default SSH)
4. **Connection type**: `SSH`
5. Klik **Open**
6. Login dengan username dan password server Anda

### Menggunakan Command Line (alternatif)
```bash
ssh username@your-server-ip
```

## Langkah 2: Persiapan Server

### Update sistem
```bash
sudo apt update && sudo apt upgrade -y
```

### Install dependencies yang diperlukan
```bash
# Install PHP 8.1 dan ekstensi
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-intl php8.1-bcmath -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Git
sudo apt install git -y

# Install Node.js dan npm (untuk build assets)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

## Langkah 3: Clone Repository

```bash
# Pindah ke direktori web
cd /var/www/html

# Clone repository dari GitHub
sudo git clone https://github.com/laodesumardi/web-kecamatan-waesama.git

# Pindah ke direktori project
cd web-kecamatan-waesama

# Set permission
sudo chown -R www-data:www-data /var/www/html/web-kecamatan-waesama
sudo chmod -R 755 /var/www/html/web-kecamatan-waesama
```

## Langkah 4: Konfigurasi Aplikasi

### Install dependencies PHP
```bash
composer install --optimize-autoloader --no-dev
```

### Setup environment
```bash
# Copy file environment
cp .env.production .env

# Generate application key
php artisan key:generate

# Edit file .env sesuai dengan konfigurasi server
nano .env
```

### Konfigurasi .env untuk production
```env
APP_NAME="Kantor Camat Waesama"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=http://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
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

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Langkah 5: Setup Database

### Buat database MySQL
```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE kantor_camat_waesama;

# Buat user database (opsional)
CREATE USER 'camat_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON kantor_camat_waesama.* TO 'camat_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Jalankan migrasi
```bash
php artisan migrate --force

# Seed data (jika ada)
php artisan db:seed --force
```

## Langkah 6: Build Assets

```bash
# Install dependencies Node.js
npm install

# Build assets untuk production
npm run build
```

## Langkah 7: Optimasi Laravel

```bash
# Cache konfigurasi
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

## Langkah 8: Konfigurasi Web Server

### Untuk Apache
```bash
# Buat virtual host
sudo nano /etc/apache2/sites-available/kantor-camat-waesama.conf
```

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/html/web-kecamatan-waesama/public
    
    <Directory /var/www/html/web-kecamatan-waesama/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/kantor-camat-waesama_error.log
    CustomLog ${APACHE_LOG_DIR}/kantor-camat-waesama_access.log combined
</VirtualHost>
```

```bash
# Enable site dan rewrite module
sudo a2ensite kantor-camat-waesama.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Untuk Nginx
```bash
# Buat konfigurasi site
sudo nano /etc/nginx/sites-available/kantor-camat-waesama
```

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/html/web-kecamatan-waesama/public;
    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/kantor-camat-waesama /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## Langkah 9: Set Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/html/web-kecamatan-waesama

# Set permissions
sudo find /var/www/html/web-kecamatan-waesama -type f -exec chmod 644 {} \;
sudo find /var/www/html/web-kecamatan-waesama -type d -exec chmod 755 {} \;

# Set writable directories
sudo chmod -R 775 /var/www/html/web-kecamatan-waesama/storage
sudo chmod -R 775 /var/www/html/web-kecamatan-waesama/bootstrap/cache
```

## Langkah 10: Setup SSL (Opsional tapi Direkomendasikan)

### Menggunakan Let's Encrypt
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Atau untuk Nginx
sudo apt install certbot python3-certbot-nginx -y

# Generate SSL certificate
sudo certbot --apache -d your-domain.com

# Atau untuk Nginx
sudo certbot --nginx -d your-domain.com
```

## Langkah 11: Setup Cron Jobs (Jika Diperlukan)

```bash
# Edit crontab
sudo crontab -e

# Tambahkan baris berikut untuk Laravel scheduler
* * * * * cd /var/www/html/web-kecamatan-waesama && php artisan schedule:run >> /dev/null 2>&1
```

## Langkah 12: Monitoring dan Maintenance

### Setup log rotation
```bash
sudo nano /etc/logrotate.d/laravel
```

```
/var/www/html/web-kecamatan-waesama/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

### Backup script
```bash
#!/bin/bash
# backup-script.sh

DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/backup/kantor-camat-waesama"
APP_DIR="/var/www/html/web-kecamatan-waesama"
DB_NAME="kantor_camat_waesama"
DB_USER="your_db_user"
DB_PASS="your_db_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/database_$DATE.sql

# Backup application files
tar -czf $BACKUP_DIR/app_$DATE.tar.gz -C $APP_DIR .

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

## Update Aplikasi

Untuk update aplikasi di masa depan:

```bash
# Pindah ke direktori aplikasi
cd /var/www/html/web-kecamatan-waesama

# Pull perubahan terbaru
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev

# Update database jika ada migrasi baru
php artisan migrate --force

# Rebuild assets
npm install
npm run build

# Clear dan rebuild cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Troubleshooting

### Masalah Umum

1. **Permission denied**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/web-kecamatan-waesama
   sudo chmod -R 775 storage bootstrap/cache
   ```

2. **500 Internal Server Error**
   - Periksa log: `tail -f storage/logs/laravel.log`
   - Periksa log web server: `tail -f /var/log/apache2/error.log`

3. **Database connection error**
   - Periksa konfigurasi .env
   - Test koneksi database: `php artisan tinker` → `DB::connection()->getPdo();`

4. **Assets tidak load**
   - Jalankan `npm run build`
   - Periksa permission direktori public

### Log Files
- Laravel: `/var/www/html/web-kecamatan-waesama/storage/logs/laravel.log`
- Apache: `/var/log/apache2/error.log`
- Nginx: `/var/log/nginx/error.log`
- PHP: `/var/log/php8.1-fpm.log`

## Keamanan

1. **Firewall**
   ```bash
   sudo ufw enable
   sudo ufw allow 22
   sudo ufw allow 80
   sudo ufw allow 443
   ```

2. **Fail2ban** (untuk proteksi SSH)
   ```bash
   sudo apt install fail2ban
   sudo systemctl enable fail2ban
   ```

3. **Regular Updates**
   ```bash
   sudo apt update && sudo apt upgrade
   ```

---

**Catatan**: Ganti `your-domain.com`, `your-server-ip`, dan kredensial database dengan nilai yang sesuai dengan server Anda.

Untuk bantuan lebih lanjut, silakan hubungi administrator sistem atau developer aplikasi.