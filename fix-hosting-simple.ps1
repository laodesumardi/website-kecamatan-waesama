# Script Sederhana untuk Memperbaiki Masalah Hosting Laravel
# Mengatasi HTTP ERROR 500 dan masalah umum lainnya

Write-Host "=== Fix Hosting Issues - Simple Version ===" -ForegroundColor Green
Write-Host "Memperbaiki masalah hosting Laravel..." -ForegroundColor Yellow

# 1. Backup file .env yang ada
if (Test-Path ".env") {
    $backupName = ".env.backup.$(Get-Date -Format 'yyyyMMdd_HHmmss')"
    Write-Host "Backup file .env ke $backupName..." -ForegroundColor Blue
    Copy-Item ".env" $backupName
}

# 2. Periksa dan perbaiki file .env
Write-Host "Memeriksa konfigurasi .env..." -ForegroundColor Blue

if (-not (Test-Path ".env")) {
    if (Test-Path ".env.hosting") {
        Write-Host "Menggunakan .env.hosting sebagai template..." -ForegroundColor Blue
        Copy-Item ".env.hosting" ".env"
    } elseif (Test-Path ".env.example") {
        Write-Host "Menggunakan .env.example sebagai template..." -ForegroundColor Blue
        Copy-Item ".env.example" ".env"
    } else {
        Write-Host "File .env.example tidak ditemukan!" -ForegroundColor Red
        exit 1
    }
}

# 3. Generate APP_KEY jika belum ada
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch "APP_KEY=base64:") {
    Write-Host "Generate APP_KEY..." -ForegroundColor Blue
    php artisan key:generate --force
    Write-Host "APP_KEY berhasil di-generate" -ForegroundColor Green
}

# 4. Clear semua cache dan session
Write-Host "Clearing cache dan session..." -ForegroundColor Blue
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Clear session files manually
if (Test-Path "storage\framework\sessions") {
    Remove-Item "storage\framework\sessions\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "Session files cleared" -ForegroundColor Green
}

# Clear compiled views
if (Test-Path "storage\framework\views") {
    Remove-Item "storage\framework\views\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "Compiled views cleared" -ForegroundColor Green
}

# 5. Install dependencies
Write-Host "Install dependencies..." -ForegroundColor Blue
composer install --optimize-autoloader --no-dev --no-interaction

# 6. Optimize untuk production
Write-Host "Optimizing untuk production..." -ForegroundColor Blue
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize

# 7. Test aplikasi
Write-Host "Testing aplikasi..." -ForegroundColor Blue
php artisan --version

Write-Host "\n=== Hosting Issues Fixed! ===" -ForegroundColor Green
Write-Host "Langkah selanjutnya:" -ForegroundColor Yellow
Write-Host "1. Pastikan DocumentRoot mengarah ke folder public/" -ForegroundColor White
Write-Host "2. Periksa konfigurasi database di .env" -ForegroundColor White
Write-Host "3. Test website di browser" -ForegroundColor White
Write-Host "4. Periksa log error di storage/logs/ jika ada masalah" -ForegroundColor White