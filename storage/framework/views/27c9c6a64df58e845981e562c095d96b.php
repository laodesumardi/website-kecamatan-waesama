<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($surat->jenis_surat); ?> - <?php echo e($surat->nomor_surat); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        .content {
            margin: 30px 0;
        }
        .surat-info {
            margin-bottom: 20px;
        }
        .surat-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .surat-info td {
            padding: 5px 0;
            vertical-align: top;
        }
        .surat-info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .surat-info td:nth-child(2) {
            width: 10px;
            text-align: center;
        }
        .title {
            text-align: center;
            margin: 30px 0;
        }
        .title h3 {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            text-transform: uppercase;
        }
        .title p {
            margin: 5px 0 0 0;
            font-size: 12px;
        }
        .body-text {
            text-align: justify;
            margin: 20px 0;
            line-height: 1.8;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .signature-space {
            height: 80px;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
        @page {
            margin: 2cm;
        }
    </style>
</head>
<body>
    <!-- Header Kop Surat -->
    <div class="header">
        <h1>PEMERINTAH KABUPATEN WAKATOBI</h1>
        <h2>KECAMATAN WAESAMA</h2>
        <p>Alamat: Jl. Raya Waesama No. 1, Wakatobi, Sulawesi Tenggara</p>
        <p>Telepon: (0401) 123456 | Email: kecamatan.waesama@wakatobi.go.id</p>
    </div>

    <!-- Informasi Surat -->
    <div class="surat-info">
        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><?php echo e($surat->nomor_surat); ?></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td><strong><?php echo e($surat->jenis_surat); ?></strong></td>
            </tr>
        </table>
    </div>

    <!-- Judul Surat -->
    <div class="title">
        <h3><?php echo e($surat->jenis_surat); ?></h3>
        <p>Nomor: <?php echo e($surat->nomor_surat); ?></p>
    </div>

    <!-- Isi Surat -->
    <div class="content">
        <div class="body-text">
            <p>Yang bertanda tangan di bawah ini, Camat Waesama Kabupaten Wakatobi, dengan ini menerangkan bahwa:</p>
            
            <table style="margin: 20px 0; width: 100%;">
                <tr>
                    <td style="width: 150px; padding: 3px 0;">Nama Lengkap</td>
                    <td style="width: 10px; text-align: center;">:</td>
                    <td style="font-weight: bold;"><?php echo e($surat->nama_pemohon); ?></td>
                </tr>
                <tr>
                    <td style="padding: 3px 0;">NIK</td>
                    <td style="text-align: center;">:</td>
                    <td><?php echo e($surat->nik_pemohon); ?></td>
                </tr>
                <?php if($surat->phone_pemohon): ?>
                <tr>
                    <td style="padding: 3px 0;">Nomor Telepon</td>
                    <td style="text-align: center;">:</td>
                    <td><?php echo e($surat->phone_pemohon); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td style="padding: 3px 0;">Alamat</td>
                    <td style="text-align: center;">:</td>
                    <td><?php echo e($surat->alamat_pemohon); ?></td>
                </tr>
            </table>

            <?php if($surat->data_tambahan && is_array($surat->data_tambahan)): ?>
                <?php $__currentLoopData = $surat->data_tambahan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($value): ?>
                    <p><strong><?php echo e(ucwords(str_replace('_', ' ', $key))); ?>:</strong> <?php echo e($value); ?></p>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <p style="margin-top: 20px;">Adalah benar warga yang berdomisili di wilayah Kecamatan Waesama dan surat ini dibuat untuk keperluan: <strong><?php echo e($surat->keperluan); ?></strong>.</p>

            <?php if($surat->catatan): ?>
            <p><strong>Catatan:</strong> <?php echo e($surat->catatan); ?></p>
            <?php endif; ?>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <table class="signature-table">
            <tr>
                <td></td>
                <td>
                    <p>Waesama, <?php echo e($surat->tanggal_selesai ? $surat->tanggal_selesai->format('d F Y') : now()->format('d F Y')); ?></p>
                    <p><strong>CAMAT WAESAMA</strong></p>
                    <div class="signature-space"></div>
                    <p><strong><u><?php echo e($surat->processor ? $surat->processor->name : 'NAMA CAMAT'); ?></u></strong></p>
                    <p>NIP. <?php echo e($surat->processor && $surat->processor->nip ? $surat->processor->nip : '196X0X0X 198X0X X XXX'); ?></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara elektronik dan sah tanpa tanda tangan basah</p>
        <p>Dicetak pada: <?php echo e(now()->format('d F Y H:i:s')); ?></p>
    </div>
</body>
</html><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\pdf\surat.blade.php ENDPATH**/ ?>