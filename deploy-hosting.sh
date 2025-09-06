#!/bin/bash

# Script Deployment untuk Server Hosting
# Mengatasi masalah umum deployment Laravel

echo "=== Laravel Deployment Script ==="
echo "Memulai proses deployment..."

# 1. Backup file .env jika ada
if [ -f ".env" ]; then
    echo "Backup file .env yang ada..."
    cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
fi

# 2. Copy .env.example ke .env jika .env tidak ada
if [ ! -f ".env" ]; then
    echo "Membuat file .env dari .env.example..."
    cp .env.example .env
fi

# 3. Pastikan APP_KEY ada dalam .env
if ! grep -q "^APP_KEY=" .env; then
    echo "Menambahkan APP_KEY ke file .env..."
    echo "APP_KEY=" >> .env
fi

# 4. Generate application key
echo "Generate application key..."
php artisan key:generate --force

# 5. Verifikasi APP_KEY
if grep -q "^APP_KEY=base64:" .env; then
    echo "✓ APP_KEY berhasil di-generate"
else
    echo "✗ Error: APP_KEY tidak ter-generate dengan benar"
    echo "Mencoba solusi alternatif..."
    
    # Solusi alternatif
    sed -i 's/^APP_KEY=$/APP_KEY=base64:/' .env
    php artisan key:generate --force
    
    if grep -q "^APP_KEY=base64:" .env; then
        echo "✓ APP_KEY berhasil di-generate (solusi alternatif)"
    else
        echo "✗ Gagal generate APP_KEY. Periksa manual!"
        exit 1
    fi
fi

# 6. Install/Update dependencies
echo "Install dependencies..."
composer install --optimize-autoloader --no-dev

# 7. Clear cache dan session (mengatasi error 419)
echo "Clearing cache dan session..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
# Clear session files manually (session:clear tidak tersedia di Laravel 11)
if [ -d "storage/framework/sessions" ]; then
    rm -rf storage/framework/sessions/*
    echo "Session files cleared manually"
fi
echo "✓ Cache dan session cleared"

# 8. Optimize untuk production
echo "Optimize untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Run migrations
echo "Menjalankan database migrations..."
php artisan migrate --force

# 10. Seed database jika diperlukan
read -p "Jalankan database seeder? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --force
fi

# 11. Set permissions
echo "Set file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# 12. Verifikasi deployment
echo "\n=== Verifikasi Deployment ==="
echo "APP_KEY: $(grep '^APP_KEY=' .env)"
echo "APP_ENV: $(grep '^APP_ENV=' .env)"
echo "APP_DEBUG: $(grep '^APP_DEBUG=' .env)"
echo "DB_CONNECTION: $(grep '^DB_CONNECTION=' .env)"

echo "\n=== Deployment Selesai ==="
echo "Silakan test aplikasi di browser!"
echo "Jika ada error, periksa file log di storage/logs/"