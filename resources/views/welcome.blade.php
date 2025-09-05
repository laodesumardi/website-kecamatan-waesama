<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kantor Camat Waesama - Pelayanan Masyarakat</title>
    <meta name="description" content="Website resmi Kantor Camat Waesama - Melayani dengan sepenuh hati untuk kemajuan masyarakat">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; }
        .hero-bg {
            background: linear-gradient(135deg, #003f88 0%, #0056b3 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .news-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 4px solid #003f88;
        }
        .news-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .fade-in { animation: fadeIn 0.6s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .text-gradient {
            background: linear-gradient(135deg, #003f88, #0056b3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            background: #003f88;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary:hover {
            background: #002a5c;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0, 63, 136, 0.4);
        }

        /* Pagination Styles */
        .pagination-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .pagination-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        .pagination-btn.active {
            background: #003f88;
            color: white;
            border-color: #003f88;
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

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .hero-section {
                padding: 6rem 1rem 4rem !important;
            }
            .content-grid {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }
            .sidebar {
                order: -1;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 5rem 0.75rem 3rem !important;
            }
            .hero-title {
                font-size: 1.75rem !important;
            }
            .hero-subtitle {
                font-size: 0.95rem !important;
            }
        }
    </style>
</head>
<body>

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
                        <a href="{{ route('welcome') }}" class="public-nav-item active"><i class="fas fa-home mr-2"></i>Beranda</a>
                        <a href="{{ route('public.profil') }}" class="public-nav-item"><i class="fas fa-info-circle mr-2"></i>Profil</a>
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
                    <a href="{{ route('welcome') }}" class="public-nav-item active"><i class="fas fa-home mr-2"></i>Beranda</a>
                    <a href="{{ route('public.profil') }}" class="public-nav-item"><i class="fas fa-info-circle mr-2"></i>Profil</a>
                    <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper mr-2"></i>Berita</a>
                    <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs mr-2"></i>Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone mr-2"></i>Kontak</a>

                    @if (Route::has('login'))
                        <div class="flex flex-col space-y-2 pt-2 border-t border-gray-200">
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
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center justify-center text-white relative" style="padding-top: 5rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="fade-in">
                <h1 class="hero-title text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di<br>
                    <span class="text-white"t">Kantor Camat Waesama</span>
                </h1>
                <p class="hero-subtitle text-lg md:text-xl mb-8 max-w-3xl mx-auto opacity-90">
                    Kami berkomitmen memberikan pelayanan terbaik untuk masyarakat dengan sistem digital yang modern dan efisien
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.layanan') }}" class="btn-primary">
                        <i class="fas fa-cogs mr-2"></i>Lihat Layanan
                    </a>
                    <a href="{{ route('public.berita') }}" class="btn-primary" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                        <i class="fas fa-newspaper mr-2"></i>Berita Terbaru
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Content Area -->
            <div class="lg:col-span-2">
                <!-- Visi & Misi -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8 card-hover">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-eye text-blue-600 mr-3"></i>
                        Visi & Misi
                    </h2>
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-600 mb-3">Visi</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Terwujudnya Kecamatan Waesama yang maju, sejahtera, dan berkeadilan melalui pelayanan publik yang prima dan pemberdayaan masyarakat yang berkelanjutan.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-600 mb-3">Misi</h3>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Meningkatkan kualitas pelayanan publik yang transparan dan akuntabel</li>
                                <li>Memberdayakan masyarakat melalui program-program pembangunan</li>
                                <li>Menjaga keamanan dan ketertiban wilayah</li>
                                <li>Mengoptimalkan potensi sumber daya alam dan manusia</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sejarah -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8 card-hover">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-history text-green-600 mr-3"></i>
                        Sejarah Singkat
                    </h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        <p>
                            Kecamatan Waesama merupakan salah satu kecamatan di Kabupaten Buru yang dibentuk berdasarkan Peraturan Daerah dengan tujuan untuk meningkatkan pelayanan kepada masyarakat dan mempercepat pembangunan di wilayah tersebut.
                        </p>
                        <p>
                            Sejak berdirinya, Kecamatan Waesama terus berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat melalui berbagai program pembangunan dan pemberdayaan masyarakat.
                        </p>
                    </div>
                </div>

                <!-- Struktur Organisasi -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8 card-hover">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-sitemap text-purple-600 mr-3"></i>
                        Struktur Organisasi
                    </h2>
                    <div class="text-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Camat</h4>
                                <p class="text-sm text-gray-600">Kepala Kecamatan Waesama</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Sekretaris Camat</h4>
                                <p class="text-sm text-gray-600">Koordinator administrasi</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Kepala Seksi Pemerintahan</h4>
                                <p class="text-sm text-gray-600">Bidang pemerintahan dan keamanan</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Kepala Seksi Pemberdayaan</h4>
                                <p class="text-sm text-gray-600">Bidang pemberdayaan masyarakat</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wilayah Kerja -->
                <div class="bg-white rounded-lg shadow-lg p-8 card-hover">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-map-marked-alt text-red-600 mr-3"></i>
                        Wilayah Kerja
                    </h2>
                    <div class="text-gray-700 space-y-4">
                        <p>
                            Kecamatan Waesama memiliki wilayah kerja yang meliputi beberapa desa dengan karakteristik geografis yang beragam, mulai dari dataran rendah hingga perbukitan.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-900 mb-2">Luas Wilayah</h4>
                                <p class="text-blue-700">± 150 km²</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-green-900 mb-2">Jumlah Desa</h4>
                                <p class="text-green-700">8 Desa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-link text-blue-600 mr-2"></i>
                        Tautan Cepat
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('public.layanan') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-cogs text-blue-600 mr-3"></i>
                                <span class="text-gray-700 hover:text-blue-600">Layanan Publik</span>
                            </div>
                        </a>
                        <a href="{{ route('public.berita') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-newspaper text-blue-600 mr-3"></i>
                                <span class="text-gray-700 hover:text-blue-600">Berita Terbaru</span>
                            </div>
                        </a>
                        <a href="{{ route('public.kontak') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-600 mr-3"></i>
                                <span class="text-gray-700 hover:text-blue-600">Kontak Kami</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg shadow-lg p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Kontak
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-200"></i>
                            <span>Jl. Raya Waesama No. 123<br>Kecamatan Waesama</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-200"></i>
                            <span>(021) 123-4567</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-200"></i>
                            <span>info@waesama.go.id</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-3 text-blue-200"></i>
                            <span>Senin - Jumat: 08:00 - 16:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- News Section -->
        <section id="berita" class="news-section" style="padding: 6rem 2rem; background: white;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 4rem;">
                    <h2 class="fade-in" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #333;">Berita & Pengumuman</h2>
                    <p class="fade-in" style="font-size: 1.125rem; color: #666;">Informasi terbaru dari Kantor Camat Waesama</p>
                </div>

                <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; padding: 0 1rem;">
                    @forelse($latestNews as $berita)
                    <article class="news-card fade-in" style="background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; border-left: 4px solid #003f88;">
                        @if($berita->image)
                        <div style="height: 200px; background-image: url('{{ asset('storage/' . $berita->image) }}'); background-size: cover; background-position: center;"></div>
                        @endif
                        <div style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                <span style="background: {{ $berita->is_featured ? '#ef4444' : '#10b981' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 500;">{{ $berita->is_featured ? 'UNGGULAN' : 'BERITA' }}</span>
                                <span style="color: #666; font-size: 0.875rem;">{{ $berita->published_at->diffForHumans() }}</span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">{{ $berita->title }}</h3>
                            <p style="color: #666; margin-bottom: 1.5rem;">{{ Str::limit($berita->excerpt, 120) }}</p>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="{{ route('public.berita.detail', $berita->slug) }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Baca Selengkapnya →</a>
                                <div style="display: flex; align-items: center; gap: 0.5rem; color: #666; font-size: 0.875rem;">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ number_format($berita->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #666;">
                        <i class="fas fa-newspaper" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="font-size: 1.125rem;">Belum ada berita yang dipublikasikan</p>
                    </div>
                    @endforelse
                </div>

                @if(isset($latestNews) && $latestNews->count() > 0)
                <div style="margin-top: 3rem; text-align: center;">
                    <a href="{{ route('public.berita') }}" style="display: inline-block; padding: 1rem 2rem; background: #003f88; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; transition: all 0.3s ease;">Lihat Semua Berita</a>
                </div>
                @endif
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section" style="padding: 6rem 2rem; background: #003f88; color: white;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="fade-in" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Hubungi Kami</h2>
                <p class="fade-in" style="font-size: 1.125rem; margin-bottom: 3rem; opacity: 0.9;">Kami siap membantu Anda dengan pelayanan terbaik</p>

                <div class="contact-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                    <div class="fade-in" style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Alamat</h3>
                        <p style="opacity: 0.9;">Jl. Raya Waesama No. 123<br>Kecamatan Waesama</p>
                    </div>

                    <div class="fade-in" style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Telepon</h3>
                        <p style="opacity: 0.9;">(021) 123-4567<br>+62 812-3456-7890</p>
                    </div>

                    <div class="fade-in" style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Email</h3>
                        <p style="opacity: 0.9;">info@waesama.go.id<br>pelayanan@waesama.go.id</p>
                    </div>

                    <div class="fade-in" style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Jam Operasional</h3>
                        <p style="opacity: 0.9;">Senin - Jumat: 08:00 - 16:00<br>Sabtu: 08:00 - 12:00</p>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="fade-in btn-primary" style="display: inline-block; padding: 1rem 2rem; background: white; color: #003f88; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;">Mulai Layanan Online</a>
            </div>
        </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <h3 class="text-xl font-bold mb-4">Kantor Camat Waesama</h3>
                    <p class="text-gray-300 mb-4">Melayani dengan sepenuh hati untuk kemajuan masyarakat Waesama</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Navigasi</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('welcome') }}" class="text-gray-300 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.profil') }}" class="text-gray-300 hover:text-white transition-colors">Profil</a></li>
                        <li><a href="{{ route('public.berita') }}" class="text-gray-300 hover:text-white transition-colors">Berita</a></li>
                        <li><a href="{{ route('public.layanan') }}" class="text-gray-300 hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="{{ route('public.kontak') }}" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Jl. Raya Waesama No. 123
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            (021) 123-4567
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            info@waesama.go.id
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} Kantor Camat Waesama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        if (mobileMenuButton && mobileMenu && menuIcon) {
            mobileMenuButton.addEventListener('click', function() {
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

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });

            // Close mobile menu on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });

            // Close mobile menu on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        }

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all elements with fade-in class
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Initialize accessibility attributes
        document.addEventListener('DOMContentLoaded', function() {
            if (mobileMenuButton) {
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenuButton.setAttribute('aria-controls', 'mobile-menu');
            }
        });
    </script>
    </body>
</html>
