<?php $__env->startSection('title', 'Edit User'); ?>

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
                    <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
                    <nav class="text-sm text-gray-600">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-blue-600">Dashboard</a>
                        <span class="mx-2">/</span>
                        <a href="<?php echo e(route('admin.user.index')); ?>" class="hover:text-blue-600">Manajemen User</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800">Edit User</span>
                    </nav>
                </div>
            </div>
        </div>
        <p class="text-gray-600">Perbarui informasi user <?php echo e($user->name); ?></p>
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

    <!-- Form -->
    <form action="<?php echo e(route('admin.user.update', $user)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Account Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                Informasi Akun
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           required>
                    <?php $__errorArgs = ['name'];
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
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           required>
                    <?php $__errorArgs = ['email'];
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
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                    <?php $__errorArgs = ['password'];
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
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="Konfirmasi password baru">
                </div>
                
                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select id="role_id" name="role_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            required>
                        <option value="">Pilih Role</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->id); ?>" <?php echo e(old('role_id', $user->role_id) == $role->id ? 'selected' : ''); ?>>
                                <?php echo e($role->display_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['role_id'];
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
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Akun</label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="1" 
                                   <?php echo e(old('is_active', $user->is_active) == '1' ? 'checked' : ''); ?>

                                   class="mr-2 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="is_active" value="0" 
                                   <?php echo e(old('is_active', $user->is_active) == '0' ? 'checked' : ''); ?>

                                   class="mr-2 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Tidak Aktif</span>
                        </label>
                    </div>
                    <?php $__errorArgs = ['is_active'];
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
        
        <!-- Personal Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-id-card mr-2 text-blue-600"></i>
                Informasi Personal
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" id="nik" name="nik" value="<?php echo e(old('nik', $user->nik)); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           placeholder="Nomor Induk Kependudukan" maxlength="16" pattern="[0-9]{16}">
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
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           placeholder="08xxxxxxxxxx">
                    <?php $__errorArgs = ['phone'];
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
                
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" value="<?php echo e(old('birth_date', $user->birth_date?->format('Y-m-d'))); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['birth_date'];
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
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select id="gender" name="gender" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?php echo e(old('gender', $user->gender) == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                        <option value="P" <?php echo e(old('gender', $user->gender) == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                    </select>
                    <?php $__errorArgs = ['gender'];
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
                
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              placeholder="Alamat lengkap"><?php echo e(old('address', $user->address)); ?></textarea>
                    <?php $__errorArgs = ['address'];
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
        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('admin.user.show', $user)); ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
// NIK validation
document.getElementById('nik').addEventListener('input', function(e) {
    // Only allow numbers
    this.value = this.value.replace(/[^0-9]/g, '');
    
    // Limit to 16 digits
    if (this.value.length > 16) {
        this.value = this.value.slice(0, 16);
    }
});

// Phone validation
document.getElementById('phone').addEventListener('input', function(e) {
    // Only allow numbers, +, -, (, ), and spaces
    this.value = this.value.replace(/[^0-9+\-\(\)\s]/g, '');
});

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function(e) {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    if (password !== confirmation && confirmation !== '') {
        this.setCustomValidity('Password tidak cocok');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function(e) {
    const confirmation = document.getElementById('password_confirmation');
    if (confirmation.value !== '') {
        confirmation.dispatchEvent(new Event('input'));
    }
});

// Status change warning
const statusRadios = document.querySelectorAll('input[name="is_active"]');
const originalStatus = '<?php echo e($user->is_active); ?>';

statusRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value !== originalStatus) {
            if (this.value === '0') {
                if (!confirm('Apakah Anda yakin ingin menonaktifkan user ini? User yang dinonaktifkan tidak dapat login ke sistem.')) {
                    document.querySelector(`input[name="is_active"][value="${originalStatus}"]`).checked = true;
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\user\edit.blade.php ENDPATH**/ ?>