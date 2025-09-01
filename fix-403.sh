#!/bin/bash

# Script untuk Mengatasi Error 403 Forbidden
# Kantor Camat Waesama

echo "=== FIXING 403 FORBIDDEN ERROR ==="
echo "Memulai perbaikan error 403..."

# Warna untuk output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fungsi untuk menampilkan pesan
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 1. Cek current directory dan permissions
print_status "Checking current directory dan permissions..."
pwd
ls -la

# 2. Set proper directory permissions
print_status "Setting directory permissions..."
find . -type d -exec chmod 755 {} \;
if [ $? -eq 0 ]; then
    print_status "Directory permissions berhasil diset ke 755"
else
    print_error "Gagal setting directory permissions"
fi

# 3. Set proper file permissions
print_status "Setting file permissions..."
find . -type f -exec chmod 644 {} \;
if [ $? -eq 0 ]; then
    print_status "File permissions berhasil diset ke 644"
else
    print_error "Gagal setting file permissions"
fi

# 4. Set executable permissions untuk script dan artisan
print_status "Setting executable permissions..."
chmod +x artisan
chmod +x deploy.sh
chmod +x fix-403.sh
print_status "Executable permissions berhasil diset"

# 5. Set special permissions untuk storage dan cache
print_status "Setting special permissions untuk storage dan cache..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
print_status "Storage dan cache permissions berhasil diset"

# 6. Cek dan perbaiki .htaccess di public
print_status "Checking .htaccess di public directory..."
if [ ! -f public/.htaccess ]; then
    print_warning "File .htaccess tidak ditemukan di public, membuat file baru..."
    cat > public/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Prevent access to sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Prevent directory browsing
Options -Indexes
EOF
    print_status "File .htaccess berhasil dibuat"
else
    print_status "File .htaccess sudah ada"
fi

# 7. Cek dan buat index.php di public jika tidak ada
print_status "Checking index.php di public directory..."
if [ ! -f public/index.php ]; then
    print_warning "File index.php tidak ditemukan di public, copying dari root..."
    if [ -f index.php ]; then
        cp index.php public/
        print_status "File index.php berhasil di-copy ke public"
    else
        print_error "File index.php tidak ditemukan di root directory"
    fi
else
    print_status "File index.php sudah ada di public"
fi

# 8. Cek ownership (jika memungkinkan)
print_status "Checking file ownership..."
ls -la public/

# 9. Test web server configuration
print_status "Testing web server configuration..."
if command -v curl &> /dev/null; then
    print_status "Testing dengan curl..."
    curl -I https://web.kecamatangwaesama.id/ 2>/dev/null || print_warning "Curl test gagal atau server belum merespon"
else
    print_warning "Curl tidak tersedia untuk testing"
fi

# 10. Cek Apache/Nginx configuration (informational)
print_status "Informasi konfigurasi server:"
echo "Document Root harus mengarah ke: $(pwd)/public"
echo "Index file: index.php"
echo "PHP version minimal: 8.1"

# 11. Generate .htaccess untuk root directory (redirect ke public)
print_status "Creating root .htaccess untuk redirect ke public..."
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF
print_status "Root .htaccess berhasil dibuat"

# 12. Clear cache Laravel
print_status "Clearing Laravel cache..."
php artisan config:clear 2>/dev/null || print_warning "Config clear gagal"
php artisan cache:clear 2>/dev/null || print_warning "Cache clear gagal"
php artisan route:clear 2>/dev/null || print_warning "Route clear gagal"
php artisan view:clear 2>/dev/null || print_warning "View clear gagal"

# 13. Final permissions check
print_status "Final permissions check..."
ls -la public/
ls -la storage/
ls -la bootstrap/cache/

echo
print_status "=== PERBAIKAN 403 FORBIDDEN SELESAI ==="
print_status "Langkah selanjutnya:"
echo "1. Pastikan Document Root server mengarah ke folder 'public'"
echo "2. Pastikan PHP version minimal 8.1"
echo "3. Pastikan mod_rewrite Apache enabled"
echo "4. Restart web server jika diperlukan"
echo "5. Test website: https://web.kecamatangwaesama.id"

print_warning "CATATAN PENTING:"
echo "- Jika masih 403, hubungi administrator server"
echo "- Cek error log server: tail -f /var/log/apache2/error.log"
echo "- Pastikan user www-data memiliki akses ke directory"