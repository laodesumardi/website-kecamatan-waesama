<?php $__env->startSection('title', 'Ajukan Pengaduan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('warga.pengaduan.index')); ?>" class="text-primary-600 hover:text-primary-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ajukan Pengaduan</h1>
                <p class="text-gray-600 mt-2">Sampaikan keluhan atau saran Anda kepada kami</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="<?php echo e(route('warga.pengaduan.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <!-- Judul Pengaduan -->
            <div class="mb-6">
                <label for="judul_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Pengaduan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul_pengaduan" name="judul_pengaduan" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       placeholder="Masukkan judul pengaduan"
                       value="<?php echo e(old('judul_pengaduan')); ?>" required>
                <?php $__errorArgs = ['judul_pengaduan'];
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

            <!-- Kategori -->
            <div class="mb-6">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="kategori" name="kategori" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Infrastruktur" <?php echo e(old('kategori') == 'Infrastruktur' ? 'selected' : ''); ?>>Infrastruktur</option>
                    <option value="Pelayanan Publik" <?php echo e(old('kategori') == 'Pelayanan Publik' ? 'selected' : ''); ?>>Pelayanan Publik</option>
                    <option value="Keamanan" <?php echo e(old('kategori') == 'Keamanan' ? 'selected' : ''); ?>>Keamanan</option>
                    <option value="Kebersihan" <?php echo e(old('kategori') == 'Kebersihan' ? 'selected' : ''); ?>>Kebersihan</option>
                    <option value="Administrasi" <?php echo e(old('kategori') == 'Administrasi' ? 'selected' : ''); ?>>Administrasi</option>
                    <option value="Lainnya" <?php echo e(old('kategori') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                </select>
                <?php $__errorArgs = ['kategori'];
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

            <!-- Prioritas -->
            <div class="mb-6">
                <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">
                    Prioritas <span class="text-red-500">*</span>
                </label>
                <select id="prioritas" name="prioritas" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                    <option value="">Pilih Prioritas</option>
                    <option value="Rendah" <?php echo e(old('prioritas') == 'Rendah' ? 'selected' : ''); ?>>Rendah</option>
                    <option value="Sedang" <?php echo e(old('prioritas') == 'Sedang' ? 'selected' : ''); ?>>Sedang</option>
                    <option value="Tinggi" <?php echo e(old('prioritas') == 'Tinggi' ? 'selected' : ''); ?>>Tinggi</option>
                    <option value="Mendesak" <?php echo e(old('prioritas') == 'Mendesak' ? 'selected' : ''); ?>>Mendesak</option>
                </select>
                <?php $__errorArgs = ['prioritas'];
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

            <!-- Isi Pengaduan -->
            <div class="mb-6">
                <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Pengaduan <span class="text-red-500">*</span>
                </label>
                <textarea id="isi_pengaduan" name="isi_pengaduan" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                          placeholder="Jelaskan detail pengaduan Anda..." required><?php echo e(old('isi_pengaduan')); ?></textarea>
                <?php $__errorArgs = ['isi_pengaduan'];
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

            <!-- Lampiran -->
            <div class="mb-6">
                <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran (Opsional)
                </label>
                <input type="file" id="lampiran" name="lampiran" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, PDF, DOC, DOCX. Maksimal 2MB.</p>
                <?php $__errorArgs = ['lampiran'];
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

            <!-- Information Box -->
            <div class="mb-6 p-4 bg-primary-50 border border-primary-200 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-primary-500 mt-1 mr-3"></i>
                    <div class="text-sm text-primary-700">
                        <p class="font-medium mb-1">Informasi Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pengaduan akan diproses dalam 1-3 hari kerja</li>
                            <li>Anda akan mendapat notifikasi melalui email untuk setiap update status</li>
                            <li>Pastikan data yang diisi sudah benar dan lengkap</li>
                            <li>Untuk pengaduan mendesak, silakan hubungi kantor langsung</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pengaduan
                </button>
                <a href="<?php echo e(route('warga.pengaduan.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\warga\pengaduan\create.blade.php ENDPATH**/ ?>