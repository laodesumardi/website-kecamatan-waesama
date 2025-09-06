<?php if($berita->count() > 0): ?>
    <?php $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="news-card bg-white rounded-xl overflow-hidden fade-in">
            <div class="md:flex">
                <?php if($item->gambar): ?>
                    <div class="md:w-1/3">
                        <img src="<?php echo e(asset('storage/' . $item->gambar)); ?>" alt="<?php echo e($item->judul); ?>" class="w-full h-48 md:h-full object-cover">
                    </div>
                <?php endif; ?>

                <div class="p-6 <?php echo e($item->gambar ? 'md:w-2/3' : 'w-full'); ?>">
                    <div class="flex items-center space-x-4 mb-3">
                        <?php if($item->is_featured): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        <?php endif; ?>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?php echo e($item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y')); ?>

                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-user mr-1"></i>
                            <?php echo e($item->author->name ?? 'Admin'); ?>

                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-eye mr-1"></i>
                            <?php echo e(number_format($item->views ?? 0)); ?>

                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                        <a href="<?php echo e(route('public.berita.detail', $item->slug)); ?>"><?php echo e($item->judul); ?></a>
                    </h2>

                    <?php if($item->excerpt): ?>
                        <p class="text-gray-600 mb-4"><?php echo e($item->excerpt); ?></p>
                    <?php else: ?>
                        <p class="text-gray-600 mb-4"><?php echo e(Str::limit(strip_tags($item->konten), 150)); ?></p>
                    <?php endif; ?>

                    <a href="<?php echo e(route('public.berita.detail', $item->slug)); ?>" class="inline-flex items-center text-primary-900 hover:text-primary-800 font-medium transition-colors">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada berita ditemukan</h3>
        <p class="text-gray-500">Coba gunakan kata kunci yang berbeda atau hapus filter pencarian.</p>
    </div>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\public\partials\berita-grid.blade.php ENDPATH**/ ?>