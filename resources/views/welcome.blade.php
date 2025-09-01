<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kantor Camat Waesama - Pelayanan Masyarakat</title>
        <meta name="description" content="Website resmi Kantor Camat Waesama - Melayani dengan sepenuh hati untuk kemajuan masyarakat">

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
                @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
                .text-gradient { color: #003f88; }
                
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
        @endif
    </head>
    <body>
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
                        <a href="{{ route('welcome') }}" class="public-nav-item active"><i class="fas fa-home" style="margin-right: 0.5rem;"></i>Beranda</a>
                        <a href="{{ route('public.profil') }}" class="public-nav-item"><i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>Profil</a>
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
        <section class="hero-bg" style="padding: 8rem 2rem 6rem; text-align: center; color: white; position: relative; overflow: hidden; background: #003f88;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>'); opacity: 0.3;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1;" class="animate-fade-in">
                <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Selamat Datang di<br>Kantor Camat Waesama</h1>
                <p style="font-size: 1.25rem; margin-bottom: 2.5rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">Kami berkomitmen memberikan pelayanan terbaik untuk masyarakat dengan sistem digital yang modern dan efisien</p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="#layanan" style="padding: 1rem 2rem; background: rgba(255,255,255,0.2); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease;">Lihat Layanan</a>
                    <a href="#berita" style="padding: 1rem 2rem; background: white; color: #003f88; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;">Berita Terbaru</a>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan" style="padding: 6rem 2rem; background: #f8fafc;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #333;">Layanan Kami</h2>
                <p style="font-size: 1.125rem; color: #666; margin-bottom: 4rem; max-width: 600px; margin-left: auto; margin-right: auto;">Berbagai layanan digital untuk memudahkan urusan administrasi Anda</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    <div class="service-card" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
                        <div class="service-icon" style="width: 4rem; height: 4rem; background: #003f88; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 1.5rem;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">Layanan Surat</h3>
                        <p style="color: #666; margin-bottom: 1.5rem;">Ajukan berbagai jenis surat keterangan secara online dengan mudah dan cepat</p>
                        <a href="{{ route('login') }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Mulai Ajukan →</a>
                    </div>
                    
                    <div class="service-card" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
                        <div class="service-icon" style="width: 4rem; height: 4rem; background: #003f88; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 1.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; color: #333;">Antrian Online</h3>
                        <p style="color: #666; margin-bottom: 1.5rem;">Ambil nomor antrian secara online untuk menghindari kerumunan dan menghemat waktu</p>
                        <a href="{{ route('login') }}" style="color: #003f88; text-decoration: none; font-weight: 500;">Ambil Antrian →</a>
                    </div>
                    
                    <div class="service-card" style="background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; text-align: center;">
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
        <section id="berita" style="padding: 6rem 2rem; background: white;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 4rem;">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: #333;">Berita & Pengumuman</h2>
                    <p style="font-size: 1.125rem; color: #666;">Informasi terbaru dari Kantor Camat Waesama</p>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    @forelse($latestNews as $berita)
                    <article class="news-card" style="background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; border-left: 4px solid #003f88;">
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
        <section style="padding: 6rem 2rem; background: #003f88; color: white;">
            <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
                <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Hubungi Kami</h2>
                <p style="font-size: 1.125rem; margin-bottom: 3rem; opacity: 0.9;">Kami siap membantu Anda dengan pelayanan terbaik</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                    <div style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Alamat</h3>
                        <p style="opacity: 0.9;">Jl. Raya Waesama No. 123<br>Kecamatan Waesama</p>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Telepon</h3>
                        <p style="opacity: 0.9;">(021) 123-4567<br>+62 812-3456-7890</p>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Email</h3>
                        <p style="opacity: 0.9;">info@waesama.go.id<br>pelayanan@waesama.go.id</p>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="width: 3rem; height: 3rem; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.25rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Jam Operasional</h3>
                        <p style="opacity: 0.9;">Senin - Jumat: 08:00 - 16:00<br>Sabtu: 08:00 - 12:00</p>
                    </div>
                </div>
                
                <a href="{{ route('login') }}" style="display: inline-block; padding: 1rem 2rem; background: white; color: #003f88; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s ease;">Mulai Layanan Online</a>
            </div>
        </section>

        <!-- Footer -->
        <footer style="background: #1f2937; color: white; padding: 3rem 2rem 2rem;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
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
    </body>
</html>
