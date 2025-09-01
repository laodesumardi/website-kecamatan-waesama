#!/bin/bash

# Auto-Deployment Script untuk GitHub Webhook
# Script ini akan dijalankan oleh webhook handler

set -e  # Exit on any error

# Konfigurasi
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_FILE="$PROJECT_DIR/storage/logs/deployment.log"
BRANCH="main"

# Fungsi logging
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Fungsi untuk menjalankan command dengan logging
run_command() {
    local cmd="$1"
    log "Executing: $cmd"
    
    if eval "$cmd" >> "$LOG_FILE" 2>&1; then
        log "✓ Success: $cmd"
        return 0
    else
        log "✗ Failed: $cmd"
        return 1
    fi
}

# Mulai deployment
log "=== Starting Auto-Deployment ==="
log "Project Directory: $PROJECT_DIR"
log "Target Branch: $BRANCH"

# Pindah ke directory project
cd "$PROJECT_DIR"

# Backup current state (optional)
log "Creating backup of current state..."
run_command "git stash push -m 'Auto-backup before deployment $(date)'"

# Update repository
log "Updating repository..."
run_command "git fetch origin"
run_command "git reset --hard origin/$BRANCH"
run_command "git pull origin $BRANCH"

# Install/Update dependencies
log "Installing PHP dependencies..."
if [ -f "composer.json" ]; then
    run_command "composer install --no-dev --optimize-autoloader --no-interaction"
fi

log "Installing Node.js dependencies..."
if [ -f "package.json" ]; then
    run_command "npm ci --production=false"
fi

# Build assets
log "Building assets..."
if [ -f "package.json" ] && grep -q '"build"' package.json; then
    run_command "npm run build"
fi

# Laravel optimizations
log "Optimizing Laravel application..."
if [ -f "artisan" ]; then
    run_command "php artisan config:cache"
    run_command "php artisan route:cache"
    run_command "php artisan view:cache"
    run_command "php artisan optimize"
fi

# Set proper permissions
log "Setting proper permissions..."
if [ -d "storage" ]; then
    run_command "chmod -R 775 storage"
fi
if [ -d "bootstrap/cache" ]; then
    run_command "chmod -R 775 bootstrap/cache"
fi

# Clear any cached data that might cause issues
log "Clearing caches..."
if [ -f "artisan" ]; then
    run_command "php artisan cache:clear"
fi

log "=== Deployment Completed Successfully ==="
log "Deployment finished at $(date)"

# Send notification (optional)
if command -v curl &> /dev/null; then
    COMMIT_HASH=$(git rev-parse HEAD)
    log "Latest commit: $COMMIT_HASH"
fi

exit 0