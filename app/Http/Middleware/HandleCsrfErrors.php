<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class HandleCsrfErrors
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
        } catch (TokenMismatchException $e) {
            // Log the CSRF error
            \Illuminate\Support\Facades\Log::warning('CSRF Token Mismatch', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
                'session_id' => $request->session()->getId(),
            ]);

            // Handle AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Sesi Anda telah berakhir. Silakan refresh halaman.',
                    'error' => 'csrf_token_expired',
                    'redirect' => $request->url()
                ], 419);
            }

            // Handle form submissions
            if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete')) {
                return redirect()->back()
                    ->withInput($request->except(['_token', '_method']))
                    ->with('error', 'Sesi Anda telah berakhir. Silakan coba lagi.');
            }

            // For GET requests, show the 419 error page
            return response()->view('errors.419', [], 419);
        }
    }
}