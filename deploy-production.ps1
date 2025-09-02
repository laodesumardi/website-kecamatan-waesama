# Production Deployment Script for Windows
# Kantor Camat Waesama - Ensure Consistent UI/UX

Write-Host "🚀 Starting Production Deployment..." -ForegroundColor Blue
Write-Host "📋 This script ensures online appearance matches local development" -ForegroundColor Blue

# Function to print colored output
function Write-Status {
    param([string]$Message)
    Write-Host "[INFO] $Message" -ForegroundColor Cyan
}

function Write-Success {
    param([string]$Message)
    Write-Host "[SUCCESS] $Message" -ForegroundColor Green
}

function Write-Warning {
    param([string]$Message)
    Write-Host "[WARNING] $Message" -ForegroundColor Yellow
}

function Write-Error {
    param([string]$Message)
    Write-Host "[ERROR] $Message" -ForegroundColor Red
}

# Check if we're in the right directory
if (-not (Test-Path "artisan")) {
    Write-Error "Laravel artisan file not found. Please run this script from the Laravel root directory."
    exit 1
}

Write-Status "Step 1: Environment Setup"
# Copy production environment file
if (Test-Path ".env.production") {
    Copy-Item ".env.production" ".env" -Force
    Write-Success "Production environment file copied"
} else {
    Write-Error "Production environment file (.env.production) not found!"
    exit 1
}

Write-Status "Step 2: Install Dependencies (Production)"
try {
    # Install composer dependencies for production
    composer install --optimize-autoloader --no-dev --no-interaction
    Write-Success "Composer dependencies installed"
    
    # Install npm dependencies
    npm ci --production
    Write-Success "NPM dependencies installed"
} catch {
    Write-Error "Failed to install dependencies: $_"
    exit 1
}

Write-Status "Step 3: Build Assets for Production"
try {
    # Build assets for production
    npm run build
    Write-Success "Assets built for production"
} catch {
    Write-Error "Failed to build assets: $_"
    exit 1
}

Write-Status "Step 4: Laravel Optimization"
try {
    # Generate application key if needed
    php artisan key:generate --force
    Write-Success "Application key generated"
    
    # Clear all caches
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    Write-Success "All caches cleared"
    
    # Cache configurations for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    Write-Success "Production caches created"
    
    # Optimize autoloader
    composer dump-autoload --optimize
    Write-Success "Autoloader optimized"
} catch {
    Write-Error "Laravel optimization failed: $_"
    exit 1
}

Write-Status "Step 5: Database Setup"
$runMigrations = Read-Host "Do you want to run database migrations? (y/N)"
if ($runMigrations -eq 'y' -or $runMigrations -eq 'Y') {
    try {
        php artisan migrate --force
        Write-Success "Database migrations completed"
    } catch {
        Write-Warning "Database migrations failed: $_"
    }
} else {
    Write-Warning "Database migrations skipped"
}

Write-Status "Step 6: Storage and Permissions"
try {
    # Create storage link
    php artisan storage:link
    Write-Success "Storage link created"
} catch {
    Write-Warning "Storage link creation failed (may already exist)"
}

Write-Status "Step 7: Asset Verification"
# Verify that all CSS and JS files are properly built
if (Test-Path "public\build") {
    Write-Success "Vite build directory exists"
    
    # Check for manifest file
    if (Test-Path "public\build\manifest.json") {
        Write-Success "Vite manifest file found"
    } else {
        Write-Error "Vite manifest file missing! Assets may not load properly."
    }
    
    # List built assets
    Write-Host "Built assets:"
    Get-ChildItem "public\build\assets" | Select-Object -First 10 | Format-Table Name, Length, LastWriteTime
} else {
    Write-Error "Vite build directory not found! Run 'npm run build' first."
}

# Check custom CSS files
if (Test-Path "public\css\mobile-fix.css") {
    Write-Success "Mobile fix CSS found"
} else {
    Write-Warning "Mobile fix CSS not found"
}

if (Test-Path "public\css\form-fixes.css") {
    Write-Success "Form fixes CSS found"
} else {
    Write-Warning "Form fixes CSS not found"
}

if (Test-Path "public\js\mobile-responsive.js") {
    Write-Success "Mobile responsive JS found"
} else {
    Write-Warning "Mobile responsive JS not found"
}

Write-Status "Step 8: Security Check"
# Check .env file security
$envContent = Get-Content ".env" -Raw
if ($envContent -match "APP_DEBUG=false") {
    Write-Success "Debug mode is disabled"
} else {
    Write-Warning "Debug mode should be disabled in production"
}

if ($envContent -match "APP_ENV=production") {
    Write-Success "Environment is set to production"
} else {
    Write-Warning "Environment should be set to production"
}

Write-Status "Step 9: Final Verification"
# Test if the application can boot
try {
    php artisan about | Out-Null
    Write-Success "Laravel application can boot successfully"
} catch {
    Write-Error "Laravel application failed to boot. Check your configuration."
}

Write-Host ""
Write-Host "🎉 Production deployment completed!" -ForegroundColor Green
Write-Host ""
Write-Host "📝 Post-deployment checklist:" -ForegroundColor Yellow
Write-Host "   ✅ Upload all files to your hosting provider"
Write-Host "   ✅ Update .env file with production database credentials"
Write-Host "   ✅ Set up SSL certificate (HTTPS)"
Write-Host "   ✅ Configure web server (Apache/Nginx)"
Write-Host "   ✅ Test all functionality"
Write-Host "   ✅ Monitor error logs"
Write-Host ""
Write-Host "🔗 Important URLs to test:" -ForegroundColor Yellow
Write-Host "   - Homepage: https://your-domain.com"
Write-Host "   - Login: https://your-domain.com/login"
Write-Host "   - Admin: https://your-domain.com/admin"
Write-Host ""
Write-Host "📱 Test responsive design on:" -ForegroundColor Yellow
Write-Host "   - Mobile devices (iOS/Android)"
Write-Host "   - Tablets"
Write-Host "   - Desktop browsers"
Write-Host ""
Write-Success "Deployment script completed successfully!"

# Create deployment package
Write-Status "Creating deployment package..."
$deploymentFolder = "deployment-package-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
New-Item -ItemType Directory -Path $deploymentFolder -Force | Out-Null

# Copy essential files
$filesToCopy = @(
    "app",
    "bootstrap",
    "config",
    "database",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor",
    ".env.production",
    "artisan",
    "composer.json",
    "composer.lock",
    "package.json",
    "package-lock.json",
    "vite.config.js"
)

foreach ($item in $filesToCopy) {
    if (Test-Path $item) {
        Copy-Item $item -Destination $deploymentFolder -Recurse -Force
        Write-Host "✅ Copied: $item"
    }
}

# Rename .env.production to .env in deployment package
if (Test-Path "$deploymentFolder\.env.production") {
    Rename-Item "$deploymentFolder\.env.production" ".env"
    Write-Success "Environment file prepared for production"
}

Write-Success "Deployment package created: $deploymentFolder"
Write-Host "Upload the contents of '$deploymentFolder' to your hosting provider" -ForegroundColor Cyan