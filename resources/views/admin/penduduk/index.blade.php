@extends('layouts.main')

@section('title', 'Data Penduduk')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Penduduk</h1>
        <p class="text-gray-600">Kelola data penduduk Kecamatan Waesama</p>
    </div>

    <!-- Action Bar -->
    <div class="bg-[#001d3d] rounded-lg shadow-sm p-4 mb-6">
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

                <!-- Import Excel Button -->
                <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-file-excel"></i>
                    Import Excel
                </button>

                <!-- Add Button -->
                <a href="{{ route('admin.penduduk.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    Tambah Penduduk
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table with Enhanced Scroll -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Scroll Hint -->
        <div class="bg-blue-50 border-b border-blue-100 px-4 py-3 flex items-center justify-between text-sm">
            <div class="flex items-center text-blue-700">
                <i class="fas fa-arrows-alt-h mr-2"></i>
                <span>Scroll horizontal untuk melihat semua kolom • Scroll vertikal untuk navigasi data</span>
            </div>
            <div class="text-blue-600 text-xs font-medium">
                Total: {{ $penduduk->total() }} data
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-wrapper">
            <div class="table-container" id="tableContainer">
                <table class="data-table">
                    <thead class="table-header">
                        <tr>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-id-card"></i>
                                    <span>NIK</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-user"></i>
                                    <span>Nama Lengkap</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-birthday-cake"></i>
                                    <span>Tempat, Tgl Lahir</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-venus-mars"></i>
                                    <span>Jenis Kelamin</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Alamat</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-home"></i>
                                    <span>RT/RW</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-mosque"></i>
                                    <span>Agama</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-briefcase"></i>
                                    <span>Pekerjaan</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell">
                                <div class="header-content">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="table-cell header-cell action-column">
                                <div class="header-content">
                                    <i class="fas fa-cogs"></i>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @forelse($penduduk as $item)
                            <tr class="table-row">
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <span class="font-mono text-sm">{{ $item->nik }}</span>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <div class="font-medium text-gray-900">{{ $item->nama_lengkap }}</div>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <div class="text-sm">{{ $item->tempat_lahir }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->tanggal_lahir->format('d/m/Y') }}</div>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <div class="flex items-center gap-2">
                                            <i class="fas {{ $item->jenis_kelamin == 'L' ? 'fa-mars text-blue-500' : 'fa-venus text-pink-500' }}"></i>
                                            <span>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <div class="text-sm" title="{{ $item->alamat }}">{{ Str::limit($item->alamat, 40) }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->desa_kelurahan }}</div>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <span class="text-sm">RT {{ $item->rt }}/RW {{ $item->rw }}</span>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <span class="text-sm">{{ $item->agama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <span class="text-sm">{{ $item->pekerjaan ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="table-cell data-cell">
                                    <div class="cell-content">
                                        <span class="status-badge status-{{ strtolower($item->status_penduduk) }}">
                                            <i class="fas {{ $item->status_penduduk == 'Tetap' ? 'fa-check-circle' : ($item->status_penduduk == 'Pindah' ? 'fa-exchange-alt' : 'fa-times-circle') }}"></i>
                                            {{ $item->status_penduduk }}
                                        </span>
                                    </div>
                                </td>
                                <td class="table-cell data-cell action-column">
                                    <div class="cell-content">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.penduduk.show', $item) }}"
                                               class="action-btn view-btn" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.penduduk.edit', $item) }}"
                                               class="action-btn edit-btn" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.penduduk.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete-btn" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="empty-state">
                                    <div class="empty-content">
                                        <div class="empty-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h3>Tidak ada data penduduk</h3>
                                        <p>Silakan tambah data penduduk baru atau ubah filter pencarian</p>
                                        <a href="{{ route('admin.penduduk.create') }}" class="empty-action">
                                            <i class="fas fa-plus"></i>
                                            Tambah Penduduk Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($penduduk->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <span>Menampilkan {{ $penduduk->firstItem() ?? 0 }} sampai {{ $penduduk->lastItem() ?? 0 }} dari {{ $penduduk->total() }} data</span>
                </div>
                <div class="pagination-controls">
                    {{ $penduduk->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Import Excel Modal -->
<div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Import Data Penduduk dari Excel</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('admin.penduduk.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Excel</label>
                    <input type="file" name="excel_file" accept=".xlsx,.xls" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format yang didukung: .xlsx, .xls (Maksimal 10MB)</p>
                </div>

                <div class="mb-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Format Excel yang diperlukan:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Kolom A: NIK (16 digit)</li>
                            <li>• Kolom B: Nama Lengkap</li>
                            <li>• Kolom C: Tempat Lahir</li>
                            <li>• Kolom D: Tanggal Lahir (YYYY-MM-DD)</li>
                            <li>• Kolom E: Jenis Kelamin (L/P)</li>
                            <li>• Kolom F: Alamat</li>
                            <li>• Kolom G: RT</li>
                            <li>• Kolom H: RW</li>
                            <li>• Kolom I: Agama</li>
                            <li>• Kolom J: Status Perkawinan</li>
                            <li>• Kolom K: Pekerjaan</li>
                            <li>• Kolom L: Kewarganegaraan</li>
                        </ul>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-upload mr-2"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Table Wrapper Styles */
.table-wrapper {
    position: relative;
    width: 100%;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Table Container dengan Scroll */
.table-container {
    width: 100%;
    max-height: 70vh;
    overflow: auto;
    position: relative;
    border: 1px solid #e5e7eb;
    background: white;

    /* Custom Scrollbar */
    scrollbar-width: thin;
    scrollbar-color: #001d3d #f8fafc;
}

/* Webkit Scrollbar Styling */
.table-container::-webkit-scrollbar {
    width: 14px;
    height: 14px;
}

.table-container::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 7px;
}

.table-container::-webkit-scrollbar-thumb {
    background: linear-gradient(45deg, #001d3d, #003566);
    border-radius: 7px;
    border: 2px solid #f8fafc;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(45deg, #003566, #0077b6);
}

.table-container::-webkit-scrollbar-corner {
    background: #f8fafc;
}

/* Table Styles */
.data-table {
    width: 100%;
    min-width: 1400px; /* Force horizontal scroll */
    border-collapse: collapse;
    table-layout: fixed;
}

/* Header Styles */
.table-header {
    background: linear-gradient(135deg, #001d3d, #003566);
    position: sticky;
    top: 0;
    z-index: 20;
}

.header-cell {
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 0.75rem;
    border-bottom: 2px solid #0077b6;
    position: relative;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
}

.header-content i {
    font-size: 0.875rem;
    opacity: 0.9;
}

/* Cell Styles */
.table-cell {
    border-right: 1px solid #f3f4f6;
    vertical-align: top;
}

.data-cell {
    padding: 0.75rem;
    background: white;
    transition: background-color 0.15s ease;
}

.cell-content {
    min-height: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Column Widths */
.table-cell:nth-child(1) { width: 140px; } /* NIK */
.table-cell:nth-child(2) { width: 180px; } /* Nama */
.table-cell:nth-child(3) { width: 150px; } /* Tempat/Tanggal Lahir */
.table-cell:nth-child(4) { width: 120px; } /* Jenis Kelamin */
.table-cell:nth-child(5) { width: 200px; } /* Alamat */
.table-cell:nth-child(6) { width: 100px; } /* RT/RW */
.table-cell:nth-child(7) { width: 100px; } /* Agama */
.table-cell:nth-child(8) { width: 150px; } /* Pekerjaan */
.table-cell:nth-child(9) { width: 120px; } /* Status */
.table-cell:nth-child(10) { width: 130px; } /* Aksi */

/* Action Column Sticky */
.action-column {
    position: sticky;
    right: 0;
    background: inherit;
    box-shadow: -4px 0 8px rgba(0, 0, 0, 0.1);
    z-index: 10;
}

/* Row Hover Effects */
.table-row:hover .data-cell {
    background-color: #f0f9ff;
}

.table-row:hover .action-column {
    background-color: #f0f9ff;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid;
}

.status-tetap {
    background-color: #dcfce7;
    color: #166534;
    border-color: #bbf7d0;
}

.status-pindah {
    background-color: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

.status-meninggal {
    background-color: #fee2e2;
    color: #991b1b;
    border-color: #fecaca;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.view-btn {
    color: #2563eb;
    background-color: #dbeafe;
}

.view-btn:hover {
    background-color: #bfdbfe;
    transform: translateY(-1px);
}

.edit-btn {
    color: #d97706;
    background-color: #fed7aa;
}

.edit-btn:hover {
    background-color: #fdba74;
    transform: translateY(-1px);
}

.delete-btn {
    color: #dc2626;
    background-color: #fecaca;
}

.delete-btn:hover {
    background-color: #fca5a5;
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    padding: 3rem 1.5rem;
    text-align: center;
}

.empty-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.empty-icon {
    width: 4rem;
    height: 4rem;
    background-color: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.empty-icon i {
    font-size: 1.5rem;
    color: #9ca3af;
}

.empty-content h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
}

.empty-content p {
    color: #6b7280;
    margin-bottom: 1rem;
}

.empty-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background-color: #001d3d;
    color: white;
    border-radius: 0.5rem;
    text-decoration: none;
    transition: background-color 0.15s ease;
}

.empty-action:hover {
    background-color: #003566;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: between;
    padding: 1rem 1.5rem;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.pagination-info {
    font-size: 0.875rem;
    color: #374151;
}

.pagination-controls {
    margin-left: auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-container {
        max-height: 60vh;
    }

    .data-table {
        min-width: 1200px;
    }

    .header-cell,
    .data-cell {
        padding: 0.5rem;
    }

    .pagination-wrapper {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .pagination-info {
        order: 2;
    }

    .pagination-controls {
        order: 1;
        margin-left: 0;
    }
}

@media (max-width: 480px) {
    .table-container {
        max-height: 50vh;
    }

    .data-table {
        min-width: 1000px;
    }
}

/* Smooth Scroll Behavior */
.table-container {
    scroll-behavior: smooth;
}

/* Focus States */
.action-btn:focus {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}

/* Loading State Animation */
@keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

.loading-row {
    background: linear-gradient(90deg, #f0f0f0 0px, #e0e0e0 40px, #f0f0f0 80px);
    background-size: 200px;
    animation: shimmer 1.5s infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableContainer = document.getElementById('tableContainer');

    // Enhanced scroll functionality
    if (tableContainer) {
        // Add scroll event listener for debugging and potential enhancements
        tableContainer.addEventListener('scroll', function() {
            const scrollLeft = this.scrollLeft;
            const scrollTop = this.scrollTop;

            // You can add scroll position indicators here if needed
            // Scroll position tracking
        });

        // Add touch support for mobile devices
        let isScrolling = false;

        tableContainer.addEventListener('touchstart', function() {
            isScrolling = true;
        });

        tableContainer.addEventListener('touchend', function() {
            isScrolling = false;
        });

        // Keyboard navigation support
        tableContainer.addEventListener('keydown', function(e) {
            const scrollAmount = 100;

            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.scrollBy({ top: -scrollAmount, behavior: 'smooth' });
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    this.scrollBy({ top: scrollAmount, behavior: 'smooth' });
                    break;
            }
        });

        // Make container focusable for keyboard navigation
        tableContainer.setAttribute('tabindex', '0');

        // Log table dimensions for debugging
        const table = tableContainer.querySelector('.data-table');
        if (table) {
            // Table setup complete
        }
    }
});
</script>

@endsection
