#!/bin/bash
# Script Perbaikan 403 Forbidden untuk PuTTY
# Kantor Camat Waesama - https://kecamatangwaesama.id/

echo "======================================================"
echo "    PERBAIKAN ERROR 403 FORBIDDEN - PUTTY SCRIPT    "
echo "    Situs: https://kecamatangwaesama.id/             "
echo "======================================================"
echo ""

# Fungsi untuk menampilkan status
show_status() {
    if [ $? -eq 0 ]; then
        echo "✓ $1"
    else
        echo "✗ $1"
    fi
}

# Deteksi direktori website
echo "1. Mencari direktori website..."
if [ -d "~/public_html" ]; then
    WEB_DIR="~/public_html"
    cd ~/public_html
elif [ -d "/var/www/html" ]; then
    WEB_DIR="/var/www/html"
    cd /var/www/html
elif [ -d "~/htdocs" ]; then
    WEB_DIR="~/htdocs"
    cd ~/htdocs
else
    echo "✗ Direktori website tidak ditemukan!"
    echo "   Silakan masuk ke direktori website secara manual"
    echo "   Contoh: cd ~/public_html"
    exit 1
fi

echo "✓ Direktori website: $(pwd)"
echo ""

# Backup file penting
echo "2. Membuat backup file penting..."
BACKUP_DIR="backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Backup file yang ada
[ -f ".htaccess" ] && cp .htaccess "$BACKUP_DIR/.htaccess.backup" && echo "✓ Backup .htaccess"
[ -f "index.php" ] && cp index.php "$BACKUP_DIR/index.php.backup" && echo "✓ Backup index.php"
[ -f ".env" ] && cp .env "$BACKUP_DIR/.env.backup" && echo "✓ Backup .env"
echo ""

# Perbaiki permission
echo "3. Memperbaiki permission file dan folder..."
find . -type d -exec chmod 755 {} \; 2>/dev/null
show_status "Set permission folder ke 755"

find . -type f -exec chmod 644 {} \; 2>/dev/null
show_status "Set permission file ke 644"

# Permission khusus untuk storage dan cache
if [ -d "storage" ]; then
    chmod -R 755 storage/
    show_status "Set permission storage ke 755"
fi

if [ -d "bootstrap/cache" ]; then
    chmod -R 755 bootstrap/cache/
    show_status "Set permission bootstrap/cache ke 755"
fi
echo ""

# Periksa dan buat file index.php
echo "4. Memeriksa file index.php..."
if [ ! -f "index.php" ]; then
    echo "   File index.php tidak ditemukan, membuat file baru..."
    
    if [ -f "index-root.php" ]; then
        cp index-root.php index.php
        echo "✓ index.php dibuat dari index-root.php"
    elif [ -f "public/index.php" ]; then
        cp public/index.php index.php
        echo "✓ index.php disalin dari public/index.php"
    else
        # Buat index.php untuk Laravel
        cat > index.php << 'EOF'
<?php
// Auto-generated index.php for shared hosting
define('LARAVEL_START', microtime(true));

// Check for maintenance mode
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once __DIR__.'/bootstrap/app.php';

// Handle the request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
EOF
        echo "✓ index.php dibuat dengan konfigurasi Laravel"
    fi
else
    echo "✓ File index.php sudah ada"
fi

chmod 644 index.php 2>/dev/null
echo ""

# Perbaiki file .htaccess
echo "5. Memperbaiki file .htaccess..."
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Handle Laravel routes
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

# Security headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Prevent access to sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.json">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.lock">
    Order allow,deny
    Deny from all
</Files>

# Prevent access to storage and bootstrap cache
RewriteRule ^storage/.* - [F,L]
RewriteRule ^bootstrap/cache/.* - [F,L]

# Enable compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Cache static files
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
</IfModule>
EOF

chmod 644 .htaccess
echo "✓ File .htaccess dibuat dengan konfigurasi yang aman"
echo ""

# Periksa file .env
echo "6. Memeriksa file .env..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✓ .env dibuat dari .env.example"
        echo "⚠️  PENTING: Edit .env dengan konfigurasi database yang benar!"
    else
        echo "✗ File .env dan .env.example tidak ditemukan"
        echo "   Buat file .env secara manual dengan konfigurasi yang benar"
    fi
else
    echo "✓ File .env sudah ada"
fi

chmod 600 .env 2>/dev/null
echo ""

# Buat file test untuk debugging
echo "7. Membuat file test untuk debugging..."
cat > test-debug.php << 'EOF'
<?php
echo "<h1>Debug Test - Kantor Camat Waesama</h1>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<h2>File Status Check</h2>";
$files = [
    'index.php' => 'Main entry point',
    '.env' => 'Environment configuration',
    '.htaccess' => 'Apache configuration',
    'vendor/autoload.php' => 'Composer autoloader',
    'bootstrap/app.php' => 'Laravel bootstrap',
    'app/' => 'Application directory',
    'config/' => 'Configuration directory',
    'storage/' => 'Storage directory'
];

echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>File/Directory</th><th>Status</th><th>Description</th></tr>";
foreach ($files as $file => $desc) {
    $exists = file_exists($file) || is_dir($file);
    $status = $exists ? "<span style='color:green'>✓ EXISTS</span>" : "<span style='color:red'>✗ MISSING</span>";
    echo "<tr><td>$file</td><td>$status</td><td>$desc</td></tr>";
}
echo "</table>";

echo "<h2>Laravel Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require 'vendor/autoload.php';
        echo "<p style='color:green'>✓ Composer autoloader loaded successfully</p>";
        
        if (file_exists('bootstrap/app.php')) {
            echo "<p style='color:green'>✓ Laravel bootstrap file found</p>";
            // Try to load Laravel app
            try {
                $app = require_once 'bootstrap/app.php';
                echo "<p style='color:green'>✓ Laravel application loaded successfully</p>";
            } catch (Exception $e) {
                echo "<p style='color:orange'>⚠️ Laravel app load warning: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color:red'>✗ Laravel bootstrap file not found</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Server Information</h2>";
echo "<p><strong>PHP Extensions:</strong></p>";
$required_extensions = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json'];
echo "<ul>";
foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? "<span style='color:green'>✓</span>" : "<span style='color:red'>✗</span>";
    echo "<li>$status $ext</li>";
}
echo "</ul>";

echo "<hr>";
echo "<p><a href='/'>← Kembali ke halaman utama</a> | <a href='/test-debug.php'>🔄 Refresh test</a></p>";
echo "<p><small>Generated: " . date('Y-m-d H:i:s') . "</small></p>";
?>
EOF

chmod 644 test-debug.php
echo "✓ File test-debug.php dibuat"
echo ""

# Test konfigurasi web server
echo "8. Test konfigurasi web server..."
# Test Apache
if command -v apache2ctl >/dev/null 2>&1; then
    sudo apache2ctl configtest 2>/dev/null && echo "✓ Konfigurasi Apache valid" || echo "⚠️ Konfigurasi Apache mungkin bermasalah"
fi

# Test Nginx
if command -v nginx >/dev/null 2>&1; then
    sudo nginx -t 2>/dev/null && echo "✓ Konfigurasi Nginx valid" || echo "⚠️ Konfigurasi Nginx mungkin bermasalah"
fi
echo ""

# Restart web server jika memungkinkan
echo "9. Restart web server (jika memungkinkan)..."
if command -v systemctl >/dev/null 2>&1; then
    sudo systemctl reload apache2 2>/dev/null && echo "✓ Apache direload" || echo "⚠️ Tidak bisa reload Apache"
    sudo systemctl reload nginx 2>/dev/null && echo "✓ Nginx direload" || echo "⚠️ Tidak bisa reload Nginx"
else
    echo "⚠️ systemctl tidak tersedia, restart manual mungkin diperlukan"
fi
echo ""

# Verifikasi hasil
echo "10. Verifikasi hasil perbaikan..."
echo "Status file penting:"
ls -la index.php .htaccess .env 2>/dev/null | while read line; do
    echo "   $line"
done
echo ""

# Test akses dengan curl jika tersedia
if command -v curl >/dev/null 2>&1; then
    echo "Test akses website:"
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://kecamatangwaesama.id/ 2>/dev/null)
    if [ "$HTTP_CODE" = "200" ]; then
        echo "✓ Website dapat diakses (HTTP $HTTP_CODE)"
    elif [ "$HTTP_CODE" = "403" ]; then
        echo "✗ Masih error 403 Forbidden"
    else
        echo "⚠️ HTTP Status: $HTTP_CODE"
    fi
    
    # Test file debug
    HTTP_CODE_DEBUG=$(curl -s -o /dev/null -w "%{http_code}" http://kecamatangwaesama.id/test-debug.php 2>/dev/null)
    if [ "$HTTP_CODE_DEBUG" = "200" ]; then
        echo "✓ File debug dapat diakses (HTTP $HTTP_CODE_DEBUG)"
    else
        echo "⚠️ File debug HTTP Status: $HTTP_CODE_DEBUG"
    fi
else
    echo "⚠️ curl tidak tersedia untuk test akses"
fi
echo ""

# Ringkasan
echo "======================================================"
echo "                    RINGKASAN PERBAIKAN              "
echo "======================================================"
echo "✓ Permission file dan folder diperbaiki"
echo "✓ File index.php dibuat/diperbaiki"
echo "✓ File .htaccess dibuat dengan konfigurasi aman"
echo "✓ File .env diperiksa"
echo "✓ File test-debug.php dibuat untuk debugging"
echo "✓ Backup disimpan di folder: $BACKUP_DIR"
echo ""
echo "LANGKAH SELANJUTNYA:"
echo "1. Akses: https://kecamatangwaesama.id/test-debug.php"
echo "2. Periksa semua status file dan konfigurasi"
echo "3. Jika test berhasil, akses: https://kecamatangwaesama.id/"
echo "4. Jika masih error, periksa:"
echo "   - Log error hosting"
echo "   - Konfigurasi database di .env"
echo "   - Hubungi hosting provider"
echo ""
echo "TROUBLESHOOTING:"
echo "- Jika masih 403: periksa ownership file (chown)"
echo "- Jika error 500: periksa .env dan database"
echo "- Jika blank page: periksa log error"
echo ""
echo "File backup tersimpan di: $(pwd)/$BACKUP_DIR"
echo "======================================================"
echo "Perbaikan selesai! Silakan test akses website."
echo "======================================================"