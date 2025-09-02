# Manual Deployment Script untuk Kantor Camat Waesama (PowerShell)
# Script ini akan mengupdate server dengan versi terbaru dari GitHub

Write-Host "=== Manual Deployment Script (PowerShell) ===" -ForegroundColor Cyan
Write-Host "Starting deployment process..." -ForegroundColor Green

# Fungsi untuk logging
function Write-Info {
    param($Message)
    Write-Host "[INFO] $Message" -ForegroundColor Green
}

function Write-Warning {
    param($Message)
    Write-Host "[WARNING] $Message" -ForegroundColor Yellow
}

function Write-Error {
    param($Message)
    Write-Host "[ERROR] $Message" -ForegroundColor Red
}

# Fungsi untuk menjalankan command dengan error handling
function Invoke-SafeCommand {
    param(
        [string]$Command,
        [string]$Description
    )
    
    Write-Info $Description
    Write-Host "Running: $Command" -ForegroundColor Gray
    
    try {
        Invoke-Expression $Command
        if ($LASTEXITCODE -eq 0 -or $LASTEXITCODE -eq $null) {
            Write-Info "✅ $Description - SUCCESS"
            return $true
        } else {
            Write-Error "❌ $Description - FAILED (Exit Code: $LASTEXITCODE)"
            return $false
        }
    } catch {
        Write-Error "❌ $Description - FAILED: $($_.Exception.Message)"
        return $false
    }
}

# Backup current state
Write-Info "Creating backup..."
$BackupDir = "backup_$(Get-Date -Format 'yyyyMMdd_HHmmss')"
New-Item -ItemType Directory -Path $BackupDir -Force | Out-Null
try {
    Copy-Item -Path ".\*" -Destination $BackupDir -Recurse -Force
    Write-Info "Backup created in: $BackupDir"
} catch {
    Write-Warning "Backup creation failed: $($_.Exception.Message)"
}

# Git operations
Write-Info "Updating code from GitHub..."
if (!(Invoke-SafeCommand "git fetch origin" "Fetching latest changes")) { exit 1 }
if (!(Invoke-SafeCommand "git reset --hard origin/main" "Resetting to latest main branch")) { exit 1 }
if (!(Invoke-SafeCommand "git pull origin main" "Pulling latest changes")) { exit 1 }

# Show current commit
$CurrentCommit = git rev-parse --short HEAD
Write-Info "Current commit: $CurrentCommit"
$CommitMessage = git log -1 --pretty=%B
Write-Info "Latest commit message: $CommitMessage"

# Composer dependencies
if (Test-Path "composer.json") {
    Write-Info "Installing PHP dependencies..."
    if (!(Invoke-SafeCommand "composer install --no-dev --optimize-autoloader" "Installing Composer dependencies")) { exit 1 }
} else {
    Write-Warning "composer.json not found, skipping Composer install"
}

# NPM dependencies and build
if (Test-Path "package.json") {
    Write-Info "Installing Node.js dependencies..."
    if (!(Invoke-SafeCommand "npm install" "Installing NPM dependencies")) { exit 1 }
    if (!(Invoke-SafeCommand "npm run build" "Building assets")) { exit 1 }
} else {
    Write-Warning "package.json not found, skipping NPM install"
}

# Laravel optimizations
Write-Info "Optimizing Laravel application..."
Invoke-SafeCommand "php artisan config:clear" "Clearing config cache"
Invoke-SafeCommand "php artisan route:clear" "Clearing route cache"
Invoke-SafeCommand "php artisan view:clear" "Clearing view cache"
Invoke-SafeCommand "php artisan cache:clear" "Clearing application cache"

# Rebuild caches for production
Invoke-SafeCommand "php artisan config:cache" "Caching config"
Invoke-SafeCommand "php artisan route:cache" "Caching routes"
Invoke-SafeCommand "php artisan view:cache" "Caching views"
Invoke-SafeCommand "php artisan optimize" "Optimizing application"

# Verify deployment
Write-Info "Verifying deployment..."
if (Test-Path "resources\views\welcome.blade.php") {
    $WelcomeContent = Get-Content "resources\views\welcome.blade.php" -Raw
    if ($WelcomeContent -match "duplicate-menu-fix") {
        Write-Info "✅ Menu fix detected in welcome.blade.php"
    } else {
        Write-Warning "⚠️  Menu fix not found in welcome.blade.php"
    }
}

# Check if Laravel is working
try {
    $LaravelVersion = php artisan --version 2>$null
    if ($LASTEXITCODE -eq 0) {
        Write-Info "✅ Laravel is working properly"
        Write-Info "Laravel version: $LaravelVersion"
    } else {
        Write-Error "❌ Laravel is not working properly"
    }
} catch {
    Write-Error "❌ Laravel is not working properly: $($_.Exception.Message)"
}

Write-Host ""
Write-Info "=== Deployment Summary ==="
Write-Info "Commit: $CurrentCommit"
Write-Info "Time: $(Get-Date)"
Write-Info "Backup created in: $BackupDir"
Write-Host ""
Write-Host "🎉 Deployment completed successfully!" -ForegroundColor Green
Write-Info "Please test the website: https://kecamatangwaesama.id/public/"
Write-Host ""
Write-Info "If there are issues, you can restore from backup:"
Write-Info "Copy-Item -Path '$BackupDir\*' -Destination '.' -Recurse -Force"
Write-Host ""

# Pause to see results
Write-Host "Press any key to continue..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")