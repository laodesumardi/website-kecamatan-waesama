@extends('layouts.main')

@section('title', 'Data Penduduk')

@section('sidebar-menu')
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="nav-item text-gray-700 hover:text-white">
        <i class="fas fa-tachometer-alt"></i>
        <span class="nav-text">Dashboard</span>
    </a>
    
    <!-- Data Penduduk -->
    <a href="{{ route('admin.penduduk.index') }}" class="nav-item active text-white">
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
    <a href="{{ route('admin.berita.index') }}" class="nav-item text-gray-700 hover:text-white">
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
@endsection

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Penduduk</h1>
        <p class="text-gray-600">Kelola data penduduk Kecamatan Waesama</p>
    </div>

    <!-- Action Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <form method="GET" action="{{ route('admin.penduduk.index') }}" class="flex gap-2">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari NIK, nama, atau alamat..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Filter & Add Button -->
            <div class="flex gap-2">
                <!-- Status Filter -->
                <form method="GET" action="{{ route('admin.penduduk.index') }}" class="flex gap-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="Tetap" {{ request('status') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="Pindah" {{ request('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="Meninggal" {{ request('status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </form>
                
                <!-- Add Button -->
                <a href="{{ route('admin.penduduk.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Penduduk
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penduduk as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->nik }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500">{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : $item->jenis_kelamin) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div>{{ $item->alamat }}</div>
                                <div class="text-gray-500">RT {{ $item->rt }}/RW {{ $item->rw }}, {{ $item->desa_kelurahan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($item->status_penduduk == 'Tetap') bg-green-100 text-green-800
                                    @elseif($item->status_penduduk == 'Pindah') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $item->status_penduduk }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.penduduk.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.penduduk.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.penduduk.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada data penduduk</p>
                                    <p class="text-sm">Silakan tambah data penduduk baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($penduduk->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $penduduk->links() }}
            </div>
        @endif
    </div>
</div>
@endsection