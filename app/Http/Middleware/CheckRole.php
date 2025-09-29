<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Redirect berdasarkan role user
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        return $next($request);
    }
}
