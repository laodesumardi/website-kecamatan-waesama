@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('sidebar-menu')
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="nav-item active text-white">
        <i class="fas fa-tachometer-alt"></i>
        <span class="nav-text">Dashboard</span>
    </a>
    
    <!-- Data Penduduk -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-users"></i>
        <span class="nav-text">Data Penduduk</span>
    </a>
    
    <!-- Layanan Surat -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-file-alt"></i>
        <span class="nav-text">Layanan Surat</span>
    </a>
    
    <!-- Antrian -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-clock"></i>
        <span class="nav-text">Antrian</span>
    </a>
    
    <!-- Berita -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-newspaper"></i>
        <span class="nav-text">Berita</span>
    </a>
    
    <!-- Pengaduan -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-comments"></i>
        <span class="nav-text">Pengaduan</span>
    </a>
    
    <!-- Manajemen User -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-user-cog"></i>
        <span class="nav-text">Manajemen User</span>
    </a>
    
    <!-- Laporan -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-chart-bar"></i>
        <span class="nav-text">Laporan</span>
    </a>
    
    <!-- Pengaturan -->
    <a href="#" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-cog"></i>
        <span class="nav-text">Pengaturan</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">Kelola sistem informasi Kantor Camat Waesama dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-shield text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500 font-medium">+12%</span>
                <span class="text-gray-500 ml-1">dari bulan lalu</span>
            </div>
        </div>

        <!-- Total Penduduk -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Data Penduduk</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_penduduk']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-address-book text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-500 font-medium">+5%</span>
                <span class="text-gray-500 ml-1">dari bulan lalu</span>
            </div>
        </div>

        <!-- Surat Pending -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Pending</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['pending_surat']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Total: {{ number_format($stats['total_surat']) }} surat</span>
            </div>
        </div>

        <!-- Antrian Aktif -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Antrian Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['active_antrian']) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-gray-500">Total: {{ number_format($stats['total_antrian']) }} antrian</span>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Berita -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Berita</h3>
                <i class="fas fa-newspaper text-gray-400"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Berita</span>
                    <span class="font-semibold">{{ number_format($stats['total_berita']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Dipublikasi</span>
                    <span class="font-semibold text-green-600">{{ number_format($stats['published_berita']) }}</span>
                </div>
            </div>
        </div>

        <!-- Pengaduan -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pengaduan</h3>
                <i class="fas fa-comments text-gray-400"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Pengaduan</span>
                    <span class="font-semibold">{{ number_format($stats['total_pengaduan']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-semibold text-yellow-600">{{ number_format($stats['pending_pengaduan']) }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
                <i class="fas fa-bolt text-gray-400"></i>
            </div>
            <div class="space-y-2">
                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-plus text-blue-600 mr-2"></i>
                    <span class="text-gray-700">Tambah Pengguna</span>
                </button>
                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-file-plus text-green-600 mr-2"></i>
                    <span class="text-gray-700">Buat Berita</span>
                </button>
                <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                    <span class="text-gray-700">Lihat Laporan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-800 font-medium">Surat Keterangan Domisili baru diajukan</p>
                    <p class="text-gray-500 text-sm">oleh Ahmad Fauzi - 5 menit yang lalu</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-green-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-800 font-medium">Pengguna baru terdaftar</p>
                    <p class="text-gray-500 text-sm">Siti Nurhaliza - 15 menit yang lalu</p>
                </div>
            </div>
            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-yellow-600"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-800 font-medium">Pengaduan baru diterima</p>
                    <p class="text-gray-500 text-sm">tentang pelayanan - 30 menit yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection