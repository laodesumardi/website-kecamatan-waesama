# Script untuk mengatasi Error 419 Page Expired (PowerShell)
# Jalankan script ini ketika mengalami CSRF token mismatch

Write-Host "=== Fix Error 419 Page Expired ===" -ForegroundColor Green
Write-Host "Mengatasi masalah CSRF token mismatch..." -ForegroundColor Yellow

# 1. Clear semua cache dan session
Write-Host "Step 1: Clear cache dan session..." -ForegroundColor Blue
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Clear session files manually (session:clear tidak tersedia di Laravel 11)
Write-Host "Clearing session files manually..." -ForegroundColor Blue
if (Test-Path "storage\framework\sessions") {
    Remove-Item "storage\framework\sessions\*" -Force -Recurse -ErrorAction SilentlyContinue
    Write-Host "✓ Session files cleared manually" -ForegroundColor Green
} else {
    Write-Host "Session directory not found, creating..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path "storage\framework\sessions" -Force | Out-Null
    Write-Host "✓ Session directory created" -ForegroundColor Green
}

# 2. Periksa konfigurasi session di .env
Write-Host "Step 2: Verifikasi konfigurasi session..." -ForegroundColor Blue
$envContent = Get-Content ".env" -Raw

if ($envContent -notmatch "^SESSION_DRIVER=") {
    Add-Content ".env" "SESSION_DRIVER=file"
    Write-Host "✓ Added SESSION_DRIVER=file" -ForegroundColor Green
}

if ($envContent -notmatch "^SESSION_LIFETIME=") {
    Add-Content ".env" "SESSION_LIFETIME=120"
    Write-Host "✓ Added SESSION_LIFETIME=120" -ForegroundColor Green
}

# 3. Regenerate cache
Write-Host "Step 3: Regenerate cache..." -ForegroundColor Blue
php artisan config:cache
php artisan route:cache

# 4. Test APP_KEY
Write-Host "Step 4: Verifikasi APP_KEY..." -ForegroundColor Blue
$envLines = Get-Content ".env"
$appKey = $envLines | Where-Object { $_ -match "^APP_KEY=base64:" }
if ($appKey) {
    Write-Host "✓ APP_KEY is properly set" -ForegroundColor Green
} else {
    Write-Host "⚠ Warning: APP_KEY might not be properly set" -ForegroundColor Yellow
    Write-Host "Run: php artisan key:generate --force" -ForegroundColor Yellow
}

# 5. Verifikasi APP_URL
Write-Host "Step 5: Verifikasi APP_URL..." -ForegroundColor Blue
$appUrlLine = $envLines | Where-Object { $_ -match "^APP_URL=" }
if ($appUrlLine) {
    $appUrl = $appUrlLine.Split('=')[1]
    if ([string]::IsNullOrEmpty($appUrl) -or $appUrl -eq "http://localhost") {
        Write-Host "⚠ Warning: APP_URL not set properly for production" -ForegroundColor Yellow
        Write-Host "Update APP_URL in .env to match your domain" -ForegroundColor Yellow
        Write-Host "Example: APP_URL=https://yourdomain.com" -ForegroundColor Yellow
    } else {
        Write-Host "✓ APP_URL: $appUrl" -ForegroundColor Green
    }
} else {
    Write-Host "⚠ Warning: APP_URL not found in .env" -ForegroundColor Yellow
}

# 6. Tampilkan konfigurasi session saat ini
Write-Host "`n=== Current Session Configuration ===" -ForegroundColor Green
$sessionDriver = ($envLines | Where-Object { $_ -match "^SESSION_DRIVER=" }).Split('=')[1]
$sessionLifetime = ($envLines | Where-Object { $_ -match "^SESSION_LIFETIME=" }).Split('=')[1]
$appUrl = ($envLines | Where-Object { $_ -match "^APP_URL=" }).Split('=')[1]

Write-Host "SESSION_DRIVER: $sessionDriver" -ForegroundColor Cyan
Write-Host "SESSION_LIFETIME: $sessionLifetime" -ForegroundColor Cyan
Write-Host "APP_URL: $appUrl" -ForegroundColor Cyan

Write-Host "`n=== Troubleshooting Tips ===" -ForegroundColor Green
Write-Host "1. Pastikan APP_URL sesuai dengan domain hosting" -ForegroundColor Yellow
Write-Host "2. Untuk HTTPS, set SESSION_SECURE_COOKIE=true" -ForegroundColor Yellow
Write-Host "3. Untuk subdomain, set SESSION_DOMAIN=.yourdomain.com" -ForegroundColor Yellow
Write-Host "4. Test form submission setelah menjalankan script ini" -ForegroundColor Yellow
Write-Host "5. Jika masih error, periksa log: Get-Content storage\logs\laravel.log -Tail 50" -ForegroundColor Yellow

Write-Host "`n=== Script Selesai ===" -ForegroundColor Green
Write-Host "Silakan test aplikasi di browser!" -ForegroundColor Yellow