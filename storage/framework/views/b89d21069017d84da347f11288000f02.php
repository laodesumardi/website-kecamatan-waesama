<?php $__env->startSection('title', 'Dashboard Warga'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="rounded-xl p-6 text-white" style="background: #003f88;">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo e(auth()->user()->name); ?>!</h2>
                <p class="text-emerald-100">Akses layanan Kantor Camat Waesama dengan mudah dan cepat.</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-circle text-6xl text-emerald-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- My Surat -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Surat Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e(number_format($stats['my_surat'])); ?></p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-primary-900 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('warga.surat.list')); ?>" class="text-primary-900 hover:text-primary-700 text-sm font-medium">Lihat Riwayat →</a>
            </div>
        </div>

        <!-- My Antrian -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Antrian Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e(number_format($stats['my_antrian'])); ?></p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-gray-500 cursor-not-allowed text-sm font-medium" title="Fitur dalam pengembangan">Ambil Antrian →</a>
            </div>
        </div>

        <!-- My Pengaduan -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pengaduan Saya</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e(number_format($stats['my_pengaduan'])); ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-gray-500 cursor-not-allowed text-sm font-medium" title="Fitur dalam pengembangan">Buat Pengaduan →</a>
            </div>
        </div>
    </div>

    <!-- Quick Services -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Layanan Cepat</h3>
            <i class="fas fa-rocket text-gray-400"></i>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="<?php echo e(route('warga.surat.create', ['jenis' => 'Surat Keterangan Domisili'])); ?>" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-all duration-200 group block">
                <div class="text-center">
                    <i class="fas fa-id-card text-3xl text-gray-400 group-hover:text-primary-900 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-primary-900 font-medium text-sm">Surat Keterangan Domisili</p>
                </div>
            </a>
            <a href="<?php echo e(route('warga.surat.create', ['jenis' => 'Surat Keterangan Usaha'])); ?>" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-green-300 hover:bg-green-50 transition-all duration-200 group block">
                <div class="text-center">
                    <i class="fas fa-briefcase text-3xl text-gray-400 group-hover:text-green-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-green-600 font-medium text-sm">Surat Keterangan Usaha</p>
                </div>
            </a>
            <a href="<?php echo e(route('warga.surat.create', ['jenis' => 'Surat Keterangan Belum Menikah'])); ?>" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group block">
                <div class="text-center">
                    <i class="fas fa-heart text-3xl text-gray-400 group-hover:text-purple-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-purple-600 font-medium text-sm">Surat Keterangan Belum Menikah</p>
                </div>
            </a>
            <a href="<?php echo e(route('warga.surat.create', ['jenis' => 'Surat Keterangan Sehat'])); ?>" class="p-6 rounded-lg border-2 border-dashed border-gray-200 hover:border-yellow-300 hover:bg-yellow-50 transition-all duration-200 group block">
                <div class="text-center">
                    <i class="fas fa-file-medical text-3xl text-gray-400 group-hover:text-yellow-600 mb-3"></i>
                    <p class="text-gray-600 group-hover:text-yellow-600 font-medium text-sm">Surat Keterangan Sehat</p>
                </div>
            </a>
        </div>
    </div>

    <!-- News & Status -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent News -->
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Berita Terbaru</h3>
                <a href="<?php echo e(route('warga.berita.index')); ?>" class="text-primary-900 hover:text-primary-700 text-sm font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $recentNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <?php if($news->gambar): ?>
                        <img src="<?php echo e(asset('storage/' . $news->gambar)); ?>" alt="<?php echo e($news->judul); ?>" class="w-16 h-16 rounded-lg object-cover">
                    <?php else: ?>
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800 text-sm mb-1"><?php echo e(Str::limit($news->judul, 60)); ?></h4>
                        <p class="text-gray-500 text-xs mb-2"><?php echo e(Str::limit($news->excerpt, 80)); ?></p>
                        <p class="text-gray-400 text-xs"><?php echo e($news->published_at->diffForHumans()); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-8">
                    <i class="fas fa-newspaper text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Belum ada berita terbaru</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status & Information -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Status Terkini</h3>
                    <i class="fas fa-info-circle text-gray-400"></i>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="text-gray-700 text-sm">Surat Domisili</span>
                        </div>
                        <span class="bg-green-200 text-green-800 text-xs font-medium px-2 py-1 rounded">Selesai</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-clock text-yellow-600"></i>
                            <span class="text-gray-700 text-sm">Surat Usaha</span>
                        </div>
                        <span class="bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Proses</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-primary-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-user-clock text-primary-900"></i>
                            <span class="text-gray-700 text-sm">Antrian A-025</span>
                        </div>
                        <span class="bg-primary-200 text-primary-900 text-xs font-medium px-2 py-1 rounded">Menunggu</span>
                    </div>
                </div>
            </div>

            <!-- Office Hours -->
            <div class="bg-white rounded-xl p-6 card-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Jam Pelayanan</h3>
                    <i class="fas fa-clock text-gray-400"></i>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Senin - Kamis</span>
                        <span class="font-medium text-gray-800">08:00 - 16:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumat</span>
                        <span class="font-medium text-gray-800">08:00 - 11:30</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sabtu - Minggu</span>
                        <span class="font-medium text-red-600">Tutup</span>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-green-700 text-sm font-medium">Kantor sedang buka</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help & Contact -->
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Bantuan & Kontak</h3>
            <i class="fas fa-question-circle text-gray-400"></i>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-phone text-2xl text-primary-900 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">Telepon</p>
                <p class="text-gray-500 text-sm">(0274) 123-4567</p>
            </div>
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-envelope text-2xl text-green-600 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">Email</p>
                <p class="text-gray-500 text-sm">info@waesama.go.id</p>
            </div>
            <div class="text-center p-4 rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fab fa-whatsapp text-2xl text-green-500 mb-3"></i>
                <p class="text-gray-800 font-medium mb-1">WhatsApp</p>
                <p class="text-gray-500 text-sm">+62 812-3456-7890</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\warga\dashboard.blade.php ENDPATH**/ ?>