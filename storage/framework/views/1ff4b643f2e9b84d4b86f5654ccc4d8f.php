<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired | Kantor Camat Waesama</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Error Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-20 rounded-full mb-6 floating">
                <i class="fas fa-clock text-4xl text-white"></i>
            </div>
            <h1 class="text-6xl font-bold text-white mb-2">419</h1>
            <h2 class="text-2xl font-semibold text-white mb-4">Page Expired</h2>
        </div>
        
        <!-- Error Message -->
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-6 mb-8">
            <p class="text-white text-center mb-4">
                Sesi Anda telah berakhir karena tidak ada aktivitas dalam waktu yang lama. Silakan refresh halaman atau kembali ke beranda.
            </p>
            
            <!-- Error Code -->
            <div class="bg-red-50 bg-opacity-20 border border-red-200 border-opacity-30 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-yellow-300 mr-2"></i>
                    <span class="text-white font-medium">Error 419 - CSRF Token Expired</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-3">
                <button onclick="window.location.reload()" 
                        class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-redo mr-2"></i>
                    Refresh Halaman
                </button>
                
                <a href="<?php echo e(url('/')); ?>" 
                   class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
                
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="w-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="text-center">
            <p class="text-white text-opacity-80 text-sm mb-4">
                Jika masalah ini terus terjadi, silakan hubungi administrator.
            </p>
            
            <!-- Contact Info -->
            <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-4">
                <p class="text-white text-sm mb-2">
                    <i class="fas fa-envelope mr-2"></i>
                    Email: info@waesama.go.id
                </p>
                <p class="text-white text-sm">
                    <i class="fas fa-phone mr-2"></i>
                    Telepon: (0123) 456-7890
                </p>
            </div>
        </div>
    </div>
    
    <!-- Auto refresh script -->
    <script>
        // Auto refresh setelah 30 detik jika tidak ada interaksi
        let autoRefreshTimer = setTimeout(function() {
            if (confirm('Halaman akan di-refresh otomatis. Lanjutkan?')) {
                window.location.reload();
            }
        }, 30000);
        
        // Clear timer jika user berinteraksi
        document.addEventListener('click', function() {
            clearTimeout(autoRefreshTimer);
        });
        
        document.addEventListener('keydown', function() {
            clearTimeout(autoRefreshTimer);
        });
    </script>
</body>
</html><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\errors\419.blade.php ENDPATH**/ ?>