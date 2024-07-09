@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-5 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <h4 class="mb-4">Hello, {{ Auth::user()->name }}!</h4>

    @if (Auth::user()->user_type == 'Admin')
    <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-info shadow p-2 mb-1 fs-5"><i class="bi bi-calendar2-week-fill text-info"></i></span></p>
                    <h5 class="card-title">Not Started Tasks</h5>
                    <h1>10</h1>
                    <h6 class="text-secondary">5 not assigned to staff yet</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-warning shadow p-2 mb-1 fs-5"><i class="bi bi-hourglass-split text-warning"></i></span></p>
                    <h5 class="card-title">On-Going Tasks</h5>
                    <h1>10</h1>
                    <h6 class="text-secondary">5 not assigned to staff yet</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-success shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard2-check text-success"></i></span></p>
                    <h5 class="card-title">Completed Tasks</h5>
                    <h1>10</h1>
                    <h6 class="text-secondary">5 not assigned to staff yet</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-danger shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard-x text-danger"></i></span></p>
                    <h5 class="card-title">Pending Tasks</h5>
                    <h1>10</h1>
                    <h6 class="text-secondary">5 not assigned to staff yet</h6>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
