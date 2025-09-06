<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
        <link rel="alternate icon" href="<?php echo e(asset('favicon.ico')); ?>">
        <link rel="mask-icon" href="<?php echo e(asset('favicon.svg')); ?>" color="#1e40af">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Mobile CSS Fixes -->
        <link href="<?php echo e(asset('css/mobile-fix.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('css/form-fixes.css')); ?>" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Mobile Responsive JavaScript -->
        <script src="<?php echo e(asset('js/mobile-responsive.js')); ?>" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>
        </div>
    </body>
</html>
<?php /**PATH D:\laragon\www\kantor-camat-waesama\resources\views\layouts\app.blade.php ENDPATH**/ ?>