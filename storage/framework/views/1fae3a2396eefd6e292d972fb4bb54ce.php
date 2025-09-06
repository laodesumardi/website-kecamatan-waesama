<?php $__env->startSection('title', 'Informasi Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex items-center space-x-2 text-sm text-blue-200 mb-2">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-white">Dashboard</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="hover:text-white">Pengaturan</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-white">Informasi Sistem</span>
                </nav>
                <h2 class="text-2xl font-bold mb-2">Informasi Sistem</h2>
                <p class="text-blue-100">Detail informasi server dan konfigurasi sistem.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-server text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div>
        <a href="<?php echo e(route('admin.settings.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Pengaturan
        </a>
    </div>

    <!-- System Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- PHP Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fab fa-php text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">PHP</h3>
                    <p class="text-sm text-gray-600">Versi & Konfigurasi</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Versi:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['php_version']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Memory Limit:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['memory_limit']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Max Execution:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['max_execution_time']); ?>s</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Upload Max:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['upload_max_filesize']); ?></span>
                </div>
            </div>
        </div>

        <!-- Laravel Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="fab fa-laravel text-2xl text-red-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Laravel</h3>
                    <p class="text-sm text-gray-600">Framework</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Versi:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['laravel_version']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Environment:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(app()->environment()); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Debug Mode:</span>
                    <span class="text-sm font-medium <?php echo e(config('app.debug') ? 'text-red-600' : 'text-green-600'); ?>">
                        <?php echo e(config('app.debug') ? 'Aktif' : 'Nonaktif'); ?>

                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Timezone:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('app.timezone')); ?></span>
                </div>
            </div>
        </div>

        <!-- Server Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-server text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Server</h3>
                    <p class="text-sm text-gray-600">Informasi Server</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Software:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['server_software']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">OS:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(PHP_OS); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Architecture:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(php_uname('m')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Host:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(php_uname('n')); ?></span>
                </div>
            </div>
        </div>

        <!-- Database Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="fas fa-database text-2xl text-orange-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Database</h3>
                    <p class="text-sm text-gray-600">Informasi Database</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Driver:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('database.default')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Versi:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['database_version']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Host:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('database.connections.mysql.host')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Database:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('database.connections.mysql.database')); ?></span>
                </div>
            </div>
        </div>

        <!-- Storage Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-hdd text-2xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Storage</h3>
                    <p class="text-sm text-gray-600">Penyimpanan</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Terpakai:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['storage_used']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Tersedia:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e($info['storage_free']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Path:</span>
                    <span class="text-sm font-medium text-gray-800 truncate"><?php echo e(storage_path()); ?></span>
                </div>
            </div>
        </div>

        <!-- Application Information -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 p-3 rounded-lg">
                    <i class="fas fa-cogs text-2xl text-indigo-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Aplikasi</h3>
                    <p class="text-sm text-gray-600">Konfigurasi App</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nama:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('app.name')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">URL:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('app.url')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Locale:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('app.locale')); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Cache Driver:</span>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(config('cache.default')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- PHP Extensions -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">PHP Extensions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
            <?php
                $extensions = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath', 'curl', 'fileinfo', 'gd', 'zip'];
            ?>
            <?php $__currentLoopData = $extensions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ext): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center space-x-2 p-2 rounded-lg <?php echo e(extension_loaded($ext) ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'); ?>">
                    <i class="fas <?php echo e(extension_loaded($ext) ? 'fa-check-circle' : 'fa-times-circle'); ?> text-sm"></i>
                    <span class="text-sm font-medium"><?php echo e($ext); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Sistem</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                <div>
                    <p class="text-sm font-medium text-green-800">Database</p>
                    <p class="text-xs text-green-600">Terhubung</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 p-3 <?php echo e(is_writable(storage_path()) ? 'bg-green-50' : 'bg-red-50'); ?> rounded-lg">
                <i class="fas <?php echo e(is_writable(storage_path()) ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600'); ?> text-xl"></i>
                <div>
                    <p class="text-sm font-medium <?php echo e(is_writable(storage_path()) ? 'text-green-800' : 'text-red-800'); ?>">Storage</p>
                    <p class="text-xs <?php echo e(is_writable(storage_path()) ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e(is_writable(storage_path()) ? 'Writable' : 'Not Writable'); ?></p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 p-3 <?php echo e(is_writable(base_path('bootstrap/cache')) ? 'bg-green-50' : 'bg-red-50'); ?> rounded-lg">
                <i class="fas <?php echo e(is_writable(base_path('bootstrap/cache')) ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600'); ?> text-xl"></i>
                <div>
                    <p class="text-sm font-medium <?php echo e(is_writable(base_path('bootstrap/cache')) ? 'text-green-800' : 'text-red-800'); ?>">Bootstrap Cache</p>
                    <p class="text-xs <?php echo e(is_writable(base_path('bootstrap/cache')) ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e(is_writable(base_path('bootstrap/cache')) ? 'Writable' : 'Not Writable'); ?></p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 p-3 <?php echo e(config('app.key') ? 'bg-green-50' : 'bg-red-50'); ?> rounded-lg">
                <i class="fas <?php echo e(config('app.key') ? 'fa-check-circle text-green-600' : 'fa-times-circle text-red-600'); ?> text-xl"></i>
                <div>
                    <p class="text-sm font-medium <?php echo e(config('app.key') ? 'text-green-800' : 'text-red-800'); ?>">App Key</p>
                    <p class="text-xs <?php echo e(config('app.key') ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e(config('app.key') ? 'Set' : 'Not Set'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\settings\system-info.blade.php ENDPATH**/ ?>