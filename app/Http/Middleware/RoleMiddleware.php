<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        // Mendukung role admin dan user (serta alias customer)
        if ($userRole === $role) {
            return $next($request);
        }

        if (in_array($role, ['user', 'customer']) && in_array($userRole, ['user', 'customer'])) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses ke halaman ini.');
    }
}
