<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUnitKerja
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->role->role_name === 'unit_kerja') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
