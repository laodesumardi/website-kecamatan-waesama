<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limiting
        $this->handleRateLimit($request);
        
        // Security headers
        $response = $next($request);
        
        return $this->addSecurityHeaders($response);
    }
    
    /**
     * Handle rate limiting
     */
    protected function handleRateLimit(Request $request): void
    {
        $key = 'security_rate_limit:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 100)) {
            abort(429, 'Too Many Requests');
        }
        
        RateLimiter::hit($key, 60); // 100 requests per minute
    }
    
    /**
     * Add security headers to response
     */
    protected function addSecurityHeaders(Response $response): Response
    {
        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'geolocation=(), microphone=(), camera=()',
        ];
        
        // Add HSTS header for HTTPS
        if (request()->secure()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }
        
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
        
        return $response;
    }
}