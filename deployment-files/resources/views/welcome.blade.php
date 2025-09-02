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
        <link rel="mask-icon" href="{{ asset('favicon.svg') }}" color="#1e40af">

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

                /* Additional custom styles if needed */

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
            .hero-buttons {
                flex-direction: column !important;
                gap: 0.75rem !important;
            }
            
            .hero-btn {
                width: 100% !important;
                max-width: 280px !important;
                font-size: 0.9rem !important;
                padding: 0.875rem 1.5rem !important;
            }
            
            .services-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            
            .news-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            
            .service-card, .news-card {
                margin: 0 0.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                padding: 6rem 0.75rem 3rem !important;
            }
            
            .services-section, .news-section {
                padding: 4rem 1rem !important;
            }
            
            .hero-title {
                font-size: 1.75rem !important;
                margin-bottom: 1rem !important;
            }
            
            .hero-subtitle {
                font-size: 0.95rem !important;
                margin-bottom: 2rem !important;
            }
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
                       class="group flex items-center px-3 py-2 text-sm font-medium text-blue-800 bg-blue-50 rounded-lg">
                        <i class="fas fa-home text-base mr-2"></i>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('public.profil') }}"
                       class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-info-circle text-base mr-2 group-hover:scale-110 transition-transform duration-200"></i>
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
                               class="group flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg text-sm font-medium hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-tachometer-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="group flex items-center px-4 py-2 border border-blue-800 text-blue-800 rounded-lg text-sm font-medium hover:bg-blue-800 hover:text-white transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                                Masuk
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="group flex items-center px-4 py-2 bg-blue-800 text-white rounded-lg text-sm font-medium hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform duration-200"></i>
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
                        class="flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-blue-800 hover:bg-gray-100 transition-all duration-200"
                        aria-expanded="false"
                        aria-label="Toggle navigation menu">
                    <i id="menu-icon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-200 shadow-lg">
            <div class="px-4 py-4">
                <div class="space-y-2">
                    <!-- Mobile Navigation Links -->
                    <a href="{{ route('welcome') }}"
                       class="flex items-center px-3 py-3 text-sm font-medium text-blue-800 bg-blue-50 rounded-lg">
                        <i class="fas fa-home text-base mr-3"></i>
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('public.profil') }}"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-info-circle text-base mr-3"></i>
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('public.berita') }}"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-newspaper text-base mr-3"></i>
                        <span>Berita</span>
                    </a>

                    <a href="{{ route('public.layanan') }}"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-cogs text-base mr-3"></i>
                        <span>Layanan</span>
                    </a>

                    <a href="{{ route('public.kontak') }}"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-700 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-phone text-base mr-3"></i>
                        <span>Kontak</span>
                    </a>

                    <!-- Mobile Authentication Section -->
                    @if (Route::has('login'))
                        <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="flex items-center justify-center w-full px-4 py-3 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex items-center justify-center w-full px-4 py-3 border-2 border-blue-800 text-blue-800 text-sm font-medium rounded-lg hover:bg-blue-800 hover:text-white transition-all duration-200">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="flex items-center justify-center w-full px-4 py-3 bg-blue-800 text-white text-sm font-medium rounded-lg hover:bg-blue-900 transition-all duration-200 shadow-sm hover:shadow-md">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
        <!-- Hero Section -->
        <section class="hero-bg hero-section" style="padding: 8rem 1rem 4rem; text-align: center; color: white; position: relative; overflow: hidden; background: #003f88; margin-top: 0; min-height: 100vh; display: flex; align-items: center;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>'); opacity: 0.1; z-index: 0;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; width: 100%;" class="animate-fade-in">
                <h1 class="hero-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 700; margin-bottom: 1.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); line-height: 1.2;">Selamat Datang di<br>Kantor Camat Waesama</h1>
                <p class="hero-subtitle" style="font-size: clamp(1rem, 3vw, 1.25rem); margin-bottom: 2.5rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">Kami berkomitmen memberikan pelayanan terbaik untuk masyarakat dengan sistem digital yang modern dan efisien</p>
                <div class="hero-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; flex-direction: column; align-items: center;">
                    <a href="#layanan" class="hero-btn" style="padding: 1rem 2rem; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease; min-width: 200px; text-align: center;">Lihat Layanan</a>
                    <a href="#berita" class="hero-btn" style="padding: 1rem 2rem; background: white; color: #003f88; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease; min-width: 200px; text-align: center;">Berita Terbaru</a>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan" class="services-section" style="padding: 6rem 2rem; background: #f8fafc;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 class="fade-in" style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #333;">Layanan Kami</h2>
                <p class="fade-in" style="font-size: 1.125rem; color: #666; margin-bottom: 4rem; max-width: 600px; margin-left: auto; margin-right: auto;">Berbagai layanan digital untuk memudahkan urusan administrasi Anda</p>

                <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; padding: 0 1rem;">
                    <div class="service-card fade-in" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
                        <div class="service-icon" style="width: 4rem; height: 4rem; background: #003f88; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 1.5rem;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">Layanan Surat</h3>
                        <p style="color: #666; margin-bottom: 1.5rem;">Ajukan berbagai jenis surat keterangan secara online dengan mudah dan cepat</p>
                        <a href="{{ route('login') }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Mulai Ajukan →</a>
                    </div>

                    <div class="service-card fade-in" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
                        <div class="service-icon" style="width: 4rem; height: 4rem; background: #003f88; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 1.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">Antrian Online</h3>
                        <p style="color: #666; margin-bottom: 1.5rem;">Ambil nomor antrian secara online untuk menghindari kerumunan dan menghemat waktu</p>
                        <a href="{{ route('login') }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Ambil Antrian →</a>
                    </div>

                    <div class="service-card fade-in" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
                        <div class="service-icon" style="width: 4rem; height: 4rem; background: #003f88; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 1.5rem;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">Pengaduan</h3>
                        <p style="color: #666; margin-bottom: 1.5rem;">Sampaikan keluhan atau saran Anda untuk perbaikan pelayanan yang lebih baik</p>
                        <a href="{{ route('login') }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Buat Pengaduan →</a>
                    </div>
                </div>
            </div>
        </section>

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
        <footer style="background: #1a1a1a; color: white; padding: 3rem 2rem 1rem;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                            <i class="fas fa-building" style="font-size: 1.5rem; color: #003f88;"></i>
                            <h3 style="font-size: 1.25rem; font-weight: 600;">Kantor Camat Waesama</h3>
                        </div>
                        <p style="color: #9ca3af; margin-bottom: 1rem;">Melayani dengan sepenuh hati untuk kemajuan masyarakat Waesama.</p>
                        <div style="display: flex; gap: 1rem;">
                            <a href="#" style="color: #003f88; font-size: 1.25rem;"><i class="fab fa-facebook"></i></a>
                            <a href="#" style="color: #003f88; font-size: 1.25rem;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: #003f88; font-size: 1.25rem;"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Layanan</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Surat Keterangan</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Antrian Online</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Pengaduan</a></li>
                            <li style="margin-bottom: 0.5rem;"><a href="#" style="color: #9ca3af; text-decoration: none;">Informasi Publik</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Informasi</h4>
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
