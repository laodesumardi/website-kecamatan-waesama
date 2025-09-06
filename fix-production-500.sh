#!/bin/bash

# Script untuk memperbaiki HTTP Error 500 di hosting production
# Website: kecamatangwaesama.id

echo "=== FIXING HTTP 500 ERROR IN PRODUCTION ==="
echo "Website: kecamatangwaesama.id"
echo "Error URL: /profil"
echo ""

# 1. Backup current files
echo "1. Creating backup..."
cp -r . ../backup-$(date +%Y%m%d-%H%M%S) 2>/dev/null || echo "Backup failed, continuing..."

# 2. Check and fix file permissions
echo "2. Fixing file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "Cannot change ownership, continuing..."

# 3. Clear all caches
echo "3. Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 4. Check .env file
echo "4. Checking .env configuration..."
if [ ! -f .env ]; then
    echo "ERROR: .env file not found!"
    if [ -f .env.hosting ]; then
        echo "Copying .env.hosting to .env..."
        cp .env.hosting .env
    else
        echo "ERROR: No .env.hosting file found either!"
        exit 1
    fi
fi

# 5. Generate APP_KEY if missing
echo "5. Checking APP_KEY..."
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating new APP_KEY..."
    php artisan key:generate
fi

# 6. Run migrations
echo "6. Running database migrations..."
php artisan migrate --force

# 7. Install/update dependencies
echo "7. Installing dependencies..."
composer install --no-dev --optimize-autoloader

# 8. Optimize for production
echo "8. Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 9. Check storage link
echo "9. Creating storage link..."
php artisan storage:link

# 10. Set proper environment
echo "10. Setting production environment..."
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

# 11. Test the application
echo "11. Testing application..."
php artisan about 2>/dev/null || echo "Application test failed"

echo ""
echo "=== DEPLOYMENT COMPLETED ==="
echo "Please check the website: https://kecamatangwaesama.id/profil"
echo "If error persists, check the error logs:"
echo "- storage/logs/laravel.log"
echo "- Server error logs (usually in /var/log/ or hosting control panel)"
echo ""
echo "Common issues to check:"
echo "1. Database connection settings in .env"
echo "2. File permissions (755 for directories, 644 for files)"
echo "3. PHP version compatibility (Laravel 11 requires PHP 8.2+)"
echo "4. Missing PHP extensions"
echo "5. Memory limits and execution time"
echo ""