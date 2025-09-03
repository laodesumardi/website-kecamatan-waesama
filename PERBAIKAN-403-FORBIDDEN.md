# Panduan Perbaikan Error 403 Forbidden

## Masalah
Situs `https://kecamatangwaesama.id/` menampilkan error **403 Forbidden** yang berarti server menolak akses ke resource yang diminta.

## Kemungkinan Penyebab dan Solusi

### 1. File Index Tidak Ditemukan
**Penyebab:** Tidak ada file `index.php` atau `index.html` di root directory `public_html`

**Solusi:**
- Pastikan file `index.php` ada di folder `public_html`
- Jika menggunakan struktur Laravel, upload `index-root.php` dan rename menjadi `index.php`
- Atau buat file `index.html` sederhana sebagai landing page

### 2. Permission File/Folder Salah
**Penyebab:** File permission tidak sesuai dengan requirement server

**Solusi melalui cPanel File Manager:**
```
Folder permissions: 755 (drwxr-xr-x)
File permissions: 644 (-rw-r--r--)
```

**Solusi melalui SSH/Terminal:**
```bash
# Set permission untuk folder
find /path/to/public_html -type d -exec chmod 755 {} \;

# Set permission untuk file
find /path/to/public_html -type f -exec chmod 644 {} \;

# Set permission khusus untuk file executable
chmod 755 /path/to/public_html/index.php
```

### 3. Konfigurasi .htaccess Bermasalah
**Penyebab:** File `.htaccess` memblokir akses atau memiliki konfigurasi yang salah

**Solusi:**
1. **Backup dan hapus sementara `.htaccess`:**
   ```bash
   mv .htaccess .htaccess.backup
   ```

2. **Jika situs bisa diakses, buat `.htaccess` baru:**
   ```apache
   # Basic Laravel .htaccess
   <IfModule mod_rewrite.c>
       RewriteEngine On
       
       # Handle Angular routes
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_URI} !^/api/
       RewriteRule ^(.*)$ /index.php [QSA,L]
   </IfModule>
   
   # Security headers
   <IfModule mod_headers.c>
       Header always set X-Content-Type-Options nosniff
       Header always set X-Frame-Options DENY
       Header always set X-XSS-Protection "1; mode=block"
   </IfModule>
   
   # Prevent access to sensitive files
   <Files ".env">
       Order allow,deny
       Deny from all
   </Files>
   ```

### 4. Struktur Directory Salah
**Penyebab:** File aplikasi tidak berada di lokasi yang benar

**Solusi untuk hosting shared:**
```
public_html/
├── index.php (dari index-root.php)
├── .htaccess
├── css/
├── js/
├── favicon.svg
├── robots.txt
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
└── vendor/
```

### 5. Konfigurasi Server/Hosting
**Penyebab:** Konfigurasi server tidak mendukung PHP atau Laravel

**Solusi:**
1. **Pastikan PHP aktif:**
   - Buat file `info.php` dengan konten: `<?php phpinfo(); ?>`
   - Akses `https://kecamatangwaesama.id/info.php`
   - Jika tidak bisa diakses, hubungi hosting provider

2. **Periksa versi PHP:**
   - Laravel membutuhkan PHP 8.1 atau lebih tinggi
   - Ubah versi PHP melalui cPanel atau hubungi hosting

3. **Periksa ekstensi PHP yang diperlukan:**
   ```
   - BCMath
   - Ctype
   - Fileinfo
   - JSON
   - Mbstring
   - OpenSSL
   - PDO
   - Tokenizer
   - XML
   ```

### 6. File .env Tidak Ada atau Salah
**Penyebab:** File konfigurasi environment tidak ada atau tidak valid

**Solusi:**
1. **Upload file `.env` ke root directory**
2. **Pastikan konfigurasi database benar:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://kecamatangwaesama.id
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username_db
   DB_PASSWORD=password_db
   ```

## Langkah Troubleshooting Sistematis

### Step 1: Periksa File Index
```bash
# Masuk ke cPanel File Manager atau SSH
ls -la public_html/

# Pastikan ada file index.php atau index.html
```

### Step 2: Periksa Permission
```bash
# Lihat permission file dan folder
ls -la public_html/

# Perbaiki jika diperlukan
chmod 755 public_html/
chmod 644 public_html/index.php
```

### Step 3: Test Tanpa .htaccess
```bash
# Backup .htaccess
mv public_html/.htaccess public_html/.htaccess.backup

# Test akses situs
# Jika bisa diakses, masalah di .htaccess
```

### Step 4: Periksa Log Error
```bash
# Lihat error log hosting
tail -f /path/to/error.log

# Atau melalui cPanel Error Logs
```

### Step 5: Test PHP
```php
<?php
// Buat file test.php
echo "PHP berjalan dengan baik!";
echo "<br>Versi PHP: " . phpversion();
?>
```

## Solusi Cepat untuk Deploy

### Opsi 1: Upload Manual
1. Gunakan skrip `prepare-manual-upload.ps1`
2. Upload semua file ke `public_html`
3. Rename `index-root.php` menjadi `index.php`
4. Set permission yang benar

### Opsi 2: Deploy via Git
```bash
# Clone repository
git clone https://github.com/username/kantor-camat-waesama.git

# Copy file ke public_html
cp -r kantor-camat-waesama/* public_html/

# Install dependencies
cd public_html
composer install --no-dev --optimize-autoloader

# Set permission
chmod -R 755 storage bootstrap/cache
```

## Kontak Support
Jika masalah masih berlanjut setelah mengikuti panduan ini:
1. Hubungi hosting provider (Hostinger, dll)
2. Berikan informasi error log yang spesifik
3. Minta bantuan konfigurasi PHP dan Apache/Nginx

## Catatan Penting
- Selalu backup file sebelum melakukan perubahan
- Test setiap perubahan secara bertahap
- Simpan log error untuk referensi
- Dokumentasikan solusi yang berhasil untuk referensi masa depan