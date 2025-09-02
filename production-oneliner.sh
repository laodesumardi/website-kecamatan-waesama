#!/bin/bash

# One-liner Production Fix for Kantor Camat Waesama
# Run this directly in your production directory

echo "🚀 PRODUCTION ONE-LINER FIX - KANTOR CAMAT WAESAMA"
echo "================================================="
echo ""

# Check if we're in Laravel directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel directory. Please cd to your Laravel project first."
    exit 1
fi

echo "📍 Current directory: $(pwd)"
echo "✅ Laravel project detected"
echo ""

# Install dependencies and build assets
echo "📦 Installing NPM dependencies..."
npm ci --production=false

echo "🔨 Building assets for production..."
npm run build

echo "⚙️ Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔐 Setting permissions..."
chmod -R 755 public/build
chmod -R 775 storage bootstrap/cache

echo "🧹 Clearing caches..."
php artisan cache:clear

echo ""
echo "🔍 VERIFICATION:"
if [ -f "public/build/manifest.json" ]; then
    echo "✅ manifest.json: Found"
    manifest_size=$(stat -c%s "public/build/manifest.json" 2>/dev/null || stat -f%z "public/build/manifest.json" 2>/dev/null || echo "unknown")
    echo "📄 Manifest size: $manifest_size bytes"
else
    echo "❌ manifest.json: Missing"
fi

if [ -d "public/build/assets" ]; then
    asset_count=$(ls -1 public/build/assets 2>/dev/null | wc -l)
    echo "✅ assets folder: $asset_count files"
else
    echo "❌ assets folder: Missing"
fi

echo ""
echo "🎉 ONE-LINER FIX COMPLETED!"
echo "🌐 Test your website: https://website.kecamatangwaesama.id"
echo "📋 Check manifest: https://website.kecamatangwaesama.id/build/manifest.json"
echo ""