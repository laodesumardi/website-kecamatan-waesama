# Panduan Deployment Manual via Putty

## Masalah yang Terjadi

Error: `Vite manifest not found at: /home/u798974089/domains/website.kecamatangwaesama.id/public_html/public/build/manifest.json`

**Penyebab:**
- Assets CSS/JS belum di-build untuk production
- File manifest.json tidak ada karena `npm run build` belum dijalankan
- Development server menggunakan Vite yang memerlukan build process

## Solusi Manual via Putty

### 1. Koneksi ke Server via Putty

```bash
# Login ke server
ssh username@website.kecamatangwaesama.id
# atau
ssh username@server-ip-address
```

### 2. Navigasi ke Directory Project

```bash
# Masuk ke directory website
cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html

# Cek isi directory
ls -la
```

### 3. Install Dependencies (Jika Belum Ada)

```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install
```

### 4. Build Assets untuk Production

```bash
# Build assets dengan Vite
npm run build

# Atau jika menggunakan Laravel Mix
npm run production
```

### 5. Set Environment untuk Production

```bash
# Copy environment file
cp .env.example .env

# Edit file .env
nano .env
```

**Isi .env yang perlu disesuaikan:**
```env
APP_NAME="Kantor Camat Waesama"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://website.kecamatangwaesama.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### 6. Generate Application Key

```bash
# Generate key aplikasi
php artisan key:generate
```

### 7. Setup Database

```bash
# Jalankan migrasi
php artisan migrate --force

# Jalankan seeder (opsional)
php artisan db:seed --force
```

### 8. Optimize untuk Production

```bash
# Clear dan cache konfigurasi
php artisan config:clear
php artisan config:cache

# Clear dan cache route
php artisan route:clear
php artisan route:cache

# Clear dan cache view
php artisan view:clear
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 9. Set Permissions

```bash
# Set permission untuk storage dan bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (sesuaikan dengan user server)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 10. Verifikasi Build Assets

```bash
# Cek apakah manifest.json sudah ada
ls -la public/build/

# Isi directory build harus ada:
# - manifest.json
# - assets/ (folder dengan file CSS dan JS)
```

## Script Otomatis untuk Putty

Buat file `deploy-production.sh`:

```bash
#!/bin/bash

echo "=== Starting Production Deployment ==="

# Update code dari Git (jika menggunakan Git)
git pull origin main

# Install dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

echo "Installing NPM dependencies..."
npm install

# Build assets
echo "Building assets for production..."
npm run build

# Laravel optimizations
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

echo "=== Deployment Complete ==="
echo "Please check: https://website.kecamatangwaesama.id"
```

### Cara Menjalankan Script:

```bash
# Upload script ke server
# Beri permission execute
chmod +x deploy-production.sh

# Jalankan script
./deploy-production.sh
```

## Troubleshooting

### Jika NPM Build Gagal:

```bash
# Clear npm cache
npm cache clean --force

# Hapus node_modules dan install ulang
rm -rf node_modules
npm install

# Build ulang
npm run build
```

### Jika Permission Error:

```bash
# Set permission yang benar
sudo chown -R $USER:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

### Jika Database Error:

```bash
# Cek koneksi database
php artisan tinker
# Dalam tinker:
DB::connection()->getPdo();
```

## Verifikasi Deployment

1. **Cek Website:** https://website.kecamatangwaesama.id
2. **Cek Assets:** https://website.kecamatangwaesama.id/build/manifest.json
3. **Cek Console Browser:** Tidak ada error 404 untuk CSS/JS
4. **Cek Functionality:** Login, navigation, dll berfungsi

## File yang Harus Ada Setelah Build

```
public/build/
├── manifest.json
└── assets/
    ├── app-[hash].css
    ├── app-[hash].js
    └── [other-assets]
```

## Tips Maintenance

1. **Backup Database** sebelum deployment
2. **Test di staging** sebelum production
3. **Monitor logs** setelah deployment
4. **Setup monitoring** untuk error tracking

## Monitoring Commands

```bash
# Monitor Laravel logs
tail -f storage/logs/laravel.log

# Monitor web server logs
tail -f /var/log/apache2/error.log
# atau
tail -f /var/log/nginx/error.log
```