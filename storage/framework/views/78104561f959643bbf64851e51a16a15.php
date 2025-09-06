<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Detail Berita
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold" style="color: #001d3d;">Detail Berita</h2>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.news.edit', $news)); ?>" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #001d3d;" 
                       onmouseover="this.style.backgroundColor='#003366'" 
                       onmouseout="this.style.backgroundColor='#001d3d'">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="<?php echo e(route('admin.news.index')); ?>" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #6b7280;" 
                       onmouseover="this.style.backgroundColor='#4b5563'" 
                       onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Info -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($news->title); ?></h1>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Oleh: <strong><?php echo e($news->author); ?></strong></span>
                                    <span>•</span>
                                    <span><?php echo e($news->created_at->format('d M Y, H:i')); ?></span>
                                    <?php if($news->published_at): ?>
                                        <span>•</span>
                                        <span>Dipublikasi: <?php echo e($news->published_at->format('d M Y, H:i')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div>
                                <?php if($news->status === 'published'): ?>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Published
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Draft
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Image -->
                    <?php if($news->image): ?>
                        <div class="mb-6">
                            <img src="<?php echo e(asset('storage/' . $news->image)); ?>" alt="<?php echo e($news->title); ?>" 
                                 class="w-full max-w-2xl mx-auto rounded-lg shadow-md">
                        </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <div class="prose max-w-none">
                        <div class="text-gray-800 leading-relaxed whitespace-pre-line"><?php echo e($news->content); ?></div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Terakhir diupdate: <?php echo e($news->updated_at->format('d M Y, H:i')); ?>

                            </div>
                            <div class="flex space-x-2">
                                <?php if($news->status === 'published'): ?>
                                    <a href="<?php echo e(route('news.show', $news)); ?>" target="_blank" 
                                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Lihat di Website
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.news.edit', $news)); ?>" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Berita
                                </a>
                                <form action="<?php echo e(route('admin.news.destroy', $news)); ?>" method="POST" class="inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Berita
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\news\show.blade.php ENDPATH**/ ?>