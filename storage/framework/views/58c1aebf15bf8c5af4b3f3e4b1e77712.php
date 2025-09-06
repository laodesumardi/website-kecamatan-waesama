<?php $__env->startSection('title', 'Data Penduduk'); ?>

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="bg-[#003f88] rounded-xl p-6 text-white mb-6">
    <div class="flex items-center justify-between">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-blue-200 mb-2">
                <a href="<?php echo e(route('pegawai.dashboard')); ?>" class="hover:text-white">Dashboard</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">Data Penduduk</span>
            </nav>
            <h2 class="text-2xl font-bold mb-2">Data Penduduk</h2>
            <p class="text-blue-100">Lihat dan cari data penduduk Kecamatan Waesama</p>
        </div>
        <div class="hidden md:block">
            <i class="fas fa-users text-6xl text-blue-200"></i>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="bg-white rounded-xl p-6 card-shadow mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Search -->
        <div class="flex-1 max-w-md">
            <form method="GET" action="<?php echo e(route('pegawai.penduduk.index')); ?>" class="flex gap-2">
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
                <input type="hidden" name="rt" value="<?php echo e(request('rt')); ?>">
                <input type="hidden" name="rw" value="<?php echo e(request('rw')); ?>">
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="<?php echo e(request('search')); ?>"
                        placeholder="Cari NIK, nama, alamat, atau No. KK..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <!-- Filters -->
        <div class="flex flex-wrap gap-2">
            <!-- Status Filter -->
            <form method="GET" action="<?php echo e(route('pegawai.penduduk.index')); ?>" class="inline">
                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
                <input type="hidden" name="rt" value="<?php echo e(request('rt')); ?>">
                <input type="hidden" name="rw" value="<?php echo e(request('rw')); ?>">
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Tetap" <?php echo e(request('status') == 'Tetap' ? 'selected' : ''); ?>>Tetap</option>
                    <option value="Pindah" <?php echo e(request('status') == 'Pindah' ? 'selected' : ''); ?>>Pindah</option>
                    <option value="Meninggal" <?php echo e(request('status') == 'Meninggal' ? 'selected' : ''); ?>>Meninggal</option>
                </select>
            </form>
            
            <!-- Gender Filter -->
            <form method="GET" action="<?php echo e(route('pegawai.penduduk.index')); ?>" class="inline">
                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <input type="hidden" name="rt" value="<?php echo e(request('rt')); ?>">
                <input type="hidden" name="rw" value="<?php echo e(request('rw')); ?>">
                <select name="gender" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="L" <?php echo e(request('gender') == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                    <option value="P" <?php echo e(request('gender') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                </select>
            </form>
            
            <!-- RT Filter -->
            <form method="GET" action="<?php echo e(route('pegawai.penduduk.index')); ?>" class="inline">
                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
                <input type="hidden" name="rw" value="<?php echo e(request('rw')); ?>">
                <select name="rt" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua RT</option>
                    <?php $__currentLoopData = $rtOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($rt); ?>" <?php echo e(request('rt') == $rt ? 'selected' : ''); ?>>RT <?php echo e($rt); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
            
            <!-- RW Filter -->
            <form method="GET" action="<?php echo e(route('pegawai.penduduk.index')); ?>" class="inline">
                <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <input type="hidden" name="gender" value="<?php echo e(request('gender')); ?>">
                <input type="hidden" name="rt" value="<?php echo e(request('rt')); ?>">
                <select name="rw" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua RW</option>
                    <?php $__currentLoopData = $rwOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($rw); ?>" <?php echo e(request('rw') == $rw ? 'selected' : ''); ?>>RW <?php echo e($rw); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="mb-6">
    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="fas fa-file-excel"></i>
        Import Excel
    </button>
</div>

<!-- Data Table -->
<div class="bg-white rounded-xl card-shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $penduduk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo e($item->nik); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($item->nama_lengkap); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($item->tempat_lahir); ?>, <?php echo e($item->tanggal_lahir->format('d/m/Y')); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($item->jenis_kelamin == 'L' ? 'Laki-laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : $item->jenis_kelamin)); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div><?php echo e($item->alamat); ?></div>
                            <div class="text-gray-500">RT <?php echo e($item->rt); ?>/RW <?php echo e($item->rw); ?>, <?php echo e($item->desa_kelurahan); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php if($item->status_penduduk == 'Tetap'): ?> bg-green-100 text-green-800
                                <?php elseif($item->status_penduduk == 'Pindah'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                <?php echo e($item->status_penduduk); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('pegawai.penduduk.show', $item)); ?>" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center py-8">
                                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">Tidak ada data penduduk</p>
                                <p class="text-sm">Data penduduk tidak ditemukan dengan kriteria pencarian saat ini</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($penduduk->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($penduduk->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Penduduk</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($penduduk->total()); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Status Tetap</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($penduduk->where('status_penduduk', 'Tetap')->count()); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-mars text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Laki-laki</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($penduduk->where('jenis_kelamin', 'L')->count()); ?></p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                <i class="fas fa-venus text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Perempuan</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($penduduk->where('jenis_kelamin', 'P')->count()); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Import Excel Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Penduduk dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('pegawai.penduduk.import')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Pilih File Excel</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format file yang didukung: .xlsx, .xls (Maksimal 10MB)</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6>Format Excel yang diperlukan:</h6>
                        <p class="mb-1">Kolom yang harus ada (urutan kolom A-L):</p>
                        <ol class="mb-0">
                            <li>NIK</li>
                            <li>Nama Lengkap</li>
                            <li>Tempat Lahir</li>
                            <li>Tanggal Lahir (format: YYYY-MM-DD)</li>
                            <li>Jenis Kelamin (L/P)</li>
                            <li>Alamat</li>
                            <li>RT</li>
                            <li>RW</li>
                            <li>Agama</li>
                            <li>Status Perkawinan</li>
                            <li>Pekerjaan</li>
                            <li>Kewarganegaraan</li>
                        </ol>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\pegawai\penduduk\index.blade.php ENDPATH**/ ?>