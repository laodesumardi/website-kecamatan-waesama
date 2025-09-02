# Panduan Cepat Deployment Manual

## 🚨 Masalah: Website Online Belum Terupdate

Website di `https://kecamatangwaesama.id/public/` masih menampilkan menu yang berantakan karena server belum menggunakan versi terbaru dari GitHub.

## ✅ Solusi Cepat

### Opsi 1: Script Otomatis (Recommended)

#### Untuk Server Linux/Unix:
```bash
# Upload file manual-deploy.sh ke server
# Jalankan di terminal server:
chmod +x manual-deploy.sh
./manual-deploy.sh
```

#### Untuk Server Windows:
```powershell
# Upload file manual-deploy.ps1 ke server
# Jalankan di PowerShell server:
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
.\manual-deploy.ps1
```

### Opsi 2: Manual Commands

#### Login ke Server (SSH/PuTTY)
```bash
# Masuk ke direktori website
cd /path/to/your/website

# Update kode dari GitHub
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

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Opsi 3: Via Control Panel (Hostinger/cPanel)

1. **Login ke Control Panel**
2. **File Manager** → Navigasi ke direktori website
3. **Terminal** (jika tersedia) → Jalankan commands di atas
4. **Atau upload manual** file `welcome.blade.php` yang sudah diperbaiki

## 🔍 Verifikasi

Setelah deployment, cek:

1. **Website**: `https://kecamatangwaesama.id/public/`
2. **Menu duplikat hilang**: Tidak ada lagi menu yang muncul 2 kali
3. **Layout rapi**: Spasi dan tampilan sudah benar

## 📋 Checklist Deployment

- [ ] Backup website saat ini
- [ ] Pull kode terbaru dari GitHub
- [ ] Update dependencies (Composer & NPM)
- [ ] Build assets (npm run build)
- [ ] Clear semua cache Laravel
- [ ] Rebuild cache untuk production
- [ ] Set permissions yang benar
- [ ] Test website

## 🆘 Jika Ada Masalah

### Rollback ke Backup
```bash
# Restore dari backup
cp -r backup_YYYYMMDD_HHMMSS/* .
```

### Cek Log Error
```bash
# Laravel log
tail -50 storage/logs/laravel.log

# Web server log
tail -50 /var/log/apache2/error.log
# atau
tail -50 /var/log/nginx/error.log
```

### Contact Support
Jika masih ada masalah, hubungi:
- **Developer**: [Your Contact]
- **Hosting Support**: [Hosting Provider]

---

**Catatan**: Ganti `/path/to/your/website` dengan path sebenarnya di server Anda.

**Commit yang perlu di-deploy**: `08eb747 - Fix navigation menu layout`