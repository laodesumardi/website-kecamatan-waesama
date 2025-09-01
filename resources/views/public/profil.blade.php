<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Profil Kantor - Kantor Camat Waesama</title>
        <meta name="description" content="Profil lengkap Kantor Camat Waesama - Visi, Misi, Struktur Organisasi, dan Sejarah">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; }
                .hero-bg { background: #003f88; }
                .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
                .card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
                .btn-primary { background: #003f88; }
                .btn-primary:hover { background: #002a5c; }
                .news-card { border-left: 4px solid #667eea; }
                .service-icon { background: #003f88; }
                .animate-fade-in { animation: fadeIn 0.6s ease-in; }
                .fade-in { animation: fadeIn 0.6s ease-in; }
                @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
                .text-gradient { color: #003f88; }

                /* Enhanced hover effects */
                .service-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }

                .news-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                }

                .btn-primary {
                    transition: all 0.3s ease;
                }

                .btn-primary:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 10px 20px rgba(0, 63, 136, 0.4);
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

                .timeline-item {
                    position: relative;
                    padding-left: 2rem;
                }

                .timeline-item::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 0.5rem;
                    width: 0.75rem;
                    height: 0.75rem;
                    background: #667eea;
                    border-radius: 50%;
                }

                .timeline-item::after {
                    content: '';
                    position: absolute;
                    left: 0.375rem;
                    top: 1.25rem;
                    width: 2px;
                    height: calc(100% - 1.25rem);
                    background: #e5e7eb;
                }

                .timeline-item:last-child::after {
                    display: none;
                }
            </style>
        @endif
    </head>
    <body>
      <!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-lg border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Navigation Container -->
        <div class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 flex-shrink-0">
                <div class="bg-blue-800 p-2 rounded-lg">
                    <i class="fas fa-building text-xl text-white"></i>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-gray-900 leading-tight">Kantor Camat Waesama</h1>
                    <p class="text-sm text-gray-600">Melayani dengan Sepenuh Hati</p>
                </div>
                <div class="sm:hidden">
                    <h1 class="text-base font-bold text-gray-900">Camat Waesama</h1>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-1">
                    <a href="{{ route('welcome') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-home text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('public.profil') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-blue-800 bg-blue-50 rounded-lg ">
                        <i class="fas fa-info-circle text-base mr-2"></i>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('public.berita') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-newspaper text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('public.layanan') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-cogs text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Layanan</span>
                    </a>

                    <a href="{{ route('public.kontak') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-phone text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Kontak</span>
                    </a>
                </div>

                <!-- Authentication Section -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-3 pl-6 border-l border-gray-200">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 border border-blue-800 text-blue-800 text-sm font-medium rounded-lg hover:bg-blue-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button id="mobile-menu-btn"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-blue-800 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Toggle navigation menu">
                    <i id="menu-icon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white" role="navigation" aria-hidden="true">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Mobile Navigation Links -->
                <a href="{{ route('welcome') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-home text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('public.profil') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-blue-800 bg-blue-50 rounded-lg">
                    <i class="fas fa-info-circle text-lg mr-3"></i>
                    <span>Profil</span>
                </a>

                <a href="{{ route('public.berita') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-newspaper text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Berita</span>
                </a>

                <a href="{{ route('public.layanan') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-cogs text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Layanan</span>
                </a>

                <a href="{{ route('public.kontak') }}"
                   class="group flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-phone text-lg mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                    <span>Kontak</span>
                </a>

                <!-- Mobile Authentication Section -->
                @if (Route::has('login'))
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="flex items-center px-3 py-2 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
                                <i class="fas fa-tachometer-alt text-lg mr-3"></i>
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="flex items-center px-3 py-2 text-base font-medium text-blue-800 border border-blue-800 rounded-lg hover:bg-blue-800 hover:text-white transition-all duration-200">
                                <i class="fas fa-sign-in-alt text-lg mr-3"></i>
                                <span>Masuk</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="flex items-center px-3 py-2 text-base font-medium text-white bg-blue-800 rounded-lg hover:bg-blue-900 transition-all duration-200">
                                    <i class="fas fa-user-plus text-lg mr-3"></i>
                                    <span>Daftar</span>
                                </a>
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Profil Kantor Camat</h1>
            <p class="text-xl mb-8 opacity-90 fade-in">Mengenal lebih dekat Kantor Camat Waesama</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Overview -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-in">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Tentang Kami</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kantor Camat Waesama merupakan instansi pemerintahan tingkat kecamatan yang bertugas melaksanakan sebagian urusan otonomi daerah yang dilimpahkan oleh Bupati untuk menangani urusan pemerintahan di wilayah kecamatan.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan prinsip transparansi, akuntabilitas, dan profesionalisme dalam setiap aspek pelayanan publik.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">15+</div>
                            <div class="text-gray-600">Tahun Melayani</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">25K+</div>
                            <div class="text-gray-600">Penduduk Dilayani</div>
                        </div>
                    </div>
                </div>

                <div class="fade-in">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3Crect width='400' height='300' fill='%23f3f4f6'/%3E%3Crect x='50' y='50' width='300' height='200' fill='%23667eea' rx='10'/%3E%3Ctext x='200' y='160' text-anchor='middle' fill='white' font-size='24' font-weight='bold'%3EKantor Camat%3C/text%3E%3Ctext x='200' y='185' text-anchor='middle' fill='white' font-size='18'%3EWaesama%3C/text%3E%3C/svg%3E" alt="Kantor Camat Waesama" class="w-full rounded-xl shadow-lg">
                </div>
            </div>
        </section>

        <!-- Visi Misi -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-white rounded-xl p-8 shadow-lg card-hover fade-in">
                    <div class="text-center mb-6">
                        <div class="bg-blue-100 p-4 rounded-full inline-block mb-4">
                            <i class="fas fa-eye text-blue-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                    </div>
                    <p class="text-gray-600 text-center leading-relaxed">
                        "Terwujudnya Kecamatan Waesama yang Maju, Sejahtera, dan Berkeadilan melalui Pelayanan Prima dan Pembangunan Berkelanjutan"
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-xl p-8 shadow-lg card-hover fade-in">
                    <div class="text-center mb-6">
                        <div class="bg-green-100 p-4 rounded-full inline-block mb-4">
                            <i class="fas fa-bullseye text-green-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                    </div>
                    <ul class="text-gray-600 space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Meningkatkan kualitas pelayanan publik yang profesional dan transparan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Mendorong pembangunan infrastruktur yang berkelanjutan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Memberdayakan masyarakat dalam pembangunan daerah</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Menjaga keamanan dan ketertiban masyarakat</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi -->
        <section class="mb-16">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Struktur organisasi Kantor Camat Waesama yang terdiri dari berbagai bidang untuk melayani masyarakat</p>
            </div>

            <div class="bg-white rounded-xl p-8 shadow-lg fade-in">
                <!-- Camat -->
                <div class="text-center mb-8">
                    <div class="bg-blue-600 text-white p-6 rounded-lg inline-block mb-4">
                        <i class="fas fa-user-tie text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Camat Waesama</h3>
                    <p class="text-gray-600 font-medium">Drs. Ahmad Suryanto, M.AP</p>
                    <p class="text-sm text-gray-500">Kepala Kecamatan</p>
                </div>

                <!-- Bidang-bidang -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-purple-100 p-6 rounded-lg text-center">
                        <div class="bg-purple-600 text-white p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Bidang Pemerintahan</h4>
                        <p class="text-sm text-gray-600 mb-3">Menangani urusan administrasi kependudukan dan pemerintahan</p>
                        <p class="text-sm font-medium text-purple-600">Kepala: Budi Santoso, S.AP</p>
                    </div>

                    <div class="bg-orange-100 p-6 rounded-lg text-center">
                        <div class="bg-orange-600 text-white p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Bidang Pembangunan</h4>
                        <p class="text-sm text-gray-600 mb-3">Menangani perencanaan dan pelaksanaan pembangunan</p>
                        <p class="text-sm font-medium text-orange-600">Kepala: Ir. Dewi Sartika</p>
                    </div>

                    <div class="bg-teal-100 p-6 rounded-lg text-center">
                        <div class="bg-teal-600 text-white p-3 rounded-lg inline-block mb-4">
                            <i class="fas fa-handshake text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Bidang Kesejahteraan</h4>
                        <p class="text-sm text-gray-600 mb-3">Menangani program kesejahteraan dan pemberdayaan masyarakat</p>
                        <p class="text-sm font-medium text-teal-600">Kepala: Siti Nurhaliza, S.Sos</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sejarah -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="fade-in">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Sejarah Singkat</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Kecamatan Waesama dibentuk pada tahun 2008 sebagai hasil pemekaran dari Kecamatan induk. Pembentukan kecamatan ini bertujuan untuk mendekatkan pelayanan pemerintahan kepada masyarakat dan mempercepat pembangunan di wilayah tersebut.
                    </p>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Sejak berdiri, Kantor Camat Waesama terus berkomitmen untuk memberikan pelayanan terbaik dan mendorong pembangunan yang berkelanjutan di wilayah kecamatan.
                    </p>
                </div>

                <div class="fade-in">
                    <div class="space-y-6">
                        <div class="timeline-item">
                            <h4 class="font-bold text-gray-800 mb-2">2008</h4>
                            <p class="text-gray-600">Pembentukan Kecamatan Waesama melalui pemekaran</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-gray-800 mb-2">2010</h4>
                            <p class="text-gray-600">Pembangunan gedung kantor camat yang representatif</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-gray-800 mb-2">2015</h4>
                            <p class="text-gray-600">Implementasi sistem pelayanan online pertama</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-gray-800 mb-2">2020</h4>
                            <p class="text-gray-600">Digitalisasi penuh layanan administrasi kependudukan</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="font-bold text-gray-800 mb-2">2024</h4>
                            <p class="text-gray-600">Peluncuran website resmi dan sistem terintegrasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

        <!-- Footer -->
        <footer style="background-color: #1f2937; color: white; padding: 3rem 0;">
            <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                    <div style="grid-column: span 2;">
                        <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='white'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='%23667eea' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" style="height: 3rem; width: 3rem; margin-right: 1rem;">
                            <div>
                                <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.25rem;">Kantor Camat Waesama</h3>
                                <p style="color: #9ca3af;">Melayani dengan Sepenuh Hati</p>
                            </div>
                        </div>
                        <p style="color: #9ca3af; margin-bottom: 1rem;">Kantor Camat Waesama berkomitmen memberikan pelayanan terbaik kepada masyarakat dengan mengutamakan transparansi, akuntabilitas, dan profesionalisme.</p>
                        <div style="display: flex; gap: 1rem;">
                            <a href="#" style="color: #9ca3af; font-size: 1.25rem; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" style="color: #9ca3af; font-size: 1.25rem; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" style="color: #9ca3af; font-size: 1.25rem; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" style="color: #9ca3af; font-size: 1.25rem; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#9ca3af'">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Tautan Cepat</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Tentang Kami</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Berita</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Kontak</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Kontak</h4>
                        <div style="color: #9ca3af;">
                            <p style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i>Jl. Raya Waesama No. 123</p>
                            <p style="margin-bottom: 0.5rem;"><i class="fas fa-phone" style="margin-right: 0.5rem;"></i>(021) 123-4567</p>
                            <p style="margin-bottom: 0.5rem;"><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>info@waesama.go.id</p>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid #374151; padding-top: 2rem; text-align: center; color: #9ca3af;">
                    <p>&copy; 2024 Kantor Camat Waesama. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>

        <script>
           // Mobile Menu Toggle - Clean and Optimized Version
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    // Early return if required elements don't exist
    if (!mobileMenuBtn || !mobileMenu || !menuIcon) {
        console.warn('Mobile menu elements not found');
        return;
    }

    // Menu state management
    const MenuState = {
        isOpen: false,

        open() {
            this.isOpen = true;
            mobileMenu.classList.remove('hidden');
            menuIcon.className = 'fas fa-times text-xl';
            mobileMenuBtn.setAttribute('aria-expanded', 'true');

            // Smooth slide-in animation
            this.animateIn();
        },

        close() {
            this.isOpen = false;

            // Smooth slide-out animation
            this.animateOut(() => {
                mobileMenu.classList.add('hidden');
                menuIcon.className = 'fas fa-bars text-xl';
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            });
        },

        toggle() {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },

        animateIn() {
            mobileMenu.style.opacity = '0';
            mobileMenu.style.transform = 'translateY(-10px)';

            requestAnimationFrame(() => {
                mobileMenu.style.transition = 'opacity 0.2s ease-out, transform 0.2s ease-out';
                mobileMenu.style.opacity = '1';
                mobileMenu.style.transform = 'translateY(0)';
            });
        },

        animateOut(callback) {
            mobileMenu.style.transition = 'opacity 0.2s ease-in, transform 0.2s ease-in';
            mobileMenu.style.opacity = '0';
            mobileMenu.style.transform = 'translateY(-10px)';

            setTimeout(callback, 200);
        }
    };

    // Event Handlers
    const EventHandlers = {
        // Mobile menu button click handler
        handleMenuButtonClick(event) {
            event.preventDefault();
            event.stopPropagation();
            MenuState.toggle();
        },

        // Click outside to close menu
        handleDocumentClick(event) {
            if (MenuState.isOpen &&
                !mobileMenuBtn.contains(event.target) &&
                !mobileMenu.contains(event.target)) {
                MenuState.close();
            }
        },

        // Handle escape key to close menu
        handleKeyDown(event) {
            if (event.key === 'Escape' && MenuState.isOpen) {
                MenuState.close();
                mobileMenuBtn.focus(); // Return focus to button for accessibility
            }
        },

        // Handle window resize (close menu when switching to desktop)
        handleWindowResize() {
            if (window.innerWidth >= 1024 && MenuState.isOpen) {
                MenuState.close();
            }
        },

        // Handle focus trap within mobile menu
        handleFocusTrap(event) {
            if (!MenuState.isOpen) return;

            const focusableElements = mobileMenu.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled])'
            );

            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            if (event.key === 'Tab') {
                if (event.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable) {
                        event.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable) {
                        event.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        }
    };

    // Initialize event listeners
    function initializeEventListeners() {
        // Mobile menu button click
        mobileMenuBtn.addEventListener('click', EventHandlers.handleMenuButtonClick);

        // Click outside to close
        document.addEventListener('click', EventHandlers.handleDocumentClick);

        // Keyboard navigation
        document.addEventListener('keydown', EventHandlers.handleKeyDown);
        document.addEventListener('keydown', EventHandlers.handleFocusTrap);

        // Window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(EventHandlers.handleWindowResize, 100);
        });

        // Prevent menu links from bubbling up to document click handler
        mobileMenu.addEventListener('click', (event) => {
            if (event.target.tagName === 'A') {
                // Close menu when clicking on a link (optional)
                setTimeout(() => MenuState.close(), 150);
            }
        });
    }

    // Initialize accessibility attributes
    function initializeAccessibility() {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.setAttribute('aria-controls', 'mobile-menu');
        mobileMenuBtn.setAttribute('aria-label', 'Toggle navigation menu');

        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileMenu.setAttribute('role', 'navigation');
    }

    // Update accessibility attributes when menu state changes
    function updateAccessibility() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    mobileMenu.setAttribute('aria-hidden', isHidden.toString());
                }
            });
        });

        observer.observe(mobileMenu, {
            attributes: true,
            attributeFilter: ['class']
        });
    }

    // Initialize everything
    function init() {
        try {
            initializeAccessibility();
            initializeEventListeners();
            updateAccessibility();

            console.log('Mobile menu initialized successfully');
        } catch (error) {
            console.error('Error initializing mobile menu:', error);
        }
    }

    // Start the application
    init();

    // Expose MenuState for debugging (optional - remove in production)
    if (typeof window !== 'undefined' && window.location.hostname === 'localhost') {
        window.MobileMenu = MenuState;
    }
});
</script>
        </script>
    </body>
</html>
