# 🚀 DIRECT FIX COMMANDS - Kantor Camat Waesama

## ⚡ Langsung Jalankan di Server Production

Karena file `complete-fix.sh` tidak ada di server, gunakan perintah langsung berikut:

### 📍 Pastikan Anda di Direktori yang Benar
```bash
# Anda sudah di: /home/u798974089/domains/website.kecamatangwaesama.id/public_html
# Pastikan ini adalah direktori Laravel
ls -la artisan
```

### 🔧 SOLUSI 1: One-Liner Command (Tercepat)
```bash
npm ci --production=false && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache && chmod -R 755 public/build && chmod -R 775 storage bootstrap/cache && php artisan cache:clear
```

### 🔧 SOLUSI 2: Step-by-Step Commands
```bash
# 1. Install NPM dependencies
npm ci --production=false

# 2. Build assets for production
npm run build

# 3. Cache Laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Set permissions
chmod -R 755 public/build
chmod -R 775 storage bootstrap/cache

# 5. Clear caches
php artisan cache:clear
```

### 🔍 VERIFIKASI HASIL
```bash
# Check manifest file
ls -la public/build/manifest.json

# Check assets folder
ls -la public/build/assets/

# Test website
curl -I https://website.kecamatangwaesama.id
```

### ✅ HASIL YANG DIHARAPKAN
```
✅ public/build/manifest.json - File exists
✅ public/build/assets/ - Folder with CSS/JS files
✅ Website loads without styling errors
```

### 🛠️ TROUBLESHOOTING

#### Jika NPM tidak ditemukan:
```bash
# Install Node.js via NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
source ~/.bashrc
nvm install 18
nvm use 18
```

#### Jika build gagal:
```bash
# Clear npm cache
npm cache clean --force

# Remove node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

#### Jika permission error:
```bash
# Fix ownership
sudo chown -R $USER:$USER .

# Set proper permissions
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

### 🌐 TEST URLS
- **Website:** https://website.kecamatangwaesama.id
- **Manifest:** https://website.kecamatangwaesama.id/build/manifest.json
- **Admin:** https://website.kecamatangwaesama.id/login

---

## 📋 QUICK REFERENCE

**Current Status dari log Anda:**
- ❌ `complete-fix.sh` tidak ada di server
- ✅ `git pull` berhasil (Already up to date)
- 📍 Anda berada di direktori yang benar

**Next Action:**
Jalankan **SOLUSI 1** (one-liner) untuk fix cepat, atau **SOLUSI 2** (step-by-step) untuk kontrol lebih detail.

**Estimasi waktu:** 2-5 menit
**Hasil:** Website berfungsi normal tanpa error Vite manifest