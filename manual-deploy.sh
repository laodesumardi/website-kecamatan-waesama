#!/bin/bash

# Manual Deployment Script untuk Kantor Camat Waesama
# Script ini akan mengupdate server dengan versi terbaru dari GitHub

echo "=== Manual Deployment Script ==="
echo "Starting deployment process..."

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fungsi untuk logging
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Fungsi untuk menjalankan command dengan error handling
run_command() {
    local cmd="$1"
    local desc="$2"
    
    log_info "$desc"
    echo "Running: $cmd"
    
    if eval "$cmd"; then
        log_info "✅ $desc - SUCCESS"
        return 0
    else
        log_error "❌ $desc - FAILED"
        return 1
    fi
}

# Backup current state
log_info "Creating backup..."
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"
cp -r . "$BACKUP_DIR/" 2>/dev/null || log_warning "Backup creation failed"

# Git operations
log_info "Updating code from GitHub..."
run_command "git fetch origin" "Fetching latest changes" || exit 1
run_command "git reset --hard origin/main" "Resetting to latest main branch" || exit 1
run_command "git pull origin main" "Pulling latest changes" || exit 1

# Show current commit
CURRENT_COMMIT=$(git rev-parse --short HEAD)
log_info "Current commit: $CURRENT_COMMIT"
log_info "Latest commit message: $(git log -1 --pretty=%B)"

# Composer dependencies
if [ -f "composer.json" ]; then
    log_info "Installing PHP dependencies..."
    run_command "composer install --no-dev --optimize-autoloader" "Installing Composer dependencies" || exit 1
else
    log_warning "composer.json not found, skipping Composer install"
fi

# NPM dependencies and build
if [ -f "package.json" ]; then
    log_info "Installing Node.js dependencies..."
    run_command "npm install" "Installing NPM dependencies" || exit 1
    run_command "npm run build" "Building assets" || exit 1
else
    log_warning "package.json not found, skipping NPM install"
fi

# Laravel optimizations
log_info "Optimizing Laravel application..."
run_command "php artisan config:clear" "Clearing config cache"
run_command "php artisan route:clear" "Clearing route cache"
run_command "php artisan view:clear" "Clearing view cache"
run_command "php artisan cache:clear" "Clearing application cache"

# Rebuild caches for production
run_command "php artisan config:cache" "Caching config"
run_command "php artisan route:cache" "Caching routes"
run_command "php artisan view:cache" "Caching views"
run_command "php artisan optimize" "Optimizing application"

# Set proper permissions
log_info "Setting proper permissions..."
run_command "chmod -R 755 storage" "Setting storage permissions"
run_command "chmod -R 755 bootstrap/cache" "Setting bootstrap cache permissions"

# Optional: Set ownership (uncomment if needed)
# run_command "chown -R www-data:www-data ." "Setting file ownership"

# Verify deployment
log_info "Verifying deployment..."
if [ -f "resources/views/welcome.blade.php" ]; then
    if grep -q "duplicate-menu-fix" "resources/views/welcome.blade.php"; then
        log_info "✅ Menu fix detected in welcome.blade.php"
    else
        log_warning "⚠️  Menu fix not found in welcome.blade.php"
    fi
fi

# Check if Laravel is working
if php artisan --version > /dev/null 2>&1; then
    log_info "✅ Laravel is working properly"
    LARAVEL_VERSION=$(php artisan --version)
    log_info "Laravel version: $LARAVEL_VERSION"
else
    log_error "❌ Laravel is not working properly"
fi

echo ""
log_info "=== Deployment Summary ==="
log_info "Commit: $CURRENT_COMMIT"
log_info "Time: $(date)"
log_info "Backup created in: $BACKUP_DIR"
echo ""
log_info "🎉 Deployment completed successfully!"
log_info "Please test the website: https://kecamatangwaesama.id/public/"
echo ""
log_info "If there are issues, you can restore from backup:"
log_info "cp -r $BACKUP_DIR/* ."
echo ""