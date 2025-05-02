@extends('layouts.auth')

@section('content')
    <section id="hero" class="mt-5">
        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <div class="row align-items-center g-lg-5 py-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <img src="{{ asset('assets/images/illustrator_1.png') }}" class="rounded-3" id="illustrator" alt="">
                </div>
                <div class="col-md-10 mx-auto col-lg-5">
                    
                    <form class="p-4 p-md-5 border rounded-5 bg-body-tertiary" method="POST"
                        action="{{ route('register.store') }}">
                        @csrf
                        <h1 class="fs-1 fw-bold mb-4 title">MMRC Tailoring</h1>
                        <div class="form-floating mb-3">
                            <input type="text" name="first_name" class="form-control" id="floatingInput"
                                placeholder="John Doe">
                            <label for="floatingInput">First Name</label>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="middle_name" class="form-control" id="floatingInput"
                                placeholder="John Doe">
                            <label for="floatingInput">Middle Name</label>
                            @error('middle_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="last_name" class="form-control" id="floatingInput"
                                placeholder="John Doe">
                            <label for="floatingInput">Last Name</label>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput"
                                placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                id="floatingPasswordConfirmation" placeholder="Password Confirmation">
                            <label for="floatingPasswordConfirmation">Password Confirmation</label>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="checkbox mb-3">
                            <label>
                                <input type="checkbox" value="remember-me"> Remember me
                            </label>
                        </div>
                        <div class="d-flex justify-content-around align-items-center gap-2">
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
                        </div>
                        <hr class="my-4">
                        <small class="text-body-secondary">By clicking Sign Up, you agree to the terms of use.</small>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection