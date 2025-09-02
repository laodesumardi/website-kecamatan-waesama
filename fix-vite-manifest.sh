#!/bin/bash

# Quick Fix for Vite Manifest Error
# Specifically addresses: "Vite manifest not found at manifest.json"

set -e

echo "🔧 FIXING VITE MANIFEST ERROR"
echo "=============================="

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_step() {
    echo -e "${BLUE}[STEP]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[OK]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Check if we're in Laravel directory
if [ ! -f "artisan" ]; then
    print_error "Not in Laravel directory. Please cd to your Laravel project first."
    exit 1
fi

print_step "1. Checking current build status..."
if [ -f "public/build/manifest.json" ]; then
    print_warning "Manifest already exists. Rebuilding anyway..."
else
    print_error "Manifest not found. This is the issue we're fixing."
fi

print_step "2. Installing NPM dependencies..."
if command -v npm &> /dev/null; then
    npm install
    print_success "NPM dependencies installed"
else
    print_error "NPM not found. Please install Node.js first."
    exit 1
fi

print_step "3. Building assets with Vite..."
npm run build
if [ $? -eq 0 ]; then
    print_success "Build completed successfully"
else
    print_error "Build failed. Check the error messages above."
    exit 1
fi

print_step "4. Verifying manifest file..."
if [ -f "public/build/manifest.json" ]; then
    print_success "✅ manifest.json created successfully"
    echo "📄 Manifest location: $(pwd)/public/build/manifest.json"
else
    print_error "❌ manifest.json still not found after build"
    exit 1
fi

print_step "5. Checking build assets..."
if [ -d "public/build/assets" ]; then
    asset_count=$(ls -1 public/build/assets 2>/dev/null | wc -l)
    print_success "✅ Assets folder created with $asset_count files"
else
    print_error "❌ Assets folder not created"
    exit 1
fi

print_step "6. Setting proper permissions..."
chmod -R 755 public/build
print_success "Permissions set for build directory"

print_step "7. Clearing Laravel caches..."
php artisan config:clear
php artisan view:clear
php artisan cache:clear
print_success "Laravel caches cleared"

echo ""
echo "🎉 VITE MANIFEST FIX COMPLETED!"
echo "=============================="
echo ""
echo "📋 Summary:"
echo "   ✅ Manifest file: public/build/manifest.json"
echo "   ✅ Assets folder: public/build/assets/"
echo "   ✅ Permissions: Set correctly"
echo "   ✅ Caches: Cleared"
echo ""
echo "🌐 Test your website now:"
echo "   Main site: https://website.kecamatangwaesama.id"
echo "   Manifest: https://website.kecamatangwaesama.id/build/manifest.json"
echo ""
echo "If the error persists:"
echo "1. Check your .env file (APP_ENV=production)"
echo "2. Verify web server configuration"
echo "3. Check Laravel logs: tail -f storage/logs/laravel.log"
echo ""