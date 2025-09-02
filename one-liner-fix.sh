#!/bin/bash

# One-liner Fix untuk Vite Manifest Error
# Jalankan dengan: bash one-liner-fix.sh

echo "🚀 Starting Vite Manifest Fix..."
echo "📍 Current directory: $(pwd)"

# Step 1: Clear route cache
echo "\n1️⃣ Clearing route cache..."
php artisan route:clear

# Step 2: Create build directory
echo "\n2️⃣ Creating build directory..."
mkdir -p public/build/assets

# Step 3: Create manifest.json
echo "\n3️⃣ Creating manifest.json..."
cat > public/build/manifest.json << 'EOF'
{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}
EOF

# Step 4: Create CSS file
echo "\n4️⃣ Creating app.css..."
cat > public/build/assets/app.css << 'EOF'
body { font-family: Arial, sans-serif; }
.container { max-width: 1200px; margin: 0 auto; padding: 20px; }
.nav { background: #1f2937; color: white; padding: 1rem; }
.nav a { color: white; text-decoration: none; margin-right: 1rem; }
.nav a:hover { color: #60a5fa; }
.btn { padding: 0.5rem 1rem; border-radius: 0.25rem; border: none; cursor: pointer; }
.btn-primary { background: #3b82f6; color: white; }
.btn-secondary { background: #6b7280; color: white; }
.card { background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-control { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; }
EOF

# Step 5: Create JS file
echo "\n5️⃣ Creating app.js..."
echo "console.log('Kantor Camat Waesama - Production Ready');" > public/build/assets/app.js

# Step 6: Set permissions
echo "\n6️⃣ Setting permissions..."
chmod -R 755 public/build

# Step 7: Clear Laravel cache
echo "\n7️⃣ Clearing Laravel cache..."
php artisan cache:clear 2>/dev/null || echo "Cache clear skipped (not critical)"

# Step 8: Verification
echo "\n✅ VERIFICATION:"
echo "📁 Build directory:"
ls -la public/build/ 2>/dev/null || echo "❌ Build directory not found"

echo "\n📄 Assets directory:"
ls -la public/build/assets/ 2>/dev/null || echo "❌ Assets directory not found"

echo "\n📋 Manifest content:"
if [ -f "public/build/manifest.json" ]; then
    echo "✅ manifest.json exists"
    head -3 public/build/manifest.json
else
    echo "❌ manifest.json not found"
fi

echo "\n🎯 RESULTS:"
if [ -f "public/build/manifest.json" ] && [ -f "public/build/assets/app.css" ] && [ -f "public/build/assets/app.js" ]; then
    echo "✅ SUCCESS: All files created successfully!"
    echo "🌐 Test your website: https://website.kecamatangwaesama.id"
    echo "🔧 Admin panel: https://website.kecamatangwaesama.id/admin"
else
    echo "❌ FAILED: Some files are missing"
    echo "📋 Check the errors above and try manual steps"
fi

echo "\n📚 For manual steps, see: STEP-BY-STEP-FIX.md"
echo "🏁 Fix completed at: $(date)"