@extends('layouts.blank')
@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center full-height">
    <div class="card bg-white w-75">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-7 p-3 p-md-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <img src="{{ asset('img/um-logo.png') }}" class="img-fluid mb-5" alt="Universiti Malaya Logo">
                        <h1 class="fw-bold">Welcome Back!</h1>
                        <p class="mb-3">Universiti Malaya | Task Management System</p>
                        <div class="form-floating mb-2">
                            <input id="email" type="email" class="form-control bg-light @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                            <label for="floatingInput">Email Address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control bg-light @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="password" autocomplete="current-password">
                            <label for="floatingPassword">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="checkbox mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                    </form>
                </div>
                <div class="col-0 col-lg-5">
                    <img src="{{ asset('img/img-login.jpeg') }}" class="card-img d-none d-sm-none d-md-none d-lg-block rounded " alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
