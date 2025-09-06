<?php $__env->startSection('title', 'Ajukan Surat Baru'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('warga.dashboard')); ?>" 
               class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ajukan Surat Baru</h1>
                <p class="text-gray-600">Isi formulir di bawah untuk mengajukan surat</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <form id="surat-form" action="<?php echo e(route('warga.surat.store')); ?>" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            
            <!-- Jenis Surat -->
            <div class="mb-6">
                <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Surat <span class="text-red-500">*</span>
                </label>
                <select id="jenis_surat" name="jenis_surat" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['jenis_surat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Pilih Jenis Surat</option>
                    <option value="Domisili" <?php echo e((old('jenis_surat') == 'Domisili' || $jenisSurat == 'Domisili') ? 'selected' : ''); ?>>Surat Keterangan Domisili</option>
                    <option value="SKTM" <?php echo e((old('jenis_surat') == 'SKTM' || $jenisSurat == 'SKTM') ? 'selected' : ''); ?>>Surat Keterangan Tidak Mampu</option>
                    <option value="Usaha" <?php echo e((old('jenis_surat') == 'Usaha' || $jenisSurat == 'Usaha') ? 'selected' : ''); ?>>Surat Keterangan Usaha</option>
                    <option value="Pengantar" <?php echo e((old('jenis_surat') == 'Pengantar' || $jenisSurat == 'Pengantar') ? 'selected' : ''); ?>>Surat Pengantar Nikah</option>
                    <option value="Kelahiran" <?php echo e((old('jenis_surat') == 'Kelahiran' || $jenisSurat == 'Kelahiran') ? 'selected' : ''); ?>>Surat Keterangan Kelahiran</option>
                    <option value="Kematian" <?php echo e((old('jenis_surat') == 'Kematian' || $jenisSurat == 'Kematian') ? 'selected' : ''); ?>>Surat Keterangan Kematian</option>
                    <option value="Pindah" <?php echo e((old('jenis_surat') == 'Pindah' || $jenisSurat == 'Pindah') ? 'selected' : ''); ?>>Surat Keterangan Pindah</option>
                </select>
                <?php $__errorArgs = ['jenis_surat'];
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

            <!-- Keperluan -->
            <div class="mb-6">
                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea id="keperluan" name="keperluan" rows="4" required
                          placeholder="Jelaskan keperluan surat ini..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 <?php $__errorArgs = ['keperluan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('keperluan')); ?></textarea>
                <?php $__errorArgs = ['keperluan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
            </div>

            <!-- Dynamic Fields -->
            <div id="dynamic-fields" class="space-y-4 mb-6">
                <!-- Fields will be populated by JavaScript based on selected letter type -->
            </div>

            <!-- Data Pemohon (Read-only) -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Data Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="<?php echo e(Auth::user()->name); ?>" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                        <input type="text" value="<?php echo e(Auth::user()->nik); ?>" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" value="<?php echo e(Auth::user()->alamat ?? 'Belum diisi'); ?>" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" value="<?php echo e(Auth::user()->phone ?? 'Belum diisi'); ?>" readonly
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-600">
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Data pemohon diambil dari profil Anda. Jika ada yang perlu diubah, silakan update profil terlebih dahulu.
                </p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" 
                        class="flex-1 bg-primary-900 hover:bg-primary-800 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Ajukan Surat
                </button>
                <a href="<?php echo e(route('warga.dashboard')); ?>" 
                   class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- User Data Script -->
<script id="user-data" type="application/json">
<?php echo json_encode([
    'name' => auth()->user()->name ?? '',
    'nik' => auth()->user()->nik ?? '',
    'alamat' => auth()->user()->alamat ?? '',
    'phone' => auth()->user()->phone ?? ''
]); ?>

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/surat-form.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\warga\surat\create.blade.php ENDPATH**/ ?>