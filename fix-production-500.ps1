# Script untuk memperbaiki HTTP Error 500 di hosting production
# Website: kecamatangwaesama.id

Write-Host "=== FIXING HTTP 500 ERROR IN PRODUCTION ===" -ForegroundColor Yellow
Write-Host "Website: kecamatangwaesama.id" -ForegroundColor Cyan
Write-Host "Error URL: /profil" -ForegroundColor Cyan
Write-Host ""

# 1. Backup current files
Write-Host "1. Creating backup..." -ForegroundColor Green
$backupName = "backup-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
try {
    Copy-Item -Path "." -Destination "..\$backupName" -Recurse -ErrorAction Stop
    Write-Host "Backup created: $backupName" -ForegroundColor Green
} catch {
    Write-Host "Backup failed, continuing..." -ForegroundColor Yellow
}

# 2. Clear all caches
Write-Host "2. Clearing caches..." -ForegroundColor Green
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 3. Check .env file
Write-Host "3. Checking .env configuration..." -ForegroundColor Green
if (-not (Test-Path ".env")) {
    Write-Host "ERROR: .env file not found!" -ForegroundColor Red
    if (Test-Path ".env.hosting") {
        Write-Host "Copying .env.hosting to .env..." -ForegroundColor Yellow
        Copy-Item ".env.hosting" ".env"
    } else {
        Write-Host "ERROR: No .env.hosting file found either!" -ForegroundColor Red
        exit 1
    }
}

# 4. Generate APP_KEY if missing
Write-Host "4. Checking APP_KEY..." -ForegroundColor Green
$envContent = Get-Content ".env" -Raw
if ($envContent -notmatch "APP_KEY=base64:") {
    Write-Host "Generating new APP_KEY..." -ForegroundColor Yellow
    php artisan key:generate
}

# 5. Run migrations
Write-Host "5. Running database migrations..." -ForegroundColor Green
php artisan migrate --force

# 6. Install/update dependencies
Write-Host "6. Installing dependencies..." -ForegroundColor Green
composer install --no-dev --optimize-autoloader

# 7. Optimize for production
Write-Host "7. Optimizing for production..." -ForegroundColor Green
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Check storage link
Write-Host "8. Creating storage link..." -ForegroundColor Green
php artisan storage:link

# 9. Set proper environment
Write-Host "9. Setting production environment..." -ForegroundColor Green
$envContent = Get-Content ".env" -Raw
$envContent = $envContent -replace "APP_ENV=local", "APP_ENV=production"
$envContent = $envContent -replace "APP_DEBUG=true", "APP_DEBUG=false"
Set-Content ".env" $envContent

# 10. Test the application
Write-Host "10. Testing application..." -ForegroundColor Green
try {
    php artisan about
    Write-Host "Application test passed" -ForegroundColor Green
} catch {
    Write-Host "Application test failed" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=== DEPLOYMENT COMPLETED ===" -ForegroundColor Yellow
Write-Host "Please check the website: https://kecamatangwaesama.id/profil" -ForegroundColor Cyan
Write-Host "If error persists, check the error logs:" -ForegroundColor White
Write-Host "- storage/logs/laravel.log" -ForegroundColor Gray
Write-Host "- Server error logs (usually in /var/log/ or hosting control panel)" -ForegroundColor Gray
Write-Host ""
Write-Host "Common issues to check:" -ForegroundColor White
Write-Host "1. Database connection settings in .env" -ForegroundColor Gray
Write-Host "2. File permissions (755 for directories, 644 for files)" -ForegroundColor Gray
Write-Host "3. PHP version compatibility (Laravel 11 requires PHP 8.2+)" -ForegroundColor Gray
Write-Host "4. Missing PHP extensions" -ForegroundColor Gray
Write-Host "5. Memory limits and execution time" -ForegroundColor Gray
Write-Host ""