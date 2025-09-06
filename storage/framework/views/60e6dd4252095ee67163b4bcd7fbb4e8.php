<?php $__env->startSection('content'); ?>
<div class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold" style="color: #001d3d;">Berita Terbaru</h1>
                <p class="mt-2 text-gray-600">Informasi dan update terkini dari Kantor Camat</p>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <?php if($news->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="admin-card hover:shadow-lg transition-all duration-300">
                    <?php if($item->image): ?>
                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="<?php echo e($item->title); ?>" class="w-full h-48 object-cover rounded-t-lg">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 rounded-t-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2" style="color: #001d3d;"><?php echo e($item->title); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo e(Str::limit(strip_tags($item->content), 150)); ?></p>
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                <span><?php echo e($item->published_at->format('d M Y')); ?></span>
                                <?php if($item->author): ?>
                                    <span class="ml-2">• <?php echo e($item->author); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('news.show', $item->id)); ?>" class="text-sm font-medium hover:underline" style="color: #001d3d;">Baca Selengkapnya</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                <?php echo e($news->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada berita</h3>
                <p class="mt-1 text-sm text-gray-500">Berita akan ditampilkan di sini setelah admin menambahkannya.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Back to Home -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="text-center">
            <a href="<?php echo e(route('welcome')); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\news\index.blade.php ENDPATH**/ ?>