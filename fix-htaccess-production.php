<?php
/**
 * Fix .htaccess for Production Hosting
 * Script khusus untuk memperbaiki masalah .htaccess di hosting shared
 * Upload ke hosting dan akses via: https://kecamatangwaesama.id/fix-htaccess-production.php
 */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Fix .htaccess for Production - Kecamatan Gwaesama</h1>";
echo "<hr>";

// Backup existing .htaccess
echo "<h2>1. Backup Existing .htaccess</h2>";
if (file_exists('.htaccess')) {
    $backup = '.htaccess.backup.' . date('Y-m-d-H-i-s');
    if (copy('.htaccess', $backup)) {
        echo "✅ Backup created: {$backup}<br>";
    } else {
        echo "❌ Failed to create backup<br>";
    }
} else {
    echo "⚠️ No existing .htaccess file found<br>";
}
echo "<br>";

// Create optimized .htaccess for shared hosting
echo "<h2>2. Creating Optimized .htaccess</h2>";

$htaccessContent = <<<'HTACCESS'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Disable server signature
ServerSignature Off

# Hide sensitive files
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.json">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.lock">
    Order allow,deny
    Deny from all
</Files>

<Files "package.json">
    Order allow,deny
    Deny from all
</Files>

<Files "*.log">
    Order allow,deny
    Deny from all
</Files>

# Prevent access to storage and bootstrap cache
<IfModule mod_alias.c>
    RedirectMatch 403 ^/storage/.*$
    RedirectMatch 403 ^/bootstrap/cache/.*$
</IfModule>

# PHP Configuration for shared hosting
<IfModule mod_php7.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value memory_limit 256M
    php_value max_execution_time 300
    php_value max_input_vars 3000
</IfModule>

<IfModule mod_php8.c>
    php_value upload_max_filesize 64M
    php_value post_max_size 64M
    php_value memory_limit 256M
    php_value max_execution_time 300
    php_value max_input_vars 3000
</IfModule>

# Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Browser Caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/svg+xml "access plus 1 month"
</IfModule>
HTACCESS;

if (file_put_contents('.htaccess', $htaccessContent)) {
    echo "✅ New .htaccess file created successfully<br>";
} else {
    echo "❌ Failed to create .htaccess file<br>";
}
echo "<br>";

// Create public/.htaccess if it doesn't exist
echo "<h2>3. Checking public/.htaccess</h2>";
if (!file_exists('public/.htaccess')) {
    $publicHtaccess = <<<'PUBLIC_HTACCESS'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
PUBLIC_HTACCESS;

    if (!is_dir('public')) {
        mkdir('public', 0755, true);
    }
    
    if (file_put_contents('public/.htaccess', $publicHtaccess)) {
        echo "✅ Created public/.htaccess<br>";
    } else {
        echo "❌ Failed to create public/.htaccess<br>";
    }
} else {
    echo "✅ public/.htaccess already exists<br>";
}
echo "<br>";

// Test .htaccess syntax
echo "<h2>4. Testing .htaccess Configuration</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    $requiredModules = ['mod_rewrite', 'mod_headers', 'mod_deflate', 'mod_expires'];
    
    foreach ($requiredModules as $module) {
        if (in_array($module, $modules)) {
            echo "✅ {$module} is enabled<br>";
        } else {
            echo "⚠️ {$module} is not enabled (may cause issues)<br>";
        }
    }
} else {
    echo "⚠️ Cannot check Apache modules (function not available)<br>";
}
echo "<br>";

// Test website access
echo "<h2>5. Testing Website Access</h2>";
if (function_exists('curl_init')) {
    $testUrls = [
        'https://kecamatangwaesama.id/',
        'https://kecamatangwaesama.id/profil'
    ];
    
    foreach ($testUrls as $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'htaccess Fix Script');
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            echo "❌ {$url} - cURL Error: {$error}<br>";
        } elseif ($httpCode == 200) {
            echo "✅ {$url} - Working (HTTP 200)<br>";
        } elseif ($httpCode == 500) {
            echo "❌ {$url} - HTTP 500 Error<br>";
        } else {
            echo "⚠️ {$url} - HTTP {$httpCode}<br>";
        }
    }
} else {
    echo "❌ cURL not available for testing<br>";
}
echo "<br>";

// Alternative .htaccess for problematic hosting
echo "<h2>6. Alternative .htaccess (if issues persist)</h2>";
echo "<p>If you're still getting errors, try this minimal .htaccess:</p>";
echo "<textarea rows='15' cols='80' readonly>";
echo "RewriteEngine On\n";
echo "RewriteCond %{REQUEST_FILENAME} !-d\n";
echo "RewriteCond %{REQUEST_FILENAME} !-f\n";
echo "RewriteRule ^ index.php [L]\n";
echo "\n";
echo "<Files \".env\">\n";
echo "    Order allow,deny\n";
echo "    Deny from all\n";
echo "</Files>";
echo "</textarea><br>";
echo "<button onclick='useMinimal()'>Use Minimal .htaccess</button>";
echo "<br><br>";

echo "<script>";
echo "function useMinimal() {";
echo "    if (confirm('Replace current .htaccess with minimal version?')) {";
echo "        fetch('fix-htaccess-production.php?action=minimal', {method: 'POST'})";
echo "            .then(() => location.reload());";
echo "    }";
echo "}";
echo "</script>";

// Handle minimal .htaccess request
if (isset($_GET['action']) && $_GET['action'] === 'minimal') {
    $minimalHtaccess = <<<'MINIMAL'
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

<Files ".env">
    Order allow,deny
    Deny from all
</Files>
MINIMAL;
    
    file_put_contents('.htaccess', $minimalHtaccess);
    echo "<p>✅ Minimal .htaccess applied!</p>";
}

echo "<hr>";
echo "<h2>Summary & Next Steps</h2>";
echo "<ol>";
echo "<li>✅ .htaccess file has been optimized for shared hosting</li>";
echo "<li>✅ Security rules and performance optimizations added</li>";
echo "<li>✅ PHP configuration adjusted for hosting limits</li>";
echo "<li>🔄 Test your website: <a href='https://kecamatangwaesama.id/profil' target='_blank'>https://kecamatangwaesama.id/profil</a></li>";
echo "<li>🗑️ Delete this file after testing: fix-htaccess-production.php</li>";
echo "</ol>";

echo "<p><strong>If problems persist:</strong></p>";
echo "<ul>";
echo "<li>Try the minimal .htaccess version above</li>";
echo "<li>Contact your hosting provider about mod_rewrite support</li>";
echo "<li>Check hosting control panel for error logs</li>";
echo "<li>Verify PHP version compatibility (Laravel requires PHP 8.1+)</li>";
echo "</ul>";

echo "<p><em>Generated at: " . date('Y-m-d H:i:s') . "</em></p>";
?>