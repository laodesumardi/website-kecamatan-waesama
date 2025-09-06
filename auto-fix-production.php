<?php
/**
 * Auto Fix Production Issues
 * Script untuk memperbaiki masalah umum di hosting production
 * Upload ke hosting dan akses via: https://kecamatangwaesama.id/auto-fix-production.php
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Auto Fix Production Issues - Kecamatan Gwaesama</h1>";
echo "<hr>";

$fixes = [];
$errors = [];

// Fix 1: Clear all caches
echo "<h2>1. Clearing Caches</h2>";
try {
    // Clear Laravel caches
    $commands = [
        'php artisan cache:clear',
        'php artisan config:clear',
        'php artisan route:clear',
        'php artisan view:clear',
        'php artisan optimize:clear'
    ];
    
    foreach ($commands as $cmd) {
        $output = [];
        $return_var = 0;
        exec($cmd . ' 2>&1', $output, $return_var);
        
        if ($return_var === 0) {
            echo "✅ {$cmd} - Success<br>";
            $fixes[] = $cmd;
        } else {
            echo "❌ {$cmd} - Failed: " . implode(' ', $output) . "<br>";
            $errors[] = $cmd . ': ' . implode(' ', $output);
        }
    }
} catch (Exception $e) {
    echo "❌ Cache clearing error: " . $e->getMessage() . "<br>";
    $errors[] = 'Cache clearing: ' . $e->getMessage();
}
echo "<br>";

// Fix 2: Fix storage permissions
echo "<h2>2. Fixing Storage Permissions</h2>";
try {
    $directories = [
        'storage',
        'storage/logs',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'bootstrap/cache'
    ];
    
    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            if (chmod($dir, 0755)) {
                echo "✅ Fixed permissions for {$dir}<br>";
                $fixes[] = "chmod 755 {$dir}";
            } else {
                echo "❌ Failed to fix permissions for {$dir}<br>";
                $errors[] = "chmod failed for {$dir}";
            }
        } else {
            echo "⚠️ Directory {$dir} not found<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Permission fix error: " . $e->getMessage() . "<br>";
    $errors[] = 'Permission fix: ' . $e->getMessage();
}
echo "<br>";

// Fix 3: Generate APP_KEY if missing
echo "<h2>3. Checking APP_KEY</h2>";
try {
    if (file_exists('.env')) {
        $envContent = file_get_contents('.env');
        if (strpos($envContent, 'APP_KEY=') === false || strpos($envContent, 'APP_KEY=base64:') === false) {
            $output = [];
            $return_var = 0;
            exec('php artisan key:generate --force 2>&1', $output, $return_var);
            
            if ($return_var === 0) {
                echo "✅ APP_KEY generated successfully<br>";
                $fixes[] = 'APP_KEY generated';
            } else {
                echo "❌ Failed to generate APP_KEY: " . implode(' ', $output) . "<br>";
                $errors[] = 'APP_KEY generation: ' . implode(' ', $output);
            }
        } else {
            echo "✅ APP_KEY already exists<br>";
        }
    } else {
        echo "❌ .env file not found<br>";
        $errors[] = '.env file not found';
    }
} catch (Exception $e) {
    echo "❌ APP_KEY check error: " . $e->getMessage() . "<br>";
    $errors[] = 'APP_KEY check: ' . $e->getMessage();
}
echo "<br>";

// Fix 4: Install/Update Composer dependencies
echo "<h2>4. Composer Dependencies</h2>";
try {
    if (file_exists('composer.json')) {
        $output = [];
        $return_var = 0;
        exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $return_var);
        
        if ($return_var === 0) {
            echo "✅ Composer dependencies installed<br>";
            $fixes[] = 'Composer install';
        } else {
            echo "❌ Composer install failed: " . implode(' ', $output) . "<br>";
            $errors[] = 'Composer install: ' . implode(' ', $output);
        }
    } else {
        echo "❌ composer.json not found<br>";
        $errors[] = 'composer.json not found';
    }
} catch (Exception $e) {
    echo "❌ Composer error: " . $e->getMessage() . "<br>";
    $errors[] = 'Composer: ' . $e->getMessage();
}
echo "<br>";

// Fix 5: Run database migrations
echo "<h2>5. Database Migrations</h2>";
try {
    $output = [];
    $return_var = 0;
    exec('php artisan migrate --force 2>&1', $output, $return_var);
    
    if ($return_var === 0) {
        echo "✅ Database migrations completed<br>";
        $fixes[] = 'Database migrations';
    } else {
        echo "❌ Migration failed: " . implode(' ', $output) . "<br>";
        $errors[] = 'Migration: ' . implode(' ', $output);
    }
} catch (Exception $e) {
    echo "❌ Migration error: " . $e->getMessage() . "<br>";
    $errors[] = 'Migration: ' . $e->getMessage();
}
echo "<br>";

// Fix 6: Optimize for production
echo "<h2>6. Production Optimization</h2>";
try {
    $commands = [
        'php artisan config:cache',
        'php artisan route:cache',
        'php artisan view:cache'
    ];
    
    foreach ($commands as $cmd) {
        $output = [];
        $return_var = 0;
        exec($cmd . ' 2>&1', $output, $return_var);
        
        if ($return_var === 0) {
            echo "✅ {$cmd} - Success<br>";
            $fixes[] = $cmd;
        } else {
            echo "❌ {$cmd} - Failed: " . implode(' ', $output) . "<br>";
            $errors[] = $cmd . ': ' . implode(' ', $output);
        }
    }
} catch (Exception $e) {
    echo "❌ Optimization error: " . $e->getMessage() . "<br>";
    $errors[] = 'Optimization: ' . $e->getMessage();
}
echo "<br>";

// Fix 7: Create missing directories
echo "<h2>7. Creating Missing Directories</h2>";
try {
    $requiredDirs = [
        'storage/app/public',
        'storage/framework/cache/data',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs'
    ];
    
    foreach ($requiredDirs as $dir) {
        if (!is_dir($dir)) {
            if (mkdir($dir, 0755, true)) {
                echo "✅ Created directory: {$dir}<br>";
                $fixes[] = "Created {$dir}";
            } else {
                echo "❌ Failed to create directory: {$dir}<br>";
                $errors[] = "Failed to create {$dir}";
            }
        } else {
            echo "✅ Directory exists: {$dir}<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Directory creation error: " . $e->getMessage() . "<br>";
    $errors[] = 'Directory creation: ' . $e->getMessage();
}
echo "<br>";

// Fix 8: Test route /profil
echo "<h2>8. Testing Route /profil</h2>";
try {
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://kecamatangwaesama.id/profil');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Auto Fix Script');
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo "❌ cURL Error: {$error}<br>";
            $errors[] = "Route test cURL: {$error}";
        } elseif ($httpCode == 200) {
            echo "✅ Route /profil working (HTTP 200)<br>";
            $fixes[] = 'Route /profil accessible';
        } elseif ($httpCode == 500) {
            echo "❌ Route /profil still returns HTTP 500<br>";
            $errors[] = 'Route /profil HTTP 500';
        } else {
            echo "⚠️ Route /profil returns HTTP {$httpCode}<br>";
            $errors[] = "Route /profil HTTP {$httpCode}";
        }
    } else {
        echo "❌ cURL not available for testing<br>";
        $errors[] = 'cURL not available';
    }
} catch (Exception $e) {
    echo "❌ Route test error: " . $e->getMessage() . "<br>";
    $errors[] = 'Route test: ' . $e->getMessage();
}
echo "<br>";

// Summary
echo "<hr>";
echo "<h2>Summary</h2>";
echo "<h3>✅ Successful Fixes (" . count($fixes) . "):</h3>";
if (!empty($fixes)) {
    echo "<ul>";
    foreach ($fixes as $fix) {
        echo "<li>" . htmlspecialchars($fix) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No fixes were applied successfully.</p>";
}

echo "<h3>❌ Errors/Issues (" . count($errors) . "):</h3>";
if (!empty($errors)) {
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    
    echo "<h3>Manual Steps Required:</h3>";
    echo "<ol>";
    echo "<li>Contact hosting provider if permission issues persist</li>";
    echo "<li>Check hosting control panel for PHP version compatibility</li>";
    echo "<li>Verify database credentials in .env file</li>";
    echo "<li>Check hosting error logs for detailed error messages</li>";
    echo "<li>Ensure all required PHP extensions are installed</li>";
    echo "</ol>";
} else {
    echo "<p>✅ All fixes applied successfully! No errors found.</p>";
}

echo "<hr>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Test the website: <a href='https://kecamatangwaesama.id/profil' target='_blank'>https://kecamatangwaesama.id/profil</a></li>";
echo "<li>If still getting HTTP 500, check hosting error logs</li>";
echo "<li>Delete this file after fixing: auto-fix-production.php</li>";
echo "</ol>";

echo "<p><em>Auto-fix completed at: " . date('Y-m-d H:i:s') . "</em></p>";
?>