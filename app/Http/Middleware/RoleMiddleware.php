<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // atau sesuaikan
        }

        $user = Auth::user();

        if ($user->role->name !== $role) {
            // Redirect berdasarkan role
            switch ($user->role->name) {
                case 'customer':
                    return redirect('/home');
                case 'superadmin':
                    return redirect('/admin/dashboard');
                default:
                    abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
