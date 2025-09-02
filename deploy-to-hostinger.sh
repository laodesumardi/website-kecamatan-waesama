#!/bin/bash

# =============================================================================
# SCRIPT DEPLOYMENT OTOMATIS KE HOSTINGER
# Sistem Informasi Kantor Camat Waesama
# =============================================================================

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="Kantor Camat Waesama"
LOCAL_PROJECT_PATH="$(pwd)"
BACKUP_DIR="./backups"
DEPLOY_EXCLUDE="deploy-exclude.txt"

echo -e "${BLUE}==============================================================================${NC}"
echo -e "${BLUE}🚀 DEPLOYMENT SCRIPT - ${PROJECT_NAME}${NC}"
echo -e "${BLUE}==============================================================================${NC}"
echo ""

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_step() {
    echo -e "${BLUE}[STEP]${NC} $1"
}

# Create backup directory
print_step "Membuat direktori backup..."
mkdir -p "$BACKUP_DIR"

# Step 1: Prepare production files
print_step "1. Mempersiapkan file production..."

print_status "Building assets untuk production..."
npm run build

print_status "Clearing cache Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

print_status "Caching konfigurasi untuk production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

print_status "Optimizing autoloader..."
composer dump-autoload --optimize --no-dev

print_status "✅ File production siap!"
echo ""

# Step 2: Create deployment package
print_step "2. Membuat package deployment..."

# Create exclude file for deployment
cat > "$DEPLOY_EXCLUDE" << EOF
node_modules/
.git/
.env
storage/logs/*.log
tests/
.phpunit.result.cache
.editorconfig
.gitattributes
.gitignore
README.md
*.md
backups/
deploy-*.sh
deploy-exclude.txt
EOF

DEPLOY_PACKAGE="$BACKUP_DIR/deploy-package-$(date +%Y%m%d-%H%M%S).zip"

print_status "Membuat package deployment: $DEPLOY_PACKAGE"
zip -r "$DEPLOY_PACKAGE" . -x@"$DEPLOY_EXCLUDE"

print_status "✅ Package deployment dibuat: $DEPLOY_PACKAGE"
echo ""

# Step 3: Create production .env template
print_step "3. Membuat template .env untuk production..."

ENV_TEMPLATE="$BACKUP_DIR/.env.production.template"
cat > "$ENV_TEMPLATE" << 'EOF'
# =============================================================================
# PRODUCTION ENVIRONMENT CONFIGURATION
# Kantor Camat Waesama - Hostinger Deployment
# =============================================================================

APP_NAME="Kantor Camat Waesama"
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_WITH_php_artisan_key:generate
APP_DEBUG=false
APP_TIMEZONE=Asia/Makassar
APP_URL=https://yourdomain.com

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database Configuration (Update with your Hostinger details)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

# Cache Configuration
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database
CACHE_PREFIX=

# Redis Configuration (if available)
MEMCACHED_HOST=127.0.0.1
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration (Update with your Hostinger email)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@yourdomain.com
MAIL_FROM_NAME="Kantor Camat Waesama"

# AWS Configuration (if needed)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Vite Configuration
VITE_APP_NAME="${APP_NAME}"
EOF

print_status "✅ Template .env production dibuat: $ENV_TEMPLATE"
echo ""

# Step 4: Create deployment commands script
print_step "4. Membuat script command untuk server..."

SERVER_COMMANDS="$BACKUP_DIR/server-commands.sh"
cat > "$SERVER_COMMANDS" << 'EOF'
#!/bin/bash

# =============================================================================
# COMMANDS TO RUN ON HOSTINGER SERVER
# Run these commands via SSH or Terminal in cPanel
# =============================================================================

echo "🚀 Starting server-side deployment..."

# Navigate to project directory
cd public_html

# Generate application key
echo "📝 Generating application key..."
php artisan key:generate --force

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Seed database (optional)
echo "🌱 Seeding database..."
php artisan db:seed --force

# Cache configurations for production
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create symbolic link for storage (if needed)
echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ Server-side deployment completed!"
echo "🌐 Your application should now be accessible at your domain."
EOF

chmod +x "$SERVER_COMMANDS"
print_status "✅ Script server commands dibuat: $SERVER_COMMANDS"
echo ""

# Step 5: Create quick deployment checklist
print_step "5. Membuat checklist deployment..."

CHECKLIST="$BACKUP_DIR/deployment-checklist.md"
cat > "$CHECKLIST" << 'EOF'
# 📋 DEPLOYMENT CHECKLIST - Hostinger

## ✅ Pre-Deployment (Local)
- [ ] Build assets completed (`npm run build`)
- [ ] Laravel caches cleared and optimized
- [ ] Composer autoloader optimized
- [ ] Deployment package created
- [ ] .env template prepared

## 🔄 Hostinger Deployment Steps

### 1. Backup Existing Project
- [ ] Export database via phpMyAdmin
- [ ] Download current files via File Manager
- [ ] Store backups safely

### 2. Upload New Project
- [ ] Clear public_html folder
- [ ] Upload deployment package ZIP
- [ ] Extract files in public_html
- [ ] Delete ZIP file after extraction

### 3. Database Setup
- [ ] Create/use existing database
- [ ] Import database-migration-complete.sql
- [ ] Note database credentials

### 4. Environment Configuration
- [ ] Copy .env.example to .env
- [ ] Update .env with production settings:
  - [ ] APP_URL (your domain)
  - [ ] Database credentials
  - [ ] Mail configuration
  - [ ] APP_DEBUG=false
  - [ ] APP_ENV=production

### 5. Server Commands (via SSH/Terminal)
- [ ] Run: `php artisan key:generate --force`
- [ ] Run: `chmod -R 775 storage/ bootstrap/cache/`
- [ ] Run: `php artisan migrate --force`
- [ ] Run: `php artisan db:seed --force`
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Run: `php artisan storage:link`

### 6. Server Configuration
- [ ] Set PHP version to 8.1+
- [ ] Enable required PHP extensions
- [ ] Configure document root (if needed)
- [ ] Check .htaccess in public folder

### 7. Testing
- [ ] Homepage loads correctly
- [ ] Login/register works
- [ ] Admin dashboard accessible
- [ ] File uploads work
- [ ] Email notifications work
- [ ] Mobile responsive design
- [ ] All CRUD operations work

## 🚨 Troubleshooting
- [ ] Check storage/logs/laravel.log for errors
- [ ] Verify file permissions
- [ ] Check database connection
- [ ] Verify .env configuration
- [ ] Clear browser cache

## 📞 Support Resources
- Hostinger Knowledge Base
- Laravel Documentation
- Project Documentation
EOF

print_status "✅ Deployment checklist dibuat: $CHECKLIST"
echo ""

# Step 6: Summary
print_step "6. Ringkasan deployment..."

echo -e "${GREEN}==============================================================================${NC}"
echo -e "${GREEN}🎉 DEPLOYMENT PACKAGE SIAP!${NC}"
echo -e "${GREEN}==============================================================================${NC}"
echo ""
echo -e "${BLUE}📦 File yang dibuat:${NC}"
echo "   • $DEPLOY_PACKAGE"
echo "   • $ENV_TEMPLATE"
echo "   • $SERVER_COMMANDS"
echo "   • $CHECKLIST"
echo ""
echo -e "${BLUE}📋 Langkah selanjutnya:${NC}"
echo "   1. Baca file: $CHECKLIST"
echo "   2. Login ke cPanel Hostinger"
echo "   3. Backup project lama"
echo "   4. Upload: $DEPLOY_PACKAGE"
echo "   5. Konfigurasi .env dengan template: $ENV_TEMPLATE"
echo "   6. Jalankan commands: $SERVER_COMMANDS"
echo ""
echo -e "${YELLOW}⚠️  PENTING:${NC}"
echo "   • Backup project lama sebelum deployment"
echo "   • Update database credentials di .env"
echo "   • Test semua fitur setelah deployment"
echo "   • Ganti password default admin"
echo ""
echo -e "${GREEN}✅ Deployment script selesai!${NC}"

# Cleanup
rm -f "$DEPLOY_EXCLUDE"

echo -e "${BLUE}==============================================================================${NC}"