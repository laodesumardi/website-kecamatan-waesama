<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Auto-detect base path for different hosting environments
$detectedBasePath = dirname(__DIR__);

// If we're in a shared hosting environment where files are in root
// Check if we have Laravel structure in current directory
if (file_exists(__DIR__.'/app') && file_exists(__DIR__.'/config')) {
    $detectedBasePath = __DIR__;
}

return Application::configure(basePath: $detectedBasePath)
    ->withRouting(
        web: $detectedBasePath.'/routes/web.php',
        commands: $detectedBasePath.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'share.notifications' => \App\Http\Middleware\ShareNotificationData::class,
            'security' => \App\Http\Middleware\SecurityMiddleware::class,
            'csrf.handler' => \App\Http\Middleware\HandleCsrfErrors::class,
            'exception.handler' => \App\Http\Middleware\ExceptionHandlerMiddleware::class,
        ]);
        
        // Add global middleware
        $middleware->append(\App\Http\Middleware\ExceptionHandlerMiddleware::class);
        
        // Add security middleware to web group
        $middleware->web(append: [
            \App\Http\Middleware\SecurityMiddleware::class,
            \App\Http\Middleware\HandleCsrfErrors::class,
        ]);
        
        // Add security middleware to API group
        $middleware->api(append: [
            \App\Http\Middleware\SecurityMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling untuk production
        $exceptions->render(function (Throwable $e, $request) {
            // Log semua error dengan detail lengkap
            if (!app()->environment('testing')) {
                \Illuminate\Support\Facades\Log::error('Application Error', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'user_id' => auth()->id(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
            
            // Untuk production, jangan tampilkan detail error
            if (app()->environment('production') && !config('app.debug')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                        'error_id' => uniqid('err_')
                    ], 500);
                }
                
                // Tampilkan halaman error yang user-friendly
                return response()->view('errors.500', [], 500);
            }
        });
    })->create();
