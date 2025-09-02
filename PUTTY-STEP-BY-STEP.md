# Panduan Lengkap Upload dan Deploy via Putty

## Masalah yang Terjadi

```
Vite manifest not found at: /home/u798974089/domains/website.kecamatangwaesama.id/public_html/public/build/manifest.json
```

**Penyebab:** Assets belum di-build untuk production, sehingga file manifest.json tidak ada.

## Metode 1: Upload Script dan Jalankan

### A. Persiapan File di Local

1. **Download script yang sudah dibuat:**
   - `deploy-production.sh` (deployment lengkap)
   - `fix-vite-manifest.sh` (fix khusus manifest)

### B. Upload File ke Server

#### Opsi 1: Menggunakan WinSCP (Recommended)

1. **Download dan Install WinSCP:**
   - Download dari: https://winscp.net/
   - Install dengan setting default

2. **Koneksi ke Server:**
   ```
   Host: website.kecamatangwaesama.id
   Username: u798974089
   Password: [password hosting Anda]
   Port: 22
   ```

3. **Upload Script:**
   - Navigate ke: `/home/u798974089/domains/website.kecamatangwaesama.id/public_html/`
   - Drag & drop file `fix-vite-manifest.sh` ke folder tersebut

#### Opsi 2: Menggunakan Putty + nano (Manual)

1. **Buka Putty dan koneksi ke server**
2. **Buat file script:**
   ```bash
   cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html
   nano fix-vite-manifest.sh
   ```
3. **Copy-paste isi script** (dari file `fix-vite-manifest.sh`)
4. **Save:** Ctrl+X, Y, Enter

### C. Eksekusi Script via Putty

1. **Buka Putty dan koneksi:**
   ```
   Host: website.kecamatangwaesama.id
   Port: 22
   Username: u798974089
   ```

2. **Masuk ke directory website:**
   ```bash
   cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html
   ```

3. **Beri permission execute pada script:**
   ```bash
   chmod +x fix-vite-manifest.sh
   ```

4. **Jalankan script:**
   ```bash
   ./fix-vite-manifest.sh
   ```

## Metode 2: Manual Commands via Putty

Jika script tidak bisa dijalankan, ikuti perintah manual ini:

### 1. Koneksi dan Navigasi

```bash
# Login via Putty
ssh u798974089@website.kecamatangwaesama.id

# Masuk ke directory website
cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html

# Cek isi directory
ls -la
```

### 2. Install Dependencies

```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install
```

### 3. Build Assets (PENTING!)

```bash
# Build assets untuk production
npm run build

# Cek apakah berhasil
ls -la public/build/
```

**Output yang diharapkan:**
```
drwxr-xr-x 3 user user 4096 Jan 15 10:30 assets
-rw-r--r-- 1 user user  500 Jan 15 10:30 manifest.json
```

### 4. Optimize Laravel

```bash
# Clear dan cache konfigurasi
php artisan config:clear
php artisan config:cache

# Clear dan cache route
php artisan route:clear
php artisan route:cache

# Clear dan cache view
php artisan view:clear
php artisan view:cache
```

### 5. Set Permissions

```bash
# Set permission untuk build directory
chmod -R 755 public/build

# Set permission untuk storage
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 6. Verifikasi

```bash
# Cek manifest file
cat public/build/manifest.json

# Cek assets
ls -la public/build/assets/
```

## Metode 3: One-Liner Commands

Jika ingin cepat, jalankan perintah ini satu per satu:

```bash
# 1. Masuk ke directory
cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html

# 2. Install dan build
npm install && npm run build

# 3. Optimize Laravel
php artisan config:cache && php artisan route:cache && php artisan view:cache

# 4. Set permissions
chmod -R 755 public/build && chmod -R 775 storage bootstrap/cache

# 5. Verifikasi
ls -la public/build/manifest.json
```

## Troubleshooting

### Error: "npm: command not found"

```bash
# Install Node.js dan NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Atau gunakan nvm
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
source ~/.bashrc
nvm install 18
nvm use 18
```

### Error: "composer: command not found"

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Error: "Permission denied"

```bash
# Gunakan sudo untuk commands yang memerlukan permission
sudo chmod -R 775 storage
sudo chown -R www-data:www-data storage
```

### Error: "npm run build" gagal

```bash
# Clear npm cache
npm cache clean --force

# Hapus node_modules dan install ulang
rm -rf node_modules package-lock.json
npm install
npm run build
```

## Verifikasi Setelah Deploy

### 1. Cek Website

Buka browser dan akses:
- https://website.kecamatangwaesama.id

### 2. Cek Manifest

Akses langsung:
- https://website.kecamatangwaesama.id/build/manifest.json

### 3. Cek Console Browser

1. Buka website
2. Tekan F12 (Developer Tools)
3. Lihat tab Console
4. Tidak boleh ada error 404 untuk CSS/JS

### 4. Cek Functionality

- Navigation menu berfungsi
- Login/Register berfungsi
- Styling tampil dengan benar

## File Structure Setelah Build

```
public/
├── build/
│   ├── manifest.json          ← File ini yang error sebelumnya
│   └── assets/
│       ├── app-[hash].css     ← CSS yang di-compile
│       ├── app-[hash].js      ← JS yang di-compile
│       └── [other-assets]
├── index.php
└── [other-files]
```

## Tips Maintenance

1. **Backup sebelum deploy:**
   ```bash
   cp -r public/build public/build.backup
   ```

2. **Monitor logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Auto-deploy setup** (untuk kedepannya):
   - Setup GitHub webhooks
   - Buat script auto-deploy
   - Monitor dengan cron jobs

## Kontak Support

Jika masih ada masalah:
1. Cek error logs di `storage/logs/laravel.log`
2. Cek web server logs (Apache/Nginx)
3. Hubungi support hosting jika diperlukan

---

**Catatan:** Pastikan Anda memiliki akses SSH ke server dan permission yang cukup untuk menjalankan perintah-perintah di atas.