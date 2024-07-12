@extends('layouts.app')
@section('title', 'Projects')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projects</li>
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
                            <form action="{{ route('project.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="query" class="form-control bg-white" placeholder="Projects" aria-label="Search projects" aria-describedby="button-search" value="{{ request()->input('query') }}">
                                    <button class="btn btn-secondary" type="submit" id="button-search">Search</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            @can('create.projects')
                                <a href="{{ route('project.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i>Project</a>
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
                                    <th>Title</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($projects->count())
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td class="align-middle text-center">{{ $project->id }}</td>
                                            <td class="align-middle">{{ $project->title }}</td>
                                            <td class="align-middle">
                                                @if ($project->users->isNotEmpty())
                                                    @foreach ($project->users as $staff)
                                                        <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if ($project->status == 'Not Started')
                                                    <span class="badge rounded-pill text-bg-secondary">Not Started</span>
                                                @elseif ($project->status == 'In Progress')
                                                    <span class="badge rounded-pill text-bg-info">In Progress</span>
                                                @elseif ($project->status == 'Completed')
                                                    <span class="badge rounded-pill text-bg-success">Completed</span>
                                                @elseif ($project->status == 'Pending')
                                                    <span class="badge rounded-pill text-bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                                        @can('read.tasks')
                                                            <li><a href="{{ route('task.index', $project->id) }}" class="dropdown-item" type="button"><span class="fw-bold">Tasks</span></a></li>
                                                        @endcan
                                                        @can('read.projects')
                                                            <li><a href="{{ route('project.show', $project->id) }}" class="dropdown-item" type="button">View</a></li>
                                                        @endcan
                                                        @can('update.projects')
                                                            <li><a href="{{ route('project.edit', $project->id) }}" class="dropdown-item" type="button">Edit</a></li>
                                                        @endcan
                                                        @can('delete.projects')
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $project->id }}">
                                                                    Delete
                                                                </button>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="staticBackdrop{{ $project->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Project</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        This process can't be undone! Are you sure you want to delete this project <span class="fw-bold">#{{ $project->id }} - {{ $project->title }}</span> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <form action="{{ route('project.delete', $project->id) }}" method="POST">
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
                                        <td colspan="5" class="align-middle text-center py-3">There is no data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small>Showing {{$projects->count()}} of {{ $projects->total() }} project(s).</small>
                        {!! $projects->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
