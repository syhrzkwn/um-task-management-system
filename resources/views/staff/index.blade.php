@extends('layouts.app')
@section('title', 'Staffs')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staffs</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white rounded-4 border border-opacity-10">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <form action="{{ route('staff.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="query" class="form-control bg-white" placeholder="Staffs" aria-label="Search staffs" aria-describedby="button-search" value="{{ request()->input('query') }}">
                                    <button class="btn btn-secondary" type="submit" id="button-search">Search</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            @can('create.staffs')
                                <a href="{{ route('staff.register') }}" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Staff</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th class="text-center">#ID</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($staffs->count())
                                    @foreach ($staffs as $staff)
                                        <tr>
                                            <td class="align-middle text-center">{{ $staff->id }}</td>
                                            <td class="align-middle">{{ $staff->name }}</td>
                                            <td class="align-middle"><a href="tel:{{ $staff->phone }}" class="link-primary">{{ $staff->phone }}</a></td>
                                            <td class="align-middle"><a href="mailto:{{ $staff->email }}" class="link-primary">{{ $staff->email }}</a></td>
                                            <td class="align-middle">
                                                @if ($staff->status == 'Active')
                                                    <span class="badge rounded-pill text-bg-success">Works</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-danger">On Leave</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                                        @can('read.staffs')
                                                            <li><a href="{{ route('staff.show', $staff->id) }}" class="dropdown-item" type="button">View</a></li>
                                                        @endcan
                                                        @can('update.staffs')
                                                            <li><a href="{{ route('staff.edit', $staff->id) }}" class="dropdown-item" type="button">Edit</a></li>
                                                        @endcan
                                                        @can('delete.staffs')
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $staff->id }}">
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="staticBackdrop{{ $staff->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Staff</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        This process can't be undone! Are you sure you want to delete this staff <span class="fw-bold">#{{ $staff->id }} - {{ $staff->name }}</span> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <form action="{{ route('staff.delete', $staff->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger ms-0">Yes, Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="align-middle text-center py-3">There is no data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small>Showing {{$staffs->count()}} of {{ $staffs->total() }} staff(s).</small>
                        {!! $staffs->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
