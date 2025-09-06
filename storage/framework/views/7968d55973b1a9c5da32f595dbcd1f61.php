<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Detail Pengguna
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold" style="color: #001d3d;">Detail Pengguna</h2>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.users')); ?>" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #6b7280;" 
                       onmouseover="this.style.backgroundColor='#4b5563'" 
                       onmouseout="this.style.backgroundColor='#6b7280'">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" 
                       class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                       style="background-color: #001d3d;" 
                       onmouseover="this.style.backgroundColor='#003366'" 
                       onmouseout="this.style.backgroundColor='#001d3d'">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- User Profile Header -->
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-20 w-20">
                            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-2xl font-medium text-gray-700">
                                    <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                </span>
                            </div>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo e($user->name); ?></h3>
                            <p class="text-gray-600"><?php echo e($user->email); ?></p>
                            <div class="mt-2">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                                    <?php elseif($user->role === 'pegawai'): ?> bg-green-100 text-green-800
                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                                <span class="ml-2 inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($user->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->name); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->email); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->phone ?? '-'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e(ucfirst($user->role)); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900">
                                        <?php echo e($user->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Employment Information -->
                        <?php if($user->role !== 'masyarakat'): ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kepegawaian</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">ID Pegawai</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->employee_id ?? '-'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Jabatan</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->position ?? '-'); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Departemen</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->department ?? '-'); ?></dd>
                                </div>
                            </dl>
                        </div>
                        <?php endif; ?>

                        <!-- Account Information -->
                        <div class="bg-gray-50 p-4 rounded-lg <?php echo e($user->role === 'masyarakat' ? 'md:col-span-1' : ''); ?>">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                                    <dd class="text-sm text-gray-900"><?php echo e($user->created_at->format('d M Y H:i')); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email Terverifikasi</dt>
                                    <dd class="text-sm text-gray-900">
                                        <?php if($user->email_verified_at): ?>
                                            <span class="text-green-600">✓ Terverifikasi</span>
                                            <div class="text-xs text-gray-500"><?php echo e($user->email_verified_at->format('d M Y H:i')); ?></div>
                                        <?php else: ?>
                                            <span class="text-red-600">✗ Belum Terverifikasi</span>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Login Terakhir</dt>
                                    <dd class="text-sm text-gray-900">
                                        <?php if($user->last_login_at): ?>
                                            <?php echo e($user->last_login_at->format('d M Y H:i')); ?>

                                            <div class="text-xs text-gray-500"><?php echo e($user->last_login_at->diffForHumans()); ?></div>
                                        <?php else: ?>
                                            <span class="text-gray-500">Belum pernah login</span>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                                    <dd class="text-sm text-gray-900">
                                        <?php echo e($user->updated_at->format('d M Y H:i')); ?>

                                        <div class="text-xs text-gray-500"><?php echo e($user->updated_at->diffForHumans()); ?></div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Preferences (if any) -->
                        <?php if($user->preferences): ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Preferensi</h4>
                            <pre class="text-sm text-gray-700 bg-white p-3 rounded border overflow-auto"><?php echo e(json_encode($user->preferences, JSON_PRETTY_PRINT)); ?></pre>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Pengguna
                            </a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" 
                                      class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus Pengguna
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('admin.users')); ?>" class="text-gray-600 hover:text-gray-900">
                            ← Kembali ke Daftar Pengguna
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\users\show.blade.php ENDPATH**/ ?>