<!-- Dashboard -->
<a href="<?php echo e(route('warga.dashboard')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-tachometer-alt"></i>
    <span class="nav-text">Dashboard</span>
</a>

<!-- Ajukan Surat -->
<a href="<?php echo e(route('warga.surat.create')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.surat.create') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-plus-square"></i>
    <span class="nav-text">Ajukan Surat</span>
</a>

<!-- Riwayat Surat -->
<a href="<?php echo e(route('warga.surat.list')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.surat.list') || request()->routeIs('warga.surat.show') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-history"></i>
    <span class="nav-text">Riwayat Surat</span>
</a>

<!-- Antrian Online -->
<a href="<?php echo e(route('warga.antrian.index')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.antrian.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-clock"></i>
    <span class="nav-text">Antrian Online</span>
</a>

<!-- Pengaduan -->
<a href="<?php echo e(route('warga.pengaduan.index')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.pengaduan.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-exclamation-triangle"></i>
    <span class="nav-text">Pengaduan</span>
</a>

<!-- Berita -->
<a href="<?php echo e(route('warga.berita.index')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.berita.*') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-newspaper"></i>
    <span class="nav-text">Berita</span>
</a>

<!-- Profil -->
<a href="<?php echo e(route('warga.profil')); ?>" class="nav-item <?php echo e(request()->routeIs('warga.profil') ? 'active text-white' : 'text-gray-700 hover:text-white'); ?>">
    <i class="fas fa-user"></i>
    <span class="nav-text">Profil Saya</span>
</a><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\partials\warga-sidebar.blade.php ENDPATH**/ ?>