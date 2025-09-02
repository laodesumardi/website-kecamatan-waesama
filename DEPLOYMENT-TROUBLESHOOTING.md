# Panduan Troubleshooting Deployment

## Masalah: Server Online Tidak Terupdate Setelah Push ke GitHub

### Analisis Masalah
1. **Commit terbaru sudah di-push ke GitHub** ✅
   - Commit: `08eb747 - Fix navigation menu layout`
   - Branch: `main`

2. **Webhook auto-deployment belum dikonfigurasi** ❌
   - File `webhook.php` ada tapi belum aktif
   - Log webhook tidak ditemukan

### Solusi 1: Konfigurasi GitHub Webhook (Otomatis)

#### Langkah 1: Setup Webhook di GitHub
1. Buka repository di GitHub: `https://github.com/[username]/kantor-camat-waesama`
2. Masuk ke **Settings** → **Webhooks** → **Add webhook**
3. Konfigurasi:
   - **Payload URL**: `https://kecamatangwaesama.id/public/webhook.php`
   - **Content type**: `application/json`
   - **Secret**: Buat secret key yang aman (misal: `KantorCamat2024!`)
   - **Events**: Pilih "Just the push event"
   - **Active**: ✅ Centang

#### Langkah 2: Update Secret Key di Server
1. Login ke server via SSH/PuTTY
2. Edit file webhook:
   ```bash
   nano /path/to/project/public/webhook.php
   ```
3. Ganti baris:
   ```php
   $secret = 'your-webhook-secret-key';
   ```
   Menjadi:
   ```php
   $secret = 'KantorCamat2024!';
   ```

#### Langkah 3: Set Permission
```bash
chmod 755 /path/to/project/public/webhook.php
chmod 755 /path/to/project/storage/logs
```

### Solusi 2: Manual Deployment (Sementara)

#### Via SSH/PuTTY:
```bash
# Masuk ke direktori project
cd /path/to/project

# Pull perubahan terbaru
git fetch origin
git reset --hard origin/main
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Clear dan rebuild cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild cache untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permission yang benar
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Solusi 3: Deployment via Control Panel (Hostinger/cPanel)

1. **Login ke Control Panel**
2. **Buka File Manager**
3. **Navigasi ke direktori website**
4. **Upload file terbaru** atau **gunakan Git Deploy** jika tersedia
5. **Clear cache** melalui PHP Selector atau terminal

### Verifikasi Deployment

1. **Cek versi file di server:**
   ```bash
   head -20 /path/to/project/resources/views/welcome.blade.php
   ```
   Pastikan ada CSS anti-duplikasi yang baru ditambahkan

2. **Test website:**
   - Buka `https://kecamatangwaesama.id/public/`
   - Periksa apakah menu duplikat sudah hilang
   - Cek developer tools untuk memastikan CSS baru dimuat

3. **Cek log webhook (jika menggunakan auto-deployment):**
   ```bash
   tail -50 /path/to/project/storage/logs/webhook.log
   ```

### Troubleshooting Umum

#### Problem: Permission Denied
```bash
sudo chown -R www-data:www-data /path/to/project
chmod -R 755 /path/to/project
chmod -R 775 /path/to/project/storage
chmod -R 775 /path/to/project/bootstrap/cache
```

#### Problem: Composer/NPM Not Found
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

#### Problem: Git Not Configured
```bash
git config --global user.name "Server Deploy"
git config --global user.email "deploy@kecamatangwaesama.id"
```

### Monitoring Deployment

#### Setup Log Monitoring
```bash
# Monitor webhook log
tail -f /path/to/project/storage/logs/webhook.log

# Monitor Laravel log
tail -f /path/to/project/storage/logs/laravel.log
```

#### Test Webhook
```bash
# Test webhook endpoint
curl -X POST https://kecamatangwaesama.id/public/webhook.php \
  -H "Content-Type: application/json" \
  -d '{"ref":"refs/heads/main"}'
```

### Rekomendasi

1. **Prioritas Tinggi**: Setup webhook auto-deployment untuk kemudahan maintenance
2. **Backup**: Selalu backup sebelum deployment
3. **Testing**: Test di staging environment sebelum production
4. **Monitoring**: Setup monitoring untuk mendeteksi masalah deployment

---

**Catatan**: Ganti `/path/to/project` dengan path sebenarnya di server Anda.