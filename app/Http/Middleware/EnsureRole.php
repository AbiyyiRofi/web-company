<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = 'superadmin'): Response
    {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        $userRole = strtolower($request->user()->role ?? '');
        $targetRole = strtolower($role);

        $isAuthorized = ($targetRole === 'superadmin' || $targetRole === 'super_admin')
            ? $request->user()->isSuperAdmin()
            : ($userRole === $targetRole);

        if (! $isAuthorized) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Akses ditolak. Fitur ini hanya untuk Super Admin.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak! Halaman tersebut hanya dapat diakses oleh Super Admin.');
        }

        return $next($request);
    }
}
