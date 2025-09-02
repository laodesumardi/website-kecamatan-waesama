#!/bin/bash

# Auto Upload Script to Production Server
# This script uploads all necessary files to fix the Vite manifest issue

set -e

echo "🚀 UPLOADING FILES TO PRODUCTION SERVER"
echo "======================================"

# Server configuration
SERVER_HOST="website.kecamatangwaesama.id"
SERVER_USER="u798974089"
SERVER_PATH="/home/u798974089/domains/website.kecamatangwaesama.id/public_html"

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
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Check if required files exist
print_step "1. Checking required files..."

required_files=(
    "fix-vite-manifest.sh"
    "deploy-production.sh"
    "resources/views/welcome.blade.php"
    "package.json"
    "composer.json"
)

for file in "${required_files[@]}"; do
    if [ -f "$file" ]; then
        print_success "✅ $file found"
    else
        print_error "❌ $file not found"
        exit 1
    fi
done

# Check SSH connection
print_step "2. Testing SSH connection..."
if ssh -o ConnectTimeout=10 -o BatchMode=yes "$SERVER_USER@$SERVER_HOST" exit 2>/dev/null; then
    print_success "SSH connection successful"
else
    print_error "SSH connection failed. Please check:"
    echo "   - Server hostname: $SERVER_HOST"
    echo "   - Username: $SERVER_USER"
    echo "   - SSH key or password authentication"
    echo "   - Network connectivity"
    exit 1
fi

# Upload deployment scripts
print_step "3. Uploading deployment scripts..."
scp fix-vite-manifest.sh "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/"
scp deploy-production.sh "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/"
print_success "Deployment scripts uploaded"

# Upload updated Laravel files
print_step "4. Uploading updated Laravel files..."

# Upload welcome.blade.php (with inline styles fix)
scp resources/views/welcome.blade.php "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/resources/views/"
print_success "welcome.blade.php uploaded"

# Upload package.json and composer.json
scp package.json "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/"
scp composer.json "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/"
print_success "Configuration files uploaded"

# Upload other important files if they exist
optional_files=(
    ".env.example"
    "vite.config.js"
    "tailwind.config.js"
    "postcss.config.js"
)

for file in "${optional_files[@]}"; do
    if [ -f "$file" ]; then
        scp "$file" "$SERVER_USER@$SERVER_HOST:$SERVER_PATH/"
        print_success "✅ $file uploaded"
    else
        print_warning "⚠️ $file not found, skipping"
    fi
done

# Set permissions for scripts
print_step "5. Setting script permissions..."
ssh "$SERVER_USER@$SERVER_HOST" "cd $SERVER_PATH && chmod +x fix-vite-manifest.sh deploy-production.sh"
print_success "Script permissions set"

# Run the fix script
print_step "6. Running Vite manifest fix..."
echo "Executing fix-vite-manifest.sh on server..."
ssh "$SERVER_USER@$SERVER_HOST" "cd $SERVER_PATH && ./fix-vite-manifest.sh"

if [ $? -eq 0 ]; then
    print_success "Vite manifest fix completed successfully!"
else
    print_error "Fix script failed. Please check the output above."
    exit 1
fi

# Verify the fix
print_step "7. Verifying deployment..."
echo "Checking if manifest.json exists..."
ssh "$SERVER_USER@$SERVER_HOST" "cd $SERVER_PATH && ls -la public/build/manifest.json"

if [ $? -eq 0 ]; then
    print_success "✅ manifest.json found on server!"
else
    print_error "❌ manifest.json still not found"
    exit 1
fi

echo ""
echo "🎉 UPLOAD AND DEPLOYMENT COMPLETED!"
echo "==================================="
echo ""
echo "📋 What was done:"
echo "   ✅ Uploaded deployment scripts"
echo "   ✅ Uploaded updated Laravel files"
echo "   ✅ Set proper permissions"
echo "   ✅ Ran Vite manifest fix"
echo "   ✅ Verified manifest.json creation"
echo ""
echo "🌐 Test your website:"
echo "   Main site: https://website.kecamatangwaesama.id"
echo "   Manifest: https://website.kecamatangwaesama.id/build/manifest.json"
echo ""
echo "📊 Next steps:"
echo "   1. Open your website in browser"
echo "   2. Check browser console for errors"
echo "   3. Test all functionality"
echo "   4. Monitor logs if needed"
echo ""
print_success "Deployment process completed successfully!"
echo ""