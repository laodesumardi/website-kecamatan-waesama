<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ProductionErrorHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (Throwable $e) {
            // Log error dengan detail lengkap
            Log::error('Production Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
            ]);

            // Jika dalam mode debug, lempar error asli
            if (config('app.debug')) {
                throw $e;
            }

            // Untuk production, tampilkan halaman error yang user-friendly
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                    'error_id' => uniqid('err_')
                ], 500);
            }

            return response()->view('errors.500', [
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}