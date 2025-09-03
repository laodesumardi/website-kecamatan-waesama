# Script untuk mempersiapkan file deployment manual
# Jalankan script ini untuk membuat package upload manual

Write-Host "=== Mempersiapkan File untuk Upload Manual ===" -ForegroundColor Green

# Buat folder deployment
$deploymentFolder = "manual-deployment-package"
if (Test-Path $deploymentFolder) {
    Write-Host "Menghapus folder deployment lama..." -ForegroundColor Yellow
    Remove-Item $deploymentFolder -Recurse -Force
}

New-Item -ItemType Directory -Path $deploymentFolder | Out-Null
Write-Host "Folder deployment dibuat: $deploymentFolder" -ForegroundColor Green

# Daftar folder dan file yang akan dicopy
$itemsToCopy = @(
    "app",
    "bootstrap",
    "config", 
    "database",
    "resources",
    "routes",
    "storage",
    "public",
    "artisan",
    "composer.json",
    "composer.lock",
    "package.json",
    ".htaccess",
    "robots.txt",
    "index-root.php"
)

# Copy file dan folder yang diperlukan
foreach ($item in $itemsToCopy) {
    if (Test-Path $item) {
        Write-Host "Copying $item..." -ForegroundColor Cyan
        if (Test-Path $item -PathType Container) {
            # Jika folder
            Copy-Item $item -Destination $deploymentFolder -Recurse
        } else {
            # Jika file
            Copy-Item $item -Destination $deploymentFolder
        }
    } else {
        Write-Host "Warning: $item tidak ditemukan" -ForegroundColor Yellow
    }
}

# Bersihkan file yang tidak diperlukan dari folder deployment
Write-Host "Membersihkan file yang tidak diperlukan..." -ForegroundColor Yellow

# Hapus node_modules jika ada
$nodeModulesPath = Join-Path $deploymentFolder "node_modules"
if (Test-Path $nodeModulesPath) {
    Remove-Item $nodeModulesPath -Recurse -Force
    Write-Host "Removed node_modules" -ForegroundColor Yellow
}

# Hapus vendor jika ada
$vendorPath = Join-Path $deploymentFolder "vendor"
if (Test-Path $vendorPath) {
    Remove-Item $vendorPath -Recurse -Force
    Write-Host "Removed vendor" -ForegroundColor Yellow
}

# Bersihkan storage cache
$storagePath = Join-Path $deploymentFolder "storage"
if (Test-Path $storagePath) {
    # Hapus cache files
    $cachePaths = @(
        Join-Path $storagePath "framework\cache\*",
        Join-Path $storagePath "framework\sessions\*", 
        Join-Path $storagePath "framework\views\*",
        Join-Path $storagePath "logs\*.log"
    )
    
    foreach ($cachePath in $cachePaths) {
        if (Test-Path $cachePath) {
            Remove-Item $cachePath -Force -ErrorAction SilentlyContinue
        }
    }
    Write-Host "Cleaned storage cache files" -ForegroundColor Yellow
}

# Hapus file .env jika ada (akan dibuat baru di server)
$envPath = Join-Path $deploymentFolder ".env"
if (Test-Path $envPath) {
    Remove-Item $envPath -Force
    Write-Host "Removed .env (akan dibuat baru di server)" -ForegroundColor Yellow
}

# Buat file instruksi upload
$instructionContent = @"
=== INSTRUKSI UPLOAD MANUAL ===

1. STRUKTUR UPLOAD:
   - Upload semua folder (app, bootstrap, config, dll) ke ROOT public_html
   - Upload file .htaccess ke ROOT public_html  
   - Upload ISI folder 'public' ke ROOT public_html (bukan foldernya)
   - Upload file index-root.php dan RENAME menjadi index.php di ROOT public_html

2. PENTING - FILE INDEX.PHP:
   - JANGAN gunakan index.php dari folder public
   - GUNAKAN index-root.php yang sudah disesuaikan untuk root deployment
   - Rename index-root.php menjadi index.php setelah upload

3. SETELAH UPLOAD:
   - Buat file .env di root public_html
   - Set database configuration di .env
   - Jalankan: composer install --no-dev --optimize-autoloader
   - Jalankan: php artisan key:generate
   - Set permissions: chmod -R 755 storage bootstrap/cache

4. TROUBLESHOOTING:
   - Jika 403 Forbidden: cek file index.php dan permissions
   - Jika 500 Error: cek .env dan composer install
   - Jika Route Error: clear cache dengan php artisan cache:clear

Lihat file MANUAL-UPLOAD-GUIDE.md untuk panduan lengkap.
"@

$instructionPath = Join-Path $deploymentFolder "UPLOAD-INSTRUCTIONS.txt"
$instructionContent | Out-File -FilePath $instructionPath -Encoding UTF8

# Copy panduan upload
$guideSource = "MANUAL-UPLOAD-GUIDE.md"
if (Test-Path $guideSource) {
    Copy-Item $guideSource -Destination $deploymentFolder
    Write-Host "Copied upload guide" -ForegroundColor Green
}

# Hitung ukuran folder
$folderSize = (Get-ChildItem $deploymentFolder -Recurse | Measure-Object -Property Length -Sum).Sum
$folderSizeMB = [math]::Round($folderSize / 1MB, 2)

Write-Host "`n=== DEPLOYMENT PACKAGE SIAP ===" -ForegroundColor Green
Write-Host "Lokasi: $deploymentFolder" -ForegroundColor Cyan
Write-Host "Ukuran: $folderSizeMB MB" -ForegroundColor Cyan
Write-Host "`nLangkah selanjutnya:" -ForegroundColor Yellow
Write-Host "1. Compress folder '$deploymentFolder' menjadi ZIP" -ForegroundColor White
Write-Host "2. Upload ZIP ke server dan extract di public_html" -ForegroundColor White
Write-Host "3. Ikuti instruksi di UPLOAD-INSTRUCTIONS.txt" -ForegroundColor White
Write-Host "4. Baca MANUAL-UPLOAD-GUIDE.md untuk panduan lengkap" -ForegroundColor White

Write-Host "`n=== SELESAI ===" -ForegroundColor Green