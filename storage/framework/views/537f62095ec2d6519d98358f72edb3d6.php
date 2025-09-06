<?php $__env->startSection('title', 'Antrian'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Antrian Layanan</h2>
                <p class="text-blue-100">Kelola antrian yang Anda layani dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-clock text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>
    
    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Error Message -->
    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl p-4 md:p-6 card-shadow">
        <form method="GET" action="<?php echo e(route('pegawai.antrian.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Cari nomor antrian, nama, NIK, atau telepon..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                <?php echo e($status); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Layanan</option>
                        <?php $__currentLoopData = $jenisLayananOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($jenis); ?>" <?php echo e(request('jenis_layanan') == $jenis ? 'selected' : ''); ?>>
                                <?php echo e($jenis); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" value="<?php echo e(request('tanggal')); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-end space-y-2 sm:space-y-0 sm:space-x-2 lg:col-span-1">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="<?php echo e(route('pegawai.antrian.index')); ?>" class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Antrian</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($antrians->total()); ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-list text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($antrians->where('status', 'Menunggu')->count()); ?></p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Dilayani</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($antrians->where('status', 'Dilayani')->count()); ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-check text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-600"><?php echo e($antrians->where('status', 'Selesai')->count()); ?></p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <i class="fas fa-check text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrian Table -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Antrian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengunjung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $antrians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $antrian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($antrian->nomor_antrian); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($antrian->nama_pengunjung); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($antrian->phone_pengunjung); ?></div>
                                <?php if($antrian->nik_pengunjung): ?>
                                    <div class="text-xs text-gray-400">NIK: <?php echo e($antrian->nik_pengunjung); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($antrian->jenis_layanan); ?></div>
                                <?php if($antrian->keperluan): ?>
                                    <div class="text-xs text-gray-500"><?php echo e(Str::limit($antrian->keperluan, 30)); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($antrian->tanggal_kunjungan->format('d/m/Y')); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($antrian->jam_kunjungan->format('H:i')); ?></div>
                                <?php if($antrian->estimasi_waktu): ?>
                                    <div class="text-xs text-gray-400">~<?php echo e($antrian->estimasi_waktu); ?> menit</div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusColors = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Dipanggil' => 'bg-blue-100 text-blue-800',
                                        'Dilayani' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-gray-100 text-gray-800',
                                        'Batal' => 'bg-red-100 text-red-800'
                                    ];
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColors[$antrian->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($antrian->status); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('pegawai.antrian.show', $antrian)); ?>" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Quick Actions for Pegawai -->
                                    <?php if($antrian->status === 'Menunggu'): ?>
                                        <form action="<?php echo e(route('pegawai.antrian.call', $antrian)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="Panggil">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if(in_array($antrian->status, ['Menunggu', 'Dipanggil'])): ?>
                                        <form action="<?php echo e(route('pegawai.antrian.serve', $antrian)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Mulai Layani">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if($antrian->status === 'Dilayani'): ?>
                                        <form action="<?php echo e(route('pegawai.antrian.complete', $antrian)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-purple-600 hover:text-purple-900" title="Selesaikan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if(in_array($antrian->status, ['Menunggu', 'Dipanggil'])): ?>
                                        <form action="<?php echo e(route('pegawai.antrian.cancel', $antrian)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Batalkan" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada data antrian</p>
                                    <p class="text-sm">Antrian akan muncul ketika ada pengunjung yang mendaftar</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $antrians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $antrian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-lg font-bold text-gray-900"><?php echo e($antrian->nomor_antrian); ?></span>
                                <?php
                                    $statusColors = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Dipanggil' => 'bg-blue-100 text-blue-800',
                                        'Dilayani' => 'bg-green-100 text-green-800',
                                        'Selesai' => 'bg-gray-100 text-gray-800',
                                        'Batal' => 'bg-red-100 text-red-800'
                                    ];
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusColors[$antrian->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($antrian->status); ?>

                                </span>
                            </div>
                            <div class="text-sm font-medium text-gray-900 mb-1"><?php echo e($antrian->nama_pengunjung); ?></div>
                            <div class="text-sm text-gray-500 mb-1"><?php echo e($antrian->phone_pengunjung); ?></div>
                            <?php if($antrian->nik_pengunjung): ?>
                                <div class="text-xs text-gray-400 mb-2">NIK: <?php echo e($antrian->nik_pengunjung); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3 text-sm">
                        <div>
                            <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Layanan</div>
                            <div class="text-gray-900"><?php echo e($antrian->jenis_layanan); ?></div>
                            <?php if($antrian->keperluan): ?>
                                <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($antrian->keperluan, 40)); ?></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="text-gray-500 text-xs uppercase tracking-wider mb-1">Jadwal</div>
                            <div class="text-gray-900"><?php echo e($antrian->tanggal_kunjungan->format('d/m/Y')); ?></div>
                            <div class="text-gray-500"><?php echo e($antrian->jam_kunjungan->format('H:i')); ?></div>
                            <?php if($antrian->estimasi_waktu): ?>
                                <div class="text-xs text-gray-400">~<?php echo e($antrian->estimasi_waktu); ?> menit</div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Mobile Actions -->
                    <div class="flex flex-wrap gap-2">
                        <a href="<?php echo e(route('pegawai.antrian.show', $antrian)); ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-200">
                            <i class="fas fa-eye mr-1"></i>Detail
                        </a>
                        
                        <?php if($antrian->status === 'Menunggu'): ?>
                            <form action="<?php echo e(route('pegawai.antrian.call', $antrian)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-200">
                                    <i class="fas fa-phone mr-1"></i>Panggil
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if(in_array($antrian->status, ['Menunggu', 'Dipanggil'])): ?>
                            <form action="<?php echo e(route('pegawai.antrian.serve', $antrian)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-xs font-medium rounded-lg hover:bg-green-200">
                                    <i class="fas fa-play mr-1"></i>Layani
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if($antrian->status === 'Dilayani'): ?>
                            <form action="<?php echo e(route('pegawai.antrian.complete', $antrian)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-medium rounded-lg hover:bg-purple-200">
                                    <i class="fas fa-check mr-1"></i>Selesai
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if(in_array($antrian->status, ['Menunggu', 'Dipanggil'])): ?>
                            <form action="<?php echo e(route('pegawai.antrian.cancel', $antrian)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200" onclick="return confirm('Yakin ingin membatalkan antrian ini?')">
                                    <i class="fas fa-times mr-1"></i>Batal
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-clock text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium">Belum ada data antrian</p>
                        <p class="text-sm">Antrian akan muncul ketika ada pengunjung yang mendaftar</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($antrians->hasPages()): ?>
            <div class="px-4 md:px-6 py-4 border-t border-gray-200 bg-gray-50">
                <?php echo e($antrians->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\pegawai\antrian\index.blade.php ENDPATH**/ ?>