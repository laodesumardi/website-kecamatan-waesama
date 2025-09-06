<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Dokumen</h3>
                    <div class="btn-group">
                        <?php if($document->is_active): ?>
                            <a href="<?php echo e(route('admin.documents.download', $document)); ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <a href="<?php echo e(route('admin.documents.preview', $document)); ?>" class="btn btn-info btn-sm" target="_blank">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.documents.edit', $document)); ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <?php if($document->is_active): ?>
                            <form action="<?php echo e(route('admin.documents.deactivate', $document)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menonaktifkan dokumen ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-ban"></i> Nonaktifkan
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?php echo e(route('admin.documents.activate', $document)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Aktifkan
                                </button>
                            </form>
                        <?php endif; ?>
                        <form action="<?php echo e(route('admin.documents.destroy', $document)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini? Data yang sudah dihapus tidak dapat dikembalikan.')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Dokumen -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Dokumen</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nomor Dokumen</strong></td>
                                    <td>: <?php echo e($document->document_number); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Template</strong></td>
                                    <td>: <?php echo e(str_replace('_', ' ', ucwords($document->template_name, '_'))); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>: 
                                        <?php if($document->is_active): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Ukuran File</strong></td>
                                    <td>: <?php echo e($document->formatted_file_size); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Download</strong></td>
                                    <td>: <?php echo e(number_format($document->download_count)); ?> kali</td>
                                </tr>
                                <tr>
                                    <td><strong>Masa Berlaku</strong></td>
                                    <td>: 
                                        <?php if($document->valid_until): ?>
                                            <?php echo e($document->valid_until->format('d/m/Y')); ?>

                                            <?php if($document->is_valid): ?>
                                                <span class="badge bg-success ms-1">Valid</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger ms-1">Kadaluarsa</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak terbatas</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat Tanggal</strong></td>
                                    <td>: <?php echo e($document->created_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate Tanggal</strong></td>
                                    <td>: <?php echo e($document->updated_at->format('d/m/Y H:i')); ?></td>
                                </tr>
                            </table>
                        </div>

                        <!-- Informasi Permohonan Terkait -->
                        <div class="col-md-6">
                            <h5 class="mb-3">Informasi Terkait</h5>
                            <table class="table table-borderless">
                                <?php if($document->serviceRequest): ?>
                                <tr>
                                    <td width="40%"><strong>Permohonan</strong></td>
                                    <td>: 
                                        <a href="<?php echo e(route('admin.service-requests.show', $document->serviceRequest)); ?>" class="text-decoration-none">
                                            <?php echo e($document->serviceRequest->request_number); ?>

                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pemohon</strong></td>
                                    <td>: <?php echo e($document->serviceRequest->citizen->name); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>NIK Pemohon</strong></td>
                                    <td>: <?php echo e($document->serviceRequest->citizen->nik); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Layanan</strong></td>
                                    <td>: <?php echo e(str_replace('_', ' ', ucwords($document->serviceRequest->service_type, '_'))); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Permohonan</strong></td>
                                    <td>: <?php echo $document->serviceRequest->status_badge; ?></td>
                                </tr>
                                <?php else: ?>
                                <tr>
                                    <td colspan="2">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle"></i> Dokumen ini dibuat secara manual, tidak terkait dengan permohonan tertentu.
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td><strong>Dibuat Oleh</strong></td>
                                    <td>: <?php echo e($document->generatedBy->name ?? 'System'); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <?php if($document->notes): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Catatan</h5>
                            <div class="alert alert-light">
                                <?php echo e($document->notes); ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Template Variables -->
                    <?php if($document->template_variables && count($document->template_variables) > 0): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Data Template</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30%">Field</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $document->template_variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong><?php echo e(str_replace('_', ' ', ucwords($key, '_'))); ?></strong></td>
                                            <td><?php echo e($value); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- File Preview (if PDF) -->
                    <?php if($document->is_active && $document->file_path): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Preview Dokumen</h5>
                            <div class="card">
                                <div class="card-body p-0">
                                    <iframe src="<?php echo e(route('admin.documents.preview', $document)); ?>" 
                                            width="100%" 
                                            height="600px" 
                                            style="border: none;">
                                        <p>Browser Anda tidak mendukung preview PDF. 
                                           <a href="<?php echo e(route('admin.documents.download', $document)); ?>">Download dokumen</a> untuk melihatnya.
                                        </p>
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Download History (if needed) -->
                    <?php if($document->download_count > 0): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">Statistik Download</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4><?php echo e(number_format($document->download_count)); ?></h4>
                                            <p class="mb-0">Total Download</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4><?php echo e($document->formatted_file_size); ?></h4>
                                            <p class="mb-0">Ukuran File</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4><?php echo e($document->created_at->diffForHumans()); ?></h4>
                                            <p class="mb-0">Dibuat</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h4>
                                                <?php if($document->valid_until): ?>
                                                    <?php echo e($document->valid_until->diffForHumans()); ?>

                                                <?php else: ?>
                                                    ∞
                                                <?php endif; ?>
                                            </h4>
                                            <p class="mb-0">Masa Berlaku</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('admin.documents.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <?php if($document->serviceRequest): ?>
                    <a href="<?php echo e(route('admin.service-requests.show', $document->serviceRequest)); ?>" class="btn btn-info">
                        <i class="fas fa-file-alt"></i> Lihat Permohonan
                    </a>
                    <?php endif; ?>
                    <?php if($document->is_active): ?>
                    <a href="<?php echo e(route('admin.documents.download', $document)); ?>" class="btn btn-success">
                        <i class="fas fa-download"></i> Download Dokumen
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Auto refresh download count every 30 seconds if document is being viewed
    setInterval(function() {
        // This could be implemented to refresh download statistics
        // via AJAX if needed
    }, 30000);
    
    // Handle iframe load errors
    $('iframe').on('error', function() {
        $(this).hide();
        $(this).after('<div class="alert alert-warning">Tidak dapat memuat preview dokumen. <a href="<?php echo e(route("admin.documents.download", $document)); ?>">Download dokumen</a> untuk melihatnya.</div>');
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\documents\show.blade.php ENDPATH**/ ?>