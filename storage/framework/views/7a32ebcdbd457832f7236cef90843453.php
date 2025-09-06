<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan <?php echo e(ucfirst($type)); ?> - Kantor Camat Waesama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
        }
        .report-info {
            margin: 20px 0;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-info td {
            padding: 5px;
            border: none;
        }
        .report-info .label {
            font-weight: bold;
            width: 30%;
        }
        .content {
            margin: 20px 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th,
        .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .data-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 11px;
        }
        .data-table td {
            font-size: 10px;
        }
        .summary {
            margin: 20px 0;
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 5px;
        }
        .summary h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ddd;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-left: 50px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 40px auto 5px;
        }
        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH KABUPATEN WAKATOBI</h1>
        <h2>KANTOR CAMAT WAESAMA</h2>
        <p>Alamat: Jl. Raya Waesama, Kec. Waesama, Kab. Wakatobi, Sulawesi Tenggara</p>
        <p>Telepon: (0401) 123456 | Email: camat.waesama@wakatolikab.go.id</p>
    </div>

    <div class="report-info">
        <table>
            <tr>
                <td class="label">Jenis Laporan</td>
                <td>: <?php echo e(ucfirst($type)); ?></td>
            </tr>
            <tr>
                <td class="label">Periode</td>
                <td>: <?php echo e($startDate); ?> s/d <?php echo e($endDate); ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: <?php echo e($generatedAt->format('d F Y, H:i')); ?> WIB</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h2 style="text-align: center; margin-bottom: 20px;">LAPORAN <?php echo e(strtoupper($type)); ?></h2>
        
        <?php if($type === 'overview'): ?>
            <!-- Summary Overview -->
            <div class="summary">
                <h3>Ringkasan Data Keseluruhan</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Penduduk</div>
                        <div class="value"><?php echo e($data['total_penduduk'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Surat</div>
                        <div class="value"><?php echo e($data['total_surat'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Antrian</div>
                        <div class="value"><?php echo e($data['total_antrian'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Pengaduan</div>
                        <div class="value"><?php echo e($data['total_pengaduan'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Berita</div>
                        <div class="value"><?php echo e($data['total_berita'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total User</div>
                        <div class="value"><?php echo e($data['total_user'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            <!-- Detail Status -->
            <div class="summary">
                <h3>Detail Status Layanan</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Pending</th>
                            <th>Diproses</th>
                            <th>Selesai</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Surat</td>
                            <td><?php echo e($data['surat_pending'] ?? 0); ?></td>
                            <td><?php echo e($data['surat_processing'] ?? 0); ?></td>
                            <td><?php echo e($data['surat_completed'] ?? 0); ?></td>
                            <td><?php echo e($data['total_surat'] ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Antrian</td>
                            <td><?php echo e($data['antrian_pending'] ?? 0); ?></td>
                            <td><?php echo e($data['antrian_processing'] ?? 0); ?></td>
                            <td><?php echo e($data['antrian_completed'] ?? 0); ?></td>
                            <td><?php echo e($data['total_antrian'] ?? 0); ?></td>
                        </tr>
                        <tr>
                            <td>Pengaduan</td>
                            <td><?php echo e($data['pengaduan_pending'] ?? 0); ?></td>
                            <td><?php echo e($data['pengaduan_processing'] ?? 0); ?></td>
                            <td><?php echo e($data['pengaduan_completed'] ?? 0); ?></td>
                            <td><?php echo e($data['total_pengaduan'] ?? 0); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <?php elseif($type === 'penduduk'): ?>
            <!-- Summary Penduduk -->
            <div class="summary">
                <h3>Ringkasan Data Penduduk</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Penduduk</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Laki-laki</div>
                        <div class="value"><?php echo e($data['by_gender']->where('jenis_kelamin', 'Laki-laki')->first()->total ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Perempuan</div>
                        <div class="value"><?php echo e($data['by_gender']->where('jenis_kelamin', 'Perempuan')->first()->total ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Registrasi Periode Ini</div>
                        <div class="value"><?php echo e($data['new_registrations'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            <!-- Data by Status Perkawinan -->
            <?php if(isset($data['by_status']) && $data['by_status']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Status Perkawinan</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->status_perkawinan); ?></td>
                        <td><?php echo e($item->total); ?></td>
                        <td><?php echo e($data['total'] > 0 ? round(($item->total / $data['total']) * 100, 1) : 0); ?>%</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

        <?php elseif($type === 'berita'): ?>
            <!-- Summary Berita -->
            <div class="summary">
                <h3>Ringkasan Data Berita</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Berita</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Berita Published</div>
                        <div class="value"><?php echo e($data['published'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Berita Draft</div>
                        <div class="value"><?php echo e($data['draft'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            <!-- Data Berita Terbaru -->
            <?php if(isset($data['recent']) && $data['recent']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['recent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->judul); ?></td>
                        <td><?php echo e($item->author->name ?? '-'); ?></td>
                        <td>
                            <span class="status 
                                <?php if($item->is_published): ?>
                                    status-completed
                                <?php else: ?>
                                    status-pending
                                <?php endif; ?>">
                                <?php echo e($item->is_published ? 'Published' : 'Draft'); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->created_at->format('d/m/Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

        <?php elseif($type === 'user'): ?>
            <!-- Summary User -->
            <div class="summary">
                <h3>Ringkasan Data User</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total User</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">User Aktif</div>
                        <div class="value"><?php echo e($data['active'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">User Tidak Aktif</div>
                        <div class="value"><?php echo e($data['inactive'] ?? 0); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Registrasi Baru</div>
                        <div class="value"><?php echo e($data['new_registrations'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            <!-- Data by Role -->
            <?php if(isset($data['by_role']) && $data['by_role']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['by_role']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e(ucfirst($item->role)); ?></td>
                        <td><?php echo e($item->total); ?></td>
                        <td><?php echo e($data['total'] > 0 ? round(($item->total / $data['total']) * 100, 1) : 0); ?>%</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

        <?php elseif($type === 'surat'): ?>
            <!-- Summary Surat -->
            <div class="summary">
                <h3>Ringkasan Data Surat</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Surat</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <?php if(isset($data['by_status'])): ?>
                        <?php $__currentLoopData = $data['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="summary-item">
                            <div class="label"><?php echo e(ucfirst($status->status)); ?></div>
                            <div class="value"><?php echo e($status->total); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Data Surat by Type -->
            <?php if(isset($data['by_type']) && $data['by_type']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['by_type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->jenis_surat); ?></td>
                        <td><?php echo e($item->total); ?></td>
                        <td><?php echo e($data['total'] > 0 ? round(($item->total / $data['total']) * 100, 1) : 0); ?>%</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Data Surat Terbaru -->
            <?php if(isset($data['recent']) && $data['recent']->count() > 0): ?>
            <div class="page-break"></div>
            <h3>Data Surat Terbaru</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>
                        <th>Jenis Surat</th>
                        <th>Nama Pemohon</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['recent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->nomor_surat ?? '-'); ?></td>
                        <td><?php echo e($item->jenis_surat); ?></td>
                        <td><?php echo e($item->penduduk->nama ?? $item->nama_pemohon ?? '-'); ?></td>
                        <td>
                            <span class="status 
                                <?php switch($item->status):
                                    case ('pending'): ?>
                                        status-pending
                                        <?php break; ?>
                                    <?php case ('processing'): ?>
                                        status-processing
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        status-completed
                                        <?php break; ?>
                                    <?php case ('rejected'): ?>
                                        status-rejected
                                        <?php break; ?>
                                    <?php default: ?>
                                        status-pending
                                <?php endswitch; ?>">
                                <?php echo e(ucfirst($item->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->created_at->format('d/m/Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

        <?php elseif($type === 'antrian'): ?>
            <!-- Summary Antrian -->
            <div class="summary">
                <h3>Ringkasan Data Antrian</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Antrian</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <?php if(isset($data['by_status'])): ?>
                        <?php $__currentLoopData = $data['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="summary-item">
                            <div class="label"><?php echo e(ucfirst($status->status)); ?></div>
                            <div class="value"><?php echo e($status->total); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Data Antrian by Service -->
            <?php if(isset($data['by_service']) && $data['by_service']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Layanan</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['by_service']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->layanan); ?></td>
                        <td><?php echo e($item->total); ?></td>
                        <td><?php echo e($data['total'] > 0 ? round(($item->total / $data['total']) * 100, 1) : 0); ?>%</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Data Antrian Terbaru -->
            <?php if(isset($data['recent']) && $data['recent']->count() > 0): ?>
            <div class="page-break"></div>
            <h3>Data Antrian Terbaru</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Antrian</th>
                        <th>Nama</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['recent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->nomor_antrian); ?></td>
                        <td><?php echo e($item->nama); ?></td>
                        <td><?php echo e($item->layanan); ?></td>
                        <td>
                            <span class="status 
                                <?php switch($item->status):
                                    case ('waiting'): ?>
                                    <?php case ('menunggu'): ?>
                                        status-pending
                                        <?php break; ?>
                                    <?php case ('called'): ?>
                                    <?php case ('dipanggil'): ?>
                                        status-processing
                                        <?php break; ?>
                                    <?php case ('serving'): ?>
                                    <?php case ('dilayani'): ?>
                                        status-processing
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                    <?php case ('selesai'): ?>
                                        status-completed
                                        <?php break; ?>
                                    <?php default: ?>
                                        status-pending
                                <?php endswitch; ?>">
                                <?php echo e(ucfirst($item->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->created_at->format('d/m/Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

        <?php elseif($type === 'pengaduan'): ?>
            <!-- Summary Pengaduan -->
            <div class="summary">
                <h3>Ringkasan Data Pengaduan</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Pengaduan</div>
                        <div class="value"><?php echo e($data['total'] ?? 0); ?></div>
                    </div>
                    <?php if(isset($data['by_status'])): ?>
                        <?php $__currentLoopData = $data['by_status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="summary-item">
                            <div class="label"><?php echo e(ucfirst($status->status)); ?></div>
                            <div class="value"><?php echo e($status->total); ?></div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Data Pengaduan by Category -->
            <?php if(isset($data['by_category']) && $data['by_category']->count() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['by_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->kategori); ?></td>
                        <td><?php echo e($item->total); ?></td>
                        <td><?php echo e($data['total'] > 0 ? round(($item->total / $data['total']) * 100, 1) : 0); ?>%</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Data Pengaduan Terbaru -->
            <?php if(isset($data['recent']) && $data['recent']->count() > 0): ?>
            <div class="page-break"></div>
            <h3>Data Pengaduan Terbaru</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Nama Pengadu</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['recent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($item->judul); ?></td>
                        <td><?php echo e($item->nama); ?></td>
                        <td><?php echo e($item->kategori); ?></td>
                        <td><?php echo e($item->prioritas ?? '-'); ?></td>
                        <td>
                            <span class="status 
                                <?php switch($item->status):
                                    case ('pending'): ?>
                                        status-pending
                                        <?php break; ?>
                                    <?php case ('processing'): ?>
                                        status-processing
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        status-completed
                                        <?php break; ?>
                                    <?php case ('rejected'): ?>
                                        status-rejected
                                        <?php break; ?>
                                    <?php default: ?>
                                        status-pending
                                <?php endswitch; ?>">
                                <?php echo e(ucfirst($item->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($item->created_at->format('d/m/Y')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>Waesama, <?php echo e($generatedAt->format('d F Y')); ?></p>
        <div class="signature">
            <div class="signature-box">
                <p>Camat Waesama</p>
                <div class="signature-line"></div>
                <p><strong>Nama Camat</strong></p>
                <p>NIP. 123456789012345678</p>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\pdf\laporan.blade.php ENDPATH**/ ?>