# Setup Auto-Deployment dengan GitHub Webhooks

Dokumentasi ini menjelaskan cara mengatur auto-deployment untuk project Kantor Camat Waesama menggunakan GitHub webhooks.

## 1. Persiapan Server

### Pastikan Dependencies Terinstall
```bash
# Git
git --version

# PHP
php --version

# Composer
composer --version

# Node.js & NPM
node --version
npm --version
```

### Set Permissions untuk Script
```bash
chmod +x deploy-webhook.sh
chmod 755 public/webhook.php
```

### Buat Directory Log
```bash
mkdir -p storage/logs
chmod 775 storage/logs
```

## 2. Konfigurasi GitHub Webhook

### Langkah-langkah:

1. **Buka Repository GitHub**
   - Masuk ke https://github.com/laodesumardi/web-kecamatan-waesama
   - Klik tab "Settings"

2. **Tambah Webhook**
   - Klik "Webhooks" di sidebar kiri
   - Klik "Add webhook"

3. **Konfigurasi Webhook**
   ```
   Payload URL: https://yourdomain.com/webhook.php
   Content type: application/json
   Secret: [generate secret key yang aman]
   Events: Just the push event
   Active: ✓ (checked)
   ```

4. **Generate Secret Key**
   ```bash
   # Generate random secret key
   openssl rand -hex 32
   ```

## 3. Konfigurasi Server

### Update Webhook Secret
Edit file `public/webhook.php` dan ganti:
```php
$secret = 'your-webhook-secret-key'; // Ganti dengan secret key dari GitHub
```

### Test Webhook Handler
```bash
# Test manual
curl -X POST https://yourdomain.com/webhook.php \
  -H "Content-Type: application/json" \
  -d '{"ref":"refs/heads/main","head_commit":{"id":"test"}}'
```

## 4. Konfigurasi Web Server

### Apache (.htaccess sudah ada)
Pastikan file `.htaccess` di root project memiliki:
```apache
RewriteEngine On
RewriteRule ^webhook$ public/webhook.php [L]
```

### Nginx
Tambahkan ke konfigurasi server:
```nginx
location /webhook {
    try_files $uri $uri/ /public/webhook.php?$query_string;
}
```

## 5. Testing Auto-Deployment

### Test 1: Manual Trigger
```bash
# Jalankan script deployment manual
./deploy-webhook.sh
```

### Test 2: GitHub Push
1. Buat perubahan kecil di repository
2. Commit dan push ke branch `main`
3. Cek log deployment:
   ```bash
   tail -f storage/logs/webhook.log
   tail -f storage/logs/deployment.log
   ```

### Test 3: Webhook Endpoint
```bash
# Test webhook endpoint
curl -X POST https://yourdomain.com/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-Hub-Signature-256: sha256=$(echo -n '{"ref":"refs/heads/main"}' | openssl dgst -sha256 -hmac 'your-secret-key' | cut -d' ' -f2)" \
  -d '{"ref":"refs/heads/main","head_commit":{"id":"test"}}'
```

## 6. Monitoring dan Troubleshooting

### Log Files
- **Webhook Log**: `storage/logs/webhook.log`
- **Deployment Log**: `storage/logs/deployment.log`
- **Laravel Log**: `storage/logs/laravel.log`

### Common Issues

1. **Permission Denied**
   ```bash
   chmod +x deploy-webhook.sh
   chown -R www-data:www-data storage/
   ```

2. **Git Authentication**
   ```bash
   # Setup SSH key atau personal access token
   git config --global credential.helper store
   ```

3. **Node.js/NPM Issues**
   ```bash
   # Clear npm cache
   npm cache clean --force
   rm -rf node_modules package-lock.json
   npm install
   ```

4. **Composer Issues**
   ```bash
   # Clear composer cache
   composer clear-cache
   composer install --no-dev --optimize-autoloader
   ```

### Security Considerations

1. **Gunakan HTTPS** untuk webhook URL
2. **Set Secret Key** yang kuat di GitHub webhook
3. **Limit IP Access** jika memungkinkan (GitHub webhook IPs)
4. **Monitor Logs** secara berkala
5. **Backup Database** sebelum deployment besar

## 7. Workflow Auto-Deployment

```
Developer Push → GitHub → Webhook → Server → Deployment Script
                                      ↓
                              1. Git Pull
                              2. Composer Install
                              3. NPM Install & Build
                              4. Laravel Optimize
                              5. Clear Caches
                              6. Set Permissions
```

## 8. Rollback Strategy

Jika deployment gagal:
```bash
# Rollback ke commit sebelumnya
git log --oneline -5
git reset --hard <previous-commit-hash>

# Atau restore dari stash
git stash list
git stash apply stash@{0}
```

## 9. Production Checklist

- [ ] Secret key sudah diset di webhook.php
- [ ] GitHub webhook sudah dikonfigurasi
- [ ] Script deployment sudah executable
- [ ] Directory logs sudah ada dan writable
- [ ] Web server sudah dikonfigurasi untuk webhook endpoint
- [ ] SSL certificate sudah aktif
- [ ] Backup strategy sudah ada
- [ ] Monitoring logs sudah disetup

---

**Note**: Setelah setup selesai, setiap kali ada push ke branch `main`, deployment akan berjalan otomatis tanpa perlu manual `git pull` lagi.