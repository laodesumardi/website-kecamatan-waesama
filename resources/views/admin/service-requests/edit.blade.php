@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Permohonan Surat</h3>
                </div>
                <form action="{{ route('admin.service-requests.update', $serviceRequest) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Info Permohonan -->
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <strong>Nomor Permohonan:</strong> {{ $serviceRequest->request_number }}<br>
                                    <strong>Status:</strong> {!! $serviceRequest->status_badge !!}<br>
                                    <strong>Dibuat:</strong> {{ $serviceRequest->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            <!-- Pilih Pemohon -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citizen_id" class="form-label">Pemohon <span class="text-danger">*</span></label>
                                    <select name="citizen_id" id="citizen_id" class="form-select @error('citizen_id') is-invalid @enderror" required>
                                        <option value="">Pilih Pemohon</option>
                                        @foreach($citizens as $citizen)
                                        <option value="{{ $citizen->id }}" {{ (old('citizen_id') ?? $serviceRequest->citizen_id) == $citizen->id ? 'selected' : '' }}>
                                            {{ $citizen->name }} - NIK: {{ $citizen->nik }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('citizen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Layanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_type" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                                    <select name="service_type" id="service_type" class="form-select @error('service_type') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis Layanan</option>
                                        <option value="surat_keterangan_domisili" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                        <option value="surat_keterangan_usaha" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                        <option value="surat_keterangan_tidak_mampu" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                        <option value="surat_pengantar_nikah" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                        <option value="surat_keterangan_kelahiran" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                        <option value="surat_keterangan_kematian" {{ (old('service_type') ?? $serviceRequest->service_type) == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                                    </select>
                                    @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="purpose" class="form-label">Keperluan <span class="text-danger">*</span></label>
                                    <textarea name="purpose" id="purpose" class="form-control @error('purpose') is-invalid @enderror" rows="3" placeholder="Jelaskan keperluan surat ini..." required>{{ old('purpose') ?? $serviceRequest->purpose }}</textarea>
                                    @error('purpose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Prioritas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioritas</label>
                                    <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror">
                                        <option value="normal" {{ (old('priority') ?? $serviceRequest->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="urgent" {{ (old('priority') ?? $serviceRequest->priority) == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                                        <option value="very_urgent" {{ (old('priority') ?? $serviceRequest->priority) == 'very_urgent' ? 'selected' : '' }}>Sangat Mendesak</option>
                                    </select>
                                    @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tanggal Dibutuhkan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="required_date" class="form-label">Tanggal Dibutuhkan</label>
                                    <input type="date" name="required_date" id="required_date" class="form-control @error('required_date') is-invalid @enderror" value="{{ old('required_date') ?? ($serviceRequest->required_date ? \Carbon\Carbon::parse($serviceRequest->required_date)->format('Y-m-d') : '') }}" min="{{ date('Y-m-d') }}">
                                    @error('required_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dokumen Pendukung Existing -->
                            @if($serviceRequest->required_documents && count($serviceRequest->required_documents) > 0)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Dokumen Pendukung Saat Ini</label>
                                    <div class="row">
                                        @foreach($serviceRequest->required_documents as $index => $document)
                                        <div class="col-md-3 mb-2">
                                            <div class="card">
                                                <div class="card-body text-center p-2">
                                                    <i class="fas fa-file-alt fa-2x text-primary mb-1"></i>
                                                    <p class="card-text small mb-1">{{ basename($document) }}</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remove_documents[]" value="{{ $index }}" id="remove_doc_{{ $index }}">
                                                        <label class="form-check-label small" for="remove_doc_{{ $index }}">
                                                            Hapus
                                                        </label>
                                                    </div>
                                                    <a href="{{ Storage::url($document) }}" target="_blank" class="btn btn-xs btn-primary mt-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Upload Dokumen Baru -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="required_documents" class="form-label">Upload Dokumen Baru (Opsional)</label>
                                    <input type="file" name="required_documents[]" id="required_documents" class="form-control @error('required_documents') is-invalid @enderror" multiple accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">Upload dokumen pendukung tambahan (PDF, JPG, PNG). Maksimal 5 file, masing-masing 2MB.</div>
                                    @error('required_documents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan Tambahan</label>
                                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Catatan atau informasi tambahan...">{{ old('notes') ?? $serviceRequest->notes }}</textarea>
                                    @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Template Variables (Dynamic based on service type) -->
                        <div id="template-variables" class="row" style="{{ $serviceRequest->template_variables ? '' : 'display: none;' }}">
                            <div class="col-12">
                                <h5 class="mb-3">Informasi Tambahan</h5>
                                <div id="variables-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Permohonan
                        </button>
                        <a href="{{ route('admin.service-requests.show', $serviceRequest) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Template variables untuk setiap jenis surat
    const templateVariables = {
        'surat_keterangan_domisili': [
            { name: 'alamat_lengkap', label: 'Alamat Lengkap', type: 'textarea', required: true },
            { name: 'rt_rw', label: 'RT/RW', type: 'text', required: true },
            { name: 'kelurahan', label: 'Kelurahan/Desa', type: 'text', required: true },
            { name: 'kecamatan', label: 'Kecamatan', type: 'text', required: true },
            { name: 'lama_tinggal', label: 'Lama Tinggal', type: 'text', required: true }
        ],
        'surat_keterangan_usaha': [
            { name: 'nama_usaha', label: 'Nama Usaha', type: 'text', required: true },
            { name: 'jenis_usaha', label: 'Jenis Usaha', type: 'text', required: true },
            { name: 'alamat_usaha', label: 'Alamat Usaha', type: 'textarea', required: true },
            { name: 'modal_usaha', label: 'Modal Usaha', type: 'text', required: false },
            { name: 'lama_usaha', label: 'Lama Usaha', type: 'text', required: true }
        ],
        'surat_keterangan_tidak_mampu': [
            { name: 'penghasilan_perbulan', label: 'Penghasilan Per Bulan', type: 'text', required: true },
            { name: 'jumlah_tanggungan', label: 'Jumlah Tanggungan', type: 'number', required: true },
            { name: 'pekerjaan', label: 'Pekerjaan', type: 'text', required: true },
            { name: 'keperluan_bantuan', label: 'Keperluan Bantuan', type: 'textarea', required: true }
        ],
        'surat_pengantar_nikah': [
            { name: 'nama_calon_pasangan', label: 'Nama Calon Pasangan', type: 'text', required: true },
            { name: 'tempat_lahir_pasangan', label: 'Tempat Lahir Pasangan', type: 'text', required: true },
            { name: 'tanggal_lahir_pasangan', label: 'Tanggal Lahir Pasangan', type: 'date', required: true },
            { name: 'alamat_pasangan', label: 'Alamat Pasangan', type: 'textarea', required: true },
            { name: 'rencana_tanggal_nikah', label: 'Rencana Tanggal Nikah', type: 'date', required: true }
        ],
        'surat_keterangan_kelahiran': [
            { name: 'nama_bayi', label: 'Nama Bayi', type: 'text', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'tempat_lahir', label: 'Tempat Lahir', type: 'text', required: true },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'datetime-local', required: true },
            { name: 'nama_ayah', label: 'Nama Ayah', type: 'text', required: true },
            { name: 'nama_ibu', label: 'Nama Ibu', type: 'text', required: true }
        ],
        'surat_keterangan_kematian': [
            { name: 'nama_almarhum', label: 'Nama Almarhum/Almarhumah', type: 'text', required: true },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: ['Laki-laki', 'Perempuan'], required: true },
            { name: 'umur', label: 'Umur', type: 'number', required: true },
            { name: 'tanggal_kematian', label: 'Tanggal Kematian', type: 'datetime-local', required: true },
            { name: 'tempat_kematian', label: 'Tempat Kematian', type: 'text', required: true },
            { name: 'sebab_kematian', label: 'Sebab Kematian', type: 'text', required: true }
        ]
    };

    // Existing template variables from database
    const existingVariables = @json($serviceRequest->template_variables ?? []);

    // Handle service type change
    $('#service_type').change(function() {
        const serviceType = $(this).val();
        const container = $('#variables-container');
        const templateDiv = $('#template-variables');
        
        container.empty();
        
        if (serviceType && templateVariables[serviceType]) {
            const variables = templateVariables[serviceType];
            
            variables.forEach(function(variable) {
                let inputHtml = '';
                const existingValue = existingVariables[variable.name] || '';
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        const selected = existingValue === option ? 'selected' : '';
                        inputHtml += `<option value="${option}" ${selected}>${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" rows="3">${existingValue}</textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" value="${existingValue}">`;
                }
                
                const fieldHtml = `
                    <div class="col-md-6 mb-3">
                        <label class="form-label">${variable.label} ${variable.required ? '<span class="text-danger">*</span>' : ''}</label>
                        ${inputHtml}
                    </div>
                `;
                
                container.append(fieldHtml);
            });
            
            templateDiv.show();
        } else {
            templateDiv.hide();
        }
    });

    // Trigger change event on page load
    $('#service_type').trigger('change');
});
</script>
@endpush