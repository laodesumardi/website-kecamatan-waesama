<?php $__env->startSection('title', 'Manajemen User'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#001d3d]  rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Manajemen User</h2>
                <p class="text-blue-100">Kelola pengguna sistem dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-cog text-6xl text-blue-200"></i>
            </div>
        </div>
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

    <!-- Action Bar -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Search and Filters -->
            <form method="GET" action="<?php echo e(route('admin.user.index')); ?>" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <input
                            type="text"
                            name="search"
                            value="<?php echo e(request('search')); ?>"
                            placeholder="Cari nama, email, NIK, atau telepon..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Role Filter -->
                    <div class="w-full md:w-48">
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Role</option>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') == $role->name ? 'selected' : ''); ?>>
                                    <?php echo e($role->display_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full md:w-48">
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="<?php echo e(route('admin.user.index')); ?>" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                </div>
            </form>

            <!-- Add Button -->
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.user.create')); ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah User
                </a>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                        <?php if($user->nik): ?>
                                            <div class="text-xs text-gray-400">NIK: <?php echo e($user->nik); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php if($user->role->name === 'Admin'): ?> bg-red-100 text-red-800
                                    <?php elseif($user->role->name === 'Pegawai'): ?> bg-blue-100 text-blue-800
                                    <?php else: ?> bg-green-100 text-green-800
                                    <?php endif; ?>">
                                    <?php echo e($user->role->display_name); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if($user->phone): ?>
                                    <div><?php echo e($user->phone); ?></div>
                                <?php endif; ?>
                                <?php if($user->address): ?>
                                    <div class="text-xs text-gray-500 max-w-xs truncate"><?php echo e($user->address); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($user->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($user->created_at->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo e(route('admin.user.show', $user)); ?>" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if($user->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('admin.user.toggle-status', $user)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="<?php echo e($user->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900'); ?>" title="<?php echo e($user->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                                <i class="fas <?php echo e($user->is_active ? 'fa-user-slash' : 'fa-user-check'); ?>"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.user.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada user</p>
                                    <p class="text-sm">Belum ada user yang terdaftar dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($users->hasPages()): ?>
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <?php echo e($users->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\user\index.blade.php ENDPATH**/ ?>