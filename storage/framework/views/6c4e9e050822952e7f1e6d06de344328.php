<?php $__env->startSection('title', 'Tambah Data Penduduk'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="<?php echo e(route('admin.penduduk.index')); ?>" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Data Penduduk</h1>
                <p class="text-gray-600">Tambah data penduduk baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm">
        <form action="<?php echo e(route('admin.penduduk.store')); ?>" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            
            <!-- Data Identitas -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Identitas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK *</label>
                        <input type="text" id="nik" name="nik" value="<?php echo e(old('nik')); ?>" maxlength="16" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['nik'];
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
                    
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo e(old('nama_lengkap')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['nama_lengkap'];
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
                    
                    <!-- Tempat Lahir -->
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo e(old('tempat_lahir')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tempat_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tempat_lahir'];
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
                    
                    <!-- Tanggal Lahir -->
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['tanggal_lahir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_lahir'];
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
                    
                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?php echo e(old('jenis_kelamin') == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo e(old('jenis_kelamin') == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                        </select>
                        <?php $__errorArgs = ['jenis_kelamin'];
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
                    
                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">Agama *</label>
                        <select id="agama" name="agama" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['agama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" <?php echo e(old('agama') == 'Islam' ? 'selected' : ''); ?>>Islam</option>
                            <option value="Kristen" <?php echo e(old('agama') == 'Kristen' ? 'selected' : ''); ?>>Kristen</option>
                            <option value="Katolik" <?php echo e(old('agama') == 'Katolik' ? 'selected' : ''); ?>>Katolik</option>
                            <option value="Hindu" <?php echo e(old('agama') == 'Hindu' ? 'selected' : ''); ?>>Hindu</option>
                            <option value="Buddha" <?php echo e(old('agama') == 'Buddha' ? 'selected' : ''); ?>>Buddha</option>
                            <option value="Konghucu" <?php echo e(old('agama') == 'Konghucu' ? 'selected' : ''); ?>>Konghucu</option>
                        </select>
                        <?php $__errorArgs = ['agama'];
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
            
            <!-- Data Sosial -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Sosial</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pendidikan -->
                    <div>
                        <label for="pendidikan" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan *</label>
                        <input type="text" id="pendidikan" name="pendidikan" value="<?php echo e(old('pendidikan')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['pendidikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pendidikan'];
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
                    
                    <!-- Pekerjaan -->
                    <div>
                        <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan *</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo e(old('pekerjaan')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['pekerjaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['pekerjaan'];
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
                    
                    <!-- Status Perkawinan -->
                    <div>
                        <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan *</label>
                        <select id="status_perkawinan" name="status_perkawinan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['status_perkawinan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Status Perkawinan</option>
                            <option value="Belum Kawin" <?php echo e(old('status_perkawinan') == 'Belum Kawin' ? 'selected' : ''); ?>>Belum Kawin</option>
                            <option value="Kawin" <?php echo e(old('status_perkawinan') == 'Kawin' ? 'selected' : ''); ?>>Kawin</option>
                            <option value="Cerai Hidup" <?php echo e(old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : ''); ?>>Cerai Hidup</option>
                            <option value="Cerai Mati" <?php echo e(old('status_perkawinan') == 'Cerai Mati' ? 'selected' : ''); ?>>Cerai Mati</option>
                        </select>
                        <?php $__errorArgs = ['status_perkawinan'];
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
                    
                    <!-- Kewarganegaraan -->
                    <div>
                        <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700 mb-2">Kewarganegaraan *</label>
                        <select id="kewarganegaraan" name="kewarganegaraan" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['kewarganegaraan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Kewarganegaraan</option>
                            <option value="WNI" <?php echo e(old('kewarganegaraan') == 'WNI' ? 'selected' : ''); ?>>WNI</option>
                            <option value="WNA" <?php echo e(old('kewarganegaraan') == 'WNA' ? 'selected' : ''); ?>>WNA</option>
                        </select>
                        <?php $__errorArgs = ['kewarganegaraan'];
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
            
            <!-- Data Keluarga -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Keluarga</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- No KK -->
                    <div>
                        <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-2">No. KK *</label>
                        <input type="text" id="no_kk" name="no_kk" value="<?php echo e(old('no_kk')); ?>" maxlength="16" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['no_kk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['no_kk'];
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
                    
                    <!-- Hubungan Keluarga -->
                    <div>
                        <label for="hubungan_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Hubungan Keluarga *</label>
                        <input type="text" id="hubungan_keluarga" name="hubungan_keluarga" value="<?php echo e(old('hubungan_keluarga')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['hubungan_keluarga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['hubungan_keluarga'];
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
            
            <!-- Data Alamat -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Alamat</h3>
                <div class="grid grid-cols-1 gap-6">
                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                        <textarea id="alamat" name="alamat" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat')); ?></textarea>
                        <?php $__errorArgs = ['alamat'];
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- RT -->
                        <div>
                            <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT *</label>
                            <input type="text" id="rt" name="rt" value="<?php echo e(old('rt')); ?>" maxlength="3" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['rt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['rt'];
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
                        
                        <!-- RW -->
                        <div>
                            <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW *</label>
                            <input type="text" id="rw" name="rw" value="<?php echo e(old('rw')); ?>" maxlength="3" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['rw'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['rw'];
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
                        
                        <!-- Desa/Kelurahan -->
                        <div>
                            <label for="desa_kelurahan" class="block text-sm font-medium text-gray-700 mb-2">Desa/Kelurahan *</label>
                            <input type="text" id="desa_kelurahan" name="desa_kelurahan" value="<?php echo e(old('desa_kelurahan')); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['desa_kelurahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['desa_kelurahan'];
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
                        
                        <!-- Kode Pos -->
                        <div>
                            <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos *</label>
                            <input type="text" id="kode_pos" name="kode_pos" value="<?php echo e(old('kode_pos')); ?>" maxlength="5" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['kode_pos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['kode_pos'];
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
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Kecamatan -->
                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan *</label>
                            <input type="text" id="kecamatan" name="kecamatan" value="<?php echo e(old('kecamatan')); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['kecamatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['kecamatan'];
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
                        
                        <!-- Kabupaten/Kota -->
                        <div>
                            <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota *</label>
                            <input type="text" id="kabupaten_kota" name="kabupaten_kota" value="<?php echo e(old('kabupaten_kota')); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['kabupaten_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['kabupaten_kota'];
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
                        
                        <!-- Provinsi -->
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                            <input type="text" id="provinsi" name="provinsi" value="<?php echo e(old('provinsi')); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['provinsi'];
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
            </div>
            
            <!-- Status Penduduk -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Status Penduduk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status_penduduk" class="block text-sm font-medium text-gray-700 mb-2">Status Penduduk *</label>
                        <select id="status_penduduk" name="status_penduduk" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent <?php $__errorArgs = ['status_penduduk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Status Penduduk</option>
                            <option value="Tetap" <?php echo e(old('status_penduduk') == 'Tetap' ? 'selected' : ''); ?>>Tetap</option>
                            <option value="Pindah" <?php echo e(old('status_penduduk') == 'Pindah' ? 'selected' : ''); ?>>Pindah</option>
                            <option value="Meninggal" <?php echo e(old('status_penduduk') == 'Meninggal' ? 'selected' : ''); ?>>Meninggal</option>
                        </select>
                        <?php $__errorArgs = ['status_penduduk'];
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
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="<?php echo e(route('admin.penduduk.index')); ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\penduduk\create.blade.php ENDPATH**/ ?>