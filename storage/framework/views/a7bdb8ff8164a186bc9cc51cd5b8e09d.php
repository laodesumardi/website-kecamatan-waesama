<?php $__env->startSection('title', 'Detail Data Penduduk'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('admin.penduduk.index')); ?>" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">Detail Data Penduduk</h1>
                <p class="text-gray-600">Informasi lengkap data penduduk</p>
            </div>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.penduduk.edit', $penduduk)); ?>" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="<?php echo e(route('admin.penduduk.destroy', $penduduk)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Identitas -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Identitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                        <p class="text-gray-900 font-medium"><?php echo e($penduduk->nik); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium"><?php echo e($penduduk->nama_lengkap); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tempat Lahir</label>
                        <p class="text-gray-900"><?php echo e($penduduk->tempat_lahir); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                        <p class="text-gray-900"><?php echo e($penduduk->tanggal_lahir->format('d F Y')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                        <p class="text-gray-900"><?php echo e($penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : ($penduduk->jenis_kelamin == 'P' ? 'Perempuan' : $penduduk->jenis_kelamin)); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                        <p class="text-gray-900"><?php echo e($penduduk->agama); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Kewarganegaraan</label>
                        <p class="text-gray-900"><?php echo e($penduduk->kewarganegaraan); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Data Sosial -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Sosial</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pendidikan</label>
                        <p class="text-gray-900"><?php echo e($penduduk->pendidikan); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                        <p class="text-gray-900"><?php echo e($penduduk->pekerjaan); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status Perkawinan</label>
                        <p class="text-gray-900"><?php echo e($penduduk->status_perkawinan); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Data Keluarga -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Keluarga</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">No. KK</label>
                        <p class="text-gray-900 font-medium"><?php echo e($penduduk->no_kk); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Hubungan Keluarga</label>
                        <p class="text-gray-900"><?php echo e($penduduk->hubungan_keluarga); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Data Alamat -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Alamat</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                        <p class="text-gray-900"><?php echo e($penduduk->alamat); ?></p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">RT</label>
                            <p class="text-gray-900"><?php echo e($penduduk->rt); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">RW</label>
                            <p class="text-gray-900"><?php echo e($penduduk->rw); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Desa/Kelurahan</label>
                            <p class="text-gray-900"><?php echo e($penduduk->desa_kelurahan); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kode Pos</label>
                            <p class="text-gray-900"><?php echo e($penduduk->kode_pos); ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kecamatan</label>
                            <p class="text-gray-900"><?php echo e($penduduk->kecamatan); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Kabupaten/Kota</label>
                            <p class="text-gray-900"><?php echo e($penduduk->kabupaten_kota); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Provinsi</label>
                            <p class="text-gray-900"><?php echo e($penduduk->provinsi); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Penduduk</h3>
                <div class="text-center">
                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full 
                        <?php if($penduduk->status_penduduk == 'Tetap'): ?> bg-green-100 text-green-800
                        <?php elseif($penduduk->status_penduduk == 'Pindah'): ?> bg-yellow-100 text-yellow-800
                        <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                        <?php echo e($penduduk->status_penduduk); ?>

                    </span>
                </div>
                
                <?php if($penduduk->status_penduduk == 'Pindah' && $penduduk->tanggal_pindah): ?>
                    <div class="mt-4 pt-4 border-t">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pindah</label>
                        <p class="text-gray-900"><?php echo e($penduduk->tanggal_pindah->format('d F Y')); ?></p>
                        <?php if($penduduk->alamat_pindah): ?>
                            <label class="block text-sm font-medium text-gray-500 mb-1 mt-3">Alamat Pindah</label>
                            <p class="text-gray-900"><?php echo e($penduduk->alamat_pindah); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <?php if($penduduk->status_penduduk == 'Meninggal' && $penduduk->tanggal_meninggal): ?>
                    <div class="mt-4 pt-4 border-t">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Meninggal</label>
                        <p class="text-gray-900"><?php echo e($penduduk->tanggal_meninggal->format('d F Y')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Metadata -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Sistem</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                        <p class="text-gray-900 text-sm"><?php echo e($penduduk->created_at->format('d F Y H:i')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diperbarui</label>
                        <p class="text-gray-900 text-sm"><?php echo e($penduduk->updated_at->format('d F Y H:i')); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.penduduk.edit', $penduduk)); ?>" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors flex items-center gap-2 justify-center">
                        <i class="fas fa-edit"></i>
                        Edit Data
                    </a>
                    <button onclick="window.print()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 justify-center">
                        <i class="fas fa-print"></i>
                        Cetak Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\penduduk\show.blade.php ENDPATH**/ ?>