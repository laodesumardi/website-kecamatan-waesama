<?php $__env->startSection('title', 'Laporan Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-[#001d3d]  rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Laporan Statistik, <?php echo e(auth()->user()->name); ?>!</h2>
                <p class="text-blue-100">Analisis data dan statistik sistem Kantor Camat Waesama secara komprehensif.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-6xl text-blue-200"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Filter Laporan</h3>
            <p class="text-gray-600 text-sm">Pilih jenis laporan dan rentang waktu yang diinginkan</p>
        </div>
        <form method="GET" action="<?php echo e(route('admin.laporan.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Jenis Laporan</label>
                <select id="type" name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="overview" <?php echo e($type === 'overview' ? 'selected' : ''); ?>>Ringkasan</option>
                    <option value="penduduk" <?php echo e($type === 'penduduk' ? 'selected' : ''); ?>>Data Penduduk</option>
                    <option value="surat" <?php echo e($type === 'surat' ? 'selected' : ''); ?>>Layanan Surat</option>
                    <option value="antrian" <?php echo e($type === 'antrian' ? 'selected' : ''); ?>>Antrian</option>
                    <option value="pengaduan" <?php echo e($type === 'pengaduan' ? 'selected' : ''); ?>>Pengaduan</option>
                    <option value="berita" <?php echo e($type === 'berita' ? 'selected' : ''); ?>>Berita</option>
                    <option value="user" <?php echo e($type === 'user' ? 'selected' : ''); ?>>Manajemen User</option>
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo e($startDate); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo e($endDate); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="<?php echo e(route('admin.laporan.export')); ?>?type=<?php echo e($type); ?>&start_date=<?php echo e($startDate); ?>&end_date=<?php echo e($endDate); ?>&format=pdf"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>PDF
                </a>
                <a href="<?php echo e(route('admin.laporan.export')); ?>?type=<?php echo e($type); ?>&start_date=<?php echo e($startDate); ?>&end_date=<?php echo e($endDate); ?>&format=excel"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-file-excel mr-2"></i>Excel
                </a>
            </div>
        </form>
    </div>

    <!-- Content based on type -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <?php if($type === 'overview'): ?>
            <?php echo $__env->make('admin.laporan.partials.overview', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'penduduk'): ?>
            <?php echo $__env->make('admin.laporan.partials.penduduk', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'surat'): ?>
            <?php echo $__env->make('admin.laporan.partials.surat', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'antrian'): ?>
            <?php echo $__env->make('admin.laporan.partials.antrian', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'pengaduan'): ?>
            <?php echo $__env->make('admin.laporan.partials.pengaduan', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'berita'): ?>
            <?php echo $__env->make('admin.laporan.partials.berita', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($type === 'user'): ?>
            <?php echo $__env->make('admin.laporan.partials.user', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Auto submit form when type changes
document.getElementById('type').addEventListener('change', function() {
    this.form.submit();
});

// Set default dates
window.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (!startDate.value) {
        const firstDay = new Date();
        firstDay.setDate(1);
        startDate.value = firstDay.toISOString().split('T')[0];
    }

    if (!endDate.value) {
        endDate.value = new Date().toISOString().split('T')[0];
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\laporan\index.blade.php ENDPATH**/ ?>