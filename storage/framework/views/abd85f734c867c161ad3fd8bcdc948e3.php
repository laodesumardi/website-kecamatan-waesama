<!-- Surat Statistics -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Status Breakdown -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Surat</h3>
        <?php if(isset($data['status_breakdown']) && $data['status_breakdown']->count() > 0): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $data['status_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600"><?php echo e($status->status); ?></span>
                        <span class="font-semibold 
                            <?php if($status->status == 'Selesai'): ?> text-green-600
                            <?php elseif($status->status == 'Diproses'): ?> text-blue-600
                            <?php elseif($status->status == 'Pending'): ?> text-yellow-600
                            <?php else: ?> text-gray-600
                            <?php endif; ?>
                        "><?php echo e(number_format($status->total)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">Tidak ada data status surat</p>
        <?php endif; ?>
    </div>
    
    <!-- Jenis Surat Breakdown -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jenis Surat</h3>
        <?php if(isset($data['jenis_breakdown']) && $data['jenis_breakdown']->count() > 0): ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $data['jenis_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm"><?php echo e($jenis->jenis_surat); ?></span>
                        <span class="font-semibold text-blue-600"><?php echo e(number_format($jenis->total)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">Tidak ada data jenis surat</p>
        <?php endif; ?>
    </div>
    
    <!-- Summary -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Total Surat</span>
                <span class="font-semibold text-blue-600"><?php echo e(number_format($data['my_surat']->count() ?? 0)); ?></span>
            </div>
            <?php
                $completed = $data['status_breakdown']->where('status', 'Selesai')->first()->total ?? 0;
                $total = $data['my_surat']->count() ?? 0;
                $completionRate = $total > 0 ? ($completed / $total) * 100 : 0;
            ?>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tingkat Penyelesaian</span>
                <span class="font-semibold text-green-600"><?php echo e(number_format($completionRate, 1)); ?>%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e($completionRate); ?>%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Surat List -->
<div class="bg-white rounded-xl p-6 card-shadow">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Daftar Surat yang Saya Proses</h3>
            <p class="text-gray-600">Detail surat yang telah Anda proses dalam periode yang dipilih</p>
        </div>
    </div>
    
    <?php if(isset($data['my_surat']) && $data['my_surat']->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $data['my_surat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $surat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($surat->nomor_surat); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($surat->jenis_surat); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($surat->nama_pemohon); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php if($surat->status == 'Selesai'): ?> bg-green-100 text-green-800
                                    <?php elseif($surat->status == 'Diproses'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($surat->status == 'Pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php else: ?> bg-gray-100 text-gray-800
                                    <?php endif; ?>
                                ">
                                    <?php echo e($surat->status); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($surat->created_at->format('d/m/Y H:i')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <i class="fas fa-file-alt text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data surat</h3>
            <p class="text-gray-500">Belum ada surat yang Anda proses dalam periode yang dipilih.</p>
        </div>
    <?php endif; ?>
</div><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\pegawai\laporan\partials\surat.blade.php ENDPATH**/ ?>