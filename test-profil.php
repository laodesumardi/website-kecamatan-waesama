<?php
/**
 * Simple Test Script for /profil Route
 * Upload to hosting and access via: https://kecamatangwaesama.id/test-profil.php
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test Route /profil - Kecamatan Gwaesama</h1>";
echo "<hr>";

// Test 1: Check if view file exists
echo "<h2>1. View File Check</h2>";
$viewFile = 'resources/views/public/profil.blade.php';
if (file_exists($viewFile)) {
    echo "✅ View file exists: {$viewFile}<br>";
    echo "File size: " . filesize($viewFile) . " bytes<br>";
    echo "Last modified: " . date('Y-m-d H:i:s', filemtime($viewFile)) . "<br>";
} else {
    echo "❌ View file NOT found: {$viewFile}<br>";
}
echo "<br>";

// Test 2: Check controller file
echo "<h2>2. Controller File Check</h2>";
$controllerFile = 'app/Http/Controllers/PublicController.php';
if (file_exists($controllerFile)) {
    echo "✅ Controller file exists: {$controllerFile}<br>";
    echo "File size: " . filesize($controllerFile) . " bytes<br>";
    echo "Last modified: " . date('Y-m-d H:i:s', filemtime($controllerFile)) . "<br>";
} else {
    echo "❌ Controller file NOT found: {$controllerFile}<br>";
}
echo "<br>";

// Test 3: Check routes file
echo "<h2>3. Routes File Check</h2>";
$routesFile = 'routes/web.php';
if (file_exists($routesFile)) {
    echo "✅ Routes file exists: {$routesFile}<br>";
    
    $routesContent = file_get_contents($routesFile);
    if (strpos($routesContent, '/profil') !== false) {
        echo "✅ Route /profil found in routes file<br>";
    } else {
        echo "❌ Route /profil NOT found in routes file<br>";
    }
} else {
    echo "❌ Routes file NOT found: {$routesFile}<br>";
}
echo "<br>";

// Test 4: Try to access the route via cURL
echo "<h2>4. Route Access Test</h2>";
if (function_exists('curl_init')) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://kecamatangwaesama.id/profil');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Debug Script');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "HTTP Status Code: {$httpCode}<br>";
    
    if ($error) {
        echo "❌ cURL Error: {$error}<br>";
    } elseif ($httpCode == 200) {
        echo "✅ Route accessible (HTTP 200)<br>";
        echo "Response length: " . strlen($response) . " characters<br>";
    } elseif ($httpCode == 500) {
        echo "❌ HTTP 500 Error confirmed<br>";
        echo "Response: " . substr($response, 0, 500) . "...<br>";
    } else {
        echo "⚠️ HTTP {$httpCode}<br>";
    }
} else {
    echo "❌ cURL not available<br>";
}
echo "<br>";

// Test 5: Check Laravel installation
echo "<h2>5. Laravel Installation Check</h2>";
if (file_exists('artisan')) {
    echo "✅ Artisan file exists<br>";
} else {
    echo "❌ Artisan file NOT found<br>";
}

if (file_exists('composer.json')) {
    echo "✅ Composer.json exists<br>";
    $composer = json_decode(file_get_contents('composer.json'), true);
    if (isset($composer['require']['laravel/framework'])) {
        echo "Laravel version: " . $composer['require']['laravel/framework'] . "<br>";
    }
} else {
    echo "❌ Composer.json NOT found<br>";
}

if (file_exists('vendor/autoload.php')) {
    echo "✅ Vendor autoload exists<br>";
} else {
    echo "❌ Vendor autoload NOT found - Run composer install<br>";
}
echo "<br>";

// Test 6: Check .htaccess
echo "<h2>6. .htaccess Check</h2>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess file exists<br>";
    $htaccess = file_get_contents('.htaccess');
    if (strpos($htaccess, 'RewriteEngine On') !== false) {
        echo "✅ URL rewriting enabled<br>";
    } else {
        echo "❌ URL rewriting not properly configured<br>";
    }
} else {
    echo "❌ .htaccess file NOT found<br>";
}
echo "<br>";

echo "<hr>";
echo "<h2>Quick Fix Commands</h2>";
echo "<p>If you have SSH access, try these commands:</p>";
echo "<pre style='background: #f0f0f0; padding: 10px;'>";
echo "# Clear cache\n";
echo "php artisan cache:clear\n";
echo "php artisan config:clear\n";
echo "php artisan route:clear\n";
echo "php artisan view:clear\n";
echo "\n";
echo "# Fix permissions\n";
echo "chmod -R 755 storage\n";
echo "chmod -R 755 bootstrap/cache\n";
echo "\n";
echo "# Install dependencies\n";
echo "composer install --no-dev --optimize-autoloader\n";
echo "\n";
echo "# Generate app key if missing\n";
echo "php artisan key:generate\n";
echo "</pre>";

echo "<p><em>Generated at: " . date('Y-m-d H:i:s') . "</em></p>";
echo "<p><strong>Remember to delete this file after debugging!</strong></p>";
?>