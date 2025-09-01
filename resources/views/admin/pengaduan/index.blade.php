@extends('layouts.admin')

@section('title', 'Pengaduan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
        <div class="flex items-center justify-center h-16 bg-blue-600">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-blue-600 font-bold text-lg">W</span>
                </div>
                <span class="text-white font-bold text-xl">Waesama</span>
            </div>
        </div>
        
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-home w-5 mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.penduduk.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-users w-5 mr-3"></i>
                    Data Penduduk
                </a>
                <a href="{{ route('admin.surat.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-file-alt w-5 mr-3"></i>
                    Layanan Surat
                </a>
                <a href="{{ route('admin.antrian.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-clock w-5 mr-3"></i>
                    Antrian
                </a>
                <a href="{{ route('admin.pengaduan.index') }}" class="flex items-center px-4 py-3 text-white bg-blue-600 rounded-lg">
                    <i class="fas fa-comments w-5 mr-3"></i>
                    Pengaduan
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="fas fa-newspaper w-5 mr-3"></i>
                    Berita
                    <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">Soon</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="fas fa-user-cog w-5 mr-3"></i>
                    Manajemen User
                    <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">Soon</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    Laporan
                    <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">Soon</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-400 rounded-lg cursor-not-allowed">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    Pengaturan
                    <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">Soon</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button class="lg:hidden text-gray-600 hover:text-gray-800" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div>
                        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                            <i class="fas fa-chevron-right text-xs"></i>
                            <span class="text-gray-800">Pengaduan</span>
                        </nav>
                        <h1 class="text-2xl font-bold text-gray-800">Pengaduan</h1>
                        <p class="text-gray-600 text-sm">Kelola pengaduan masyarakat</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-600 hover:text-gray-800">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span class="hidden md:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-6">
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nomor, nama, judul, email, telepon..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                @foreach($statusOptions as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Kategori Filter -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori" id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoriOptions as $kategori)
                                    <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Prioritas Filter -->
                        <div>
                            <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <select name="prioritas" id="prioritas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Prioritas</option>
                                @foreach($prioritasOptions as $prioritas)
                                    <option value="{{ $prioritas }}" {{ request('prioritas') == $prioritas ? 'selected' : '' }}>{{ $prioritas }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Handler Filter -->
                        <div>
                            <label for="handler" class="block text-sm font-medium text-gray-700 mb-1">Petugas</label>
                            <select name="handler" id="handler" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Petugas</option>
                                @foreach($pegawaiUsers as $pegawai)
                                    <option value="{{ $pegawai->id }}" {{ request('handler') == $pegawai->id ? 'selected' : '' }}>{{ $pegawai->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                            <a href="{{ route('admin.pengaduan.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-refresh mr-2"></i>Reset
                            </a>
                        </div>
                        <a href="{{ route('admin.pengaduan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tambah Pengaduan
                        </a>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor & Pengadu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul & Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengaduan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nomor_pengaduan }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->nama_pengadu }}</div>
                                        <div class="text-xs text-gray-400">{{ $item->phone_pengadu }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $item->judul_pengaduan }}</div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($item->kategori === 'Pelayanan') bg-blue-100 text-blue-800
                                            @elseif($item->kategori === 'Infrastruktur') bg-green-100 text-green-800
                                            @elseif($item->kategori === 'Keamanan') bg-red-100 text-red-800
                                            @elseif($item->kategori === 'Kebersihan') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $item->kategori }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($item->prioritas === 'Urgent') bg-red-100 text-red-800
                                        @elseif($item->prioritas === 'Tinggi') bg-orange-100 text-orange-800
                                        @elseif($item->prioritas === 'Sedang') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $item->prioritas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($item->status === 'Diterima') bg-blue-100 text-blue-800
                                        @elseif($item->status === 'Diproses') bg-yellow-100 text-yellow-800
                                        @elseif($item->status === 'Ditindaklanjuti') bg-purple-100 text-purple-800
                                        @elseif($item->status === 'Selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->handler ? $item->handler->name : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.pengaduan.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pengaduan.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.pengaduan.export-pdf', $item) }}" class="text-purple-600 hover:text-purple-900" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    @if($item->lampiran)
                                    <a href="{{ route('admin.pengaduan.download', $item) }}" class="text-orange-600 hover:text-orange-900" title="Download Lampiran">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @endif
                                    <form action="{{ route('admin.pengaduan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Quick Actions -->
                                    @if($item->status === 'Diterima')
                                        <form action="{{ route('admin.pengaduan.process', $item) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Proses">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada pengaduan</p>
                                    <p class="text-sm">Belum ada pengaduan yang terdaftar dalam sistem.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($pengaduan->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pengaduan->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}
</script>
@endsection