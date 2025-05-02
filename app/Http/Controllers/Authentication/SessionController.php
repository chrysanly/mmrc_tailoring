<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Please verify your email before logging in.',
            ]);
        }
    

        request()->session()->regenerate();

        return auth()->user()->role === 'superadmin' ? redirect('/admin/dashboard') : redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
