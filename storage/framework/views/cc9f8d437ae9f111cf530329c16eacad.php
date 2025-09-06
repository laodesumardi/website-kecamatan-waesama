<?php $__env->startSection('title', 'Ambil Antrian'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .time-slot {
        transition: all 0.2s ease;
    }
    .time-slot:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .time-slot.selected {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .time-slot.unavailable {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('warga.antrian.index')); ?>" 
               class="text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Ambil Antrian</h1>
                <p class="text-gray-600">Pilih waktu kunjungan yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <form action="<?php echo e(route('warga.antrian.store')); ?>" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            
            <!-- Jenis Layanan -->
            <div class="mb-6">
                <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Layanan <span class="text-red-500">*</span>
                </label>
                <select id="jenis_layanan" name="jenis_layanan" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['jenis_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Pilih Jenis Layanan</option>
                    <option value="Surat Domisili" <?php echo e(old('jenis_layanan') == 'Surat Domisili' ? 'selected' : ''); ?>>Surat Keterangan Domisili</option>
                    <option value="SKTM" <?php echo e(old('jenis_layanan') == 'SKTM' ? 'selected' : ''); ?>>Surat Keterangan Tidak Mampu</option>
                    <option value="Surat Usaha" <?php echo e(old('jenis_layanan') == 'Surat Usaha' ? 'selected' : ''); ?>>Surat Keterangan Usaha</option>
                    <option value="Surat Pengantar" <?php echo e(old('jenis_layanan') == 'Surat Pengantar' ? 'selected' : ''); ?>>Surat Pengantar</option>
                    <option value="Konsultasi" <?php echo e(old('jenis_layanan') == 'Konsultasi' ? 'selected' : ''); ?>>Konsultasi</option>
                    <option value="Lainnya" <?php echo e(old('jenis_layanan') == 'Lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                </select>
                <?php $__errorArgs = ['jenis_layanan'];
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
                          placeholder="Jelaskan keperluan kunjungan Anda..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['keperluan'];
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
            </div>

            <!-- Pilih Tanggal dan Waktu -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    Pilih Tanggal dan Waktu Kunjungan <span class="text-red-500">*</span>
                </label>
                
                <?php $__currentLoopData = $availableSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateSlot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3"><?php echo e($dateSlot['date_formatted']); ?></h3>
                        
                        <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
                            <?php $__currentLoopData = $dateSlot['slots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="time-slot cursor-pointer border-2 border-gray-200 rounded-lg p-3 text-center <?php echo e(!$slot['available'] ? 'unavailable' : ''); ?>">
                                    <input type="radio" name="slot" value="<?php echo e($dateSlot['date']); ?>|<?php echo e($slot['time']); ?>" 
                                           class="hidden" <?php echo e(!$slot['available'] ? 'disabled' : ''); ?>

                                           <?php echo e(old('slot') == $dateSlot['date'].'|'.$slot['time'] ? 'checked' : ''); ?>>
                                    <div class="text-sm font-medium"><?php echo e($slot['time']); ?></div>
                                    <?php if($slot['available']): ?>
                                        <div class="text-xs text-gray-500 mt-1"><?php echo e($slot['remaining']); ?> slot</div>
                                    <?php else: ?>
                                        <div class="text-xs text-red-500 mt-1">Penuh</div>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php $__errorArgs = ['slot'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['tanggal_kunjungan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php $__errorArgs = ['jam_kunjungan'];
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
                    <svg class="w-5 h-5 text-primary-900 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-primary-800">
                        <p class="font-medium mb-1">Informasi Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Jam pelayanan: 08:00 - 16:00 WIB (Senin - Jumat)</li>
                            <li>Istirahat: 12:00 - 13:00 WIB</li>
                            <li>Setiap slot waktu maksimal 3 orang</li>
                            <li>Harap datang 15 menit sebelum waktu yang dipilih</li>
                            <li>Bawa dokumen yang diperlukan sesuai jenis layanan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-primary-900 hover:bg-primary-800 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Ambil Antrian
                </button>
                <a href="<?php echo e(route('warga.antrian.index')); ?>" 
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slots = document.querySelectorAll('input[name="slot"]');
        const form = document.querySelector('form');
        
        slots.forEach(slot => {
            slot.addEventListener('change', function() {
                // Remove selected class from all slots
                document.querySelectorAll('.time-slot').forEach(label => {
                    label.classList.remove('selected');
                });
                
                // Add selected class to current slot
                this.closest('.time-slot').classList.add('selected');
            });
        });
        
        // Set initial selection if there's old input
        const checkedSlot = document.querySelector('input[name="slot"]:checked');
        if (checkedSlot) {
            checkedSlot.closest('.time-slot').classList.add('selected');
        }
        
        // Form validation
        form.addEventListener('submit', function(e) {
            const selectedSlot = document.querySelector('input[name="slot"]:checked');
            if (!selectedSlot) {
                e.preventDefault();
                alert('Silakan pilih tanggal dan waktu kunjungan terlebih dahulu.');
                return false;
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\warga\antrian\create.blade.php ENDPATH**/ ?>