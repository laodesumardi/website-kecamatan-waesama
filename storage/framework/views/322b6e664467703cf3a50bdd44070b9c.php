<?php $__env->startSection('title', 'Tambah Pengaduan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Tambah Pengaduan</h2>
                <p class="text-blue-100">Tambah pengaduan baru ke dalam sistem dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-plus-circle text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>
            <form action="<?php echo e(route('admin.pengaduan.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                
                <!-- Data Pengadu -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Data Pengadu
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Nama Pengadu *</label>
                            <input type="text" name="nama_pengadu" id="nama_pengadu" value="<?php echo e(old('nama_pengadu')); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['nama_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['nama_pengadu'];
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
                        
                        <div>
                            <label for="email_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_pengadu" id="email_pengadu" value="<?php echo e(old('email_pengadu')); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['email_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['email_pengadu'];
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
                        
                        <div>
                            <label for="phone_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
                            <input type="text" name="phone_pengadu" id="phone_pengadu" value="<?php echo e(old('phone_pengadu')); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['phone_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['phone_pengadu'];
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
                        
                        <div>
                            <label for="alamat_pengadu" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                            <textarea name="alamat_pengadu" id="alamat_pengadu" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['alamat_pengadu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat_pengadu')); ?></textarea>
                            <?php $__errorArgs = ['alamat_pengadu'];
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
                </div>
                
                <!-- Detail Pengaduan -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-comments text-blue-600 mr-2"></i>
                        Detail Pengaduan
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="judul_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengaduan *</label>
                            <input type="text" name="judul_pengaduan" id="judul_pengaduan" value="<?php echo e(old('judul_pengaduan')); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['judul_pengaduan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                                <select name="kategori" id="kategori" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pelayanan" <?php echo e(old('kategori') == 'Pelayanan' ? 'selected' : ''); ?>>Pelayanan</option>
                                    <option value="Infrastruktur" <?php echo e(old('kategori') == 'Infrastruktur' ? 'selected' : ''); ?>>Infrastruktur</option>
                                    <option value="Keamanan" <?php echo e(old('kategori') == 'Keamanan' ? 'selected' : ''); ?>>Keamanan</option>
                                    <option value="Kebersihan" <?php echo e(old('kategori') == 'Kebersihan' ? 'selected' : ''); ?>>Kebersihan</option>
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
                            
                            <div>
                                <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-2">Prioritas *</label>
                                <select name="prioritas" id="prioritas" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['prioritas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Pilih Prioritas</option>
                                    <option value="Rendah" <?php echo e(old('prioritas') == 'Rendah' ? 'selected' : ''); ?>>Rendah</option>
                                    <option value="Sedang" <?php echo e(old('prioritas') == 'Sedang' ? 'selected' : ''); ?>>Sedang</option>
                                    <option value="Tinggi" <?php echo e(old('prioritas') == 'Tinggi' ? 'selected' : ''); ?>>Tinggi</option>
                                    <option value="Urgent" <?php echo e(old('prioritas') == 'Urgent' ? 'selected' : ''); ?>>Urgent</option>
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
                        </div>
                        
                        <div>
                            <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-2">Isi Pengaduan *</label>
                            <textarea name="isi_pengaduan" id="isi_pengaduan" rows="6" required placeholder="Jelaskan detail pengaduan Anda..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['isi_pengaduan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('isi_pengaduan')); ?></textarea>
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
                        
                        <div>
                            <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-2">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['lampiran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, PDF, DOC, DOCX (Maksimal 5MB)</p>
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
                    </div>
                </div>
                
                <!-- Penanganan -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-cog text-blue-600 mr-2"></i>
                        Penanganan (Opsional)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="Diterima" <?php echo e(old('status', 'Diterima') == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                                <option value="Diproses" <?php echo e(old('status') == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                                <option value="Ditindaklanjuti" <?php echo e(old('status') == 'Ditindaklanjuti' ? 'selected' : ''); ?>>Ditindaklanjuti</option>
                                <option value="Selesai" <?php echo e(old('status') == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                                <option value="Ditolak" <?php echo e(old('status') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
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
                        
                        <div>
                            <label for="ditangani_oleh" class="block text-sm font-medium text-gray-700 mb-2">Ditangani Oleh</label>
                            <select name="ditangani_oleh" id="ditangani_oleh" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['ditangani_oleh'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Pilih Petugas</option>
                                <?php $__currentLoopData = $pegawaiUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pegawai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pegawai->id); ?>" <?php echo e(old('ditangani_oleh') == $pegawai->id ? 'selected' : ''); ?>><?php echo e($pegawai->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['ditangani_oleh'];
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
                    
                    <div class="mt-6">
                        <label for="tanggapan" class="block text-sm font-medium text-gray-700 mb-2">Tanggapan</label>
                        <textarea name="tanggapan" id="tanggapan" rows="4" placeholder="Tanggapan atau tindak lanjut dari petugas..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['tanggapan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('tanggapan')); ?></textarea>
                        <?php $__errorArgs = ['tanggapan'];
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
                
                <!-- Action Buttons -->
                <div class="flex justify-between items-center">
                    <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <div class="space-x-3">
                        <button type="reset" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Simpan Pengaduan
                        </button>
                    </div>
                </div>
            </form>
</div>

<script>
// Auto-generate nomor pengaduan preview
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    
    // Show preview of auto-generated number
    const previewElement = document.createElement('p');
    previewElement.className = 'mt-1 text-sm text-blue-600';
    previewElement.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Nomor pengaduan akan dibuat otomatis';
    
    const form = document.querySelector('form');
    if (form) {
        form.insertBefore(previewElement, form.firstChild);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\pengaduan\create.blade.php ENDPATH**/ ?>