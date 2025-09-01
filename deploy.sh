#!/bin/bash

# Script Deployment untuk Kantor Camat Waesama
# Kompatibel dengan PuTTY SSH Terminal

echo "=== DEPLOYMENT SCRIPT KANTOR CAMAT WAESAMA ==="
echo "Memulai proses deployment..."

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

# 1. Backup file .env jika ada
print_status "Backup file .env..."
if [ -f .env ]; then
    cp .env .env.backup
    print_status "File .env berhasil di-backup"
else
    print_warning "File .env tidak ditemukan"
fi

# 2. Pull latest code dari GitHub
print_status "Mengambil kode terbaru dari GitHub..."
git pull origin main
if [ $? -eq 0 ]; then
    print_status "Git pull berhasil"
else
    print_error "Git pull gagal"
    exit 1
fi

# 3. Setup file .env jika belum ada
if [ ! -f .env ]; then
    print_status "Membuat file .env dari .env.example..."
    cp .env.example .env
    
    # Update konfigurasi untuk production
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
    sed -i 's|APP_URL=http://localhost|APP_URL=https://wb.kecamatangwaesama.id|' .env
    
    print_status "File .env berhasil dibuat"
fi

# 4. Install/Update Composer dependencies
print_status "Menginstall Composer dependencies..."
composer install --optimize-autoloader --no-dev
if [ $? -eq 0 ]; then
    print_status "Composer install berhasil"
else
    print_error "Composer install gagal"
    exit 1
fi

# 5. Generate Application Key jika belum ada
print_status "Generate application key..."
php artisan key:generate --force
if [ $? -eq 0 ]; then
    print_status "Application key berhasil di-generate"
else
    print_error "Generate application key gagal"
fi

# 6. Set file permissions
print_status "Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
print_status "File permissions berhasil diset"

# 7. Clear dan optimize cache
print_status "Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
print_status "Cache berhasil dibersihkan"

# 8. Run database migrations
print_status "Menjalankan database migrations..."
php artisan migrate --force
if [ $? -eq 0 ]; then
    print_status "Database migrations berhasil"
else
    print_warning "Database migrations gagal atau tidak diperlukan"
fi

# 9. Seed database jika diperlukan
read -p "Apakah ingin menjalankan database seeder? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    print_status "Menjalankan database seeder..."
    php artisan db:seed --force
    print_status "Database seeder berhasil"
fi

# 10. Build assets untuk production
print_status "Building assets untuk production..."
if command -v npm &> /dev/null; then
    npm install
    npm run build
    print_status "Assets berhasil di-build"
else
    print_warning "NPM tidak ditemukan, skip building assets"
fi

# 11. Optimize untuk production
print_status "Optimizing untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
print_status "Optimization selesai"

# 12. Check status aplikasi
print_status "Checking status aplikasi..."
php artisan about

echo
print_status "=== DEPLOYMENT SELESAI ==="
print_status "Website: https://wb.kecamatangwaesama.id"
print_status "Silakan cek website untuk memastikan berjalan dengan baik"

# 13. Show important notes
echo
print_warning "CATATAN PENTING:"
echo "1. Pastikan database sudah dikonfigurasi di file .env"
echo "2. Pastikan web server mengarah ke folder 'public'"
echo "3. Jika masih error, cek log di storage/logs/laravel.log"
echo "4. Untuk troubleshooting, jalankan: tail -f storage/logs/laravel.log"