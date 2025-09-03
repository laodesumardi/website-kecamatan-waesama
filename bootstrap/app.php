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
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'share.notifications' => \App\Http\Middleware\ShareNotificationData::class,
        ]);
        
        // Add notification data sharing to web middleware group
        $middleware->web(append: [
            \App\Http\Middleware\ShareNotificationData::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
