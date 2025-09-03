# Panduan Perbaikan 403 Forbidden via PuTTY

## Koneksi ke Server

### 1. Buka PuTTY dan koneksi ke server:
```bash
# Ganti dengan detail server Anda
ssh username@kecamatangwaesama.id
# atau
ssh username@IP_ADDRESS
```

### 2. Masuk ke direktori website:
```bash
cd /home/username/public_html
# atau
cd /var/www/html
# atau sesuai dengan struktur hosting Anda
```

## Diagnosis Masalah

### 1. Periksa file yang ada:
```bash
ls -la
```

### 2. Periksa permission file dan folder:
```bash
# Lihat permission detail
ls -la | grep -E "(index|htaccess|env)"

# Periksa struktur direktori
find . -maxdepth 2 -type d -exec ls -ld {} \;
```

### 3. Periksa log error:
```bash
# Periksa error log Apache/Nginx
tail -f /var/log/apache2/error.log
# atau
tail -f /var/log/nginx/error.log
# atau
tail -f ~/logs/error.log
```

## Perbaikan Step-by-Step

### Step 1: Backup File Penting
```bash
# Buat folder backup
mkdir -p backup/$(date +%Y%m%d_%H%M%S)

# Backup file penting
cp .htaccess backup/$(date +%Y%m%d_%H%M%S)/.htaccess.backup 2>/dev/null || echo "No .htaccess found"
cp index.php backup/$(date +%Y%m%d_%H%M%S)/index.php.backup 2>/dev/null || echo "No index.php found"
cp .env backup/$(date +%Y%m%d_%H%M%S)/.env.backup 2>/dev/null || echo "No .env found"
```

### Step 2: Perbaiki Permission
```bash
# Set permission folder ke 755
find . -type d -exec chmod 755 {} \;

# Set permission file ke 644
find . -type f -exec chmod 644 {} \;

# Set permission khusus untuk folder storage dan cache
chmod -R 755 storage/ 2>/dev/null || echo "No storage folder"
chmod -R 755 bootstrap/cache/ 2>/dev/null || echo "No bootstrap/cache folder"

# Verifikasi permission
ls -la | head -10
```

### Step 3: Periksa dan Buat File Index
```bash
# Periksa apakah index.php ada
if [ ! -f "index.php" ]; then
    echo "File index.php tidak ditemukan, membuat file baru..."
    
    # Jika ada index-root.php, copy ke index.php
    if [ -f "index-root.php" ]; then
        cp index-root.php index.php
        echo "✓ index.php dibuat dari index-root.php"
    elif [ -f "public/index.php" ]; then
        cp public/index.php index.php
        echo "✓ index.php disalin dari public/index.php"
    else
        # Buat index.php sederhana
        cat > index.php << 'EOF'
<?php
// Auto-generated index.php for hosting compatibility

// Detect base path
$basePath = __DIR__;
if (file_exists($basePath . '/public/index.php')) {
    // Standard Laravel structure
    require_once $basePath . '/public/index.php';
} else {
    // Shared hosting structure
    define('LARAVEL_START', microtime(true));
    
    // Check for maintenance mode
    if (file_exists($maintenanceFile = $basePath.'/storage/framework/maintenance.php')) {
        require $maintenanceFile;
    }
    
    // Register Composer autoloader
    require $basePath.'/vendor/autoload.php';
    
    // Bootstrap Laravel application
    $app = require_once $basePath.'/bootstrap/app.php';
    
    // Handle the request
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();
    
    $kernel->terminate($request, $response);
}
EOF
        echo "✓ index.php dibuat dengan konfigurasi otomatis"
    fi
else
    echo "✓ File index.php sudah ada"
fi

# Set permission untuk index.php
chmod 644 index.php
```

### Step 4: Perbaiki File .htaccess
```bash
# Backup .htaccess yang ada (jika ada)
if [ -f ".htaccess" ]; then
    cp .htaccess .htaccess.backup
    echo "✓ Backup .htaccess dibuat"
fi

# Buat .htaccess baru yang kompatibel
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

echo "✓ File .htaccess dibuat dengan konfigurasi yang aman"
chmod 644 .htaccess
```

### Step 5: Periksa File .env
```bash
# Periksa apakah .env ada
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

# Set permission untuk .env
chmod 600 .env 2>/dev/null || echo "File .env tidak ada"
```

### Step 6: Buat File Test PHP
```bash
# Buat file test untuk debugging
cat > test-php.php << 'EOF'
<?php
// Test file untuk memeriksa konfigurasi PHP
echo "<h1>Test PHP - Kantor Camat Waesama</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";

// Test file permissions
echo "<h2>File Permissions Test</h2>";
$files = ['index.php', '.env', 'bootstrap/app.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p>$file: $perms</p>";
    } else {
        echo "<p>$file: <span style='color:red'>NOT FOUND</span></p>";
    }
}

// Test Laravel
echo "<h2>Laravel Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require 'vendor/autoload.php';
        echo "<p style='color:green'>✓ Composer autoloader loaded</p>";
        
        if (file_exists('bootstrap/app.php')) {
            echo "<p style='color:green'>✓ Laravel bootstrap file found</p>";
        } else {
            echo "<p style='color:red'>✗ Laravel bootstrap file not found</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='/'>← Kembali ke halaman utama</a></p>";
?>
EOF

echo "✓ File test-php.php dibuat"
chmod 644 test-php.php
```

### Step 7: Test Konfigurasi Apache/Nginx
```bash
# Test konfigurasi Apache
sudo apache2ctl configtest 2>/dev/null || echo "Apache config test tidak tersedia atau tidak ada permission"

# Test konfigurasi Nginx
sudo nginx -t 2>/dev/null || echo "Nginx config test tidak tersedia atau tidak ada permission"

# Restart web server (jika ada permission)
sudo systemctl reload apache2 2>/dev/null || echo "Tidak bisa reload Apache (permission atau service tidak ada)"
sudo systemctl reload nginx 2>/dev/null || echo "Tidak bisa reload Nginx (permission atau service tidak ada)"
```

## Verifikasi Perbaikan

### 1. Test akses file:
```bash
# Test akses file test
curl -I http://kecamatangwaesama.id/test-php.php

# Test akses halaman utama
curl -I http://kecamatangwaesama.id/
```

### 2. Periksa log error terbaru:
```bash
# Lihat log error terbaru
tail -20 ~/logs/error.log 2>/dev/null || tail -20 /var/log/apache2/error.log 2>/dev/null || echo "Log error tidak ditemukan"
```

### 3. Periksa status file:
```bash
echo "=== STATUS FILE PENTING ==="
ls -la index.php .htaccess .env 2>/dev/null
echo ""
echo "=== STRUKTUR DIREKTORI ==="
ls -la | head -15
```

## Script Lengkap untuk Copy-Paste

```bash
#!/bin/bash
# Script lengkap perbaikan 403 Forbidden

echo "=== PERBAIKAN 403 FORBIDDEN - KANTOR CAMAT WAESAMA ==="
echo "Situs: https://kecamatangwaesama.id/"
echo ""

# Masuk ke direktori website
cd ~/public_html || cd /var/www/html || { echo "Direktori website tidak ditemukan!"; exit 1; }

echo "Direktori saat ini: $(pwd)"
echo ""

# Backup file penting
echo "1. Membuat backup..."
mkdir -p backup/$(date +%Y%m%d_%H%M%S)
cp .htaccess backup/$(date +%Y%m%d_%H%M%S)/.htaccess.backup 2>/dev/null || echo "No .htaccess found"
cp index.php backup/$(date +%Y%m%d_%H%M%S)/index.php.backup 2>/dev/null || echo "No index.php found"
cp .env backup/$(date +%Y%m%d_%H%M%S)/.env.backup 2>/dev/null || echo "No .env found"

# Perbaiki permission
echo "2. Memperbaiki permission..."
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod -R 755 storage/ 2>/dev/null || echo "No storage folder"
chmod -R 755 bootstrap/cache/ 2>/dev/null || echo "No bootstrap/cache folder"

# Buat/perbaiki index.php
echo "3. Memeriksa file index.php..."
if [ ! -f "index.php" ]; then
    if [ -f "index-root.php" ]; then
        cp index-root.php index.php
        echo "✓ index.php dibuat dari index-root.php"
    else
        cat > index.php << 'INDEXEOF'
<?php
define('LARAVEL_START', microtime(true));
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();
$kernel->terminate($request, $response);
INDEXEOF
        echo "✓ index.php dibuat dengan konfigurasi Laravel"
    fi
else
    echo "✓ File index.php sudah ada"
fi
chmod 644 index.php

# Buat/perbaiki .htaccess
echo "4. Memperbaiki .htaccess..."
cat > .htaccess << 'HTACCESSEOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
<Files ".env">
    Order allow,deny
    Deny from all
</Files>
HTACCESSEOF
chmod 644 .htaccess
echo "✓ .htaccess diperbaiki"

# Periksa .env
echo "5. Memeriksa file .env..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✓ .env dibuat dari .env.example"
    else
        echo "⚠️  File .env tidak ada - buat secara manual"
    fi
else
    echo "✓ File .env sudah ada"
fi
chmod 600 .env 2>/dev/null

# Buat file test
echo "6. Membuat file test..."
cat > test-debug.php << 'TESTEOF'
<?php
echo "<h1>Debug Test - Kantor Camat Waesama</h1>";
echo "<p>PHP: " . phpversion() . "</p>";
echo "<p>Directory: " . __DIR__ . "</p>";
echo "<p>Files:</p><ul>";
$files = ['index.php', '.env', '.htaccess', 'vendor/autoload.php', 'bootstrap/app.php'];
foreach($files as $f) {
    $status = file_exists($f) ? '✓' : '✗';
    echo "<li>$status $f</li>";
}
echo "</ul>";
?>
TESTEOF
chmod 644 test-debug.php
echo "✓ File test-debug.php dibuat"

echo ""
echo "=== PERBAIKAN SELESAI ==="
echo "Test akses:"
echo "1. https://kecamatangwaesama.id/test-debug.php"
echo "2. https://kecamatangwaesama.id/"
echo ""
echo "Jika masih error, periksa:"
echo "- Log error hosting"
echo "- Konfigurasi database di .env"
echo "- Permission file dan folder"
```

## Troubleshooting Lanjutan

### Jika masih 403 setelah perbaikan:

1. **Periksa ownership file:**
```bash
# Lihat owner file
ls -la | head -10

# Ubah owner jika diperlukan (sesuaikan username)
sudo chown -R username:username . 2>/dev/null || echo "Tidak ada permission untuk chown"
```

2. **Periksa konfigurasi virtual host:**
```bash
# Lihat konfigurasi Apache
sudo cat /etc/apache2/sites-available/000-default.conf 2>/dev/null || echo "Tidak bisa akses config Apache"

# Lihat konfigurasi Nginx
sudo cat /etc/nginx/sites-available/default 2>/dev/null || echo "Tidak bisa akses config Nginx"
```

3. **Periksa SELinux (jika ada):**
```bash
# Periksa status SELinux
getenforce 2>/dev/null || echo "SELinux tidak aktif"

# Set context SELinux untuk web files
sudo setsebool -P httpd_enable_homedirs 1 2>/dev/null || echo "SELinux command tidak tersedia"
```

4. **Test dengan file HTML sederhana:**
```bash
# Buat file HTML test
echo "<h1>Test HTML - Kantor Camat Waesama</h1><p>Jika ini terlihat, server web berfungsi!</p>" > test.html
chmod 644 test.html

# Test akses
curl -I http://kecamatangwaesama.id/test.html
```

## Kontak Support

Jika semua langkah di atas tidak berhasil:
1. Hubungi hosting provider (Hostinger, dll)
2. Berikan informasi:
   - Error yang muncul
   - Langkah yang sudah dilakukan
   - Output dari perintah `ls -la` dan log error
3. Minta bantuan konfigurasi server web

---

**Catatan:** Simpan panduan ini dan jalankan perintah satu per satu untuk memastikan setiap langkah berhasil.