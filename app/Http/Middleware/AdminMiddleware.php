<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah user punya role admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang bisa membuka halaman ini.');
        }

        return $next($request);
    }
}
