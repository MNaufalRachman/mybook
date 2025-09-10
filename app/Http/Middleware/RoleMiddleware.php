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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  Role(s) yang diperbolehkan
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Redirect ke login jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // Cek apakah role user termasuk dalam daftar role yang diizinkan
        if (!in_array($userRole, $roles)) {
            return redirect()->back()->with('error', 'Akses ditolak. Anda tidak memiliki izin.');
        }


        // Lanjutkan ke request berikutnya
        return $next($request);
    }
}
