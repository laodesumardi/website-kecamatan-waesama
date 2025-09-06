<?php
/**
 * Script Debug Production untuk Error 500
 * Upload file ini ke hosting dan akses melalui browser
 * URL: https://kecamatangwaesama.id/debug-production.php
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Production - Kecamatan Gwaesama</h1>";
echo "<hr>";

// 1. Check PHP Version
echo "<h2>1. PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "<br>";

// 2. Check Laravel Installation
echo "<h2>2. Laravel Installation</h2>";
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer autoload found<br>";
    require_once 'vendor/autoload.php';
} else {
    echo "❌ Composer autoload NOT found<br>";
}

if (file_exists('bootstrap/app.php')) {
    echo "✅ Laravel bootstrap found<br>";
} else {
    echo "❌ Laravel bootstrap NOT found<br>";
}
echo "<br>";

// 3. Check .env file
echo "<h2>3. Environment Configuration</h2>";
if (file_exists('.env')) {
    echo "✅ .env file exists<br>";
    
    $envContent = file_get_contents('.env');
    $envLines = explode("\n", $envContent);
    
    echo "<strong>Key Environment Variables:</strong><br>";
    foreach ($envLines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) continue;
        
        if (strpos($line, 'APP_') === 0 || 
            strpos($line, 'DB_') === 0 || 
            strpos($line, 'CACHE_') === 0 || 
            strpos($line, 'SESSION_') === 0) {
            
            // Hide sensitive values
            if (strpos($line, 'APP_KEY=') === 0) {
                echo "APP_KEY=" . (strlen(substr($line, 8)) > 0 ? '[SET]' : '[NOT SET]') . "<br>";
            } elseif (strpos($line, 'DB_PASSWORD=') === 0) {
                echo "DB_PASSWORD=" . (strlen(substr($line, 12)) > 0 ? '[SET]' : '[NOT SET]') . "<br>";
            } else {
                echo htmlspecialchars($line) . "<br>";
            }
        }
    }
} else {
    echo "❌ .env file NOT found<br>";
}
echo "<br>";

// 4. Check Database Connection
echo "<h2>4. Database Connection</h2>";
try {
    if (file_exists('vendor/autoload.php') && file_exists('bootstrap/app.php')) {
        $app = require_once 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        
        $pdo = DB::connection()->getPdo();
        echo "✅ Database connection successful<br>";
        echo "Database: " . DB::connection()->getDatabaseName() . "<br>";
    } else {
        echo "❌ Cannot test database - Laravel not properly loaded<br>";
    }
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
}
echo "<br>";

// 5. Check Storage Permissions
echo "<h2>5. Storage Permissions</h2>";
$storageDir = 'storage';
if (is_dir($storageDir)) {
    echo "✅ Storage directory exists<br>";
    echo "Storage writable: " . (is_writable($storageDir) ? '✅ Yes' : '❌ No') . "<br>";
    
    $logDir = 'storage/logs';
    if (is_dir($logDir)) {
        echo "Logs directory writable: " . (is_writable($logDir) ? '✅ Yes' : '❌ No') . "<br>";
    } else {
        echo "❌ Logs directory not found<br>";
    }
    
    $cacheDir = 'storage/framework/cache';
    if (is_dir($cacheDir)) {
        echo "Cache directory writable: " . (is_writable($cacheDir) ? '✅ Yes' : '❌ No') . "<br>";
    } else {
        echo "❌ Cache directory not found<br>";
    }
} else {
    echo "❌ Storage directory not found<br>";
}
echo "<br>";

// 6. Check Recent Errors
echo "<h2>6. Recent Laravel Errors</h2>";
$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "✅ Laravel log file found<br>";
    
    $logContent = file_get_contents($logFile);
    $logLines = explode("\n", $logContent);
    $recentErrors = [];
    
    // Get last 50 lines
    $lastLines = array_slice($logLines, -50);
    
    foreach ($lastLines as $line) {
        if (strpos($line, '[ERROR]') !== false || strpos($line, 'ERROR:') !== false) {
            $recentErrors[] = $line;
        }
    }
    
    if (!empty($recentErrors)) {
        echo "<strong>Recent Errors (last 10):</strong><br>";
        echo "<pre style='background: #f5f5f5; padding: 10px; overflow-x: auto;'>";
        foreach (array_slice($recentErrors, -10) as $error) {
            echo htmlspecialchars($error) . "\n";
        }
        echo "</pre>";
    } else {
        echo "✅ No recent errors found<br>";
    }
} else {
    echo "❌ Laravel log file not found<br>";
}
echo "<br>";

// 7. Test Route /profil specifically
echo "<h2>7. Test Route /profil</h2>";
try {
    if (file_exists('vendor/autoload.php') && file_exists('bootstrap/app.php')) {
        // Try to load the view directly
        $viewPath = 'resources/views/public/profil.blade.php';
        if (file_exists($viewPath)) {
            echo "✅ View file exists: " . $viewPath . "<br>";
            
            // Check if view can be compiled
            $app = require_once 'bootstrap/app.php';
            $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
            
            try {
                $view = view('public.profil');
                echo "✅ View can be loaded successfully<br>";
            } catch (Exception $e) {
                echo "❌ View loading error: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "❌ View file not found: " . $viewPath . "<br>";
        }
    } else {
        echo "❌ Cannot test view - Laravel not properly loaded<br>";
    }
} catch (Exception $e) {
    echo "❌ Route test error: " . $e->getMessage() . "<br>";
}
echo "<br>";

echo "<hr>";
echo "<p><strong>Instructions:</strong></p>";
echo "<ol>";
echo "<li>Upload this file to your hosting root directory</li>";
echo "<li>Access it via: https://kecamatangwaesama.id/debug-production.php</li>";
echo "<li>Check all the results above</li>";
echo "<li>Fix any issues marked with ❌</li>";
echo "<li>Delete this file after debugging</li>";
echo "</ol>";

echo "<p><em>Generated at: " . date('Y-m-d H:i:s') . "</em></p>";
?>