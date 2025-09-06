<?php $__env->startSection('title', 'Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Berita Terbaru</h1>
            <p class="text-gray-600">Informasi dan pengumuman terbaru dari Kantor Camat Waesama</p>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <form id="searchForm" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           name="search"
                           value="<?php echo e(request('search')); ?>"
                           placeholder="Cari berita..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <select id="categorySelect" 
                        name="kategori"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    <option value="pengumuman" <?php echo e(request('kategori') == 'pengumuman' ? 'selected' : ''); ?>>Pengumuman</option>
                    <option value="kegiatan" <?php echo e(request('kategori') == 'kegiatan' ? 'selected' : ''); ?>>Kegiatan</option>
                    <option value="pelayanan" <?php echo e(request('kategori') == 'pelayanan' ? 'selected' : ''); ?>>Pelayanan</option>
                    <option value="informasi" <?php echo e(request('kategori') == 'informasi' ? 'selected' : ''); ?>>Informasi</option>
                </select>
                <button type="button" 
                        id="filterButton"
                        class="px-4 py-2 bg-primary-900 text-white rounded-lg hover:bg-primary-800 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <button type="button" 
                        id="resetButton"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-undo mr-2"></i>Reset
                </button>
            </div>
        </form>
    </div>

    <!-- Berita Utama -->
    <?php if(isset($featuredNews) && $featuredNews): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="<?php echo e($featuredNews->gambar ? asset('storage/' . $featuredNews->gambar) : 'https://via.placeholder.com/600x400?text=Berita+Utama'); ?>" 
                     alt="<?php echo e($featuredNews->judul); ?>" 
                     class="w-full h-64 md:h-full object-cover">
            </div>
            <div class="md:w-1/2 p-6">
                <div class="flex items-center mb-3">
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Berita Utama
                    </span>
                    <span class="text-gray-500 text-sm ml-3">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        <?php echo e($featuredNews->created_at->format('d M Y')); ?>

                    </span>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                    <?php echo e($featuredNews->judul); ?>

                </h2>
                <p class="text-gray-600 mb-4 line-clamp-3">
                    <?php echo e(Str::limit(strip_tags($featuredNews->konten), 200)); ?>

                </p>
                <a href="<?php echo e(route('public.berita.detail', $featuredNews->slug)); ?>" 
                   class="inline-flex items-center text-primary-900 hover:text-primary-800 font-medium">
                    Baca Selengkapnya
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Grid Berita -->
    <div id="newsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $berita ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative">
                <img src="<?php echo e($item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/400x250?text=Berita'); ?>" 
                     alt="<?php echo e($item->judul); ?>" 
                     class="w-full h-48 object-cover">
                <div class="absolute top-3 left-3">
                    <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        <?php echo e(ucfirst($item->kategori ?? 'Umum')); ?>

                    </span>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-gray-500 text-sm mb-2">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    <?php echo e($item->created_at->format('d M Y')); ?>

                    <span class="mx-2">•</span>
                    <i class="fas fa-user mr-1"></i>
                    Admin
                </div>
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                    <?php echo e($item->judul); ?>

                </h3>
                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                    <?php echo e(Str::limit(strip_tags($item->konten), 120)); ?>

                </p>
                <a href="<?php echo e(route('public.berita.detail', $item->slug)); ?>" 
                   class="inline-flex items-center text-primary-900 hover:text-primary-800 font-medium text-sm">
                    Baca Selengkapnya
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full">
            <div class="text-center py-12">
                <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Berita</h3>
                <p class="text-gray-500">Berita akan ditampilkan di sini ketika sudah tersedia.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if(isset($berita) && $berita->hasPages()): ?>
    <div class="mt-8">
        <?php echo e($berita->links()); ?>

    </div>
    <?php endif; ?>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile Responsive Improvements */
@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .flex.gap-2 button {
        width: 100%;
        justify-content: center;
    }
    
    .md\:flex {
        flex-direction: column;
    }
    
    .md\:w-1\/2 {
        width: 100%;
    }
    
    .text-2xl {
        font-size: 1.5rem;
    }
    
    .p-6 {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const filterButton = document.getElementById('filterButton');
    const resetButton = document.getElementById('resetButton');
    const newsContainer = document.getElementById('newsGrid');
    const paginationContainer = document.querySelector('.mt-8');
    let searchTimeout;

    // Function to show loading state
    function showLoading() {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = '<div class="spinner"></div>';
        newsContainer.style.position = 'relative';
        newsContainer.appendChild(loadingOverlay);
    }

    // Function to hide loading state
    function hideLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    // Function to perform search and filter
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const category = categorySelect.value;
        
        showLoading();
        
        const params = new URLSearchParams();
        if (searchTerm) params.append('search', searchTerm);
        if (category) params.append('kategori', category);
        
        fetch(`<?php echo e(route('warga.berita.index')); ?>?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                newsContainer.innerHTML = data.html;
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination || '';
                }
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
        });
    }

    // Search input with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500);
    });

    // Filter button click
    filterButton.addEventListener('click', function(e) {
        e.preventDefault();
        performSearch();
    });

    // Category select change
    categorySelect.addEventListener('change', function() {
        performSearch();
    });

    // Reset button click
    resetButton.addEventListener('click', function() {
        searchInput.value = '';
        categorySelect.value = '';
        window.location.href = '<?php echo e(route('warga.berita.index')); ?>';
    });

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('.pagination a').href;
            
            showLoading();
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    newsContainer.innerHTML = data.html;
                    if (paginationContainer) {
                        paginationContainer.innerHTML = data.pagination || '';
                    }
                    // Scroll to top of news container
                    newsContainer.scrollIntoView({ behavior: 'smooth' });
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
            });
        }
    });
    
    // Handle bookmark clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.bookmark-btn')) {
            e.preventDefault();
            const button = e.target.closest('.bookmark-btn');
            const beritaId = button.dataset.beritaId;
            const isBookmarked = button.dataset.bookmarked === 'true';
            const icon = button.querySelector('i');
            
            // Disable button during request
            button.disabled = true;
            
            fetch(`<?php echo e(url('/warga/bookmark')); ?>/${beritaId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button state
                    button.dataset.bookmarked = data.is_bookmarked;
                    
                    if (data.is_bookmarked) {
                        icon.classList.add('text-red-500');
                    } else {
                        icon.classList.remove('text-red-500');
                    }
                    
                    // Show toast message (optional)
                    showToast(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat menyimpan bookmark');
            })
            .finally(() => {
                button.disabled = false;
            });
        }
    });
    
    // Simple toast function
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity';
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\warga\berita.blade.php ENDPATH**/ ?>