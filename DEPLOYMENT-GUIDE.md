# 🚀 Panduan Deployment Production
## Kantor Camat Waesama - Memastikan Tampilan Online Sama dengan Lokal

### 📋 Daftar Isi
1. [Persiapan Sebelum Deployment](#persiapan-sebelum-deployment)
2. [Menjalankan Script Deployment](#menjalankan-script-deployment)
3. [Upload ke Hosting Provider](#upload-ke-hosting-provider)
4. [Konfigurasi Server](#konfigurasi-server)
5. [Verifikasi Tampilan](#verifikasi-tampilan)
6. [Troubleshooting](#troubleshooting)

---

## 🔧 Persiapan Sebelum Deployment

### 1. Pastikan Environment Lokal Berjalan dengan Baik
```bash
# Test aplikasi lokal
php artisan serve
```
- Buka http://127.0.0.1:8000
- Pastikan semua tampilan sudah sesuai
- Test responsive design di berbagai ukuran layar

### 2. Backup Data Penting
- Database lokal
- File konfigurasi
- File upload/storage

### 3. Update Konfigurasi Production
Edit file `.env.production` dengan data hosting Anda:
```env
APP_URL=https://your-actual-domain.com
DB_HOST=localhost
DB_DATABASE=your_actual_database_name
DB_USERNAME=your_actual_db_username
DB_PASSWORD=your_actual_db_password
```

---

## 🚀 Menjalankan Script Deployment

### Untuk Windows (PowerShell)
```powershell
# Buka PowerShell sebagai Administrator
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser

# Jalankan script deployment
.\deploy-production.ps1
```

### Untuk Linux/Mac (Bash)
```bash
# Berikan permission execute
chmod +x deploy-production.sh

# Jalankan script
./deploy-production.sh
```

### Apa yang Dilakukan Script:
1. ✅ Copy konfigurasi production
2. ✅ Install dependencies untuk production
3. ✅ Build assets (CSS/JS) untuk production
4. ✅ Optimize Laravel untuk production
5. ✅ Clear dan cache konfigurasi
6. ✅ Verifikasi semua file asset
7. ✅ Buat package deployment

---

## 📤 Upload ke Hosting Provider

### File yang Harus Di-upload
Setelah menjalankan script, upload folder `deployment-package-[timestamp]` ke hosting:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── build/          # ⚠️ PENTING: Asset Vite
│   ├── css/
│   │   ├── mobile-fix.css
│   │   └── form-fixes.css
│   ├── js/
│   │   └── mobile-responsive.js
│   └── ...
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env               # Dari .env.production
├── artisan
└── ...
```

### ⚠️ File Penting untuk Tampilan Konsisten
- `public/build/` - Asset Vite (CSS/JS yang sudah di-compile)
- `public/css/mobile-fix.css` - Perbaikan tampilan mobile
- `public/css/form-fixes.css` - Perbaikan styling form
- `public/js/mobile-responsive.js` - JavaScript untuk responsivitas

---

## ⚙️ Konfigurasi Server

### 1. Web Server Configuration

#### Apache (.htaccess)
Pastikan file `public/.htaccess` ada:
```apache
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
```

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 2. PHP Configuration
Pastikan PHP settings sesuai:
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

### 3. Database Setup
1. Buat database baru di hosting
2. Import database dari lokal
3. Update kredensial di `.env`

---

## ✅ Verifikasi Tampilan

### 1. Test Halaman Utama
- [ ] Homepage loading dengan benar
- [ ] CSS dan JavaScript ter-load
- [ ] Tidak ada error 404 untuk asset

### 2. Test Responsive Design
- [ ] Mobile (320px - 768px)
- [ ] Tablet (768px - 1024px)
- [ ] Desktop (1024px+)

### 3. Test Browser Compatibility
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

### 4. Test Functionality
- [ ] Login/Logout
- [ ] Form submission
- [ ] File upload
- [ ] Navigation

### 5. Performance Check
```bash
# Test loading speed
curl -w "@curl-format.txt" -o /dev/null -s "https://your-domain.com"
```

---

## 🔍 Troubleshooting

### Masalah Umum dan Solusi

#### 1. CSS/JS Tidak Loading
**Gejala:** Tampilan berantakan, tidak ada styling
**Solusi:**
```bash
# Di server, jalankan:
php artisan storage:link
php artisan view:clear
php artisan config:clear
```

#### 2. Error 500 Internal Server Error
**Solusi:**
1. Check error log server
2. Pastikan permission folder:
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```
3. Generate app key:
   ```bash
   php artisan key:generate
   ```

#### 3. Asset 404 Not Found
**Solusi:**
1. Pastikan folder `public/build/` ter-upload
2. Check file `public/build/manifest.json`
3. Rebuild assets:
   ```bash
   npm run build
   ```

#### 4. Database Connection Error
**Solusi:**
1. Verifikasi kredensial database di `.env`
2. Test koneksi database
3. Pastikan database sudah dibuat

#### 5. Mobile Tampilan Tidak Responsif
**Solusi:**
1. Pastikan file `mobile-fix.css` ter-upload
2. Pastikan file `mobile-responsive.js` ter-upload
3. Check viewport meta tag di layout

---

## 📱 Checklist Final

### Sebelum Go-Live
- [ ] Backup database production
- [ ] Test semua fitur
- [ ] Test responsive di device nyata
- [ ] Setup monitoring
- [ ] Setup SSL certificate
- [ ] Test performance

### Setelah Go-Live
- [ ] Monitor error logs
- [ ] Test user feedback
- [ ] Monitor server resources
- [ ] Setup automated backups

---

## 📞 Support

Jika mengalami masalah:
1. Check error logs di hosting panel
2. Verifikasi semua file ter-upload dengan benar
3. Test di browser incognito/private
4. Clear browser cache

**File Log Penting:**
- `storage/logs/laravel.log`
- Server error logs (cPanel/hosting panel)
- Browser developer console

---

## 🎯 Tips untuk Konsistensi Tampilan

1. **Selalu test di multiple devices**
2. **Gunakan same browser untuk development dan testing**
3. **Monitor Core Web Vitals**
4. **Setup staging environment**
5. **Automated testing untuk UI**

---

*Panduan ini memastikan tampilan aplikasi Kantor Camat Waesama di production akan sama persis dengan development environment.*