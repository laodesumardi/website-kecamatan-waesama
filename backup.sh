#!/bin/bash

# Backup Script for Kantor Camat Waesama
# This script creates backups of database and important files

# Configuration
APP_NAME="kantor-camat-waesama"
BACKUP_DIR="/home/backups"
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_NAME="${APP_NAME}_backup_${DATE}"
RETENTION_DAYS=30

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
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

# Load environment variables
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
else
    print_error ".env file not found!"
    exit 1
fi

# Create backup directory
print_status "Creating backup directory..."
mkdir -p "${BACKUP_DIR}/${BACKUP_NAME}"

# Backup database
print_status "Backing up database..."
if [ "$DB_CONNECTION" = "mysql" ]; then
    mysqldump -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "${BACKUP_DIR}/${BACKUP_NAME}/database.sql"
    if [ $? -eq 0 ]; then
        print_success "Database backup completed"
    else
        print_error "Database backup failed"
        exit 1
    fi
elif [ "$DB_CONNECTION" = "sqlite" ]; then
    cp "$DB_DATABASE" "${BACKUP_DIR}/${BACKUP_NAME}/database.sqlite"
    if [ $? -eq 0 ]; then
        print_success "SQLite database backup completed"
    else
        print_error "SQLite database backup failed"
        exit 1
    fi
else
    print_warning "Unsupported database type: $DB_CONNECTION"
fi

# Backup application files
print_status "Backing up application files..."
tar -czf "${BACKUP_DIR}/${BACKUP_NAME}/app_files.tar.gz" \
    --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='.git' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='public/build' \
    .

if [ $? -eq 0 ]; then
    print_success "Application files backup completed"
else
    print_error "Application files backup failed"
    exit 1
fi

# Backup storage files (uploads, etc.)
print_status "Backing up storage files..."
if [ -d "storage/app/public" ]; then
    tar -czf "${BACKUP_DIR}/${BACKUP_NAME}/storage_files.tar.gz" storage/app/public/
    if [ $? -eq 0 ]; then
        print_success "Storage files backup completed"
    else
        print_error "Storage files backup failed"
    fi
else
    print_warning "No storage/app/public directory found"
fi

# Create backup info file
print_status "Creating backup information file..."
cat > "${BACKUP_DIR}/${BACKUP_NAME}/backup_info.txt" << EOF
Backup Information
==================
Application: ${APP_NAME}
Backup Date: $(date)
Backup Name: ${BACKUP_NAME}
PHP Version: $(php -v | head -n 1)
Laravel Version: $(php artisan --version)
Database Type: ${DB_CONNECTION}
Database Name: ${DB_DATABASE}
App Environment: ${APP_ENV}
App Debug: ${APP_DEBUG}

Files Included:
- database.sql (or database.sqlite)
- app_files.tar.gz
- storage_files.tar.gz
- backup_info.txt

Restore Instructions:
1. Extract app_files.tar.gz to application directory
2. Extract storage_files.tar.gz to storage/app/public/
3. Import database.sql to MySQL or copy database.sqlite
4. Run: composer install --no-dev
5. Run: php artisan migrate
6. Run: php artisan config:cache
7. Run: php artisan route:cache
8. Run: php artisan view:cache
EOF

print_success "Backup information file created"

# Compress entire backup
print_status "Compressing backup..."
cd "$BACKUP_DIR"
tar -czf "${BACKUP_NAME}.tar.gz" "$BACKUP_NAME"
if [ $? -eq 0 ]; then
    rm -rf "$BACKUP_NAME"
    print_success "Backup compressed successfully"
else
    print_error "Backup compression failed"
    exit 1
fi

# Clean old backups
print_status "Cleaning old backups (older than ${RETENTION_DAYS} days)..."
find "$BACKUP_DIR" -name "${APP_NAME}_backup_*.tar.gz" -type f -mtime +${RETENTION_DAYS} -delete
print_success "Old backups cleaned"

# Calculate backup size
BACKUP_SIZE=$(du -h "${BACKUP_DIR}/${BACKUP_NAME}.tar.gz" | cut -f1)

# Final summary
print_success "Backup completed successfully!"
echo ""
echo "📋 Backup Summary:"
echo "   📁 Backup Location: ${BACKUP_DIR}/${BACKUP_NAME}.tar.gz"
echo "   📊 Backup Size: ${BACKUP_SIZE}"
echo "   📅 Backup Date: $(date)"
echo "   🗄️ Database: ${DB_CONNECTION} (${DB_DATABASE})"
echo ""
echo "💡 To restore this backup:"
echo "   1. Extract: tar -xzf ${BACKUP_NAME}.tar.gz"
echo "   2. Follow instructions in backup_info.txt"
echo ""
print_success "Backup process completed!"