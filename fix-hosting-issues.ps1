# Script untuk Memperbaiki Masalah Hosting Laravel
# Mengatasi error 419, 500, database connection, dan masalah umum lainnya

Write-Host "=== Fix Hosting Issues Script ===" -ForegroundColor Green
Write-Host "Memperbaiki masalah umum hosting Laravel..." -ForegroundColor Yellow

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
        Write-Host "✗ File .env.example tidak ditemukan!" -ForegroundColor Red
        exit 1
    }
}

# 3. Pastikan APP_KEY ada dalam .env
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch "APP_KEY=") {
    Write-Host "Menambahkan APP_KEY ke .env..." -ForegroundColor Blue
    Add-Content ".env" "APP_KEY="
}

# 4. Generate APP_KEY jika kosong
$appKeyLine = Get-Content ".env" | Where-Object { $_ -match "^APP_KEY=" }
if ($appKeyLine -match "^APP_KEY=$" -or $appKeyLine -match "^APP_KEY=base64:$") {
    Write-Host "Generate APP_KEY..." -ForegroundColor Blue
    try {
        php artisan key:generate --force
        Write-Host "✓ APP_KEY berhasil di-generate" -ForegroundColor Green
    } catch {
        Write-Host "✗ Error generate APP_KEY, mencoba solusi alternatif..." -ForegroundColor Yellow
        $envContent = Get-Content ".env" -Raw
        $envContent = $envContent -replace "^APP_KEY=$", "APP_KEY=base64:"
        Set-Content ".env" $envContent
        php artisan key:generate --force
    }
}

# 5. Periksa dan perbaiki konfigurasi database
Write-Host "Memeriksa konfigurasi database..." -ForegroundColor Blue
$dbHost = (Get-Content ".env" | Where-Object { $_ -match "^DB_HOST=" }) -replace "DB_HOST=", ""
$dbName = (Get-Content ".env" | Where-Object { $_ -match "^DB_DATABASE=" }) -replace "DB_DATABASE=", ""
$dbUser = (Get-Content ".env" | Where-Object { $_ -match "^DB_USERNAME=" }) -replace "DB_USERNAME=", ""

if ([string]::IsNullOrEmpty($dbHost) -or [string]::IsNullOrEmpty($dbName) -or [string]::IsNullOrEmpty($dbUser)) {
    Write-Host "⚠️ Konfigurasi database belum lengkap. Silakan edit .env secara manual." -ForegroundColor Yellow
    Write-Host "   DB_HOST, DB_DATABASE, dan DB_USERNAME harus diisi." -ForegroundColor Yellow
}

# 6. Clear semua cache dan session (fix error 419)
Write-Host "Clearing cache dan session (fix error 419)..." -ForegroundColor Blue
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Clear session files manually
if (Test-Path "storage\framework\sessions") {
    Remove-Item "storage\framework\sessions\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "✓ Session files cleared" -ForegroundColor Green
}

# Clear compiled views
if (Test-Path "storage\framework\views") {
    Remove-Item "storage\framework\views\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "✓ Compiled views cleared" -ForegroundColor Green
}

# 7. Set file permissions yang benar
Write-Host "Setting file permissions..." -ForegroundColor Blue
try {
    # Untuk Windows, gunakan icacls untuk set permissions
    icacls "storage" /grant Everyone:F /T /Q 2>$null
    icacls "bootstrap\cache" /grant Everyone:F /T /Q 2>$null
    Write-Host "✓ File permissions set" -ForegroundColor Green
} catch {
    Write-Host "⚠️ Tidak dapat set permissions otomatis. Set manual jika diperlukan." -ForegroundColor Yellow
}

# 8. Install/Update dependencies
Write-Host "Install dependencies..." -ForegroundColor Blue
composer install --optimize-autoloader --no-dev --no-interaction

# 9. Test database connection
Write-Host "Testing database connection..." -ForegroundColor Blue
try {
    php artisan migrate:status 2>$null
    Write-Host "✓ Database connection OK" -ForegroundColor Green
} catch {
    Write-Host "⚠️ Database connection error. Periksa konfigurasi DB di .env" -ForegroundColor Yellow
}

# 10. Run migrations jika database OK
$runMigrations = Read-Host "Jalankan database migrations? (y/n)"
if ($runMigrations -eq "y" -or $runMigrations -eq "Y") {
    Write-Host "Running migrations..." -ForegroundColor Blue
    php artisan migrate --force
}

# 11. Optimize untuk production
Write-Host "Optimizing untuk production..." -ForegroundColor Blue
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload --optimize

# 12. Verifikasi konfigurasi
Write-Host "`n=== Verifikasi Konfigurasi ===" -ForegroundColor Green
$envLines = Get-Content ".env"
$appKey = $envLines | Where-Object { $_ -match "^APP_KEY=" }
$appEnv = $envLines | Where-Object { $_ -match "^APP_ENV=" }
$appDebug = $envLines | Where-Object { $_ -match "^APP_DEBUG=" }
$appUrl = $envLines | Where-Object { $_ -match "^APP_URL=" }
$dbConnection = $envLines | Where-Object { $_ -match "^DB_CONNECTION=" }

Write-Host "APP_KEY: $appKey" -ForegroundColor Cyan
Write-Host "APP_ENV: $appEnv" -ForegroundColor Cyan
Write-Host "APP_DEBUG: $appDebug" -ForegroundColor Cyan
Write-Host "APP_URL: $appUrl" -ForegroundColor Cyan
Write-Host "DB_CONNECTION: $dbConnection" -ForegroundColor Cyan

# 13. Checklist final
Write-Host "`n=== Checklist Final ===" -ForegroundColor Green
Write-Host "✓ File .env dikonfigurasi" -ForegroundColor Green
Write-Host "✓ APP_KEY di-generate" -ForegroundColor Green
Write-Host "✓ Cache dan session cleared" -ForegroundColor Green
Write-Host "✓ Dependencies terinstall" -ForegroundColor Green
Write-Host "✓ File permissions set" -ForegroundColor Green
Write-Host "✓ Production optimization" -ForegroundColor Green

Write-Host "`n=== Langkah Selanjutnya ===" -ForegroundColor Yellow
Write-Host "1. Pastikan DocumentRoot mengarah ke folder public/" -ForegroundColor White
Write-Host "2. Periksa konfigurasi database di .env" -ForegroundColor White
Write-Host "3. Test website di browser" -ForegroundColor White
Write-Host "4. Periksa log error di storage/logs/ jika ada masalah" -ForegroundColor White
Write-Host "5. Setup SSL certificate untuk HTTPS" -ForegroundColor White

Write-Host "`n=== Hosting Issues Fixed! ===" -ForegroundColor Green
Write-Host "Jika masih ada error, periksa file log di storage/logs/laravel.log" -ForegroundColor Yellow