@extends('layouts.app')
@section('title', 'Edit Staff')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('staff.index') }}" class="link-primary">Staffs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{ $staff->id }} - {{ $staff->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white border border-opacity-10 rounded-4">
                <div class="card-body p-5">
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-4">Update Staff</h5>
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="{{ (old('name')) ? old('name') : $staff->name }}" class="form-control bg-light @error('name') is-invalid @enderror" id="name" name="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" value="{{ (old('phone')) ? old('phone') : $staff->phone }}" class="form-control bg-light @error('phone') is-invalid @enderror" id="phone" name="phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" value="{{ (old('email')) ? old('email') : $staff->email }}" class="form-control bg-light @error('email') is-invalid @enderror" id="email" name="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-4">
                                <p class="form-label">Status</p>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusWorks" value="Active" {{ old('status', $staff->status) == 'Active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusWorks">
                                        Works
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="statusOnLeave" value="Inactive" {{ old('status', $staff->status) == 'Inactive' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusOnLeave">
                                        On Leave
                                    </label>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Staff</button>
                        </form>
                    </div>
                    <hr>
                    <div class="mt-5">
                        <h5 class="mb-4">Change Password</h5>
                        <form action="{{ route('staff.update-password', $staff->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-4">
                                <label class="form-label" for="password-confirm">New Password Confirmation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" id="password-confirm" name="password_confirmation">
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
