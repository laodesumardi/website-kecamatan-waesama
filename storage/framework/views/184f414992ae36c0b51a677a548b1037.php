<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Permohonan Surat</h3>
                    <div>
                        <?php if($serviceRequest->canBeProcessed()): ?>
                        <a href="<?php echo e(route('admin.service-requests.edit', $serviceRequest)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.service-requests.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Permohonan -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Permohonan</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nomor Permohonan:</strong></td>
                                    <td><?php echo e($serviceRequest->request_number); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Layanan:</strong></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo e(str_replace('_', ' ', ucwords($serviceRequest->service_type, '_'))); ?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><?php echo $serviceRequest->status_badge; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Prioritas:</strong></td>
                                    <td><?php echo $serviceRequest->priority_badge; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Dibuat:</strong></td>
                                    <td><?php echo e($serviceRequest->created_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <?php if($serviceRequest->required_date): ?>
                                <tr>
                                    <td><strong>Tanggal Dibutuhkan:</strong></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($serviceRequest->required_date)->format('d/m/Y')); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($serviceRequest->processed_at): ?>
                                <tr>
                                    <td><strong>Tanggal Diproses:</strong></td>
                                    <td><?php echo e($serviceRequest->processed_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($serviceRequest->approved_at): ?>
                                <tr>
                                    <td><strong>Tanggal Disetujui:</strong></td>
                                    <td><?php echo e($serviceRequest->approved_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($serviceRequest->completed_at): ?>
                                <tr>
                                    <td><strong>Tanggal Selesai:</strong></td>
                                    <td><?php echo e($serviceRequest->completed_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                        <!-- Informasi Pemohon -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Pemohon</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->name); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIK:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->nik); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tempat, Tanggal Lahir:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->place_of_birth); ?>, <?php echo e(\Carbon\Carbon::parse($serviceRequest->citizen->date_of_birth)->format('d/m/Y')); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->address); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td><?php echo e($serviceRequest->citizen->phone ?? '-'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Keperluan dan Catatan -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Keperluan</h5>
                            <p class="text-justify"><?php echo e($serviceRequest->purpose); ?></p>
                        </div>
                        <?php if($serviceRequest->notes): ?>
                        <div class="col-md-6">
                            <h5 class="mb-3">Catatan</h5>
                            <p class="text-justify"><?php echo e($serviceRequest->notes); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($serviceRequest->template_variables): ?>
                    <hr>
                    <!-- Template Variables -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Tambahan</h5>
                            <div class="row">
                                <?php $__currentLoopData = $serviceRequest->template_variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 mb-2">
                                    <strong><?php echo e(str_replace('_', ' ', ucwords($key, '_'))); ?>:</strong>
                                    <span><?php echo e($value); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($serviceRequest->required_documents && count($serviceRequest->required_documents) > 0): ?>
                    <hr>
                    <!-- Dokumen Pendukung -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Dokumen Pendukung</h5>
                            <div class="row">
                                <?php $__currentLoopData = $serviceRequest->required_documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-alt fa-3x text-primary mb-2"></i>
                                            <p class="card-text small"><?php echo e(basename($document)); ?></p>
                                            <a href="<?php echo e(Storage::url($document)); ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($serviceRequest->processedBy || $serviceRequest->approvedBy): ?>
                    <hr>
                    <!-- Informasi Pemrosesan -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Informasi Pemrosesan</h5>
                            <div class="row">
                                <?php if($serviceRequest->processedBy): ?>
                                <div class="col-md-6">
                                    <strong>Diproses oleh:</strong>
                                    <span><?php echo e($serviceRequest->processedBy->name); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if($serviceRequest->approvedBy): ?>
                                <div class="col-md-6">
                                    <strong>Disetujui oleh:</strong>
                                    <span><?php echo e($serviceRequest->approvedBy->name); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($serviceRequest->documents->count() > 0): ?>
                    <hr>
                    <!-- Dokumen yang Dihasilkan -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3">Dokumen yang Dihasilkan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nomor Dokumen</th>
                                            <th>Template</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $serviceRequest->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($document->document_number); ?></td>
                                            <td><?php echo e(str_replace('_', ' ', ucwords($document->template_name, '_'))); ?></td>
                                            <td>
                                                <?php if($document->is_active): ?>
                                                <span class="badge bg-success">Aktif</span>
                                                <?php else: ?>
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($document->created_at->format('d/m/Y H:i')); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.documents.show', $document)); ?>" class="btn btn-sm btn-info" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.documents.download', $document)); ?>" class="btn btn-sm btn-success" title="Download">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.documents.preview', $document)); ?>" target="_blank" class="btn btn-sm btn-primary" title="Preview">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($serviceRequest->status === 'pending'): ?>
                            <form action="<?php echo e(route('admin.service-requests.process', $serviceRequest)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ingin memproses permohonan ini?')">
                                    <i class="fas fa-play"></i> Proses Permohonan
                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if($serviceRequest->status === 'processing'): ?>
                            <form action="<?php echo e(route('admin.service-requests.approve', $serviceRequest)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menyetujui permohonan ini?')">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.service-requests.reject', $serviceRequest)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak permohonan ini?')">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form>
                            <?php endif; ?>

                            <?php if($serviceRequest->status === 'approved'): ?>
                            <a href="<?php echo e(route('admin.documents.create', ['service_request_id' => $serviceRequest->id])); ?>" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Generate Dokumen
                            </a>
                            <form action="<?php echo e(route('admin.service-requests.complete', $serviceRequest)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin menyelesaikan permohonan ini?')">
                                    <i class="fas fa-check-double"></i> Selesaikan
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 text-end">
                            <?php if($serviceRequest->canBeProcessed()): ?>
                            <form action="<?php echo e(route('admin.service-requests.destroy', $serviceRequest)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus permohonan ini? Data yang terkait juga akan dihapus.')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\service-requests\show.blade.php ENDPATH**/ ?>