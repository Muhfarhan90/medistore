<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (Auth::user()->role === 'superadmin') {
            return '/admin/dashboard';
        } elseif (Auth::user()->role === 'customer') {
            return '/home';
        }

        // Default redirect jika role tidak terdeteksi
        return '/home';
    }

    protected function authenticated($request, $user)
    {

        if ($user->role->name === 'superadmin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role->name === 'customer') {
            return redirect('/home');
        }

        return redirect('/home'); // default
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
