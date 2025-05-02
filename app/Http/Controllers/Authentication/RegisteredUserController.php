<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'middle_name' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $userAttributes['password'] = bcrypt($userAttributes['password']);
        $userAttributes['role'] = 'user';
        $userAttributes['verification_token'] = Str::random(40);

        $user = User::create($userAttributes);

        Mail::to($user->email)->send(new VerificationMail($user));


        return redirect()->route('login')->with('success', 'User Registered, Please Verify your email to proceed.');
    }
}
