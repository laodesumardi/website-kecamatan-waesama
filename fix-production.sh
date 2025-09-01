#!/bin/bash

# Script untuk memperbaiki masalah production website
# Kantor Camat Waesama

echo "=== FIXING PRODUCTION ISSUES ==="
echo "Memperbaiki masalah tampilan website production..."

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fungsi untuk menampilkan pesan
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 1. Update APP_URL di .env untuk production
print_status "Updating APP_URL untuk production..."
if [ -f .env ]; then
    # Backup .env
    cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
    
    # Update APP_URL
    sed -i 's|APP_URL=.*|APP_URL=https://website.kecamatangwaesama.id|' .env
    sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env
    
    print_status "APP_URL berhasil diupdate"
else
    print_error "File .env tidak ditemukan"
    exit 1
fi

# 2. Clear semua cache
print_status "Clearing all caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
print_status "Cache berhasil dibersihkan"

# 3. Install npm dependencies
print_status "Installing npm dependencies..."
npm install
if [ $? -eq 0 ]; then
    print_status "NPM install berhasil"
else
    print_error "NPM install gagal"
    exit 1
fi

# 4. Build assets untuk production
print_status "Building assets untuk production..."
NODE_ENV=production npm run build
if [ $? -eq 0 ]; then
    print_status "Assets berhasil di-build"
else
    print_error "Build assets gagal"
    exit 1
fi

# 5. Set proper permissions
print_status "Setting file permissions..."
chmod -R 755 storage bootstrap/cache public/build
chown -R www-data:www-data storage bootstrap/cache public/build 2>/dev/null || true
print_status "File permissions berhasil diset"

# 6. Optimize untuk production
print_status "Optimizing untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
print_status "Optimization selesai"

# 7. Verify assets
print_status "Verifying built assets..."
if [ -f "public/build/manifest.json" ]; then
    print_status "Manifest file ditemukan"
    ls -la public/build/assets/
else
    print_error "Manifest file tidak ditemukan"
fi

echo
print_status "=== PRODUCTION FIX SELESAI ==="
print_status "Website: https://website.kecamatangwaesama.id"
print_status "Silakan cek website untuk memastikan tampilan sudah benar"

echo
print_warning "CATATAN:"
echo "1. Pastikan web server sudah restart"
echo "2. Clear browser cache jika masih ada masalah"
echo "3. Cek console browser untuk error JavaScript/CSS"
echo "4. Jika masih bermasalah, cek log: tail -f storage/logs/laravel.log"