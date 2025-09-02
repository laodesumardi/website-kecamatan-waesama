# Simple Deployment Files Preparation
# Kantor Camat Waesama - Laravel Application

Write-Host "Preparing deployment files..." -ForegroundColor Green

# Create deployment folder
$deployDir = "deployment-files"
if (Test-Path $deployDir) {
    Remove-Item $deployDir -Recurse -Force
}
New-Item -ItemType Directory -Path $deployDir | Out-Null

Write-Host "Copying essential Laravel files..." -ForegroundColor Yellow

# Copy essential directories
$essentialDirs = @('app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', 'storage', 'vendor')

foreach ($dir in $essentialDirs) {
    if (Test-Path $dir) {
        Write-Host "Copying $dir/" -ForegroundColor Cyan
        Copy-Item $dir -Destination $deployDir -Recurse -Force
    }
}

# Copy essential files
$essentialFiles = @('artisan', 'composer.json', 'composer.lock')

foreach ($file in $essentialFiles) {
    if (Test-Path $file) {
        Write-Host "Copying $file" -ForegroundColor Cyan
        Copy-Item $file -Destination $deployDir -Force
    }
}

Write-Host "Adding production configuration files..." -ForegroundColor Yellow

# Copy production files
if (Test-Path '.env.production') {
    Copy-Item '.env.production' -Destination "$deployDir/.env.example.production" -Force
    Write-Host "Added .env.example.production" -ForegroundColor Cyan
}

if (Test-Path '.htaccess.production') {
    Copy-Item '.htaccess.production' -Destination "$deployDir/.htaccess.production" -Force
    Write-Host "Added .htaccess.production" -ForegroundColor Cyan
}

# Create deployment instructions file
$instructions = @"
DEPLOYMENT INSTRUCTIONS
=======================

1. Upload all files in this folder to your Hostinger public_html directory

2. Rename .env.example.production to .env

3. Edit .env file with your Hostinger database credentials:
   - DB_DATABASE=your_database_name
   - DB_USERNAME=your_database_user
   - DB_PASSWORD=your_database_password
   - APP_URL=https://yourdomain.com

4. Copy .htaccess.production to public/.htaccess

5. Run these commands on your server:
   php artisan key:generate
   chmod -R 755 storage bootstrap/cache
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link

6. Set Document Root in Hostinger panel to: public_html/public

7. Test your application

For detailed instructions, see DEPLOYMENT-CHECKLIST.md
"@

$instructions | Out-File -FilePath "$deployDir/DEPLOYMENT-INSTRUCTIONS.txt" -Encoding UTF8

Write-Host "SUCCESS: Deployment files prepared in '$deployDir' folder" -ForegroundColor Green
Write-Host "You can now upload the contents of '$deployDir' to your Hostinger public_html folder" -ForegroundColor Magenta

# Show folder size
$folderSize = (Get-ChildItem $deployDir -Recurse | Measure-Object -Property Length -Sum).Sum / 1MB
Write-Host "Total size: $([math]::Round($folderSize, 2)) MB" -ForegroundColor Cyan