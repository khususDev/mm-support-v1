<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Jika bukan permintaan JSON dan tidak terautentikasi
        if (!$request->expectsJson()) {
            // Jika user tidak login, arahkan ke halaman login
            if (!auth()->check()) {
                return route('login');
            }

            // Jika user login tapi tidak punya akses, tampilkan 403
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}
