@extends('layouts.app')
@section('title', 'Register Staff')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('staff.index') }}" class="link-primary">Staffs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white rounded-4 border border-opacity-10">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-4">Register Staff</h5>
                        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <form action="{{ route('staff.store') }}" method="POST">
                        @csrf
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control bg-light @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control bg-light @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control bg-light @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control bg-light @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="password-confirm" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control bg-light" id="password-confirm" name="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Register Staff</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
