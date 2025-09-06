<?php $__env->startSection('title', 'Halaman Tidak Ditemukan - 404'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Error Icon -->
            <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>

            <!-- Error Code -->
            <h1 class="text-6xl font-bold text-blue-600 mb-4">404</h1>
            
            <!-- Error Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
            
            <!-- Error Message -->
            <p class="text-gray-600 mb-8 leading-relaxed">
                <?php echo e($message ?? 'Halaman yang Anda cari tidak dapat ditemukan.'); ?>

                <?php if(isset($resource_type) && isset($resource_id)): ?>
                    <br><span class="text-sm text-gray-500"><?php echo e($resource_type); ?> dengan ID: <?php echo e($resource_id); ?></span>
                <?php endif; ?>
            </p>
            
            <!-- Search Box -->
            <div class="mb-6">
                <form action="<?php echo e(route('dashboard')); ?>" method="GET" class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Cari halaman atau fitur..."
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <button onclick="history.back()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </button>
                
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 block">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ke Dashboard
                </a>
            </div>
            
            <!-- Quick Links -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-4">Mungkin Anda mencari:</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Dashboard</a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role->name === 'Warga'): ?>
                            <a href="<?php echo e(route('warga.surat.index')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Surat</a>
                            <a href="<?php echo e(route('warga.antrian.index')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Antrian</a>
                        <?php endif; ?>
                        <?php if(in_array(auth()->user()->role->name, ['Admin', 'Pegawai'])): ?>
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Users</a>
                            <a href="<?php echo e(route('admin.berita.index')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Berita</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="<?php echo e(route('public.berita.index')); ?>" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition duration-200">Berita</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Focus on search input
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.focus();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\errors\404.blade.php ENDPATH**/ ?>