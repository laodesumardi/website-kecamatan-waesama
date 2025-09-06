<?php $__env->startSection('title', 'Edit Surat - ' . $surat->nomor_surat); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('admin.surat.show', $surat)); ?>" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Surat</h1>
                <p class="text-gray-600"><?php echo e($surat->nomor_surat); ?></p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm">
        <form action="<?php echo e(route('admin.surat.update', $surat)); ?>" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Data Surat -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Surat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Surat (Read Only) -->
                    <div>
                        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">Nomor Surat</label>
                        <input type="text" id="nomor_surat" value="<?php echo e($surat->nomor_surat); ?>" readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                    </div>
                    
                    <!-- Jenis Surat -->
                    <div>
                        <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat *</label>
                        <select id="jenis_surat" name="jenis_surat" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['jenis_surat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Jenis Surat</option>
                            <option value="Domisili" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Domisili' ? 'selected' : ''); ?>>Surat Keterangan Domisili</option>
                            <option value="SKTM" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'SKTM' ? 'selected' : ''); ?>>Surat Keterangan Tidak Mampu</option>
                            <option value="Usaha" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Usaha' ? 'selected' : ''); ?>>Surat Keterangan Usaha</option>
                            <option value="Pengantar" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Pengantar' ? 'selected' : ''); ?>>Surat Pengantar</option>
                            <option value="Kematian" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Kematian' ? 'selected' : ''); ?>>Surat Keterangan Kematian</option>
                            <option value="Kelahiran" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Kelahiran' ? 'selected' : ''); ?>>Surat Keterangan Kelahiran</option>
                            <option value="Pindah" <?php echo e(old('jenis_surat', $surat->jenis_surat) == 'Pindah' ? 'selected' : ''); ?>>Surat Keterangan Pindah</option>
                        </select>
                        <?php $__errorArgs = ['jenis_surat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Tanggal Pengajuan -->
                    <div>
                        <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan *</label>
                        <input type="date" id="tanggal_pengajuan" name="tanggal_pengajuan" 
                               value="<?php echo e(old('tanggal_pengajuan', $surat->created_at->format('Y-m-d'))); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tanggal_pengajuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_pengajuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="Pending" <?php echo e(old('status', $surat->status) == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Diproses" <?php echo e(old('status', $surat->status) == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                            <option value="Selesai" <?php echo e(old('status', $surat->status) == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                            <option value="Ditolak" <?php echo e(old('status', $surat->status) == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
            
            <!-- Data Pemohon -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pemohon -->
                    <div>
                        <label for="nama_pemohon" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" id="nama_pemohon" name="nama_pemohon" 
                               value="<?php echo e(old('nama_pemohon', $surat->nama_pemohon)); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['nama_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['nama_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- NIK Pemohon -->
                    <div>
                        <label for="nik_pemohon" class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                        <input type="text" id="nik_pemohon" name="nik_pemohon" 
                               value="<?php echo e(old('nik_pemohon', $surat->nik_pemohon)); ?>" maxlength="16" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['nik_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['nik_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone_pemohon" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="text" id="phone_pemohon" name="phone_pemohon" 
                               value="<?php echo e(old('phone_pemohon', $surat->phone_pemohon)); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['phone_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['phone_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <!-- Alamat Pemohon -->
                <div class="mt-6">
                    <label for="alamat_pemohon" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                    <textarea id="alamat_pemohon" name="alamat_pemohon" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['alamat_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat_pemohon', $surat->alamat_pemohon)); ?></textarea>
                    <?php $__errorArgs = ['alamat_pemohon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Keperluan -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Keperluan Surat</h3>
                <div>
                    <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">Keperluan *</label>
                    <textarea id="keperluan" name="keperluan" rows="4" 
                              placeholder="Jelaskan keperluan surat ini..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['keperluan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('keperluan', $surat->keperluan)); ?></textarea>
                    <?php $__errorArgs = ['keperluan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Catatan -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Catatan</h3>
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                    <textarea id="catatan" name="catatan" rows="3" 
                              placeholder="Catatan atau keterangan tambahan..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('catatan', $surat->catatan)); ?></textarea>
                    <?php $__errorArgs = ['catatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Data Tambahan (Dynamic based on jenis_surat) -->
            <div id="data-tambahan-section" class="mb-8" style="<?php echo e($surat->jenis_surat ? 'display: block;' : 'display: none;'); ?>">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Tambahan</h3>
                <div id="data-tambahan-fields">
                    <!-- Dynamic fields will be inserted here -->
                </div>
            </div>
            
            <!-- Tanggal Selesai (Only show if status is Selesai) -->
            <div id="tanggal-selesai-section" class="mb-8" style="<?php echo e($surat->status === 'Selesai' ? 'display: block;' : 'display: none;'); ?>">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Tanggal Selesai</h3>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" 
                           value="<?php echo e(old('tanggal_selesai', $surat->tanggal_selesai ? $surat->tanggal_selesai->format('Y-m-d\TH:i') : '')); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="<?php echo e(route('admin.surat.show', $surat)); ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Update Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenisSuratSelect = document.getElementById('jenis_surat');
    const statusSelect = document.getElementById('status');
    const dataTambahanSection = document.getElementById('data-tambahan-section');
    const dataTambahanFields = document.getElementById('data-tambahan-fields');
    const tanggalSelesaiSection = document.getElementById('tanggal-selesai-section');
    
    // Handle jenis surat change
    jenisSuratSelect.addEventListener('change', function() {
        const jenisSurat = this.value;
        
        if (jenisSurat) {
            dataTambahanSection.style.display = 'block';
            generateAdditionalFields(jenisSurat);
        } else {
            dataTambahanSection.style.display = 'none';
            dataTambahanFields.innerHTML = '';
        }
    });
    
    // Handle status change
    statusSelect.addEventListener('change', function() {
        const status = this.value;
        
        if (status === 'Selesai') {
            tanggalSelesaiSection.style.display = 'block';
            // Set current datetime if empty
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
            if (!tanggalSelesaiInput.value) {
                const now = new Date();
                const formattedDate = now.toISOString().slice(0, 16);
                tanggalSelesaiInput.value = formattedDate;
            }
        } else {
            tanggalSelesaiSection.style.display = 'none';
        }
    });
    
    function generateAdditionalFields(jenisSurat) {
        let fieldsHtml = '';
        const existingData = <?php echo json_encode($surat->data_tambahan ?? [], 15, 512) ?>;
        
        switch(jenisSurat) {
            case 'Domisili':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lama Tinggal</label>
                            <input type="text" name="data_tambahan[lama_tinggal]" placeholder="Contoh: 5 tahun" 
                                   value="${existingData.lama_tinggal || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Tempat Tinggal</label>
                            <select name="data_tambahan[status_tempat_tinggal]" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Status</option>
                                <option value="Milik Sendiri" ${existingData.status_tempat_tinggal === 'Milik Sendiri' ? 'selected' : ''}>Milik Sendiri</option>
                                <option value="Sewa" ${existingData.status_tempat_tinggal === 'Sewa' ? 'selected' : ''}>Sewa</option>
                                <option value="Kontrak" ${existingData.status_tempat_tinggal === 'Kontrak' ? 'selected' : ''}>Kontrak</option>
                                <option value="Menumpang" ${existingData.status_tempat_tinggal === 'Menumpang' ? 'selected' : ''}>Menumpang</option>
                            </select>
                        </div>
                    </div>
                `;
                break;
                
            case 'SKTM':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan per Bulan</label>
                            <input type="text" name="data_tambahan[penghasilan]" placeholder="Contoh: Rp 1.000.000" 
                                   value="${existingData.penghasilan || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tanggungan</label>
                            <input type="number" name="data_tambahan[jumlah_tanggungan]" placeholder="Contoh: 3" 
                                   value="${existingData.jumlah_tanggungan || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                `;
                break;
                
            case 'Usaha':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha</label>
                            <input type="text" name="data_tambahan[nama_usaha]" 
                                   value="${existingData.nama_usaha || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Usaha</label>
                            <input type="text" name="data_tambahan[jenis_usaha]" 
                                   value="${existingData.jenis_usaha || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Usaha</label>
                            <textarea name="data_tambahan[alamat_usaha]" rows="2" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">${existingData.alamat_usaha || ''}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mulai Usaha</label>
                            <input type="date" name="data_tambahan[mulai_usaha]" 
                                   value="${existingData.mulai_usaha || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                `;
                break;
                
            case 'Pengantar':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan Pengantar</label>
                            <input type="text" name="data_tambahan[tujuan]" placeholder="Contoh: Dinas Kependudukan" 
                                   value="${existingData.tujuan || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pengantar</label>
                            <select name="data_tambahan[jenis_pengantar]" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis</option>
                                <option value="KTP" ${existingData.jenis_pengantar === 'KTP' ? 'selected' : ''}>Pengantar KTP</option>
                                <option value="KK" ${existingData.jenis_pengantar === 'KK' ? 'selected' : ''}>Pengantar KK</option>
                                <option value="Nikah" ${existingData.jenis_pengantar === 'Nikah' ? 'selected' : ''}>Pengantar Nikah</option>
                                <option value="Lainnya" ${existingData.jenis_pengantar === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                `;
                break;
                
            case 'Kematian':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kematian</label>
                            <input type="date" name="data_tambahan[tanggal_kematian]" 
                                   value="${existingData.tanggal_kematian || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Kematian</label>
                            <input type="text" name="data_tambahan[tempat_kematian]" 
                                   value="${existingData.tempat_kematian || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sebab Kematian</label>
                            <input type="text" name="data_tambahan[sebab_kematian]" 
                                   value="${existingData.sebab_kematian || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                `;
                break;
                
            case 'Kelahiran':
                fieldsHtml = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kelahiran</label>
                            <input type="date" name="data_tambahan[tanggal_kelahiran]" 
                                   value="${existingData.tanggal_kelahiran || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Kelahiran</label>
                            <input type="text" name="data_tambahan[tempat_kelahiran]" 
                                   value="${existingData.tempat_kelahiran || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ayah</label>
                            <input type="text" name="data_tambahan[nama_ayah]" 
                                   value="${existingData.nama_ayah || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu</label>
                            <input type="text" name="data_tambahan[nama_ibu]" 
                                   value="${existingData.nama_ibu || ''}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                `;
                break;
                
            case 'Pindah':
                fieldsHtml = `
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Tujuan</label>
                            <textarea name="data_tambahan[alamat_tujuan]" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">${existingData.alamat_tujuan || ''}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pindah</label>
                                <input type="date" name="data_tambahan[tanggal_pindah]" 
                                       value="${existingData.tanggal_pindah || ''}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pindah</label>
                                <input type="text" name="data_tambahan[alasan_pindah]" 
                                       value="${existingData.alasan_pindah || ''}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                `;
                break;
        }
        
        dataTambahanFields.innerHTML = fieldsHtml;
    }
    
    // Trigger change events on page load
    if (jenisSuratSelect.value) {
        jenisSuratSelect.dispatchEvent(new Event('change'));
    }
    
    if (statusSelect.value) {
        statusSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\surat\edit.blade.php ENDPATH**/ ?>