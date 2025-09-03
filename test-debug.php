<?php
// Test file untuk memeriksa konfigurasi PHP
echo "<h1>Debug Test - Kantor Camat Waesama</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";

// Test file permissions
echo "<h2>File Permissions Test</h2>";
$files = ['index.php', '.env', 'bootstrap/app.php', 'vendor/autoload.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "<p>$file: $perms ✓</p>";
    } else {
        echo "<p>$file: <span style='color:red'>NOT FOUND ✗</span></p>";
    }
}

// Test Laravel
echo "<h2>Laravel Test</h2>";
try {
    if (file_exists('vendor/autoload.php')) {
        require 'vendor/autoload.php';
        echo "<p style='color:green'>✓ Composer autoloader loaded</p>";
        
        if (file_exists('bootstrap/app.php')) {
            echo "<p style='color:green'>✓ Laravel bootstrap file found</p>";
        } else {
            echo "<p style='color:red'>✗ Laravel bootstrap file not found</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Directory Structure</h2>";
echo "<pre>";
$dirs = ['.', 'app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage', 'vendor'];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo "✓ $dir/\n";
    } else {
        echo "✗ $dir/\n";
    }
}
echo "</pre>";

echo "<p><a href='/'>← Kembali ke halaman utama</a></p>";
?>