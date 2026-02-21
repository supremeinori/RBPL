<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // ini buat redirect ke halaman login kalau
    }   if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized'); // ini buat ngasih error 403 kalau role tidak sesuai
            return redirect()->route('login'); // ini buat redirect ke halaman login kalau role tidak sesuai
    }
    return $next($request); // ini buat lanjut ke request berikutnya kalau role sesuai
    }

}
