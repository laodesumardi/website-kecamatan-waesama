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
        Edit Pengguna
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold" style="color: #001d3d;">Edit Pengguna</h2>
                <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" 
                   class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-colors duration-200"
                   style="background-color: #6b7280;" 
                   onmouseover="this.style.backgroundColor='#4b5563'" 
                   onmouseout="this.style.backgroundColor='#6b7280'">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        
            <?php if($errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- User Profile Header -->
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xl font-medium text-gray-700">
                                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900">Edit: <?php echo e($user->name); ?></h3>
                                <p class="text-gray-600"><?php echo e($user->email); ?></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h4>
                                
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="phone" id="phone" value="<?php echo e(old('phone', $user->phone)); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select name="role" id="role" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                            required>
                                        <option value="admin" <?php echo e(old('role', $user->role) === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        <option value="pegawai" <?php echo e(old('role', $user->role) === 'pegawai' ? 'selected' : ''); ?>>Pegawai</option>
                                        <option value="masyarakat" <?php echo e(old('role', $user->role) === 'masyarakat' ? 'selected' : ''); ?>>Masyarakat</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Akun</label>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                   <?php echo e(old('is_active', $user->is_active) ? 'checked' : ''); ?>

                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-600">Akun Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div class="space-y-4" id="employment-info">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Kepegawaian</h4>
                                
                                <!-- Employee ID -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                                    <input type="text" name="employee_id" id="employee_id" value="<?php echo e(old('employee_id', $user->employee_id)); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika bukan pegawai</p>
                                </div>

                                <!-- Position -->
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="position" id="position" value="<?php echo e(old('position', $user->position)); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Department -->
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <select name="department" id="department" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Departemen</option>
                                        <option value="Pimpinan" <?php echo e(old('department', $user->department) === 'Pimpinan' ? 'selected' : ''); ?>>Pimpinan</option>
                                        <option value="Sekretariat" <?php echo e(old('department', $user->department) === 'Sekretariat' ? 'selected' : ''); ?>>Sekretariat</option>
                                        <option value="Pelayanan" <?php echo e(old('department', $user->department) === 'Pelayanan' ? 'selected' : ''); ?>>Pelayanan</option>
                                        <option value="Kependudukan" <?php echo e(old('department', $user->department) === 'Kependudukan' ? 'selected' : ''); ?>>Kependudukan</option>
                                        <option value="Pemberdayaan" <?php echo e(old('department', $user->department) === 'Pemberdayaan' ? 'selected' : ''); ?>>Pemberdayaan</option>
                                        <option value="Keamanan" <?php echo e(old('department', $user->department) === 'Keamanan' ? 'selected' : ''); ?>>Keamanan</option>
                                        <option value="IT" <?php echo e(old('department', $user->department) === 'IT' ? 'selected' : ''); ?>>IT</option>
                                    </select>
                                </div>

                                <!-- Account Info Display -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Informasi Akun</h5>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div>Bergabung: <?php echo e($user->created_at->format('d M Y H:i')); ?></div>
                                        <?php if($user->email_verified_at): ?>
                                            <div>Email Terverifikasi: <?php echo e($user->email_verified_at->format('d M Y H:i')); ?></div>
                                        <?php endif; ?>
                                        <?php if($user->last_login_at): ?>
                                            <div>Login Terakhir: <?php echo e($user->last_login_at->format('d M Y H:i')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Simpan Perubahan
                                </button>
                                <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Batal
                                </a>
                            </div>
                            <a href="<?php echo e(route('admin.users')); ?>" class="text-gray-600 hover:text-gray-900">
                                ← Kembali ke Daftar Pengguna
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide employment fields based on role
        document.getElementById('role').addEventListener('change', function() {
            const employmentInfo = document.getElementById('employment-info');
            const employeeIdField = document.getElementById('employee_id');
            const positionField = document.getElementById('position');
            const departmentField = document.getElementById('department');
            
            if (this.value === 'masyarakat') {
                employmentInfo.style.opacity = '0.5';
                employeeIdField.value = '';
                positionField.value = '';
                departmentField.value = '';
            } else {
                employmentInfo.style.opacity = '1';
            }
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'masyarakat') {
                document.getElementById('employment-info').style.opacity = '0.5';
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>