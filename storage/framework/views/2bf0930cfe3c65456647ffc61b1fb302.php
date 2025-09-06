<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan Manajemen Berita</h3>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <i class="fas fa-newspaper text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Berita</p>
                    <p class="text-2xl font-bold text-blue-900"><?php echo e(number_format($data['total'] ?? 0)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Dipublikasi</p>
                    <p class="text-2xl font-bold text-green-900"><?php echo e(number_format($data['published'] ?? 0)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Draft</p>
                    <p class="text-2xl font-bold text-yellow-900"><?php echo e(number_format($data['draft'] ?? 0)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-lg">
                    <i class="fas fa-eye text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Total Views</p>
                    <p class="text-2xl font-bold text-purple-900"><?php echo e(number_format($data['total_views'] ?? 0)); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Publishing Trend -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Publikasi Berita</h4>
            <div class="h-64">
                <canvas id="newsPublishingChart"></canvas>
            </div>
        </div>
        
        <!-- Status Distribution -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Distribusi Status Berita</h4>
            <div class="h-64">
                <canvas id="newsStatusChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Categories and Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- News Categories -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Kategori Berita Terpopuler</h4>
            <div class="space-y-3">
                <?php $__currentLoopData = $data['categories'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600"><?php echo e($category['name']); ?></span>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($category['percentage']); ?>%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-800"><?php echo e(number_format($category['count'])); ?> (<?php echo e($category['percentage']); ?>%)</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <!-- Top Performing News -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Berita Terpopuler</h4>
            <div class="space-y-3">
                <?php $__currentLoopData = $data['top_news'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border-b border-gray-200 pb-2">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h5 class="text-sm font-medium text-gray-800 line-clamp-2"><?php echo e($news['title']); ?></h5>
                            <p class="text-xs text-gray-500 mt-1"><?php echo e($news['published_date']); ?></p>
                        </div>
                        <div class="text-right ml-3">
                            <span class="text-sm font-semibold text-blue-600"><?php echo e(number_format($news['views'])); ?></span>
                            <p class="text-xs text-gray-500">views</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    
    <!-- Author Performance and Engagement -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Author Performance -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Performa Penulis</h4>
            <div class="space-y-3">
                <?php $__currentLoopData = $data['top_authors'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                            <?php echo e(substr($author['name'], 0, 1)); ?>

                        </div>
                        <span class="text-sm text-gray-600 ml-3"><?php echo e($author['name']); ?></span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium text-gray-800"><?php echo e(number_format($author['articles_count'])); ?> artikel</span>
                        <p class="text-xs text-gray-500"><?php echo e(number_format($author['total_views'])); ?> views</p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <!-- Engagement Metrics -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Metrik Engagement</h4>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Views per Artikel</span>
                    <span class="text-lg font-semibold text-gray-800"><?php echo e(number_format($data['avg_views_per_article'] ?? 0)); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Artikel Terpopuler (Views)</span>
                    <span class="text-lg font-semibold text-blue-600"><?php echo e(number_format($data['max_views'] ?? 0)); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Publikasi</span>
                    <span class="text-lg font-semibold text-green-600"><?php echo e($data['publication_rate'] ?? '0'); ?>%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Artikel per Bulan</span>
                    <span class="text-lg font-semibold text-purple-600"><?php echo e(number_format($data['avg_articles_per_month'] ?? 0)); ?></span>
                </div>
                <div class="pt-2 border-t">
                    <div class="text-sm text-gray-600 mb-2">Engagement Rate:</div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: <?php echo e($data['engagement_rate'] ?? 0); ?>%"></div>
                    </div>
                    <div class="text-center text-sm font-medium text-gray-800 mt-1"><?php echo e($data['engagement_rate'] ?? '0'); ?>%</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Monthly Publishing Trend -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h4 class="text-md font-semibold text-gray-800 mb-4">Tren Publikasi Bulanan</h4>
        <div class="h-64">
            <canvas id="newsMonthlyChart"></canvas>
        </div>
    </div>
</div>

<script>
// Publishing Trend Chart
if (document.getElementById('newsPublishingChart')) {
    const ctx = document.getElementById('newsPublishingChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($data['daily_stats'] ?? [], 'date')); ?>,
            datasets: [{
                label: 'Publikasi Harian',
                data: <?php echo json_encode(array_column($data['daily_stats'] ?? [], 'count')); ?>,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

// Status Distribution Chart
if (document.getElementById('newsStatusChart')) {
    const ctx = document.getElementById('newsStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Dipublikasi', 'Draft'],
            datasets: [{
                data: [
                    <?php echo e($data['published'] ?? 0); ?>,
                    <?php echo e($data['draft'] ?? 0); ?>

                ],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 191, 36)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Monthly Publishing Chart
if (document.getElementById('newsMonthlyChart')) {
    const ctx = document.getElementById('newsMonthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($data['monthly_stats'] ?? [], 'month')); ?>,
            datasets: [{
                label: 'Artikel Dipublikasi',
                data: <?php echo json_encode(array_column($data['monthly_stats'] ?? [], 'published')); ?>,
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }, {
                label: 'Draft Dibuat',
                data: <?php echo json_encode(array_column($data['monthly_stats'] ?? [], 'draft')); ?>,
                backgroundColor: 'rgba(251, 191, 36, 0.8)',
                borderColor: 'rgb(251, 191, 36)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
}
</script><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\admin\laporan\news.blade.php ENDPATH**/ ?>