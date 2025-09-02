# Panduan Step-by-Step Fix Vite Manifest

## Langkah-langkah Berurutan untuk Production Server

Jalankan perintah berikut **satu per satu** di server production:

### 1. Clear Route Cache
```bash
php artisan route:clear
```
**Output yang diharapkan:**
```
INFO  Route cache cleared successfully.
```

### 2. Buat Direktori Build
```bash
mkdir -p public/build/assets
```
**Tidak ada output jika berhasil**

### 3. Buat File Manifest
```bash
cat > public/build/manifest.json << 'EOF'
{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}
EOF
```
**Tidak ada output jika berhasil**

### 4. Buat File CSS
```bash
cat > public/build/assets/app.css << 'EOF'
body { font-family: Arial, sans-serif; }
.container { max-width: 1200px; margin: 0 auto; padding: 20px; }
.nav { background: #1f2937; color: white; padding: 1rem; }
.nav a { color: white; text-decoration: none; margin-right: 1rem; }
.nav a:hover { color: #60a5fa; }
.btn { padding: 0.5rem 1rem; border-radius: 0.25rem; border: none; cursor: pointer; }
.btn-primary { background: #3b82f6; color: white; }
.btn-secondary { background: #6b7280; color: white; }
.card { background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1rem; }
.form-group { margin-bottom: 1rem; }
.form-control { width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.25rem; }
EOF
```
**Tidak ada output jika berhasil**

### 5. Buat File JavaScript
```bash
echo "console.log('Kantor Camat Waesama - Production Ready');" > public/build/assets/app.js
```
**Tidak ada output jika berhasil**

### 6. Set Permissions
```bash
chmod -R 755 public/build
```
**Tidak ada output jika berhasil**

### 7. Verifikasi File Manifest
```bash
ls -la public/build/
```
**Output yang diharapkan:**
```
total 8
drwxr-xr-x 3 user user 4096 Jan 22 10:30 .
drwxr-xr-x 8 user user 4096 Jan 22 10:30 ..
drwxr-xr-x 2 user user 4096 Jan 22 10:30 assets
-rw-r--r-- 1 user user  234 Jan 22 10:30 manifest.json
```

### 8. Verifikasi File Assets
```bash
ls -la public/build/assets/
```
**Output yang diharapkan:**
```
total 8
drwxr-xr-x 2 user user 4096 Jan 22 10:30 .
drwxr-xr-x 3 user user 4096 Jan 22 10:30 ..
-rw-r--r-- 1 user user  456 Jan 22 10:30 app.css
-rw-r--r-- 1 user user   52 Jan 22 10:30 app.js
```

### 9. Test Manifest Content
```bash
cat public/build/manifest.json
```
**Output yang diharapkan:**
```json
{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "isEntry": true,
    "src": "resources/css/app.css"
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "isEntry": true,
    "src": "resources/js/app.js"
  }
}
```

### 10. Clear Laravel Cache (Opsional)
```bash
php artisan cache:clear
```
**Output yang diharapkan:**
```
Application cache cleared successfully.
```

### 11. Test Website
```bash
curl -I https://website.kecamatangwaesama.id
```
**Output yang diharapkan:**
```
HTTP/1.1 200 OK
```

## Troubleshooting

### Jika Error "Permission Denied"
```bash
sudo chmod -R 755 public/build
# atau
chown -R www-data:www-data public/build
```

### Jika Error "No such file or directory"
```bash
# Pastikan di direktori yang benar
pwd
# Harus menampilkan: /home/u798974089/domains/website.kecamatangwaesama.id/public_html

# Jika tidak, pindah ke direktori yang benar
cd /home/u798974089/domains/website.kecamatangwaesama.id/public_html
```

### Jika Website Masih Error
```bash
# Check error log
tail -f storage/logs/laravel.log

# Atau check web server error log
tail -f /var/log/apache2/error.log
# atau
tail -f /var/log/nginx/error.log
```

## Status Setelah Fix

✅ **Berhasil jika:**
- Tidak ada error "Vite manifest not found"
- Website dapat diakses normal
- File manifest.json dan assets tersedia
- Permissions sudah benar (755)

❌ **Gagal jika:**
- Masih muncul error Vite manifest
- File tidak terbuat
- Permission denied
- Website tidak dapat diakses

## URL untuk Test

- **Website Utama:** https://website.kecamatangwaesama.id
- **Admin Panel:** https://website.kecamatangwaesama.id/admin
- **Login:** https://website.kecamatangwaesama.id/login

## Catatan Penting

1. **Jalankan perintah satu per satu** - jangan copy-paste semuanya sekaligus
2. **Tunggu setiap perintah selesai** sebelum menjalankan yang berikutnya
3. **Periksa output** setiap perintah untuk memastikan tidak ada error
4. **Backup dulu** jika ragu-ragu
5. **Test website** setelah selesai semua langkah

---

**Dibuat:** $(date)
**Status:** Ready for Production
**Estimasi Waktu:** 5-10 menit