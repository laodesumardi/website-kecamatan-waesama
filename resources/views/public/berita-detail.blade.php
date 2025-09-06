<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $berita->judul }} - Kantor Camat Waesama</title>
    <meta name="description" content="{{ $berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150) }}">

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

        .news-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .news-card:hover {
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

        .pagination-btn {
            transition: all 0.3s ease;
        }

        .pagination-btn:hover {
            background: #003f88;
            color: white;
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
            transition: all 0.3s ease;
        }
        .public-nav-btn:hover {
            transform: translateY(-1px);
        }

        /* Mobile Navigation */
        @media (max-width: 768px) {
            .mobile-menu {
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            .mobile-menu.active {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23667eea'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='white' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-10 w-10">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Kantor Camat</h1>
                        <p class="text-sm text-gray-600">Waesama</p>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ url('/') }}" class="public-nav-item">Beranda</a>
                    <a href="{{ route('public.profil') }}" class="public-nav-item">Profil</a>
                    <a href="{{ route('public.berita') }}" class="public-nav-item active">Berita</a>
                    <a href="{{ route('public.layanan') }}" class="public-nav-item">Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="public-nav-item">Kontak</a>
                </div>
                
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="public-nav-btn bg-blue-600 text-white hover:bg-blue-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="public-nav-btn text-gray-600 hover:text-blue-600">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="public-nav-btn bg-blue-600 text-white hover:bg-blue-700">
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="mobile-menu md:hidden fixed inset-y-0 right-0 w-64 bg-white shadow-xl z-50">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                    <button id="mobile-menu-close" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-4">
                    <a href="{{ url('/') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="{{ route('public.profil') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Profil</a>
                    <a href="{{ route('public.berita') }}" class="block py-2 text-blue-600 font-medium">Berita</a>
                    <a href="{{ route('public.layanan') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Layanan</a>
                    <a href="{{ route('public.kontak') }}" class="block py-2 text-gray-700 hover:text-blue-600 transition-colors">Kontak</a>
                </nav>
                <div class="p-4 border-t space-y-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center text-gray-600 py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Masuk
                        </a>
                        {{-- Registration disabled - only admin and pegawai access --}}
                {{-- <a href="{{ route('register') }}" class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Daftar
                </a> --}}
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 fade-in">{{ $berita->judul }}</h1>
                <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto fade-in">{{ $berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150) }}</p>
                <div class="flex flex-wrap justify-center gap-4 text-sm text-blue-100">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $berita->published_at ? $berita->published_at->format('d M Y') : $berita->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user"></i>
                        <span>{{ $berita->author->name }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($berita->views) }} views</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center space-x-2 text-sm mb-6 pb-6 border-b">
                        <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Beranda</a>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        <a href="{{ route('public.berita') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Berita</a>
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        <span class="text-gray-800 font-medium">Detail Berita</span>
                    </nav>

                    <!-- Article Image -->
                    @if($berita->gambar)
                        <div class="mb-8">
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-64 md:h-96 object-cover rounded-lg">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none">
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>
                    </div>

                    <!-- Share Buttons -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Bagikan Artikel</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn-primary text-white px-4 py-2 rounded-lg flex items-center space-x-2 hover:bg-blue-700">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                <i class="fab fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <button onclick="copyToClipboard()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                <i class="fas fa-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Back to News -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <a href="{{ route('public.berita') }}" class="w-full btn-primary text-white font-medium py-3 px-4 rounded-lg transition-colors text-center block">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Berita
                    </a>
                </div>
                
                <!-- Featured News -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Berita Unggulan
                    </h3>
                    <div class="space-y-4">
                        <article class="border-b border-gray-100 pb-4">
                            <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                <a href="#">Pembukaan Pendaftaran Program Bantuan Sosial Tahun 2025</a>
                            </h4>
                            <div class="flex items-center text-xs text-gray-500 space-x-3">
                                <span><i class="fas fa-calendar mr-1"></i>15 Des 2024</span>
                                <span><i class="fas fa-eye mr-1"></i>1,234</span>
                            </div>
                        </article>
                        <article class="border-b border-gray-100 pb-4">
                            <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                <a href="#">Sosialisasi Program Desa Digital</a>
                            </h4>
                            <div class="flex items-center text-xs text-gray-500 space-x-3">
                                <span><i class="fas fa-calendar mr-1"></i>12 Des 2024</span>
                                <span><i class="fas fa-eye mr-1"></i>987</span>
                            </div>
                        </article>
                        <article>
                            <h4 class="font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                                <a href="#">Peluncuran Sistem Antrian Online</a>
                            </h4>
                            <div class="flex items-center text-xs text-gray-500 space-x-3">
                                <span><i class="fas fa-calendar mr-1"></i>10 Des 2024</span>
                                <span><i class="fas fa-eye mr-1"></i>756</span>
                            </div>
                        </article>
                    </div>
                </div>
                
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
                        <a href="{{ route('public.profil') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                            <i class="fas fa-info-circle w-5 mr-3"></i>
                            Profil Kantor
                        </a>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-phone text-green-500 mr-2"></i>
                        Informasi Kontak
                    </h3>
                    <div class="space-y-4 text-sm">
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
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="font-medium text-gray-800 mb-2">Jam Operasional</p>
                            <div class="space-y-1 text-gray-600">
                                <p>Senin - Jumat: 08:00 - 16:00</p>
                                <p>Sabtu: 08:00 - 12:00</p>
                                <p>Minggu: Tutup</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Kantor Camat Waesama</h3>
                    <p class="text-gray-300 mb-4">Melayani masyarakat dengan sepenuh hati untuk kemajuan bersama.</p>
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
                    <h3 class="text-lg font-bold mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.profil') }}" class="text-gray-300 hover:text-white transition-colors">Profil</a></li>
                        <li><a href="{{ route('public.berita') }}" class="text-gray-300 hover:text-white transition-colors">Berita</a></li>
                        <li><a href="{{ route('public.layanan') }}" class="text-gray-300 hover:text-white transition-colors">Layanan</a></li>
                        <li><a href="{{ route('public.kontak') }}" class="text-gray-300 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-map-marker-alt mr-2"></i>Jl. Raya Waesama No. 123</p>
                        <p><i class="fas fa-phone mr-2"></i>(0914) 123-456</p>
                        <p><i class="fas fa-envelope mr-2"></i>info@waesama.go.id</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 Kantor Camat Waesama. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        
        function toggleMobileMenu() {
            mobileMenu.classList.toggle('active');
        }
        
        mobileMenuButton.addEventListener('click', toggleMobileMenu);
        mobileMenuClose.addEventListener('click', toggleMobileMenu);
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.remove('active');
            }
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                mobileMenu.classList.remove('active');
            }
        });
        
        // Copy to clipboard functionality
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i><span>Disalin!</span>';
                button.classList.add('bg-green-500');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-500');
                    button.classList.add('bg-gray-600');
                }, 2000);
            }, function(err) {
                console.error('Gagal menyalin link: ', err);
                alert('Gagal menyalin link!');
            });
        }
    </script>
</body>
</html>