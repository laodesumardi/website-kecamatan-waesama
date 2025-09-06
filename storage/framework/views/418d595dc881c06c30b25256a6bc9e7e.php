<?php $__env->startSection('title', 'Detail User'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <a href="<?php echo e(route('admin.user.index')); ?>" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <div class="border-l border-gray-300 pl-4">
                    <h1 class="text-2xl font-bold text-gray-800">Detail User</h1>
                    <nav class="text-sm text-gray-600">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-blue-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="<?php echo e(route('admin.user.index')); ?>" class="hover:text-blue-600">Manajemen User</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800">Detail User</span>
                    </nav>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <?php if($user->id !== auth()->id()): ?>
                    <form action="<?php echo e(route('admin.user.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <p class="text-gray-600"><?php echo e($user->email); ?></p>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user mr-2 text-blue-600"></i>
                    Informasi User
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <p class="text-gray-900"><?php echo e($user->name); ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900"><?php echo e($user->email); ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php if($user->role->name === 'Admin'): ?> bg-red-100 text-red-800
                            <?php elseif($user->role->name === 'Pegawai'): ?> bg-blue-100 text-blue-800
                            <?php else: ?> bg-green-100 text-green-800
                            <?php endif; ?>">
                            <?php echo e($user->role->display_name); ?>

                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($user->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                        </span>
                    </div>
                    
                    <?php if($user->nik): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <p class="text-gray-900 font-mono"><?php echo e($user->nik); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($user->phone): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <p class="text-gray-900"><?php echo e($user->phone); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($user->birth_date): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <p class="text-gray-900"><?php echo e($user->birth_date->format('d F Y')); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($user->gender): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900"><?php echo e($user->gender === 'L' ? 'Laki-laki' : 'Perempuan'); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($user->address): ?>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900"><?php echo e($user->address); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Activity Summary -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Ringkasan Aktivitas
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600"><?php echo e($user->suratProcessed->count()); ?></div>
                        <div class="text-sm text-gray-600">Surat Diproses</div>
                    </div>
                    
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600"><?php echo e($user->antrianServed->count()); ?></div>
                        <div class="text-sm text-gray-600">Antrian Dilayani</div>
                    </div>
                    
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600"><?php echo e($user->berita->count()); ?></div>
                        <div class="text-sm text-gray-600">Berita Dibuat</div>
                    </div>
                    
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-600"><?php echo e($user->pengaduanHandled->count()); ?></div>
                        <div class="text-sm text-gray-600">Pengaduan Ditangani</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <?php if($user->id !== auth()->id()): ?>
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        <i class="fas fa-bolt mr-2 text-blue-600"></i>
                        Aksi Cepat
                    </h3>
                    
                    <div class="space-y-3">
                        <form action="<?php echo e(route('admin.user.toggle-status', $user)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="w-full px-4 py-2 <?php echo e($user->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700'); ?> text-white rounded-lg transition-colors">
                                <i class="fas <?php echo e($user->is_active ? 'fa-user-slash' : 'fa-user-check'); ?> mr-2"></i>
                                <?php echo e($user->is_active ? 'Nonaktifkan User' : 'Aktifkan User'); ?>

                            </button>
                        </form>
                        
                        <form action="<?php echo e(route('admin.user.reset-password', $user)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset password user ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-key mr-2"></i>Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Account Information -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Akun
                </h3>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Terverifikasi</label>
                        <p class="text-gray-700"><?php echo e($user->email_verified_at ? $user->email_verified_at->format('d F Y, H:i') . ' WIB' : 'Belum terverifikasi'); ?></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terdaftar</label>
                        <p class="text-gray-700"><?php echo e($user->created_at->format('d F Y, H:i:s')); ?> WIB</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                        <p class="text-gray-700"><?php echo e($user->updated_at->format('d F Y, H:i:s')); ?> WIB</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-compass mr-2 text-blue-600"></i>
                    Navigasi
                </h3>
                
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i>Edit User
                    </a>
                    <a href="<?php echo e(route('admin.user.index')); ?>" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-list mr-2"></i>Daftar User
                    </a>
                    <a href="<?php echo e(route('admin.user.create')); ?>" class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i>Tambah User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\user\show.blade.php ENDPATH**/ ?>