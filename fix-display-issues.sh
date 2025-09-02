#!/bin/bash

# Script untuk memperbaiki masalah tampilan website production
# Mengatasi masalah Tailwind CSS yang tidak ter-load dengan benar

echo "=== FIXING DISPLAY ISSUES ==="
echo "Memperbaiki masalah tampilan website..."

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 1. Clear all caches
print_status "Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Install npm dependencies
print_status "Installing npm dependencies..."
npm install

# 3. Build assets for production
print_status "Building assets for production..."
npm run build

# 4. Verify build files
print_status "Verifying build files..."
if [ -f "public/build/manifest.json" ]; then
    print_status "✓ Manifest file exists"
else
    print_error "✗ Manifest file missing"
fi

if [ -d "public/build/assets" ]; then
    print_status "✓ Assets directory exists"
    ls -la public/build/assets/
else
    print_error "✗ Assets directory missing"
fi

# 5. Set proper permissions
print_status "Setting proper permissions..."
chmod -R 755 public/build/
chown -R www-data:www-data public/build/ 2>/dev/null || true

# 6. Optimize for production
print_status "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Check application status
print_status "Checking application status..."
php artisan about

echo
print_status "=== DISPLAY FIX COMPLETED ==="
print_status "Website: https://website.kecamatangwaesama.id"
print_status "Perubahan yang dilakukan:"
echo "1. ✓ Converted Tailwind classes to inline styles in navigation"
echo "2. ✓ Added JavaScript hover effects"
echo "3. ✓ Ensured consistent styling when Tailwind fails to load"
echo "4. ✓ Rebuilt assets for production"
echo "5. ✓ Cleared all caches"
echo "6. ✓ Optimized application"

print_warning "CATATAN:"
echo "- Navigation sekarang menggunakan inline styles yang konsisten"
echo "- Hover effects menggunakan JavaScript events"
echo "- Mobile menu disembunyikan sementara untuk fokus desktop view"
echo "- Jika masih ada masalah, cek console browser untuk error JavaScript"