@extends('layouts.main')

@section('title', 'Dashboard Admin')



@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#001d3d] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-primary-100">Kelola sistem informasi Kantor Camat Waesama dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-shield text-6xl text-primary-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Users -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm font-medium">Total Pengguna</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($stats['total_users']) }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <i class="fas fa-arrow-up text-green-400 mr-1"></i>
            <span class="text-green-400 font-medium">+12%</span>
            <span class="text-gray-300 ml-1">dari bulan lalu</span>
        </div>
    </div>

    <!-- Total Penduduk -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm font-medium">Data Penduduk</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($stats['total_penduduk']) }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-address-book text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <i class="fas fa-arrow-up text-green-400 mr-1"></i>
            <span class="text-green-400 font-medium">+5%</span>
            <span class="text-gray-300 ml-1">dari bulan lalu</span>
        </div>
    </div>

    <!-- Surat Pending -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm font-medium">Surat Pending</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($stats['pending_surat']) }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-300">
            Total: {{ number_format($stats['total_surat']) }} surat
        </div>
    </div>

    <!-- Antrian Aktif -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-300 text-sm font-medium">Antrian Aktif</p>
                <p class="text-3xl font-bold text-white mt-1">{{ number_format($stats['active_antrian']) }}</p>
            </div>
            <div class="w-12 h-12 bg-violet-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-gray-300">
            Total: {{ number_format($stats['total_antrian']) }} antrian
        </div>
    </div>
</div>


<!-- Additional Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <!-- Berita -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Berita</h3>
            <i class="fas fa-newspaper text-yellow-400"></i>
        </div>
        <div class="space-y-3 text-white">
            <div class="flex justify-between">
                <span>Total Berita</span>
                <span class="font-semibold">{{ number_format($stats['total_berita']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-300">Dipublikasi</span>
                <span class="font-semibold text-emerald-400">{{ number_format($stats['published_berita']) }}</span>
            </div>
        </div>
    </div>

    <!-- Pengaduan -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Pengaduan</h3>
            <i class="fas fa-comments text-yellow-400"></i>
        </div>
        <div class="space-y-3 text-white">
            <div class="flex justify-between">
                <span>Total Pengaduan</span>
                <span class="font-semibold">{{ number_format($stats['total_pengaduan']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-300">Pending</span>
                <span class="font-semibold text-amber-400">{{ number_format($stats['pending_pengaduan']) }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-[#001d3d] rounded-xl p-6 card-shadow border border-[#001d3d]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Aksi Cepat</h3>
            <i class="fas fa-bolt text-yellow-400"></i>
        </div>
        <div class="space-y-2 text-white">
            <a href="{{ route('admin.user.create') }}"
               class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#003566] transition-colors block">
                <i class="fas fa-plus text-yellow-400 mr-2"></i>
                <span>Tambah Pengguna</span>
            </a>
            <a href="{{ route('admin.berita.create') }}"
               class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#003566] transition-colors block">
                <i class="fas fa-file-plus text-emerald-400 mr-2"></i>
                <span>Buat Berita</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}"
               class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#003566] transition-colors block">
                <i class="fas fa-chart-line text-violet-400 mr-2"></i>
                <span>Lihat Laporan</span>
            </a>
            <a href="{{ route('admin.antrian.dashboard') }}"
               class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#003566] transition-colors block">
                <i class="fas fa-chart-bar text-indigo-400 mr-2"></i>
                <span>Dashboard Antrian</span>
            </a>
        </div>
    </div>
</div>
>
</div>

<!-- Recent Activities -->
<div class="bg-[#001d3d] rounded-xl p-6 card-shadow">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-white">Aktivitas Terbaru</h3>
        <a href="{{ route('admin.pengaduan.index') }}"
           class="text-amber-400 hover:text-amber-300 text-sm font-medium transition-colors">
           Lihat Semua
        </a>
    </div>
    <div class="space-y-4">
        <!-- Item 1 -->
        <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-[#003566] transition-colors">
            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-file-alt text-amber-400"></i>
            </div>
            <div class="flex-1">
                <p class="text-white font-medium">Surat Keterangan Domisili baru diajukan</p>
                <p class="text-gray-300 text-sm">oleh Ahmad Fauzi - 5 menit yang lalu</p>
            </div>
        </div>
        <!-- Item 2 -->
        <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-[#003566] transition-colors">
            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-emerald-400"></i>
            </div>
            <div class="flex-1">
                <p class="text-white font-medium">Pengguna baru terdaftar</p>
                <p class="text-gray-300 text-sm">Siti Nurhaliza - 15 menit yang lalu</p>
            </div>
        </div>
        <!-- Item 3 -->
        <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-[#003566] transition-colors">
            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-comments text-amber-400"></i>
            </div>
            <div class="flex-1">
                <p class="text-white font-medium">Pengaduan baru diterima</p>
                <p class="text-gray-300 text-sm">tentang pelayanan - 30 menit yang lalu</p>
            </div>
        </div>
    </div>
</div>

@endsection