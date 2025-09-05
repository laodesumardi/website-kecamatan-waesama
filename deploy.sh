#!/bin/bash

# Deployment Script untuk Kantor Camat Waesama
# Jalankan script ini di server hosting

echo "🚀 Memulai deployment Kantor Camat Waesama..."

# 1. Backup database (opsional)
echo "📦 Membuat backup database..."
# mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# 2. Update kode dari repository
echo "📥 Mengupdate kode..."
git pull origin main

# 3. Install/Update dependencies
echo "📚 Menginstall dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# 4. Copy environment file
echo "⚙️ Menyiapkan environment..."
if [ ! -f .env ]; then
    cp .env.production .env
    echo "✅ File .env dibuat dari .env.production"
else
    echo "ℹ️ File .env sudah ada"
fi

# 5. Generate application key jika belum ada
echo "🔑 Memeriksa application key..."
if grep -q "APP_KEY=base64:GENERATE_NEW_KEY_HERE" .env; then
    php artisan key:generate --force
    echo "✅ Application key berhasil digenerate"
fi

# 6. Set file permissions
echo "🔒 Mengatur file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env

# 7. Clear dan rebuild cache
echo "🧹 Membersihkan cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 8. Jalankan migrasi database
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 8a. Seed database jika diperlukan (uncomment jika diperlukan)
# php artisan db:seed --force

# 9. Seed database jika diperlukan (hanya untuk fresh install)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

# 10. Optimasi untuk production
echo "⚡ Mengoptimasi untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize

# 11. Set ownership (sesuaikan dengan user web server)
echo "👤 Mengatur ownership..."
# chown -R www-data:www-data .

echo "✅ Deployment selesai!"
echo "🌐 Website dapat diakses di: [URL_WEBSITE]"
echo ""
echo "📋 Checklist post-deployment:"
echo "   1. Periksa file .env dan sesuaikan konfigurasi database"
echo "   2. Pastikan DocumentRoot mengarah ke folder public/"
echo "   3. Periksa file permissions (storage/ dan bootstrap/cache/)"
echo "   4. Test website dan periksa log jika ada error"
echo "   5. Setup SSL certificate untuk HTTPS"
echo ""
echo "📝 Jika ada error, periksa log di storage/logs/laravel.log"