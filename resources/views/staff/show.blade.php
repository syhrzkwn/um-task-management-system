@extends('layouts.app')
@section('title', 'Staff Details')

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
            <div class="card bg-white rounded-4 border border-opacity-10">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-4">Staff Details</h5>
                        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ $staff->name }}" class="form-control bg-light" id="name" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" value="{{ $staff->phone }}" class="form-control bg-light" id="phone" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" value="{{ $staff->email }}" class="form-control bg-light" id="email" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <p class="mb-0"><span class="me-1">Status</span>
                        @if ($staff->status == 'Active')
                            <span class="badge rounded-pill text-bg-success">Works</span>
                        @else
                            <span class="badge rounded-pill text-bg-danger">On Leave</span>
                        @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
