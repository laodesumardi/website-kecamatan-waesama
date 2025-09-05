<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Ensure user object exists
        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Session tidak valid. Silakan login kembali.');
        }

        // Check if user has is_active property and if it's active
        if (property_exists($user, 'is_active') && !$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        // Check if user has role relationship
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki role yang valid. Silakan hubungi administrator.');
        }

        // Check if role has name property
        if (!isset($user->role->name) || empty($user->role->name)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak valid. Silakan hubungi administrator.');
        }

        // Check if user's role is in the allowed roles
        if (!empty($roles) && !in_array($user->role->name, $roles)) {
            // Use 403 response for unauthorized access
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
