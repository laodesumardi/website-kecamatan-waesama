#!/bin/bash

# Production Optimization Script
# Run this script after deployment to optimize Laravel for production

echo "🚀 Optimizing Laravel for Production..."

# Set environment to production
echo "📝 Setting environment to production..."
sed -i 's/APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

# Clear all caches
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

# Cache configurations for better performance
echo "📦 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize Composer autoloader
echo "⚡ Optimizing Composer autoloader..."
composer dump-autoload --optimize --no-dev

# Set proper file permissions
echo "🔒 Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create storage link if not exists
if [ ! -L "public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Optimize database queries (if using MySQL)
echo "🗄️ Optimizing database..."
php artisan migrate --force

# Generate sitemap (if you have sitemap package)
# php artisan sitemap:generate

# Restart queue workers
echo "🔄 Restarting queue workers..."
php artisan queue:restart

# Final optimization
echo "⚡ Running final optimization..."
php artisan optimize

echo "✅ Production optimization completed!"
echo ""
echo "📋 Optimization Summary:"
echo "   ✓ Environment set to production"
echo "   ✓ Debug mode disabled"
echo "   ✓ All caches cleared and rebuilt"
echo "   ✓ Composer autoloader optimized"
echo "   ✓ File permissions set correctly"
echo "   ✓ Storage link created"
echo "   ✓ Database migrations applied"
echo "   ✓ Queue workers restarted"
echo ""
echo "🔧 Additional recommendations:"
echo "   - Enable OPcache in PHP"
echo "   - Use Redis for caching (if available)"
echo "   - Enable Gzip compression"
echo "   - Set up SSL certificate"
echo "   - Configure CDN for static assets"
echo "   - Set up monitoring and logging"
echo ""
echo "🌐 Your application is now optimized for production!"