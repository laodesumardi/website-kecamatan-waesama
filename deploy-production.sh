#!/bin/bash

# Production Deployment Script for Kantor Camat Waesama
# Run this script on your production server via Putty

set -e  # Exit on any error

echo "======================================"
echo "  KANTOR CAMAT WAESAMA DEPLOYMENT"
echo "======================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "Laravel artisan file not found. Please run this script from the Laravel root directory."
    exit 1
fi

print_status "Starting deployment process..."

# Step 1: Update code from Git (if using Git)
if [ -d ".git" ]; then
    print_status "Updating code from Git repository..."
    git pull origin main || {
        print_warning "Git pull failed or not configured. Continuing with existing code..."
    }
else
    print_warning "Not a Git repository. Skipping code update..."
fi

# Step 2: Install/Update Composer dependencies
print_status "Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev --no-interaction
    print_success "Composer dependencies installed"
else
    print_error "Composer not found. Please install Composer first."
    exit 1
fi

# Step 3: Install/Update NPM dependencies
print_status "Installing NPM dependencies..."
if command -v npm &> /dev/null; then
    npm ci --production=false
    print_success "NPM dependencies installed"
else
    print_error "NPM not found. Please install Node.js and NPM first."
    exit 1
fi

# Step 4: Build assets for production
print_status "Building assets for production..."
npm run build
if [ $? -eq 0 ]; then
    print_success "Assets built successfully"
else
    print_error "Asset build failed"
    exit 1
fi

# Step 5: Verify build files
print_status "Verifying build files..."
if [ -f "public/build/manifest.json" ]; then
    print_success "Vite manifest.json found"
else
    print_error "Vite manifest.json not found after build"
    exit 1
fi

# Step 6: Environment setup
print_status "Setting up environment..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_warning "Created .env from .env.example. Please configure database and other settings."
    else
        print_error ".env file not found and no .env.example available"
        exit 1
    fi
fi

# Step 7: Generate application key if needed
if ! grep -q "APP_KEY=base64:" .env; then
    print_status "Generating application key..."
    php artisan key:generate --force
    print_success "Application key generated"
fi

# Step 8: Clear and cache configurations
print_status "Optimizing Laravel application..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache
composer dump-autoload --optimize
print_success "Laravel optimizations completed"

# Step 9: Run database migrations
print_status "Running database migrations..."
php artisan migrate --force
if [ $? -eq 0 ]; then
    print_success "Database migrations completed"
else
    print_warning "Database migrations failed. Please check database configuration."
fi

# Step 10: Set proper permissions
print_status "Setting file permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Try to set ownership (may require sudo)
if command -v chown &> /dev/null; then
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || {
        print_warning "Could not set ownership. You may need to run: sudo chown -R www-data:www-data storage bootstrap/cache"
    }
fi
print_success "Permissions set"

# Step 11: Clear application cache
print_status "Clearing application cache..."
php artisan cache:clear
php artisan queue:restart 2>/dev/null || print_warning "Queue restart failed (queue may not be configured)"
print_success "Cache cleared"

# Step 12: Final verification
print_status "Running final verification..."

echo ""
echo "======================================"
echo "         DEPLOYMENT SUMMARY"
echo "======================================"

# Check critical files
echo "📁 Build Files:"
if [ -f "public/build/manifest.json" ]; then
    echo "   ✅ manifest.json: Found"
else
    echo "   ❌ manifest.json: Missing"
fi

if [ -d "public/build/assets" ]; then
    asset_count=$(ls -1 public/build/assets | wc -l)
    echo "   ✅ assets folder: $asset_count files"
else
    echo "   ❌ assets folder: Missing"
fi

echo ""
echo "🔧 Laravel Status:"
echo "   ✅ Config cached: $([ -f bootstrap/cache/config.php ] && echo 'Yes' || echo 'No')"
echo "   ✅ Routes cached: $([ -f bootstrap/cache/routes-v7.php ] && echo 'Yes' || echo 'No')"
echo "   ✅ Views cached: $([ -d storage/framework/views ] && echo 'Yes' || echo 'No')"

echo ""
echo "🌐 Website URLs:"
echo "   🏠 Main Site: https://website.kecamatangwaesama.id"
echo "   📋 Manifest: https://website.kecamatangwaesama.id/build/manifest.json"

echo ""
echo "======================================"
print_success "DEPLOYMENT COMPLETED SUCCESSFULLY!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Visit your website to verify it's working"
echo "2. Check browser console for any remaining errors"
echo "3. Test all functionality (login, navigation, etc.)"
echo "4. Monitor logs: tail -f storage/logs/laravel.log"
echo ""
echo "If you encounter issues:"
echo "1. Check .env configuration"
echo "2. Verify database connection"
echo "3. Check web server error logs"
echo "4. Ensure proper file permissions"
echo ""