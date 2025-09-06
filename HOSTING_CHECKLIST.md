# Checklist Deployment Hosting - Kantor Camat Waesama

## Pre-Deployment Checklist

### 1. Persiapan File
- [ ] Upload semua file aplikasi ke hosting
- [ ] Pastikan struktur folder benar
- [ ] File `.env` belum ada (akan dibuat dari template)
- [ ] File `.htaccess` ada di root dan public/

### 2. Persyaratan Server
- [ ] PHP 8.2 atau lebih tinggi
- [ ] MySQL 5.7 atau lebih tinggi  
- [ ] Composer terinstall
- [ ] Apache/Nginx dengan mod_rewrite enabled
- [ ] Ekstensi PHP: pdo, mysql, mbstring, openssl, tokenizer, xml, ctype, json, bcmath, fileinfo

## Deployment Steps

### Step 1: Environment Configuration
- [ ] Copy `.env.hosting` ke `.env` atau gunakan `.env.example`
- [ ] Edit konfigurasi database di `.env`:
  ```
  DB_HOST=localhost
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  ```
- [ ] Update `APP_URL` dengan domain yang benar
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate `APP_KEY`: `php artisan key:generate --force`

### Step 2: Dependencies & Permissions
- [ ] Install dependencies: `composer install --optimize-autoloader --no-dev`
- [ ] Set file permissions:
  ```bash
  chmod -R 755 storage/
  chmod -R 755 bootstrap/cache/
  chmod 644 .env
  ```

### Step 3: Database Setup
- [ ] Buat database di hosting panel
- [ ] Test koneksi database: `php artisan migrate:status`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed data (opsional): `php artisan db:seed --force`

### Step 4: Cache & Optimization
- [ ] Clear semua cache:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```
- [ ] Clear session files manual (hapus isi `storage/framework/sessions/`)
- [ ] Build cache untuk production:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- [ ] Optimize autoloader: `composer dump-autoload --optimize`

### Step 5: Web Server Configuration
- [ ] **PENTING**: DocumentRoot harus mengarah ke folder `public/`
- [ ] File `.htaccess` ada dan benar di folder `public/`
- [ ] Test akses website

## Post-Deployment Testing

### Functional Testing
- [ ] Halaman utama dapat diakses
- [ ] Login/logout berfungsi
- [ ] Form submission tidak error 419
- [ ] Upload file berfungsi
- [ ] Database operations berfungsi
- [ ] Email notifications berfungsi (jika dikonfigurasi)

### Security Testing
- [ ] HTTPS aktif (jika SSL tersedia)
- [ ] File sensitif tidak dapat diakses:
  - [ ] `.env` tidak dapat diakses dari browser
  - [ ] `storage/` tidak dapat diakses
  - [ ] `vendor/` tidak dapat diakses
  - [ ] `config/` tidak dapat diakses

### Performance Testing
- [ ] Website loading cepat
- [ ] Cache berfungsi dengan baik
- [ ] No memory limit errors
- [ ] Database queries optimal

## Troubleshooting Common Issues

### Error 419 - Page Expired
**Solusi:**
1. Clear cache dan session
2. Periksa `APP_URL` di `.env`
3. Set `SESSION_DOMAIN` jika menggunakan subdomain
4. Pastikan `SESSION_SECURE_COOKIE=true` untuk HTTPS

### Error 500 - Internal Server Error
**Diagnosis:**
1. Periksa `storage/logs/laravel.log`
2. Periksa error log hosting
3. Pastikan file permissions benar
4. Pastikan `APP_KEY` ter-generate
5. Test database connection

### Database Connection Error
**Solusi:**
1. Periksa credentials di `.env`
2. Pastikan database sudah dibuat
3. Test koneksi manual
4. Periksa host database (biasanya `localhost`)

### File Permission Error
**Solusi:**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data . # atau user web server
```

### Route Not Found (404)
**Solusi:**
1. Pastikan DocumentRoot mengarah ke `public/`
2. Pastikan mod_rewrite enabled
3. Periksa file `.htaccess` di `public/`
4. Clear route cache: `php artisan route:clear`

## Quick Fix Scripts

### Gunakan Script Otomatis
**Windows PowerShell:**
```powershell
.\fix-hosting-issues.ps1
```

**Linux/Unix:**
```bash
chmod +x deploy-hosting.sh
./deploy-hosting.sh
```

## Security Hardening

### Production Security
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Gunakan HTTPS
- [ ] Set secure headers di `.htaccess`
- [ ] Regular backup database
- [ ] Update dependencies secara berkala
- [ ] Monitor log files

### File Protection
- [ ] Protect `.env` file
- [ ] Protect `storage/` directory
- [ ] Protect `vendor/` directory
- [ ] Protect sensitive config files

## Monitoring & Maintenance

### Regular Tasks
- [ ] Monitor disk space
- [ ] Monitor database size
- [ ] Check error logs weekly
- [ ] Update dependencies monthly
- [ ] Backup database weekly
- [ ] Test website functionality monthly

### Performance Monitoring
- [ ] Monitor page load times
- [ ] Monitor database query performance
- [ ] Monitor memory usage
- [ ] Monitor cache hit rates

## Emergency Procedures

### Website Down
1. Check hosting status
2. Check error logs
3. Verify database connection
4. Check file permissions
5. Contact hosting support if needed

### Data Recovery
1. Restore from latest backup
2. Check database integrity
3. Verify file integrity
4. Test all functionality

## Contact Information

**Development Team:**
- Email: dev@waesama.go.id
- Phone: +62-xxx-xxx-xxxx

**Hosting Support:**
- Provider: [Hosting Provider Name]
- Support: [Support Contact]
- Control Panel: [Panel URL]

---

**Last Updated:** $(Get-Date -Format 'yyyy-MM-dd')
**Version:** 1.0