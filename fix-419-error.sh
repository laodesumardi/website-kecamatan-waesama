#!/bin/bash

# Script untuk mengatasi Error 419 Page Expired
# Jalankan script ini ketika mengalami CSRF token mismatch

echo "=== Fix Error 419 Page Expired ==="
echo "Mengatasi masalah CSRF token mismatch..."

# 1. Clear semua cache dan session
echo "Step 1: Clear cache dan session..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Clear session files manually (session:clear tidak tersedia di Laravel 11)
echo "Clearing session files manually..."
if [ -d "storage/framework/sessions" ]; then
    rm -rf storage/framework/sessions/*
    echo "✓ Session files cleared manually"
else
    echo "Session directory not found, creating..."
    mkdir -p storage/framework/sessions
    chmod 755 storage/framework/sessions
    echo "✓ Session directory created"
fi

# 2. Periksa dan perbaiki file permissions
echo "Step 2: Set file permissions..."
chmod -R 755 storage/framework/sessions
chmod -R 755 storage/framework/cache
chmod -R 755 storage/framework/views
chmod 644 .env

# 3. Periksa konfigurasi session di .env
echo "Step 3: Verifikasi konfigurasi session..."
if ! grep -q "^SESSION_DRIVER=" .env; then
    echo "SESSION_DRIVER=file" >> .env
    echo "✓ Added SESSION_DRIVER=file"
fi

if ! grep -q "^SESSION_LIFETIME=" .env; then
    echo "SESSION_LIFETIME=120" >> .env
    echo "✓ Added SESSION_LIFETIME=120"
fi

# 4. Regenerate cache
echo "Step 4: Regenerate cache..."
php artisan config:cache
php artisan route:cache

# 5. Test APP_KEY
echo "Step 5: Verifikasi APP_KEY..."
if grep -q "^APP_KEY=base64:" .env; then
    echo "✓ APP_KEY is properly set"
else
    echo "⚠ Warning: APP_KEY might not be properly set"
    echo "Run: php artisan key:generate --force"
fi

# 6. Verifikasi APP_URL
echo "Step 6: Verifikasi APP_URL..."
app_url=$(grep "^APP_URL=" .env | cut -d'=' -f2)
if [ -z "$app_url" ] || [ "$app_url" = "http://localhost" ]; then
    echo "⚠ Warning: APP_URL not set properly for production"
    echo "Update APP_URL in .env to match your domain"
    echo "Example: APP_URL=https://yourdomain.com"
else
    echo "✓ APP_URL: $app_url"
fi

# 7. Tampilkan konfigurasi session saat ini
echo "\n=== Current Session Configuration ==="
echo "SESSION_DRIVER: $(grep '^SESSION_DRIVER=' .env | cut -d'=' -f2)"
echo "SESSION_LIFETIME: $(grep '^SESSION_LIFETIME=' .env | cut -d'=' -f2)"
echo "APP_URL: $(grep '^APP_URL=' .env | cut -d'=' -f2)"

echo "\n=== Troubleshooting Tips ==="
echo "1. Pastikan APP_URL sesuai dengan domain hosting"
echo "2. Untuk HTTPS, set SESSION_SECURE_COOKIE=true"
echo "3. Untuk subdomain, set SESSION_DOMAIN=.yourdomain.com"
echo "4. Test form submission setelah menjalankan script ini"
echo "5. Jika masih error, periksa log: tail -f storage/logs/laravel.log"

echo "\n=== Script Selesai ==="
echo "Silakan test aplikasi di browser!"