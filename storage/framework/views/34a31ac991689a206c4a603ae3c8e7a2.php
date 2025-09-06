<!-- Dashboard -->
<a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-tachometer-alt"></i>
    <span class="nav-text">Dashboard</span>
</a>

<!-- Data Penduduk -->
<a href="<?php echo e(route('admin.penduduk.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.penduduk.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-users"></i>
    <span class="nav-text">Data Penduduk</span>
</a>

<!-- Layanan Surat -->
<a href="<?php echo e(route('admin.surat.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.surat.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-file-alt"></i>
    <span class="nav-text">Layanan Surat</span>
</a>

<!-- Antrian -->
<a href="<?php echo e(route('admin.antrian.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.antrian.index') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-clock"></i>
    <span class="nav-text">Antrian</span>
</a>

<!-- Dashboard Antrian -->
<a href="<?php echo e(route('admin.antrian.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.antrian.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-chart-line"></i>
    <span class="nav-text">Dashboard Antrian</span>
</a>

<!-- Berita -->
<a href="<?php echo e(route('admin.berita.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.berita.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-newspaper"></i>
    <span class="nav-text">Berita</span>
</a>

<!-- Pengaduan -->
<a href="<?php echo e(route('admin.pengaduan.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.pengaduan.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-comments"></i>
    <span class="nav-text">Pengaduan</span>
</a>

<!-- Manajemen User -->
<a href="<?php echo e(route('admin.user.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.user.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-user-cog"></i>
    <span class="nav-text">Manajemen User</span>
</a>

<!-- Laporan -->
<a href="<?php echo e(route('admin.laporan.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.laporan.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-chart-bar"></i>
    <span class="nav-text">Laporan</span>
</a>

<!-- Pengaturan -->
<a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-item <?php echo e(request()->routeIs('admin.settings.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-cog"></i>
    <span class="nav-text">Pengaturan</span>
</a><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\partials\admin-sidebar.blade.php ENDPATH**/ ?>