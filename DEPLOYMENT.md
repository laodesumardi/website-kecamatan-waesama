# Panduan Deployment Kantor Camat Waesama

## Cara Deploy ke Production Server via PuTTY

### Prasyarat
1. Akses SSH ke server production
2. PuTTY sudah terinstall dan terkonfigurasi
3. Repository sudah di-clone di server production

### Langkah-langkah Deployment

#### 1. Koneksi ke Server via PuTTY
```bash
# Buka PuTTY dan koneksi ke server
# Host: wb.kecamatangwaesama.id atau IP server
# Port: 22 (default SSH)
# Username: sesuai dengan akun hosting
```

#### 2. Navigasi ke Directory Website
```bash
cd /home/u798974089/domains/wb.kecamatangwaesama.id/public_html
```

#### 3. Jalankan Script Deployment
```bash
# Berikan permission execute pada script
chmod +x deploy.sh

# Jalankan script deployment
./deploy.sh
```

#### 4. Konfigurasi Manual (Jika Diperlukan)

##### Setup Database di .env
```bash
nano .env
```

Tambahkan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u798974089_kantor_camat
DB_USERNAME=u798974089_admin
DB_PASSWORD=your_database_password
```

##### Generate Application Key (Manual)
```bash
php artisan key:generate --force
```

##### Set File Permissions (Manual)
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

##### Run Migrations (Manual)
```bash
php artisan migrate --force
php artisan db:seed --force
```

##### Clear Cache (Manual)
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Troubleshooting HTTP 500 Error

#### 1. Cek Error Log
```bash
tail -f storage/logs/laravel.log
```

#### 2. Cek File Permissions
```bash
ls -la storage/
ls -la bootstrap/cache/
```

#### 3. Cek Konfigurasi .env
```bash
cat .env | grep -E "APP_KEY|DB_|APP_URL"
```

#### 4. Test Artisan Commands
```bash
php artisan about
php artisan config:show
```

#### 5. Cek Web Server Configuration
- Pastikan Document Root mengarah ke folder `public`
- Pastikan file `.htaccess` ada di folder `public`
- Pastikan PHP version minimal 8.1

### Deployment Otomatis via Git Hook (Opsional)

Untuk deployment otomatis setiap kali push ke GitHub:

```bash
# Buat git hook
nano .git/hooks/post-receive
```

Isi file:
```bash
#!/bin/bash
cd /home/u798974089/domains/wb.kecamatangwaesama.id/public_html
git --git-dir=.git --work-tree=. checkout -f
./deploy.sh
```

Berikan permission:
```bash
chmod +x .git/hooks/post-receive
```

### Monitoring dan Maintenance

#### Cek Status Website
```bash
curl -I https://wb.kecamatangwaesama.id
```

#### Monitor Log Real-time
```bash
tail -f storage/logs/laravel.log
```

#### Backup Database
```bash
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
```

### Kontak Support

Jika mengalami masalah deployment:
1. Cek error log terlebih dahulu
2. Pastikan semua langkah sudah dijalankan
3. Hubungi administrator server jika diperlukan

---

**Catatan:** Ganti `u798974089` dengan username hosting yang sesuai.