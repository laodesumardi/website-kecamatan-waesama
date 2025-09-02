# Setup GitHub Webhook untuk Auto-Deployment

## 🎯 Tujuan
Mengatur webhook GitHub agar setiap kali ada push ke branch `main`, server otomatis mengupdate kode tanpa perlu deployment manual.

## 📋 Langkah-langkah Setup

### 1. Setup Webhook di GitHub Repository

1. **Buka Repository GitHub**
   - Masuk ke `https://github.com/[username]/kantor-camat-waesama`
   - Login dengan akun yang memiliki akses admin

2. **Navigasi ke Settings**
   - Klik tab **"Settings"** di repository
   - Scroll ke bagian **"Webhooks"** di sidebar kiri
   - Klik **"Add webhook"**

3. **Konfigurasi Webhook**
   ```
   Payload URL: https://kecamatangwaesama.id/public/webhook.php
   Content type: application/json
   Secret: KantorCamatWaesama2024!SecureKey
   
   Which events would you like to trigger this webhook?
   ☑️ Just the push event
   
   Active: ☑️ (Checked)
   ```

4. **Klik "Add webhook"**

### 2. Verifikasi Setup di Server

#### Cek File Webhook
```bash
# Pastikan file webhook ada dan executable
ls -la /path/to/website/public/webhook.php
chmod 755 /path/to/website/public/webhook.php
```

#### Cek Directory Permissions
```bash
# Pastikan directory logs bisa ditulis
chmod 755 /path/to/website/storage/logs
chown www-data:www-data /path/to/website/storage/logs
```

#### Test Webhook Endpoint
```bash
# Test apakah webhook endpoint bisa diakses
curl -X POST https://kecamatangwaesama.id/public/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-Hub-Signature-256: sha256=$(echo -n '{"ref":"refs/heads/main"}' | openssl dgst -sha256 -hmac 'KantorCamatWaesama2024!SecureKey' | cut -d' ' -f2)" \
  -d '{"ref":"refs/heads/main","head_commit":{"id":"test123"}}'
```

### 3. Test Webhook

#### Test Push ke Repository
1. **Buat perubahan kecil** di repository (misal: edit README.md)
2. **Commit dan push** ke branch main:
   ```bash
   git add .
   git commit -m "Test webhook deployment"
   git push origin main
   ```

3. **Cek log webhook** di server:
   ```bash
   tail -f /path/to/website/storage/logs/webhook.log
   ```

#### Verifikasi di GitHub
1. **Kembali ke GitHub** → Settings → Webhooks
2. **Klik webhook** yang baru dibuat
3. **Scroll ke "Recent Deliveries"**
4. **Cek status delivery** (harus ada ✅ hijau)

### 4. Monitoring dan Troubleshooting

#### Monitor Log Webhook
```bash
# Monitor real-time
tail -f /path/to/website/storage/logs/webhook.log

# Lihat log terakhir
tail -50 /path/to/website/storage/logs/webhook.log
```

#### Monitor Log Laravel
```bash
tail -f /path/to/website/storage/logs/laravel.log
```

#### Common Issues

**1. Webhook tidak terpanggil**
- Cek URL webhook di GitHub settings
- Pastikan server bisa diakses dari internet
- Cek firewall settings

**2. Permission Denied**
```bash
chmod 755 /path/to/website/public/webhook.php
chown www-data:www-data /path/to/website/storage/logs
```

**3. Git Permission Issues**
```bash
# Set git config di server
git config --global user.name "Server Deploy"
git config --global user.email "deploy@kecamatangwaesama.id"

# Fix ownership
chown -R www-data:www-data /path/to/website
```

**4. Composer/NPM Not Found**
```bash
# Add to PATH atau install
export PATH="$PATH:/usr/local/bin"
```

### 5. Security Considerations

#### Secret Key
- ✅ **Sudah diset**: `KantorCamatWaesama2024!SecureKey`
- 🔒 **Jangan share** secret key ini di tempat publik
- 🔄 **Ganti berkala** untuk keamanan

#### File Permissions
```bash
# Webhook file
chmod 755 webhook.php

# Storage directory
chmod 755 storage/logs

# Project directory
chmod 755 /path/to/website
```

### 6. Backup Strategy

#### Auto Backup Before Deploy
Webhook sudah include backup otomatis:
```php
// Backup dibuat dengan format: backup_YYYYMMDD_HHMMSS
$backupDir = "backup_" . date('Ymd_His');
```

#### Manual Backup
```bash
# Backup manual sebelum setup
cp -r /path/to/website /path/to/backup/website_$(date +%Y%m%d)
```

## ✅ Checklist Setup

- [ ] Webhook dibuat di GitHub repository
- [ ] URL webhook: `https://kecamatangwaesama.id/public/webhook.php`
- [ ] Secret key diset: `KantorCamatWaesama2024!SecureKey`
- [ ] File webhook.php ada di server
- [ ] Permissions diset dengan benar
- [ ] Test webhook berhasil
- [ ] Log monitoring berjalan
- [ ] Backup strategy aktif

## 🎉 Hasil

Setelah setup selesai:
1. **Setiap push ke main branch** → Server otomatis update
2. **No manual deployment** diperlukan
3. **Backup otomatis** sebelum setiap deployment
4. **Log monitoring** untuk troubleshooting

---

**Catatan**: Ganti `/path/to/website` dengan path sebenarnya di server Anda.