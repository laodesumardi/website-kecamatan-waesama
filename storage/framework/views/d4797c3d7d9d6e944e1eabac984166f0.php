<?php $__env->startSection('title', 'Edit Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="<?php echo e(route('admin.berita.index')); ?>" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Berita</h1>
            <p class="text-gray-600"><?php echo e($berita->judul); ?></p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm">
        <form action="<?php echo e(route('admin.berita.update', $berita)); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                        <input type="text" name="judul" id="judul" value="<?php echo e(old('judul', $berita->judul)); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="Masukkan judul berita" required>
                        <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                        <textarea name="excerpt" id="excerpt" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Ringkasan singkat berita (opsional)"><?php echo e(old('excerpt', $berita->excerpt)); ?></textarea>
                        <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Konten -->
                    <div>
                        <label for="konten" class="block text-sm font-medium text-gray-700 mb-2">Konten Berita *</label>
                        <textarea name="konten" id="konten" rows="12" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['konten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  placeholder="Tulis konten berita lengkap di sini..." required><?php echo e(old('konten', $berita->konten)); ?></textarea>
                        <?php $__errorArgs = ['konten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Current Image -->
                    <?php if($berita->gambar): ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                            <img src="<?php echo e(asset('storage/' . $berita->gambar)); ?>" alt="<?php echo e($berita->judul); ?>" class="w-full h-32 object-cover rounded-lg">
                        </div>
                    <?php endif; ?>

                    <!-- Gambar -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2"><?php echo e($berita->gambar ? 'Ganti Gambar' : 'Gambar Berita'); ?></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="gambar" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload gambar</span>
                                        <input id="gambar" name="gambar" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                            </div>
                        </div>
                        <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="Draft" <?php echo e(old('status', $berita->status) === 'Draft' ? 'selected' : ''); ?>>Draft</option>
                            <option value="Published" <?php echo e(old('status', $berita->status) === 'Published' ? 'selected' : ''); ?>>Published</option>
                            <option value="Archived" <?php echo e(old('status', $berita->status) === 'Archived' ? 'selected' : ''); ?>>Archived</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Featured -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                   <?php echo e(old('is_featured', $berita->is_featured) ? 'checked' : ''); ?>>
                            <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                                <span class="font-medium">Berita Unggulan</span>
                                <p class="text-gray-500 text-xs">Tampilkan di halaman utama</p>
                            </label>
                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi</h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Penulis:</span>
                                <span><?php echo e($berita->author->name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Dibuat:</span>
                                <span><?php echo e($berita->created_at->format('d M Y H:i')); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Views:</span>
                                <span><?php echo e(number_format($berita->views)); ?></span>
                            </div>
                            <?php if($berita->published_at): ?>
                                <div class="flex justify-between">
                                    <span>Dipublikasi:</span>
                                    <span><?php echo e($berita->published_at->format('d M Y H:i')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>Update Berita
                        </button>
                        <a href="<?php echo e(route('admin.berita.show', $berita)); ?>" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                            <i class="fas fa-eye mr-2"></i>Lihat Berita
                        </a>
                        <a href="<?php echo e(route('admin.berita.index')); ?>" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Preview image
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here
            // Image selected
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\berita\edit.blade.php ENDPATH**/ ?>