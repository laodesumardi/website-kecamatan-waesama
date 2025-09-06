<?php $__env->startSection('title', 'Manajemen Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Berita</h1>
            <p class="text-gray-600">Kelola berita dan pengumuman untuk website</p>
        </div>
        <a href="<?php echo e(route('admin.berita.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Tambah Berita</span>
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <!-- Berita Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if($item->gambar): ?>
                                        <img class="h-12 w-12 rounded-lg object-cover mr-4" src="<?php echo e(asset('storage/' . $item->gambar)); ?>" alt="<?php echo e($item->judul); ?>">
                                    <?php else: ?>
                                        <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo e(Str::limit($item->judul, 50)); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e(Str::limit($item->excerpt, 80)); ?></div>
                                        <?php if($item->is_featured): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                <i class="fas fa-star mr-1"></i> Featured
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($item->status === 'Published'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Published
                                    </span>
                                <?php elseif($item->status === 'Draft'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-edit mr-1"></i> Draft
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-archive mr-1"></i> Archived
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($item->author->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <i class="fas fa-eye text-gray-400 mr-1"></i>
                                    <?php echo e(number_format($item->views)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($item->created_at->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo e(route('admin.berita.show', $item)); ?>" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.berita.edit', $item)); ?>" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.berita.destroy', $item)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-newspaper text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 text-lg">Belum ada berita</p>
                                    <p class="text-gray-400 text-sm">Mulai dengan menambahkan berita pertama</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($berita->hasPages()): ?>
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <?php echo e($berita->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\berita\index.blade.php ENDPATH**/ ?>