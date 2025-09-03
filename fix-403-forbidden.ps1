# Script untuk Memperbaiki Error 403 Forbidden
# Kantor Camat Waesama - https://kecamatangwaesama.id/

Write-Host "=== PERBAIKAN ERROR 403 FORBIDDEN ===" -ForegroundColor Yellow
Write-Host "Situs: https://kecamatangwaesama.id/" -ForegroundColor Cyan
Write-Host ""

# Fungsi untuk membuat backup
function Create-Backup {
    param([string]$SourcePath, [string]$BackupPath)
    
    if (Test-Path $SourcePath) {
        Copy-Item $SourcePath $BackupPath -Force
        Write-Host "✓ Backup dibuat: $BackupPath" -ForegroundColor Green
    }
}

# Fungsi untuk memeriksa file yang diperlukan
function Check-RequiredFiles {
    Write-Host "1. Memeriksa file yang diperlukan..." -ForegroundColor Yellow
    
    $requiredFiles = @(
        "index.php",
        ".env",
        "bootstrap/app.php",
        "vendor/autoload.php"
    )
    
    $missingFiles = @()
    
    foreach ($file in $requiredFiles) {
        if (-not (Test-Path $file)) {
            $missingFiles += $file
            Write-Host "✗ File tidak ditemukan: $file" -ForegroundColor Red
        } else {
            Write-Host "✓ File ditemukan: $file" -ForegroundColor Green
        }
    }
    
    return $missingFiles
}

# Fungsi untuk memperbaiki file index
function Fix-IndexFile {
    Write-Host "2. Memperbaiki file index..." -ForegroundColor Yellow
    
    if (-not (Test-Path "index.php")) {
        if (Test-Path "index-root.php") {
            Copy-Item "index-root.php" "index.php" -Force
            Write-Host "✓ index.php dibuat dari index-root.php" -ForegroundColor Green
        } elseif (Test-Path "public/index.php") {
            Copy-Item "public/index.php" "index.php" -Force
            Write-Host "✓ index.php disalin dari public/index.php" -ForegroundColor Green
        } else {
            # Buat index.php sederhana
            $indexContent = @'
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
'@
            Set-Content -Path "index.php" -Value $indexContent -Encoding UTF8
            Write-Host "✓ index.php dibuat dengan konfigurasi otomatis" -ForegroundColor Green
        }
    } else {
        Write-Host "✓ index.php sudah ada" -ForegroundColor Green
    }
}

# Fungsi untuk memperbaiki .htaccess
function Fix-Htaccess {
    Write-Host "3. Memperbaiki file .htaccess..." -ForegroundColor Yellow
    
    # Backup .htaccess yang ada
    if (Test-Path ".htaccess") {
        Create-Backup ".htaccess" ".htaccess.backup"
    }
    
    # Buat .htaccess yang kompatibel
    $htaccessContent = @'
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
'@
    
    Set-Content -Path ".htaccess" -Value $htaccessContent -Encoding UTF8
    Write-Host "✓ .htaccess dibuat dengan konfigurasi yang aman" -ForegroundColor Green
}

# Fungsi untuk memeriksa file .env
function Check-EnvFile {
    Write-Host "4. Memeriksa file .env..." -ForegroundColor Yellow
    
    if (-not (Test-Path ".env")) {
        if (Test-Path ".env.example") {
            Copy-Item ".env.example" ".env" -Force
            Write-Host "✓ .env dibuat dari .env.example" -ForegroundColor Green
            Write-Host "⚠️  PENTING: Edit .env dengan konfigurasi database yang benar!" -ForegroundColor Red
        } else {
            Write-Host "✗ File .env dan .env.example tidak ditemukan" -ForegroundColor Red
            Write-Host "   Buat file .env secara manual dengan konfigurasi yang benar" -ForegroundColor Yellow
        }
    } else {
        Write-Host "✓ File .env sudah ada" -ForegroundColor Green
    }
}

# Fungsi untuk membuat file test PHP
function Create-TestFile {
    Write-Host "5. Membuat file test PHP..." -ForegroundColor Yellow
    
    # Buat konten PHP dengan escape yang benar
    $testContent = @"
<?php
// Test file untuk memeriksa konfigurasi PHP
echo "<h1>Test PHP - Kantor Camat Waesama</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . `$_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . `$_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . `$_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";

// Test file permissions
echo "<h2>File Permissions Test</h2>";
`$files = ['index.php', '.env', 'bootstrap/app.php'];
foreach (`$files as `$file) {
    if (file_exists(`$file)) {
        `$perms = substr(sprintf('%o', fileperms(`$file)), -4);
        echo "<p>`$file: `$perms</p>";
    } else {
        echo "<p>`$file: <span style='color:red'>NOT FOUND</span></p>";
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
} catch (Exception `$e) {
    echo "<p style='color:red'>Error: " . `$e->getMessage() . "</p>";
}

echo "<p><a href='/'>← Kembali ke halaman utama</a></p>";
?>
"@
    
    Set-Content -Path "test-php.php" -Value $testContent -Encoding UTF8
    Write-Host "✓ File test-php.php dibuat" -ForegroundColor Green
    Write-Host "   Akses: https://kecamatangwaesama.id/test-php.php" -ForegroundColor Cyan
}

# Fungsi untuk membuat panduan deployment
function Create-DeploymentGuide {
    Write-Host "6. Membuat panduan deployment..." -ForegroundColor Yellow
    
    $guideContent = @'
# PANDUAN UPLOAD KE HOSTING

## File yang Harus Diupload ke public_html:

### 1. File Utama:
- index.php (dari index-root.php)
- .htaccess
- .env (edit dengan konfigurasi database hosting)

### 2. Folder Laravel:
- app/
- bootstrap/
- config/
- database/
- resources/
- routes/
- storage/
- vendor/

### 3. File dari folder public/:
- css/
- js/
- favicon.svg
- robots.txt

## Langkah Upload:

1. Compress semua file dan folder di atas
2. Upload ke public_html melalui cPanel File Manager
3. Extract file
4. Set permission:
   - Folder: 755
   - File: 644
   - storage/: 755 (recursive)
   - bootstrap/cache/: 755 (recursive)

## Test Akses:

1. Buka: https://kecamatangwaesama.id/test-php.php
2. Periksa apakah semua test berhasil
3. Jika berhasil, akses: https://kecamatangwaesama.id/

## Troubleshooting:

- Jika masih 403: Periksa permission file dan folder
- Jika error 500: Periksa file .env dan konfigurasi database
- Jika blank page: Periksa error log hosting
'@
    
    Set-Content -Path "UPLOAD-GUIDE-HOSTING.md" -Value $guideContent -Encoding UTF8
    Write-Host "✓ Panduan upload dibuat: UPLOAD-GUIDE-HOSTING.md" -ForegroundColor Green
}

# Main execution
Write-Host "Memulai perbaikan error 403 Forbidden..." -ForegroundColor Cyan
Write-Host ""

# Jalankan semua fungsi perbaikan
$missingFiles = Check-RequiredFiles
Fix-IndexFile
Fix-Htaccess
Check-EnvFile
Create-TestFile
Create-DeploymentGuide

Write-Host ""
Write-Host "=== RINGKASAN PERBAIKAN ===" -ForegroundColor Yellow

if ($missingFiles.Count -eq 0) {
    Write-Host "✓ Semua file yang diperlukan sudah ada" -ForegroundColor Green
} else {
    Write-Host "⚠️  File yang masih hilang:" -ForegroundColor Red
    foreach ($file in $missingFiles) {
        Write-Host "   - $file" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "=== LANGKAH SELANJUTNYA ===" -ForegroundColor Yellow
Write-Host "1. Upload semua file ke hosting (lihat UPLOAD-GUIDE-HOSTING.md)" -ForegroundColor White
Write-Host "2. Set permission file dan folder yang benar" -ForegroundColor White
Write-Host "3. Edit file .env dengan konfigurasi database hosting" -ForegroundColor White
Write-Host "4. Test akses: https://kecamatangwaesama.id/test-php.php" -ForegroundColor White
Write-Host "5. Jika test berhasil, akses: https://kecamatangwaesama.id/" -ForegroundColor White

Write-Host ""
Write-Host "File yang dibuat:" -ForegroundColor Cyan
Write-Host "- index.php (jika belum ada)" -ForegroundColor White
Write-Host "- .htaccess (diperbaiki)" -ForegroundColor White
Write-Host "- test-php.php (untuk testing)" -ForegroundColor White
Write-Host "- UPLOAD-GUIDE-HOSTING.md (panduan upload)" -ForegroundColor White

Write-Host ""
Write-Host "Perbaikan selesai! Silakan upload ke hosting." -ForegroundColor Green