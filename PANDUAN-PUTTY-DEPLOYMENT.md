# PANDUAN DEPLOYMENT MELALUI PUTTY

## Kantor Camat Waesama - Perbaikan Error 403 Forbidden

### 🎯 TUJUAN
Memperbaiki error 403 Forbidden pada situs https://kecamatangwaesama.id/ agar dapat diakses langsung tanpa `/public/`

---

## 📋 PERSIAPAN

### 1. Yang Dibutuhkan:
- Akses PuTTY ke server hosting
- Username dan password hosting
- File `fix-403-putty.sh` (sudah disediakan)

### 2. Informasi Server:
- **Domain:** https://kecamatangwaesama.id/
- **Status saat ini:** Error 403 Forbidden
- **Target:** Akses langsung ke domain utama

---

## 🚀 LANGKAH-LANGKAH DEPLOYMENT

### STEP 1: Koneksi ke Server

1. **Buka PuTTY**
2. **Masukkan informasi server:**
   ```
   Host Name: [IP server atau hostname]
   Port: 22
   Connection Type: SSH
   ```
3. **Klik "Open"**
4. **Login dengan credentials hosting**

### STEP 2: Upload Script Perbaikan

**Opsi A: Copy-Paste Manual**
```bash
# Masuk ke direktori website
cd ~/public_html
# atau
cd /var/www/html
# atau
cd ~/htdocs

# Buat file script
nano fix-403-putty.sh
```

Kemudian copy-paste isi file `fix-403-putty.sh` dan simpan dengan `Ctrl+X`, `Y`, `Enter`

**Opsi B: Download dari GitHub (jika tersedia)**
```bash
wget https://raw.githubusercontent.com/[username]/[repo]/main/fix-403-putty.sh
# atau
curl -O https://raw.githubusercontent.com/[username]/[repo]/main/fix-403-putty.sh
```

### STEP 3: Jalankan Script Perbaikan

```bash
# Berikan permission execute
chmod +x fix-403-putty.sh

# Jalankan script
./fix-403-putty.sh
```

### STEP 4: Verifikasi Hasil

1. **Test akses website:**
   ```bash
   curl -I https://kecamatangwaesama.id/
   ```

2. **Test file debug:**
   ```bash
   curl -I https://kecamatangwaesama.id/test-debug.php
   ```

3. **Buka di browser:**
   - https://kecamatangwaesama.id/test-debug.php
   - https://kecamatangwaesama.id/

---

## 🔧 TROUBLESHOOTING

### Jika Script Gagal Dijalankan:

```bash
# Periksa permission
ls -la fix-403-putty.sh

# Pastikan executable
chmod 755 fix-403-putty.sh

# Jalankan dengan bash
bash fix-403-putty.sh
```

### Jika Masih Error 403:

1. **Periksa ownership file:**
   ```bash
   # Ganti [username] dengan username hosting
   chown -R [username]:[username] .
   ```

2. **Periksa permission manual:**
   ```bash
   find . -type d -exec chmod 755 {} \;
   find . -type f -exec chmod 644 {} \;
   ```

3. **Periksa log error:**
   ```bash
   tail -f ~/logs/error.log
   # atau
   tail -f /var/log/apache2/error.log
   ```

### Jika Error 500 (Internal Server Error):

1. **Periksa file .env:**
   ```bash
   cat .env
   ```

2. **Test konfigurasi database:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

---

## 📝 MANUAL DEPLOYMENT (Jika Script Gagal)

### 1. Perbaiki Permission:
```bash
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 755 storage/ -R
chmod 755 bootstrap/cache/ -R
```

### 2. Buat/Perbaiki index.php:
```bash
cp index-root.php index.php
# atau jika tidak ada
cp public/index.php index.php
```

### 3. Buat .htaccess:
```bash
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
EOF
```

### 4. Periksa .env:
```bash
cp .env.example .env
nano .env
```

---

## ✅ CHECKLIST VERIFIKASI

- [ ] Script berhasil dijalankan tanpa error
- [ ] File index.php ada di root direktori
- [ ] File .htaccess dibuat dengan benar
- [ ] File .env ada dan terkonfigurasi
- [ ] Permission file dan folder sudah benar
- [ ] https://kecamatangwaesama.id/test-debug.php dapat diakses
- [ ] https://kecamatangwaesama.id/ dapat diakses (tidak 403)
- [ ] Website berfungsi normal

---

## 🆘 BANTUAN DARURAT

### Jika Semua Gagal:

1. **Restore backup:**
   ```bash
   # Masuk ke folder backup yang dibuat script
   cd backup_[timestamp]
   cp * ../
   ```

2. **Hubungi hosting provider:**
   - Minta bantuan konfigurasi document root
   - Minta bantuan permission file
   - Minta bantuan troubleshooting 403

3. **Alternative: Gunakan subdomain:**
   - Buat subdomain yang mengarah ke folder `public`
   - Contoh: `app.kecamatangwaesama.id` → `/public_html/public`

---

## 📞 KONTAK SUPPORT

- **Developer:** [Nama Developer]
- **Email:** [email@domain.com]
- **GitHub:** [repository URL]

---

## 📚 REFERENSI

- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- [Shared Hosting Laravel Setup](https://laravel.com/docs/deployment#shared-hosting)
- [Apache .htaccess Guide](https://httpd.apache.org/docs/current/howto/htaccess.html)

---

**© 2024 Kantor Camat Waesama - Deployment Guide**