<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($type) }} - Kantor Camat Waesama</title>
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
                <td>: {{ ucfirst($type) }}</td>
            </tr>
            <tr>
                <td class="label">Periode</td>
                <td>: {{ $startDate }} s/d {{ $endDate }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ $generatedAt->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h2 style="text-align: center; margin-bottom: 20px;">LAPORAN {{ strtoupper($type) }}</h2>
        
        @if($type === 'surat')
            <!-- Summary Surat -->
            <div class="summary">
                <h3>Ringkasan Data Surat</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Surat</div>
                        <div class="value">{{ count($data) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Surat Selesai</div>
                        <div class="value">{{ collect($data)->where('status', 'Selesai')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Surat Diproses</div>
                        <div class="value">{{ collect($data)->where('status', 'Diproses')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Surat Pending</div>
                        <div class="value">{{ collect($data)->where('status', 'Pending')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Surat -->
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
                    @foreach($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nomor_surat ?? '-' }}</td>
                        <td>{{ $item->jenis_surat }}</td>
                        <td>{{ $item->nama_pemohon }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('Pending')
                                        status-pending
                                        @break
                                    @case('Diproses')
                                        status-processing
                                        @break
                                    @case('Selesai')
                                        status-completed
                                        @break
                                    @default
                                        status-rejected
                                @endswitch">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($type === 'antrian')
            <!-- Summary Antrian -->
            <div class="summary">
                <h3>Ringkasan Data Antrian</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Antrian</div>
                        <div class="value">{{ count($data) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Antrian Selesai</div>
                        <div class="value">{{ collect($data)->where('status', 'Selesai')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Antrian Dilayani</div>
                        <div class="value">{{ collect($data)->where('status', 'Dilayani')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Antrian Menunggu</div>
                        <div class="value">{{ collect($data)->where('status', 'Menunggu')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Antrian -->
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
                    @foreach($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nomor_antrian }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->layanan }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('Menunggu')
                                        status-pending
                                        @break
                                    @case('Dipanggil')
                                        status-processing
                                        @break
                                    @case('Dilayani')
                                        status-processing
                                        @break
                                    @case('Selesai')
                                        status-completed
                                        @break
                                    @default
                                        status-rejected
                                @endswitch">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @elseif($type === 'pengaduan')
            <!-- Summary Pengaduan -->
            <div class="summary">
                <h3>Ringkasan Data Pengaduan</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Pengaduan</div>
                        <div class="value">{{ count($data) }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Pengaduan Selesai</div>
                        <div class="value">{{ collect($data)->where('status', 'Selesai')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Pengaduan Diproses</div>
                        <div class="value">{{ collect($data)->where('status', 'Diproses')->count() }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Pengaduan Pending</div>
                        <div class="value">{{ collect($data)->where('status', 'Pending')->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Data Pengaduan -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Nama Pengadu</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('Pending')
                                        status-pending
                                        @break
                                    @case('Diproses')
                                        status-processing
                                        @break
                                    @case('Selesai')
                                        status-completed
                                        @break
                                    @case('Ditolak')
                                        status-rejected
                                        @break
                                    @default
                                        status-pending
                                @endswitch">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        <p>Waesama, {{ $generatedAt->format('d F Y') }}</p>
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
</html>