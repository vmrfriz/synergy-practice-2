<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function loginForm()
    {
        $props = [];
        if (app()->environment() !== 'production') {
            $props['email'] = 'admin@synergy.ru';
            $props['password'] = 'password';
        }

        return Inertia::render('Auth/Login', $props);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $authorized = Auth::attempt($credentials, $request->boolean('remember'));
        if ($authorized) {
            //
        }
    }

    public function registerForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function register()
    {

    }

    public function logout()
    {
        return redirect()->route('profile');
    }
}
