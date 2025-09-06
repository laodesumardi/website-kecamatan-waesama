# Script Deployment untuk Server Hosting (PowerShell)
# Mengatasi masalah umum deployment Laravel

Write-Host "=== Laravel Deployment Script ===" -ForegroundColor Green
Write-Host "Memulai proses deployment..." -ForegroundColor Yellow

# 1. Backup file .env jika ada
if (Test-Path ".env") {
    $backupName = ".env.backup.$(Get-Date -Format 'yyyyMMdd_HHmmss')"
    Write-Host "Backup file .env yang ada ke $backupName..." -ForegroundColor Blue
    Copy-Item ".env" $backupName
}

# 2. Copy .env.example ke .env jika .env tidak ada
if (-not (Test-Path ".env")) {
    Write-Host "Membuat file .env dari .env.example..." -ForegroundColor Blue
    Copy-Item ".env.example" ".env"
}

# 3. Pastikan APP_KEY ada dalam .env
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch "^APP_KEY=") {
    Write-Host "Menambahkan APP_KEY ke file .env..." -ForegroundColor Blue
    Add-Content ".env" "APP_KEY="
}

# 4. Generate application key
Write-Host "Generate application key..." -ForegroundColor Blue
try {
    php artisan key:generate --force
    Write-Host "✓ Perintah key:generate berhasil dijalankan" -ForegroundColor Green
} catch {
    Write-Host "✗ Error saat menjalankan key:generate: $_" -ForegroundColor Red
    
    # Solusi alternatif
    Write-Host "Mencoba solusi alternatif..." -ForegroundColor Yellow
    $envContent = Get-Content ".env" -Raw
    $envContent = $envContent -replace "^APP_KEY=$", "APP_KEY=base64:"
    Set-Content ".env" $envContent
    
    try {
        php artisan key:generate --force
        Write-Host "✓ APP_KEY berhasil di-generate (solusi alternatif)" -ForegroundColor Green
    } catch {
        Write-Host "✗ Gagal generate APP_KEY. Periksa manual!" -ForegroundColor Red
        exit 1
    }
}

# 5. Verifikasi APP_KEY
$envContent = Get-Content ".env" -Raw
if ($envContent -match "^APP_KEY=base64:") {
    Write-Host "✓ APP_KEY berhasil di-generate" -ForegroundColor Green
} else {
    Write-Host "✗ Warning: APP_KEY mungkin belum ter-generate dengan benar" -ForegroundColor Yellow
}

# 6. Install/Update dependencies
Write-Host "Install dependencies..." -ForegroundColor Blue
composer install --optimize-autoloader --no-dev

# 7. Clear cache dan session (mengatasi error 419)
Write-Host "Clearing cache dan session..." -ForegroundColor Blue
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Clear session files manually (session:clear tidak tersedia di Laravel 11)
if (Test-Path "storage\framework\sessions") {
    Remove-Item "storage\framework\sessions\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "✓ Session files cleared manually" -ForegroundColor Green
}
Write-Host "✓ Cache dan session cleared" -ForegroundColor Green

# 8. Optimize untuk production
Write-Host "Optimize untuk production..." -ForegroundColor Blue
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Run migrations
Write-Host "Menjalankan database migrations..." -ForegroundColor Blue
php artisan migrate --force

# 10. Seed database jika diperlukan
$runSeeder = Read-Host "Jalankan database seeder? (y/n)"
if ($runSeeder -eq "y" -or $runSeeder -eq "Y") {
    php artisan db:seed --force
}

# 11. Verifikasi deployment
Write-Host "`n=== Verifikasi Deployment ===" -ForegroundColor Green
$envLines = Get-Content ".env"
$appKey = $envLines | Where-Object { $_ -match "^APP_KEY=" }
$appEnv = $envLines | Where-Object { $_ -match "^APP_ENV=" }
$appDebug = $envLines | Where-Object { $_ -match "^APP_DEBUG=" }
$dbConnection = $envLines | Where-Object { $_ -match "^DB_CONNECTION=" }

Write-Host "APP_KEY: $appKey" -ForegroundColor Cyan
Write-Host "APP_ENV: $appEnv" -ForegroundColor Cyan
Write-Host "APP_DEBUG: $appDebug" -ForegroundColor Cyan
Write-Host "DB_CONNECTION: $dbConnection" -ForegroundColor Cyan

Write-Host "`n=== Deployment Selesai ===" -ForegroundColor Green
Write-Host "Silakan test aplikasi di browser!" -ForegroundColor Yellow
Write-Host "Jika ada error, periksa file log di storage/logs/" -ForegroundColor Yellow