<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUnitKerjaAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // DIUBAH: Memeriksa role_id untuk konsistensi dan keandalan
        // Pastikan pengguna sudah login dan memiliki role_id 2 (Admin)
        if (Auth::check() && Auth::user()->role_id == 2) {
            return $next($request);
        }

        // Jika tidak, kembalikan ke halaman login dengan pesan error
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
