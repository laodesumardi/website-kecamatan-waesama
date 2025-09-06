<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Tambah Pengguna Baru')); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.users')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                    <form method="POST" action="<?php echo e(route('admin.users.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h4>
                                
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="08xxxxxxxxxx">
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" id="password" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required minlength="8">
                                    <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                           required minlength="8">
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                                    <select name="role" id="role" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                            required>
                                        <option value="">Pilih Role</option>
                                        <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                        <option value="pegawai" <?php echo e(old('role') === 'pegawai' ? 'selected' : ''); ?>>Pegawai</option>
                                        <option value="masyarakat" <?php echo e(old('role') === 'masyarakat' ? 'selected' : ''); ?>>Masyarakat</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Akun</label>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" 
                                                   <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-600">Akun Aktif</span>
                                        </label>
                                    </div>
                                </div>
            </div>

                            <!-- Employment Information -->
                            <div class="space-y-4" id="employment-info">
                                <h4 class="text-lg font-semibold text-gray-900">Informasi Kepegawaian</h4>
                                <p class="text-sm text-gray-600">Isi bagian ini hanya untuk pegawai dan admin</p>
                                
                                <!-- Employee ID -->
                                <div>
                                    <label for="employee_id" class="block text-sm font-medium text-gray-700">ID Pegawai</label>
                                    <input type="text" name="employee_id" id="employee_id" value="<?php echo e(old('employee_id')); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="PEG001">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika bukan pegawai</p>
                                </div>

                                <!-- Position -->
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <input type="text" name="position" id="position" value="<?php echo e(old('position')); ?>" 
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Contoh: Staff Pelayanan">
                                </div>

                                <!-- Department -->
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <select name="department" id="department" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Departemen</option>
                                        <option value="Pimpinan" <?php echo e(old('department') === 'Pimpinan' ? 'selected' : ''); ?>>Pimpinan</option>
                                        <option value="Sekretariat" <?php echo e(old('department') === 'Sekretariat' ? 'selected' : ''); ?>>Sekretariat</option>
                                        <option value="Pelayanan" <?php echo e(old('department') === 'Pelayanan' ? 'selected' : ''); ?>>Pelayanan</option>
                                        <option value="Kependudukan" <?php echo e(old('department') === 'Kependudukan' ? 'selected' : ''); ?>>Kependudukan</option>
                                        <option value="Pemberdayaan" <?php echo e(old('department') === 'Pemberdayaan' ? 'selected' : ''); ?>>Pemberdayaan</option>
                                        <option value="Keamanan" <?php echo e(old('department') === 'Keamanan' ? 'selected' : ''); ?>>Keamanan</option>
                                        <option value="IT" <?php echo e(old('department') === 'IT' ? 'selected' : ''); ?>>IT</option>
                                    </select>
                                </div>

                                <!-- Info Box -->
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Password default akan dikirim ke email pengguna</li>
                                                    <li>Pengguna dapat mengubah password setelah login pertama</li>
                                                    <li>Informasi kepegawaian hanya diperlukan untuk role Admin dan Pegawai</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Buat Pengguna
                                </button>
                                <a href="<?php echo e(route('admin.users')); ?>" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Batal
                                </a>
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="text-red-500">*</span> Wajib diisi
                            </div>
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
                employeeIdField.removeAttribute('required');
            } else {
                employmentInfo.style.opacity = '1';
                if (this.value === 'admin' || this.value === 'pegawai') {
                    employeeIdField.setAttribute('required', 'required');
                }
            }
        });
        
        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password !== confirmation) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
        
        document.getElementById('password').addEventListener('input', function() {
            const confirmation = document.getElementById('password_confirmation');
            if (confirmation.value) {
                confirmation.dispatchEvent(new Event('input'));
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
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\users\create.blade.php ENDPATH**/ ?>