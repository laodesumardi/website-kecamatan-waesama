<?php $__env->startSection('title', 'Layanan Surat'); ?>



<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Layanan Surat</h1>
                <p class="text-gray-600">Kelola permohonan surat-menyurat dari masyarakat</p>
            </div>
            <a href="<?php echo e(route('admin.surat.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Surat
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="<?php echo e(route('admin.surat.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Nomor surat, nama, NIK..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Jenis Surat Filter -->
                <div>
                    <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat</label>
                    <select id="jenis_surat" name="jenis_surat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis</option>
                        <option value="Domisili" <?php echo e(request('jenis_surat') == 'Domisili' ? 'selected' : ''); ?>>Domisili</option>
                        <option value="SKTM" <?php echo e(request('jenis_surat') == 'SKTM' ? 'selected' : ''); ?>>SKTM</option>
                        <option value="Usaha" <?php echo e(request('jenis_surat') == 'Usaha' ? 'selected' : ''); ?>>Usaha</option>
                        <option value="Pengantar" <?php echo e(request('jenis_surat') == 'Pengantar' ? 'selected' : ''); ?>>Pengantar</option>
                        <option value="Kematian" <?php echo e(request('jenis_surat') == 'Kematian' ? 'selected' : ''); ?>>Kematian</option>
                        <option value="Kelahiran" <?php echo e(request('jenis_surat') == 'Kelahiran' ? 'selected' : ''); ?>>Kelahiran</option>
                        <option value="Pindah" <?php echo e(request('jenis_surat') == 'Pindah' ? 'selected' : ''); ?>>Pindah</option>
                    </select>
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="Pending" <?php echo e(request('status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="Diproses" <?php echo e(request('status') == 'Diproses' ? 'selected' : ''); ?>>Diproses</option>
                        <option value="Selesai" <?php echo e(request('status') == 'Selesai' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="Ditolak" <?php echo e(request('status') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                <a href="<?php echo e(route('admin.surat.index')); ?>" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-undo"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $surat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($item->nomor_surat); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php switch($item->jenis_surat):
                                        case ('Domisili'): ?>
                                            bg-blue-100 text-blue-800
                                            <?php break; ?>
                                        <?php case ('SKTM'): ?>
                                            bg-green-100 text-green-800
                                            <?php break; ?>
                                        <?php case ('Usaha'): ?>
                                            bg-purple-100 text-purple-800
                                            <?php break; ?>
                                        <?php case ('Pengantar'): ?>
                                            bg-yellow-100 text-yellow-800
                                            <?php break; ?>
                                        <?php case ('Kematian'): ?>
                                            bg-red-100 text-red-800
                                            <?php break; ?>
                                        <?php case ('Kelahiran'): ?>
                                            bg-pink-100 text-pink-800
                                            <?php break; ?>
                                        <?php case ('Pindah'): ?>
                                            bg-indigo-100 text-indigo-800
                                            <?php break; ?>
                                        <?php default: ?>
                                            bg-gray-100 text-gray-800
                                    <?php endswitch; ?>">
                                    <?php echo e($item->jenis_surat); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($item->nama_pemohon); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($item->nik_pemohon); ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900"><?php echo e(Str::limit($item->keperluan, 50)); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php switch($item->status):
                                        case ('Pending'): ?>
                                            bg-yellow-100 text-yellow-800
                                            <?php break; ?>
                                        <?php case ('Diproses'): ?>
                                            bg-blue-100 text-blue-800
                                            <?php break; ?>
                                        <?php case ('Selesai'): ?>
                                            bg-green-100 text-green-800
                                            <?php break; ?>
                                        <?php case ('Ditolak'): ?>
                                            bg-red-100 text-red-800
                                            <?php break; ?>
                                        <?php default: ?>
                                            bg-gray-100 text-gray-800
                                    <?php endswitch; ?>">
                                    <?php echo e($item->status); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($item->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="<?php echo e(route('admin.surat.show', $item)); ?>" 
                                       class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.surat.edit', $item)); ?>" 
                                       class="text-green-600 hover:text-green-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.surat.export-pdf', $item)); ?>" 
                                       class="text-purple-600 hover:text-purple-900" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <?php if($item->status === 'Selesai' && $item->file_surat): ?>
                                    <a href="<?php echo e(route('admin.surat.download', $item)); ?>" 
                                       class="text-orange-600 hover:text-orange-900" title="Download File">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('admin.surat.destroy', $item)); ?>" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-file-alt text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-lg font-medium text-gray-400">Tidak ada data surat</p>
                                    <p class="text-sm text-gray-400">Belum ada permohonan surat yang masuk</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($surat->hasPages()): ?>
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <?php echo e($surat->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\surat\index.blade.php ENDPATH**/ ?>