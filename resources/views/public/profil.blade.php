<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - Kantor Camat Waesama</title>
    <meta name="description" content="Profil lengkap Kantor Camat Waesama - Visi, Misi, Struktur Organisasi, dan Sejarah">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hero-bg {
            background: #003f88;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .profile-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-color: #d1d5db;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .text-gradient {
                color: #003f88;
            }

        .btn-primary {
            background: #003f88;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        /* Standardized Public Navigation Menu */
        .public-nav-item {
            color: #666;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .public-nav-item:hover {
            color: #003f88;
            background: rgba(0, 63, 136, 0.1);
        }
        .public-nav-item.active {
            color: #003f88;
            font-weight: 600;
        }
        .public-nav-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .public-nav-btn.primary {
            background: #003f88;
            color: white;
        }
        .public-nav-btn.primary:hover {
            background: #002a5c;
        }
        .public-nav-btn.secondary {
            color: #003f88;
            border: 2px solid #003f88;
        }
        .public-nav-btn.secondary:hover {
            background: #003f88;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-building text-2xl text-blue-800"></i>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Kantor Camat Waesama</h1>
                        <p class="text-sm text-gray-600">Melayani dengan Sepenuh Hati</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <div class="flex space-x-2">
                        <a href="{{ route('welcome') }}" class="public-nav-item"><i class="fas fa-home mr-2"></i>Beranda</a>
                        <a href="{{ route('public.profil') }}" class="public-nav-item active"><i class="fas fa-info-circle mr-2"></i>Profil</a>
                        <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                        <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                        <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone mr-2"></i>Kontak</a>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex space-x-4 items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="public-nav-btn primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="public-nav-btn secondary">Masuk</a>
                                {{-- Registration disabled - only admin and pegawai access --}}
                                 {{-- @if (Route::has('register'))
                                     <a href="{{ route('register') }}" class="public-nav-btn primary">Daftar</a>
                                 @endif --}}
                            @endauth
                        </div>
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-blue-800 focus:outline-none">
                        <i id="menu-icon" class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('welcome') }}" class="public-nav-item"><i class="fas fa-home mr-2"></i>Beranda</a>
                    <a href="{{ route('public.profil') }}" class="public-nav-item active"><i class="fas fa-info-circle mr-2"></i>Profil</a>
                    <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                    <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone mr-2"></i>Kontak</a>

                    @if (Route::has('login'))
                        <div class="flex flex-col space-y-2 pt-2 border-t border-gray-200">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="public-nav-btn primary">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="public-nav-btn secondary">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="public-nav-btn primary">Daftar</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-16 pt-[150px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Profil Kantor</h1>
            <p class="text-xl mb-8 opacity-90 fade-in">Mengenal lebih dekat Kantor Camat Waesama</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Profile Content -->
            <div class="lg:col-span-3">
                <!-- Visi Misi -->
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8 profile-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-eye text-blue-600 mr-3"></i>
                        Visi & Misi
                    </h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-semibold text-blue-600 mb-4">Visi</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Terwujudnya pelayanan publik yang prima, transparan, dan akuntabel untuk kesejahteraan masyarakat Waesama.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-blue-600 mb-4">Misi</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                    Memberikan pelayanan publik yang berkualitas
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                    Meningkatkan transparansi dan akuntabilitas
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                    Memberdayakan masyarakat secara optimal
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                    Menjaga ketertiban dan keamanan wilayah
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sejarah -->
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8 profile-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-history text-amber-600 mr-3"></i>
                        Sejarah Singkat
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Kantor Camat Waesama didirikan pada tahun 1965 sebagai bagian dari pembentukan Kabupaten Buru. 
                            Kecamatan Waesama merupakan salah satu kecamatan yang memiliki peran strategis dalam pengembangan 
                            wilayah Kabupaten Buru.
                        </p>
                        <p>
                            Seiring dengan perkembangan zaman dan tuntutan pelayanan publik yang semakin baik, Kantor Camat 
                            Waesama terus melakukan pembenahan dan peningkatan kualitas pelayanan kepada masyarakat.
                        </p>
                        <p>
                            Saat ini, Kantor Camat Waesama telah menerapkan sistem pelayanan digital untuk memudahkan 
                            masyarakat dalam mengakses berbagai layanan administrasi.
                        </p>
                    </div>
                </div>

                <!-- Struktur Organisasi -->
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8 profile-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-sitemap text-purple-600 mr-3"></i>
                        Struktur Organisasi
                    </h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Camat</h4>
                            <p class="text-sm text-gray-600">Kepala Kecamatan</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-user-cog text-green-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Sekretaris Camat</h4>
                            <p class="text-sm text-gray-600">Koordinator Administrasi</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-users text-purple-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Kepala Seksi</h4>
                            <p class="text-sm text-gray-600">Pelayanan Masyarakat</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-clipboard-list text-red-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Kepala Seksi</h4>
                            <p class="text-sm text-gray-600">Pemerintahan</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Kepala Seksi</h4>
                            <p class="text-sm text-gray-600">Pemberdayaan</p>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800">Kepala Seksi</h4>
                            <p class="text-sm text-gray-600">Ketertiban</p>
                        </div>
                    </div>
                </div>

                <!-- Wilayah Kerja -->
                <div class="bg-white rounded-xl shadow-sm p-8 profile-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-map-marked-alt text-green-600 mr-3"></i>
                        Wilayah Kerja
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Wilayah</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Luas Wilayah:</span>
                                    <span class="font-medium">125,5 km²</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah Desa:</span>
                                    <span class="font-medium">12 Desa</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah Penduduk:</span>
                                    <span class="font-medium">15.234 Jiwa</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kepadatan:</span>
                                    <span class="font-medium">121 Jiwa/km²</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Batas Wilayah</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Utara:</span>
                                    <span class="font-medium">Kec. Namlea</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Selatan:</span>
                                    <span class="font-medium">Laut Banda</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Timur:</span>
                                    <span class="font-medium">Kec. Waplau</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Barat:</span>
                                    <span class="font-medium">Kec. Batabual</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-link text-blue-500 mr-2"></i>
                        Tautan Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('public.layanan') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-file-alt w-5 mr-3"></i>
                            Layanan Surat
                        </a>
                        <a href="{{ route('public.layanan') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-clock w-5 mr-3"></i>
                            Antrian Online
                        </a>
                        <a href="{{ route('public.kontak') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-comments w-5 mr-3"></i>
                            Pengaduan
                        </a>
                        <a href="{{ route('public.berita') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-newspaper w-5 mr-3"></i>
                            Berita Terbaru
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-phone text-green-500 mr-2"></i>
                        Kontak
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-red-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Alamat</p>
                                <p class="text-gray-600">Jl. Raya Waesama No. 123<br>Kec. Waesama, Kab. Buru</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-500"></i>
                            <div>
                                <p class="font-medium text-gray-800">Telepon</p>
                                <p class="text-gray-600">(0914) 123-456</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-purple-500"></i>
                            <div>
                                <p class="font-medium text-gray-800">Email</p>
                                <p class="text-gray-600">info@waesama.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jam Operasional -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                        Jam Operasional
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Senin - Kamis</span>
                            <span class="font-medium">08:00 - 16:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumat</span>
                            <span class="font-medium">08:00 - 11:30</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sabtu - Minggu</span>
                            <span class="font-medium text-red-500">Tutup</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23667eea'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='white' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-12 w-12">
                        <div>
                            <h3 class="text-xl font-bold">Kantor Camat Waesama</h3>
                            <p class="text-gray-300">Melayani dengan Sepenuh Hati</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4">Kantor Camat Waesama berkomitmen memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan transparansi, akuntabilitas, dan profesionalisme.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.profil') }}" class="text-gray-300 hover:text-white transition-colors">Profil</a></li>
                        <li><a href="{{ route('public.berita') }}" class="text-gray-300 hover:text-white transition-colors">Berita</a></li>
                        <li><a href="{{ route('public.layanan') }}" class="text-gray-300 hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="{{ route('public.kontak') }}" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Media Sosial</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; 2024 Kantor Camat Waesama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');

            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');

                // Toggle icon
                if (mobileMenu.classList.contains('hidden')) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                } else {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            });
        });
    </script>
</body>
</html>
