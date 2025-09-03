# COPY-PASTE SCRIPT UNTUK PUTTY

## 🚀 EKSEKUSI CEPAT - TANPA UPLOAD FILE

### Langkah 1: Login ke PuTTY
1. Buka PuTTY dan login ke server hosting
2. Masuk ke direktori website:

```bash
cd ~/public_html
```

### Langkah 2: Copy-Paste Script Berikut

**COPY SELURUH SCRIPT DI BAWAH INI DAN PASTE KE PUTTY:**

```bash
#!/bin/bash
echo "======================================================"
echo "    PERBAIKAN ERROR 403 FORBIDDEN - QUICK FIX       "
echo "    Situs: https://kecamatangwaesama.id/             "
echo "======================================================"
echo ""

# Deteksi direktori website
echo "1. Mencari direktori website..."
if [ -d "~/public_html" ]; then
    cd ~/public_html
elif [ -d "/var/www/html" ]; then
    cd /var/www/html
elif [ -d "~/htdocs" ]; then
    cd ~/htdocs
else
    echo "Masuk ke direktori website secara manual"
fi

echo "Direktori saat ini: $(pwd)"
echo ""

# Backup cepat
echo "2. Backup file penting..."
mkdir -p backup_$(date +%Y%m%d_%H%M%S)
[ -f ".htaccess" ] && cp .htaccess backup_*/
[ -f "index.php" ] && cp index.php backup_*/
[ -f ".env" ] && cp .env backup_*/
echo "Backup selesai"
echo ""

# Perbaiki permission
echo "3. Memperbaiki permission..."
find . -type d -exec chmod 755 {} \; 2>/dev/null
find . -type f -exec chmod 644 {} \; 2>/dev/null
[ -d "storage" ] && chmod -R 755 storage/
[ -d "bootstrap/cache" ] && chmod -R 755 bootstrap/cache/
echo "Permission diperbaiki"
echo ""

# Buat index.php
echo "4. Membuat index.php..."
if [ ! -f "index.php" ]; then
    if [ -f "index-root.php" ]; then
        cp index-root.php index.php
        echo "index.php dibuat dari index-root.php"
    elif [ -f "public/index.php" ]; then
        cp public/index.php index.php
        echo "index.php disalin dari public/index.php"
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
        echo "index.php dibuat dengan konfigurasi Laravel"
    fi
else
    echo "index.php sudah ada"
fi
chmod 644 index.php
echo ""

# Buat .htaccess
echo "5. Membuat .htaccess..."
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

RewriteRule ^storage/.* - [F,L]
RewriteRule ^bootstrap/cache/.* - [F,L]
HTACCESSEOF
chmod 644 .htaccess
echo ".htaccess dibuat"
echo ""

# Periksa .env
echo "6. Memeriksa .env..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo ".env dibuat dari .env.example"
    else
        echo "File .env tidak ditemukan - buat manual!"
    fi
else
    echo ".env sudah ada"
fi
chmod 600 .env 2>/dev/null
echo ""

# Buat file test
echo "7. Membuat file test..."
cat > test-debug.php << 'TESTEOF'
<?php
echo "<h1>Debug Test - Kantor Camat Waesama</h1>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";

echo "<h2>File Status Check</h2>";
$files = ['index.php', '.env', '.htaccess', 'vendor/autoload.php', 'bootstrap/app.php'];
echo "<ul>";
foreach ($files as $file) {
    $exists = file_exists($file);
    $status = $exists ? "<span style='color:green'>✓ EXISTS</span>" : "<span style='color:red'>✗ MISSING</span>";
    echo "<li>$file: $status</li>";
}
echo "</ul>";

echo "<h2>Laravel Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require 'vendor/autoload.php';
        echo "<p style='color:green'>✓ Composer autoloader loaded</p>";
        if (file_exists('bootstrap/app.php')) {
            echo "<p style='color:green'>✓ Laravel bootstrap found</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr><p><a href='/'>← Kembali ke halaman utama</a></p>";
echo "<p><small>Generated: " . date('Y-m-d H:i:s') . "</small></p>";
?>
TESTEOF
chmod 644 test-debug.php
echo "test-debug.php dibuat"
echo ""

# Test akses
echo "8. Test akses website..."
if command -v curl >/dev/null 2>&1; then
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://kecamatangwaesama.id/ 2>/dev/null)
    echo "HTTP Status: $HTTP_CODE"
    if [ "$HTTP_CODE" = "200" ]; then
        echo "✓ Website dapat diakses!"
    elif [ "$HTTP_CODE" = "403" ]; then
        echo "✗ Masih error 403"
    fi
else
    echo "curl tidak tersedia"
fi
echo ""

# Ringkasan
echo "======================================================"
echo "                 PERBAIKAN SELESAI                   "
echo "======================================================"
echo "✓ Permission diperbaiki"
echo "✓ index.php dibuat/diperbaiki"
echo "✓ .htaccess dibuat"
echo "✓ .env diperiksa"
echo "✓ test-debug.php dibuat"
echo ""
echo "LANGKAH SELANJUTNYA:"
echo "1. Akses: https://kecamatangwaesama.id/test-debug.php"
echo "2. Jika test OK, akses: https://kecamatangwaesama.id/"
echo ""
echo "Status file:"
ls -la index.php .htaccess .env test-debug.php 2>/dev/null
echo "======================================================"
```

### Langkah 3: Tekan Enter
Script akan berjalan otomatis dan memperbaiki semua konfigurasi.

### Langkah 4: Verifikasi
1. **Test debug:** https://kecamatangwaesama.id/test-debug.php
2. **Test website:** https://kecamatangwaesama.id/

---

## 🔧 JIKA MASIH ERROR

### Quick Fix Manual:

```bash
# Perbaiki ownership (ganti 'username' dengan username hosting)
chown -R username:username .

# Perbaiki permission lagi
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Restart web server (jika memungkinkan)
sudo systemctl reload apache2
# atau
sudo systemctl reload nginx
```

### Periksa Log Error:

```bash
# Periksa log error
tail -20 ~/logs/error.log
# atau
tail -20 /var/log/apache2/error.log
```

---

## 📱 CONTACT SUPPORT

Jika masih bermasalah:
1. Screenshot hasil dari test-debug.php
2. Copy log error
3. Hubungi developer atau hosting support

---

**SELAMAT! Website seharusnya sudah dapat diakses di https://kecamatangwaesama.id/**