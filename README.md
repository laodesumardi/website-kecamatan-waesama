# Sistem Informasi Kantor Camat Waesama

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

Sistem Informasi Kantor Camat Waesama adalah aplikasi web yang dirancang untuk memudahkan pelayanan administrasi kecamatan dan meningkatkan transparansi pelayanan publik.

## 🚀 Fitur Utama

### 👥 Multi-Role System
- **Admin**: Manajemen penuh sistem
- **Pegawai**: Pengelolaan surat dan layanan
- **Warga**: Akses layanan publik

### 📋 Modul Layanan
- **Manajemen Surat**: Pembuatan dan tracking surat-menyurat
- **Antrian Online**: Sistem antrian digital untuk pelayanan
- **Berita & Pengumuman**: Publikasi informasi terkini
- **Pengaduan Masyarakat**: Platform aspirasi dan keluhan
- **Manajemen Penduduk**: Database kependudukan

### 🔔 Fitur Tambahan
- Real-time notifications
- Responsive design untuk mobile
- Search & filter functionality
- PDF generation untuk dokumen
- Dashboard analytics

## 🛠️ Teknologi

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **JavaScript**: Vanilla JS + AJAX
- **Icons**: Font Awesome
- **PDF**: DomPDF

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0
- Apache/Nginx web server

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/your-username/kantor-camat-waesama.git
cd kantor-camat-waesama
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantor_camat_waesama
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 6. Build Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Start Development Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 🔐 Default Login

### Admin
- Email: `admin@waesama.go.id`
- Password: `password`

### Pegawai
- Email: `pegawai@waesama.go.id`
- Password: `password`

### Warga
- Email: `warga@example.com`
- Password: `password`

## 🌐 Deployment

### Shared Hosting
1. Upload semua file ke public_html
2. Pindahkan isi folder `public` ke root public_html
3. Update path di `index.php`
4. Copy `.env.production` ke `.env`
5. Update konfigurasi database
6. Run: `php artisan key:generate`
7. Run: `php artisan migrate --force`
8. Run: `php artisan config:cache`
9. Run: `php artisan route:cache`
10. Run: `php artisan view:cache`

### VPS/Dedicated Server
1. Clone repository
2. Install dependencies
3. Setup web server (Apache/Nginx)
4. Configure SSL certificate
5. Setup database
6. Run deployment commands

## 📁 Project Structure

```
kantor-camat-waesama/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Pegawai/        # Pegawai controllers
│   │   ├── Warga/          # Warga controllers
│   │   └── PublicController.php
│   ├── Models/             # Eloquent models
│   └── Helpers/            # Helper classes
├── resources/views/
│   ├── admin/              # Admin views
│   ├── pegawai/            # Pegawai views
│   ├── warga/              # Warga views
│   ├── public/             # Public views
│   └── layouts/            # Layout templates
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
└── public/
    ├── js/                 # JavaScript files
    └── build/              # Built assets
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat [issue](https://github.com/your-username/kantor-camat-waesama/issues) atau hubungi tim development.

---

**Kantor Camat Waesama** - Melayani dengan Hati, Inovasi untuk Negeri
