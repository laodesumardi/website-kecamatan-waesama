<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <span>Tambah Permohonan Surat</span>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="<?php echo e(route('admin.service-requests.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                        <div class="row">
                            <!-- Pilih Pemohon -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citizen_id" class="form-label">Pemohon <span class="text-danger">*</span></label>
                                    <select name="citizen_id" id="citizen_id" class="form-select <?php $__errorArgs = ['citizen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Pilih Pemohon</option>
                                        <?php $__currentLoopData = $citizens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $citizen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($citizen->id); ?>" <?php echo e(old('citizen_id') == $citizen->id ? 'selected' : ''); ?>>
                                            <?php echo e($citizen->name); ?> - NIK: <?php echo e($citizen->nik); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['citizen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Jenis Layanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="service_type" class="form-label">Jenis Layanan <span class="text-danger">*</span></label>
                                    <select name="service_type" id="service_type" class="form-select <?php $__errorArgs = ['service_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Pilih Jenis Layanan</option>
                                        <option value="surat_keterangan_domisili" <?php echo e(old('service_type') == 'surat_keterangan_domisili' ? 'selected' : ''); ?>>Surat Keterangan Domisili</option>
                                        <option value="surat_keterangan_usaha" <?php echo e(old('service_type') == 'surat_keterangan_usaha' ? 'selected' : ''); ?>>Surat Keterangan Usaha</option>
                                        <option value="surat_keterangan_tidak_mampu" <?php echo e(old('service_type') == 'surat_keterangan_tidak_mampu' ? 'selected' : ''); ?>>Surat Keterangan Tidak Mampu</option>
                                        <option value="surat_pengantar_nikah" <?php echo e(old('service_type') == 'surat_pengantar_nikah' ? 'selected' : ''); ?>>Surat Pengantar Nikah</option>
                                        <option value="surat_keterangan_kelahiran" <?php echo e(old('service_type') == 'surat_keterangan_kelahiran' ? 'selected' : ''); ?>>Surat Keterangan Kelahiran</option>
                                        <option value="surat_keterangan_kematian" <?php echo e(old('service_type') == 'surat_keterangan_kematian' ? 'selected' : ''); ?>>Surat Keterangan Kematian</option>
                                    </select>
                                    <?php $__errorArgs = ['service_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Keperluan -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="purpose" class="form-label">Keperluan <span class="text-danger">*</span></label>
                                    <textarea name="purpose" id="purpose" class="form-control <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" placeholder="Jelaskan keperluan surat ini..." required><?php echo e(old('purpose')); ?></textarea>
                                    <?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Prioritas -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioritas</label>
                                    <select name="priority" id="priority" class="form-select <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="normal" <?php echo e(old('priority') == 'normal' ? 'selected' : ''); ?>>Normal</option>
                                        <option value="urgent" <?php echo e(old('priority') == 'urgent' ? 'selected' : ''); ?>>Mendesak</option>
                                        <option value="very_urgent" <?php echo e(old('priority') == 'very_urgent' ? 'selected' : ''); ?>>Sangat Mendesak</option>
                                    </select>
                                    <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Tanggal Dibutuhkan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="required_date" class="form-label">Tanggal Dibutuhkan</label>
                                    <input type="date" name="required_date" id="required_date" class="form-control <?php $__errorArgs = ['required_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('required_date')); ?>" min="<?php echo e(date('Y-m-d')); ?>">
                                    <?php $__errorArgs = ['required_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Dokumen Pendukung -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="required_documents" class="form-label">Dokumen Pendukung</label>
                                    <input type="file" name="required_documents[]" id="required_documents" class="form-control <?php $__errorArgs = ['required_documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" multiple accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="form-text">Upload dokumen pendukung (PDF, JPG, PNG). Maksimal 5 file, masing-masing 2MB.</div>
                                    <?php $__errorArgs = ['required_documents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan Tambahan</label>
                                    <textarea name="notes" id="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" placeholder="Catatan atau informasi tambahan..."><?php echo e(old('notes')); ?></textarea>
                                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Template Variables (Dynamic based on service type) -->
                        <div id="template-variables" class="row" style="display: none;">
                            <div class="col-12">
                                <h5 class="mb-3">Informasi Tambahan</h5>
                                <div id="variables-container"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-save"></i> Simpan Permohonan
                        </button>
                        <a href="<?php echo e(route('admin.service-requests.index')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
                
                if (variable.type === 'select') {
                    inputHtml = `<select name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
                    inputHtml += '<option value="">Pilih...</option>';
                    variable.options.forEach(function(option) {
                        inputHtml += `<option value="${option}">${option}</option>`;
                    });
                    inputHtml += '</select>';
                } else if (variable.type === 'textarea') {
                    inputHtml = `<textarea name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}" rows="3"></textarea>`;
                } else {
                    inputHtml = `<input type="${variable.type}" name="template_variables[${variable.name}]" class="form-control ${variable.required ? 'required' : ''}">`;
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

    // Trigger change event if service type is already selected (for edit mode)
    if ($('#service_type').val()) {
        $('#service_type').trigger('change');
    }
});
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\service-requests\create.blade.php ENDPATH**/ ?>