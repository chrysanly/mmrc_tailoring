<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Mail\SendUserAdminWelcome;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(){
        return view('admin.admin-user.index', [
            'users' => User::where('role', 'admin')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.admin-user.create');
    }

    public function store(UserRequest $userRequest)
    {
        $data = $userRequest->validated();
        $password = Str::random(11);
        $data['role'] = 'admin';
        $data['email_verified_at'] = now();
        $data['password'] = bcrypt($password);
        $user = User::create($data);

        Mail::to($user->email)->send(new SendUserAdminWelcome($user, $password));

        toast('User Created Successfully.', 'success', 'center');

        return redirect()->route('admin.admin-users.index');
    }

    public function edit(User $user)
    {
        return view('admin.admin-user.edit', compact('user'));
    }
}
