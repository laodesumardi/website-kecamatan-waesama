# Deployment Package Creator for Hostinger
# Kantor Camat Waesama - Laravel Application

Write-Host "Creating deployment package..." -ForegroundColor Green

# Define items to exclude
$excludeItems = @(
    '.git',
    'node_modules',
    '.env',
    'storage/logs',
    'bootstrap/cache',
    'tests',
    '.github',
    'package-lock.json',
    'vite.config.js',
    'tailwind.config.js',
    'postcss.config.js',
    'phpunit.xml'
)

# Define markdown and script files to exclude
$excludePatterns = @('*.md', '*.sh')

# Create temporary directory
$tempDir = 'deployment-temp'
if (Test-Path $tempDir) {
    Remove-Item $tempDir -Recurse -Force
}
New-Item -ItemType Directory -Path $tempDir | Out-Null

Write-Host "Copying files..." -ForegroundColor Yellow

# Copy all items except excluded ones
Get-ChildItem -Path . | Where-Object {
    $item = $_
    $shouldExclude = $false
    
    # Check against exclude list
    foreach ($exclude in $excludeItems) {
        if ($item.Name -eq $exclude) {
            $shouldExclude = $true
            break
        }
    }
    
    # Check against patterns
    if (-not $shouldExclude) {
        foreach ($pattern in $excludePatterns) {
            if ($item.Name -like $pattern) {
                $shouldExclude = $true
                break
            }
        }
    }
    
    return -not $shouldExclude
} | Copy-Item -Destination $tempDir -Recurse -Force

Write-Host "Adding production files..." -ForegroundColor Yellow

# Copy production-specific files
if (Test-Path '.env.production') {
    Copy-Item '.env.production' -Destination "$tempDir/.env.example.production"
}

if (Test-Path '.htaccess.production') {
    Copy-Item '.htaccess.production' -Destination "$tempDir/.htaccess.production"
}

# Create deployment instructions
$instructions = @"
# DEPLOYMENT INSTRUCTIONS

## Files Included:
- All Laravel application files
- Production .env template (.env.example.production)
- Production .htaccess file (.htaccess.production)
- Optimized assets (from npm run build)
- Cached Laravel configurations

## Next Steps:
1. Extract this ZIP to your Hostinger public_html folder
2. Rename .env.example.production to .env
3. Update database credentials in .env
4. Copy .htaccess.production to public/.htaccess
5. Run: php artisan key:generate
6. Set folder permissions (755 for storage and bootstrap/cache)
7. Run: php artisan migrate --force
8. Test your application

## Support:
Refer to DEPLOYMENT-CHECKLIST.md for detailed instructions.
"@

$instructions | Out-File -FilePath "$tempDir/DEPLOYMENT-INSTRUCTIONS.txt" -Encoding UTF8

Write-Host "Creating ZIP package..." -ForegroundColor Yellow

# Create ZIP file
Compress-Archive -Path "$tempDir/*" -DestinationPath 'deployment-package.zip' -Force

# Clean up
Remove-Item $tempDir -Recurse -Force

Write-Host "SUCCESS: Deployment package created: deployment-package.zip" -ForegroundColor Green
Write-Host "Package size: $([math]::Round((Get-Item 'deployment-package.zip').Length / 1MB, 2)) MB" -ForegroundColor Cyan
Write-Host "Ready for upload to Hostinger!" -ForegroundColor Magenta