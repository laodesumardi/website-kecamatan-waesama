<?php $__env->startSection('title', 'Detail Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.berita.index')); ?>" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Berita</h1>
                <p class="text-gray-600"><?php echo e($berita->judul); ?></p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('admin.berita.edit', $berita)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <?php if($berita->status === 'Published'): ?>
                <a href="<?php echo e(route('public.berita.detail', $berita->slug)); ?>" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Lihat Publik</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <?php if($berita->gambar): ?>
                    <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" alt="<?php echo e($berita->judul); ?>" class="w-full h-64 object-cover">
                <?php endif; ?>
                
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex items-center space-x-3 mb-4">
                        <?php if($berita->status === 'Published'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Published
                            </span>
                        <?php elseif($berita->status === 'Draft'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-edit mr-1"></i> Draft
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-archive mr-1"></i> Archived
                            </span>
                        <?php endif; ?>
                        
                        <?php if($berita->is_featured): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-1"></i> Featured
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo e($berita->judul); ?></h1>
                    
                    <!-- Meta Info -->
                    <div class="flex items-center space-x-6 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user"></i>
                            <span><?php echo e($berita->author->name); ?></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar"></i>
                            <span><?php echo e($berita->created_at->format('d M Y')); ?></span>
                        </div>
                        <?php if($berita->published_at): ?>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-globe"></i>
                                <span>Dipublikasi <?php echo e($berita->published_at->format('d M Y H:i')); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-eye"></i>
                            <span><?php echo e(number_format($berita->views)); ?> views</span>
                        </div>
                    </div>
                    
                    <!-- Excerpt -->
                    <?php if($berita->excerpt): ?>
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <p class="text-gray-700 font-medium"><?php echo e($berita->excerpt); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Content -->
                    <div class="prose max-w-none">
                        <?php echo nl2br(e($berita->konten)); ?>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="<?php echo e(route('admin.berita.edit', $berita)); ?>" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                        <i class="fas fa-edit mr-2"></i>Edit Berita
                    </a>
                    
                    <?php if($berita->status !== 'Published'): ?>
                        <form action="<?php echo e(route('admin.berita.update', $berita)); ?>" method="POST" class="w-full">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="judul" value="<?php echo e($berita->judul); ?>">
                            <input type="hidden" name="excerpt" value="<?php echo e($berita->excerpt); ?>">
                            <input type="hidden" name="konten" value="<?php echo e($berita->konten); ?>">
                            <input type="hidden" name="status" value="Published">
                            <input type="hidden" name="is_featured" value="<?php echo e($berita->is_featured ? '1' : '0'); ?>">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-globe mr-2"></i>Publikasikan
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('public.berita.detail', $berita->slug)); ?>" target="_blank" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center block">
                            <i class="fas fa-external-link-alt mr-2"></i>Lihat Publik
                        </a>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('admin.berita.destroy', $berita)); ?>" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Article Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Artikel</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Slug:</span>
                        <span class="text-gray-900 font-mono text-xs"><?php echo e($berita->slug); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="text-gray-900">#<?php echo e($berita->id); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat:</span>
                        <span class="text-gray-900"><?php echo e($berita->created_at->format('d M Y H:i')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diperbarui:</span>
                        <span class="text-gray-900"><?php echo e($berita->updated_at->format('d M Y H:i')); ?></span>
                    </div>
                    <?php if($berita->published_at): ?>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dipublikasi:</span>
                            <span class="text-gray-900"><?php echo e($berita->published_at->format('d M Y H:i')); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Views:</span>
                        <span class="text-gray-900 font-semibold"><?php echo e(number_format($berita->views)); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- SEO Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">SEO Preview</h3>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="text-blue-600 text-lg font-medium mb-1"><?php echo e($berita->judul); ?></div>
                    <div class="text-green-600 text-sm mb-2"><?php echo e(url('/berita/' . $berita->slug)); ?></div>
                    <div class="text-gray-600 text-sm"><?php echo e($berita->excerpt ?: Str::limit(strip_tags($berita->konten), 150)); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\berita\show.blade.php ENDPATH**/ ?>