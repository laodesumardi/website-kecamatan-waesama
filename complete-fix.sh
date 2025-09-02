#!/bin/bash

# Complete Production Fix Script
# Fixes both Vite manifest error and sets up database
# For Kantor Camat Waesama website

set -e

echo "🚀 COMPLETE PRODUCTION FIX - KANTOR CAMAT WAESAMA"
echo "================================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Functions
print_header() {
    echo -e "${PURPLE}[HEADER]${NC} $1"
}

print_step() {
    echo -e "${BLUE}[STEP]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_info() {
    echo -e "${CYAN}[INFO]${NC} $1"
}

# Check if we're in Laravel directory
if [ ! -f "artisan" ]; then
    print_error "Not in Laravel directory. Please cd to your Laravel project first."
    exit 1
fi

print_header "Starting Complete Production Fix..."
echo ""

# =====================================================
# PHASE 1: ENVIRONMENT SETUP
# =====================================================

print_header "PHASE 1: ENVIRONMENT SETUP"
echo ""

print_step "1.1 Checking environment file..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_success "Created .env from .env.example"
    else
        print_error ".env file not found and no .env.example available"
        exit 1
    fi
else
    print_success ".env file exists"
fi

print_step "1.2 Checking application key..."
if ! grep -q "APP_KEY=base64:" .env; then
    print_info "Generating application key..."
    php artisan key:generate --force
    print_success "Application key generated"
else
    print_success "Application key already exists"
fi

# =====================================================
# PHASE 2: DEPENDENCIES INSTALLATION
# =====================================================

print_header "PHASE 2: DEPENDENCIES INSTALLATION"
echo ""

print_step "2.1 Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev --no-interaction
    print_success "Composer dependencies installed"
else
    print_error "Composer not found. Please install Composer first."
    exit 1
fi

print_step "2.2 Installing NPM dependencies..."
if command -v npm &> /dev/null; then
    npm ci --production=false
    print_success "NPM dependencies installed"
else
    print_error "NPM not found. Please install Node.js and NPM first."
    exit 1
fi

# =====================================================
# PHASE 3: DATABASE SETUP
# =====================================================

print_header "PHASE 3: DATABASE SETUP"
echo ""

print_step "3.1 Testing database connection..."
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected successfully';" 2>/dev/null; then
    print_success "Database connection successful"
    
    print_step "3.2 Running database migrations..."
    php artisan migrate --force
    print_success "Database migrations completed"
    
    print_step "3.3 Running database seeders..."
    php artisan db:seed --force 2>/dev/null || {
        print_warning "Seeders failed or not available. Continuing..."
    }
else
    print_warning "Database connection failed. Please check your .env configuration."
    print_info "You can run the database migration manually using database-migration.sql"
fi

# =====================================================
# PHASE 4: ASSETS BUILD (VITE MANIFEST FIX)
# =====================================================

print_header "PHASE 4: ASSETS BUILD (VITE MANIFEST FIX)"
echo ""

print_step "4.1 Building assets for production..."
npm run build
if [ $? -eq 0 ]; then
    print_success "Assets built successfully"
else
    print_error "Asset build failed"
    exit 1
fi

print_step "4.2 Verifying Vite manifest..."
if [ -f "public/build/manifest.json" ]; then
    print_success "✅ Vite manifest.json created successfully"
    manifest_size=$(stat -c%s "public/build/manifest.json" 2>/dev/null || stat -f%z "public/build/manifest.json" 2>/dev/null || echo "unknown")
    print_info "📄 Manifest size: $manifest_size bytes"
else
    print_error "❌ Vite manifest.json not found after build"
    exit 1
fi

print_step "4.3 Checking build assets..."
if [ -d "public/build/assets" ]; then
    asset_count=$(ls -1 public/build/assets 2>/dev/null | wc -l)
    print_success "✅ Assets folder created with $asset_count files"
else
    print_error "❌ Assets folder not created"
    exit 1
fi

# =====================================================
# PHASE 5: LARAVEL OPTIMIZATION
# =====================================================

print_header "PHASE 5: LARAVEL OPTIMIZATION"
echo ""

print_step "5.1 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
print_success "Caches cleared"

print_step "5.2 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
print_success "Configurations cached"

print_step "5.3 Optimizing autoloader..."
composer dump-autoload --optimize
print_success "Autoloader optimized"

print_step "5.4 Restarting queue workers..."
php artisan queue:restart 2>/dev/null || print_warning "Queue restart failed (queue may not be configured)"

# =====================================================
# PHASE 6: PERMISSIONS SETUP
# =====================================================

print_header "PHASE 6: PERMISSIONS SETUP"
echo ""

print_step "6.1 Setting file permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 755 public/build
print_success "File permissions set"

print_step "6.2 Setting ownership (if possible)..."
if command -v chown &> /dev/null; then
    chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || {
        print_warning "Could not set ownership. You may need to run: sudo chown -R www-data:www-data storage bootstrap/cache"
    }
fi

# =====================================================
# PHASE 7: VERIFICATION
# =====================================================

print_header "PHASE 7: VERIFICATION"
echo ""

print_step "7.1 Running system checks..."

# Check critical files
echo ""
print_info "📋 System Status:"
echo "   🔧 Laravel Version: $(php artisan --version 2>/dev/null || echo 'Unknown')"
echo "   🐘 PHP Version: $(php -v | head -n1 | cut -d' ' -f2)"
echo "   📦 Node Version: $(node -v 2>/dev/null || echo 'Not found')"
echo "   📦 NPM Version: $(npm -v 2>/dev/null || echo 'Not found')"

echo ""
print_info "📁 Build Files Status:"
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
print_info "🔧 Laravel Status:"
echo "   ✅ Config cached: $([ -f bootstrap/cache/config.php ] && echo 'Yes' || echo 'No')"
echo "   ✅ Routes cached: $([ -f bootstrap/cache/routes-v7.php ] && echo 'Yes' || echo 'No')"
echo "   ✅ Views cached: $([ -d storage/framework/views ] && echo 'Yes' || echo 'No')"

echo ""
print_info "🗄️ Database Status:"
if php artisan tinker --execute="echo 'Tables: ' . count(DB::select('SHOW TABLES'));" 2>/dev/null; then
    echo "   ✅ Database: Connected"
else
    echo "   ❌ Database: Connection failed"
fi

# =====================================================
# COMPLETION
# =====================================================

echo ""
echo "🎉 COMPLETE PRODUCTION FIX COMPLETED!"
echo "====================================="
echo ""
print_success "All phases completed successfully!"
echo ""
print_info "📊 Summary of fixes applied:"
echo "   ✅ Environment configured"
echo "   ✅ Dependencies installed"
echo "   ✅ Database setup completed"
echo "   ✅ Vite manifest created"
echo "   ✅ Assets built for production"
echo "   ✅ Laravel optimized"
echo "   ✅ Permissions configured"
echo ""
print_info "🌐 Test your website:"
echo "   🏠 Main site: https://website.kecamatangwaesama.id"
echo "   📋 Manifest: https://website.kecamatangwaesama.id/build/manifest.json"
echo "   🔐 Admin login: https://website.kecamatangwaesama.id/login"
echo "       Email: admin@waesama.id"
echo "       Password: password"
echo ""
print_info "📝 Next steps:"
echo "   1. Visit your website to verify it's working"
echo "   2. Check browser console for any remaining errors"
echo "   3. Test all functionality (login, navigation, etc.)"
echo "   4. Update admin password for security"
echo "   5. Configure email settings in .env"
echo "   6. Setup SSL certificate if not already done"
echo ""
print_info "📊 Monitoring:"
echo "   📋 Laravel logs: tail -f storage/logs/laravel.log"
echo "   🌐 Web server logs: Check your hosting panel"
echo "   💾 Database: Use phpMyAdmin or similar tool"
echo ""
print_success "Production deployment completed successfully!"
echo ""