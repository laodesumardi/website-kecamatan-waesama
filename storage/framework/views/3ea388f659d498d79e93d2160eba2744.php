<?php $__env->startSection('title', 'Pengaduan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-[#003f88] rounded-xl p-6 text-white bg-[#001d3d] ">
        <div class="flex items-center justify-between ">
            <div>
                <h2 class="text-2xl font-bold mb-2">Manajemen Pengaduan</h2>
                <p class="text-blue-100">Kelola pengaduan masyarakat dengan mudah dan efisien.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-comments text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-xl p-6 card-shadow mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Filter & Pencarian</h3>
            <a href="<?php echo e(route('admin.pengaduan.create')); ?>" class="bg-[#003f88] text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Pengaduan</span>
            </a>
        </div>
                <form method="GET" action="<?php echo e(route('admin.pengaduan.index')); ?>" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>" placeholder="Nomor, nama, judul, email, telepon..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Status</option>
                                <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>><?php echo e($status); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Kategori Filter -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="kategori" id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                <?php $__currentLoopData = $kategoriOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($kategori); ?>" <?php echo e(request('kategori') == $kategori ? 'selected' : ''); ?>><?php echo e($kategori); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Prioritas Filter -->
                        <div>
                            <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            <select name="prioritas" id="prioritas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Prioritas</option>
                                <?php $__currentLoopData = $prioritasOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prioritas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prioritas); ?>" <?php echo e(request('prioritas') == $prioritas ? 'selected' : ''); ?>><?php echo e($prioritas); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Handler Filter -->
                        <div>
                            <label for="handler" class="block text-sm font-medium text-gray-700 mb-1">Petugas</label>
                            <select name="handler" id="handler" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Petugas</option>
                                <?php $__currentLoopData = $pegawaiUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pegawai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pegawai->id); ?>" <?php echo e(request('handler') == $pegawai->id ? 'selected' : ''); ?>><?php echo e($pegawai->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-[#003f88] text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <i class="fas fa-search"></i>
                            <span>Cari</span>
                        </button>
                        <a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                            <i class="fas fa-refresh"></i>
                            <span>Reset</span>
                        </a>
                    </div>
                </form>
            </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl card-shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor & Pengadu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul & Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $pengaduan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($item->nomor_pengaduan); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($item->nama_pengadu); ?></div>
                                        <div class="text-xs text-gray-400"><?php echo e($item->phone_pengadu); ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 max-w-xs truncate"><?php echo e($item->judul_pengaduan); ?></div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            <?php if($item->kategori === 'Pelayanan'): ?> bg-blue-100 text-blue-800
                                            <?php elseif($item->kategori === 'Infrastruktur'): ?> bg-green-100 text-green-800
                                            <?php elseif($item->kategori === 'Keamanan'): ?> bg-red-100 text-red-800
                                            <?php elseif($item->kategori === 'Kebersihan'): ?> bg-yellow-100 text-yellow-800
                                            <?php else: ?> bg-gray-100 text-gray-800
                                            <?php endif; ?>">
                                            <?php echo e($item->kategori); ?>

                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php if($item->prioritas === 'Urgent'): ?> bg-red-100 text-red-800
                                        <?php elseif($item->prioritas === 'Tinggi'): ?> bg-orange-100 text-orange-800
                                        <?php elseif($item->prioritas === 'Sedang'): ?> bg-yellow-100 text-yellow-800
                                        <?php else: ?> bg-green-100 text-green-800
                                        <?php endif; ?>">
                                        <?php echo e($item->prioritas); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php if($item->status === 'Diterima'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($item->status === 'Diproses'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($item->status === 'Ditindaklanjuti'): ?> bg-purple-100 text-purple-800
                                        <?php elseif($item->status === 'Selesai'): ?> bg-green-100 text-green-800
                                        <?php else: ?> bg-red-100 text-red-800
                                        <?php endif; ?>">
                                        <?php echo e($item->status); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($item->handler ? $item->handler->name : '-'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($item->created_at->format('d/m/Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="<?php echo e(route('admin.pengaduan.show', $item)); ?>" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.pengaduan.edit', $item)); ?>" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.pengaduan.export-pdf', $item)); ?>" class="text-purple-600 hover:text-purple-900" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <?php if($item->lampiran): ?>
                                    <a href="<?php echo e(route('admin.pengaduan.download', $item)); ?>" class="text-orange-600 hover:text-orange-900" title="Download Lampiran">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('admin.pengaduan.destroy', $item)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <!-- Quick Actions -->
                                    <?php if($item->status === 'Diterima'): ?>
                                        <form action="<?php echo e(route('admin.pengaduan.process', $item)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Proses">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Tidak ada pengaduan</p>
                                    <p class="text-sm">Belum ada pengaduan yang terdaftar dalam sistem.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

        <!-- Pagination -->
        <?php if($pengaduan->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($pengaduan->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\pengaduan\index.blade.php ENDPATH**/ ?>