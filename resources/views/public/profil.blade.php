<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kantor - Kantor Camat Waesama</title>
    <meta name="description" content="Profil lengkap Kantor Camat Waesama - Visi, Misi, Struktur Organisasi, dan Sejarah">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
    <nav style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); position: fixed; top: 0; left: 0; right: 0; z-index: 1000; padding: 1rem 0; box-shadow: 0 2px 20px rgba(0,0,0,0.1);">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-building" style="font-size: 2rem; color: #003f88;"></i>
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0; color: #333;">Kantor Camat Waesama</h1>
                    <p style="font-size: 0.875rem; color: #666; margin: 0;">Melayani dengan Sepenuh Hati</p>
                </div>
            </div>
                
                <!-- Navigation Menu -->
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('welcome') }}" class="public-nav-item"><i class="fas fa-home" style="margin-right: 0.5rem;"></i>Beranda</a>
                        <a href="{{ route('public.profil') }}" class="public-nav-item active"><i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Profil</a>
                        <a href="{{ route('public.berita') }}" class="public-nav-item"><i class="fas fa-newspaper" style="margin-right: 0.5rem;"></i>Berita</a>
                        <a href="{{ route('public.layanan') }}" class="public-nav-item"><i class="fas fa-cogs" style="margin-right: 0.5rem;"></i>Layanan</a>
                        <a href="{{ route('public.kontak') }}" class="public-nav-item"><i class="fas fa-phone" style="margin-right: 0.5rem;"></i>Kontak</a>
                    </div>
                    
                    @if (Route::has('login'))
                        <div style="display: flex; gap: 1rem; align-items: center;">
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
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg text-white py-16">
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
                <div class="bg-white rounded-xl shadow-sm p-8 card-hover fade-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-eye text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Visi</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        "Terwujudnya Kecamatan Waesama yang Maju, Sejahtera, dan Berkeadilan melalui Pelayanan Prima dan Pembangunan Berkelanjutan"
                    </p>
                </div>
                
                <!-- Misi -->
                <div class="bg-white rounded-xl shadow-sm p-8 card-hover fade-in">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-bullseye text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Misi</h3>
                    </div>
                    <ul class="text-gray-600 space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Meningkatkan kualitas pelayanan publik yang profesional dan berintegritas</span>
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
                            <span>Mewujudkan tata kelola pemerintahan yang transparan dan akuntabel</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Struktur organisasi Kantor Camat Waesama yang terdiri dari berbagai bidang untuk melayani masyarakat</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <!-- Camat -->
                <div class="text-center mb-8">
                    <div class="inline-block bg-blue-600 text-white px-6 py-4 rounded-lg mb-4">
                        <h3 class="text-xl font-bold">CAMAT</h3>
                        <p class="text-blue-100">Drs. Ahmad Suryanto, M.Si</p>
                    </div>
                </div>
                
                <!-- Sekretaris Camat -->
                <div class="text-center mb-8">
                    <div class="inline-block bg-green-600 text-white px-6 py-4 rounded-lg">
                        <h4 class="text-lg font-semibold">SEKRETARIS CAMAT</h4>
                        <p class="text-green-100">Siti Nurhaliza, S.Sos</p>
                    </div>
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
                        <p class="text-sm text-gray-600 mb-3">Menangani program kesejahteraan masyarakat</p>
                        <p class="text-sm font-medium text-teal-600">Kepala: Dr. Andi Wijaya</p>
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
                        Kecamatan Waesama dibentuk berdasarkan Peraturan Daerah Kabupaten Buru pada tahun 2008 sebagai hasil pemekaran dari kecamatan induk. Pembentukan kecamatan ini bertujuan untuk mendekatkan pelayanan pemerintahan kepada masyarakat.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Sejak berdiri, Kantor Camat Waesama terus berkomitmen untuk meningkatkan kualitas pelayanan dan pembangunan di wilayah kecamatan melalui berbagai program inovatif dan berkelanjutan.
                    </p>
                </div>
                
                <div class="fade-in">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Timeline Perkembangan</h3>
                    <div class="space-y-6">
                        <div class="timeline-item">
                            <div class="font-semibold text-blue-600">2008</div>
                            <div class="text-gray-800 font-medium">Pembentukan Kecamatan</div>
                            <div class="text-gray-600 text-sm">Kecamatan Waesama resmi dibentuk melalui Perda Kabupaten Buru</div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="font-semibold text-blue-600">2010</div>
                            <div class="text-gray-800 font-medium">Pembangunan Kantor</div>
                            <div class="text-gray-600 text-sm">Gedung kantor camat permanen mulai dibangun</div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="font-semibold text-blue-600">2015</div>
                            <div class="text-gray-800 font-medium">Digitalisasi Pelayanan</div>
                            <div class="text-gray-600 text-sm">Implementasi sistem pelayanan berbasis teknologi</div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="font-semibold text-blue-600">2020</div>
                            <div class="text-gray-800 font-medium">Pelayanan Online</div>
                            <div class="text-gray-600 text-sm">Launching layanan online untuk kemudahan masyarakat</div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="font-semibold text-blue-600">2024</div>
                            <div class="text-gray-800 font-medium">Modernisasi Sistem</div>
                            <div class="text-gray-600 text-sm">Upgrade sistem informasi dan website resmi</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Wilayah Kerja -->
        <section class="mb-16">
            <div class="bg-white rounded-xl shadow-sm p-8 fade-in">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Wilayah Kerja</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="text-center">
                        <div class="bg-blue-100 p-4 rounded-lg mb-4">
                            <i class="fas fa-map-marked-alt text-blue-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Luas Wilayah</h4>
                        <p class="text-2xl font-bold text-blue-600">125.5</p>
                        <p class="text-gray-600">km²</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-green-100 p-4 rounded-lg mb-4">
                            <i class="fas fa-home text-green-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Jumlah Desa</h4>
                        <p class="text-2xl font-bold text-green-600">12</p>
                        <p class="text-gray-600">Desa</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-purple-100 p-4 rounded-lg mb-4">
                            <i class="fas fa-users text-purple-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Jumlah Penduduk</h4>
                        <p class="text-2xl font-bold text-purple-600">25,432</p>
                        <p class="text-gray-600">Jiwa</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-orange-100 p-4 rounded-lg mb-4">
                            <i class="fas fa-family text-orange-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Jumlah KK</h4>
                        <p class="text-2xl font-bold text-orange-600">6,358</p>
                        <p class="text-gray-600">Kepala Keluarga</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="font-bold text-gray-800 mb-4">Desa-desa di Kecamatan Waesama:</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waesama</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Batu Merah</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waeapo</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waenetat</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Leksula</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waelata</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waekasar</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waesala</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waetulia</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waemulang</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waesamu</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg text-center">
                            <span class="text-gray-700">Waenetat Timur</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center">
            <div class="bg-[#003f88] text-white rounded-xl p-12 fade-in">
                <h2 class="text-3xl font-bold mb-4">Butuh Informasi Lebih Lanjut?</h2>
                <p class="text-xl mb-8 opacity-90">Hubungi kami untuk mendapatkan informasi dan pelayanan terbaik</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('public.kontak') }}" class="bg-white text-[#003f88] px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </a>
                    <a href="{{ route('public.layanan') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-[#003f88] transition-colors">
                        <i class="fas fa-concierge-bell mr-2"></i>
                        Lihat Layanan
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='white'/%3E%3Ctext x='50' y='60' text-anchor='middle' fill='%23667eea' font-size='40' font-weight='bold'%3EW%3C/text%3E%3C/svg%3E" alt="Logo" class="h-12 w-12">
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
</body>
</html>