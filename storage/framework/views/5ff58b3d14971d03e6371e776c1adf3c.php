<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - Kantor Camat Waesama</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .error-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-6">
        <div class="text-center">
            <!-- Error Icon -->
            <div class="error-animation mb-8">
                <i class="fas fa-exclamation-triangle text-6xl text-red-500"></i>
            </div>
            
            <!-- Error Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Oops! Terjadi Kesalahan
            </h1>
            
            <!-- Error Message -->
            <p class="text-gray-600 mb-8 leading-relaxed">
                Maaf, terjadi kesalahan pada server kami. Tim teknis sedang bekerja untuk memperbaiki masalah ini.
            </p>
            
            <!-- Error Code -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
                <div class="flex items-center justify-center">
                    <i class="fas fa-code text-red-500 mr-2"></i>
                    <span class="text-red-700 font-medium">Error 500 - Internal Server Error</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="space-y-4">
                <button onclick="window.location.reload()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i>
                    Coba Lagi
                </button>
                
                <a href="<?php echo e(url('/')); ?>" 
                   class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
            
            <!-- Contact Info -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-4">
                    Jika masalah berlanjut, silakan hubungi kami:
                </p>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-center text-gray-600">
                        <i class="fas fa-phone mr-2"></i>
                        <span>(0914) 123-456</span>
                    </div>
                    
                    <div class="flex items-center justify-center text-gray-600">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>info@waesama.go.id</span>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-xs text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> Kantor Camat Waesama</p>
                <p class="mt-1">Melayani dengan Sepenuh Hati</p>
            </div>
        </div>
    </div>
    
    <script>
        // Auto refresh setelah 30 detik
        setTimeout(function() {
            if (confirm('Halaman akan dimuat ulang otomatis. Lanjutkan?')) {
                window.location.reload();
            }
        }, 30000);
        
        // Track error untuk analytics (opsional)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'exception', {
                'description': 'Server Error 500',
                'fatal': false
            });
        }
    </script>
</body>
</html><?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views/errors/500.blade.php ENDPATH**/ ?>