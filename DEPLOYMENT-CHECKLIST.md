# 📋 DEPLOYMENT CHECKLIST - HOSTINGER
## Kantor Camat Waesama - Laravel Application

### 🔧 PERSIAPAN LOKAL (Sudah Selesai)
- [x] **Build Assets Production**: `npm run build`
- [x] **Cache Konfigurasi**: `php artisan config:cache`
- [x] **Cache Routes**: `php artisan route:cache`
- [x] **Cache Views**: `php artisan view:cache`
- [x] **Optimize Autoloader**: `composer dump-autoload --optimize`
- [x] **Buat File .htaccess Production**
- [x] **Buat Deployment Script**

### 📦 BACKUP & UPLOAD
- [ ] **Backup Database Hostinger**
  ```sql
  -- Login ke phpMyAdmin Hostinger
  -- Export database yang sudah ada
  -- Simpan file backup dengan nama: backup_YYYY-MM-DD.sql
  ```

- [ ] **Backup File Lama**
  ```bash
  # Di File Manager Hostinger
  # Rename folder public_html menjadi public_html_backup_YYYY-MM-DD
  # Atau download semua file sebagai backup
  ```

- [ ] **Upload File Baru**
  - [ ] Extract `deployment-package.zip` ke folder lokal
  - [ ] Upload semua file ke `public_html` via File Manager atau FTP
  - [ ] Pastikan struktur folder benar:
    ```
    public_html/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .htaccess
    ├── artisan
    ├── composer.json
    └── index.php
    ```

### 🗄️ KONFIGURASI DATABASE
- [ ] **Buat Database Baru** (jika diperlukan)
  - Database Name: `u123456789_kantorcamat`
  - Username: `u123456789_admin`
  - Password: `[password_kuat]`

- [ ] **Import Database**
  ```sql
  -- Via phpMyAdmin:
  -- 1. Pilih database
  -- 2. Tab "Import"
  -- 3. Upload file database.sql
  -- 4. Klik "Go"
  ```

### ⚙️ KONFIGURASI ENVIRONMENT
- [ ] **Setup File .env**
  ```bash
  # Copy .env.production ke .env
  # Edit konfigurasi berikut:
  ```
  
  ```env
  APP_NAME="Kantor Camat Waesama"
  APP_ENV=production
  APP_KEY=base64:[GENERATE_NEW_KEY]
  APP_DEBUG=false
  APP_URL=https://yourdomain.com
  
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_PORT=3306
  DB_DATABASE=u123456789_kantorcamat
  DB_USERNAME=u123456789_admin
  DB_PASSWORD=[your_db_password]
  
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.hostinger.com
  MAIL_PORT=587
  MAIL_USERNAME=[your_email]
  MAIL_PASSWORD=[your_email_password]
  MAIL_ENCRYPTION=tls
  MAIL_FROM_ADDRESS=[your_email]
  MAIL_FROM_NAME="Kantor Camat Waesama"
  ```

### 🔐 GENERATE APPLICATION KEY
- [ ] **Generate Key via Terminal/SSH**
  ```bash
  cd public_html
  php artisan key:generate
  ```
  
- [ ] **Atau Generate Manual**
  ```bash
  # Jalankan di lokal:
  php artisan key:generate --show
  # Copy key ke .env di server
  ```

### 📁 PENGATURAN PERMISSIONS
- [ ] **Set Folder Permissions**
  ```bash
  # Via File Manager atau SSH:
  chmod 755 public_html
  chmod -R 755 storage
  chmod -R 755 bootstrap/cache
  chmod 644 .env
  chmod 644 .htaccess
  ```

### 🔄 MIGRASI & SEEDING
- [ ] **Jalankan Migrasi**
  ```bash
  php artisan migrate --force
  ```

- [ ] **Jalankan Seeder** (jika diperlukan)
  ```bash
  php artisan db:seed --force
  ```

### 🧹 CLEAR CACHE
- [ ] **Clear All Cache**
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

- [ ] **Re-cache untuk Production**
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

### 🔗 STORAGE LINK
- [ ] **Create Storage Link**
  ```bash
  php artisan storage:link
  ```

### 🌐 KONFIGURASI SERVER
- [ ] **Set Document Root**
  - Login ke hPanel Hostinger
  - Website → Manage → Advanced → Document Root
  - Set ke: `public_html/public`

- [ ] **Set PHP Version**
  - Pilih PHP 8.1 atau 8.2
  - Enable extensions: mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath, fileinfo

- [ ] **Verify .htaccess**
  - Pastikan file `.htaccess` ada di folder `public`
  - Copy dari `.htaccess.production` jika diperlukan

### 🧪 TESTING
- [ ] **Test Homepage**
  - Buka: `https://yourdomain.com`
  - Pastikan halaman loading dengan benar

- [ ] **Test Login Admin**
  - Buka: `https://yourdomain.com/admin/login`
  - Login dengan kredensial admin
  - Test navigasi dashboard

- [ ] **Test Fitur Utama**
  - [ ] Registrasi user baru
  - [ ] Login user
  - [ ] Upload dokumen
  - [ ] Sistem antrian
  - [ ] Pengaduan masyarakat

- [ ] **Test Responsivitas**
  - [ ] Desktop view
  - [ ] Tablet view
  - [ ] Mobile view

### 🔍 TROUBLESHOOTING

#### ❌ Error 500 - Internal Server Error
```bash
# Check error logs:
tail -f storage/logs/laravel.log

# Common fixes:
php artisan key:generate
php artisan config:cache
chmod -R 755 storage bootstrap/cache
```

#### ❌ Database Connection Error
```bash
# Verify .env database settings
# Test connection:
php artisan tinker
>>> DB::connection()->getPdo();
```

#### ❌ Assets Not Loading
```bash
# Check public folder structure
# Verify .htaccess in public folder
# Check file permissions
```

#### ❌ Storage Link Issues
```bash
# Remove existing link:
rm public/storage

# Recreate link:
php artisan storage:link
```

### 📞 SUPPORT CONTACTS
- **Hostinger Support**: https://www.hostinger.com/contact
- **Laravel Documentation**: https://laravel.com/docs
- **Project Repository**: [Your Git Repository]

### ✅ POST-DEPLOYMENT
- [ ] **Update DNS** (jika domain baru)
- [ ] **Setup SSL Certificate** (Let's Encrypt via hPanel)
- [ ] **Configure Email** (SMTP settings)
- [ ] **Setup Backup Schedule**
- [ ] **Monitor Error Logs**
- [ ] **Performance Testing**

---

## 🚀 QUICK DEPLOYMENT COMMANDS

### Via SSH (jika tersedia):
```bash
# Navigate to project
cd public_html

# Generate key
php artisan key:generate

# Set permissions
chmod -R 755 storage bootstrap/cache

# Run migrations
php artisan migrate --force

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link
```

### Via File Manager:
1. Upload files via ZIP
2. Extract in public_html
3. Edit .env file
4. Set folder permissions
5. Run PHP commands via terminal (jika tersedia)

---

**📝 Catatan**: Checklist ini dibuat khusus untuk deployment Laravel ke Hostinger. Sesuaikan dengan kebutuhan spesifik project Anda.