<?php
// app/Http/Middleware/RedirectIfRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfRole
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Arahkan pengguna ke halaman berbeda berdasarkan role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }

        // Jika role tidak ditemukan, lanjutkan permintaan
        return $next($request);
    }
}
