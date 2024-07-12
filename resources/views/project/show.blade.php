@extends('layouts.app')
@section('title', 'Project Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('project.index') }}" class="link-primary">Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $project->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white rounded-4 border border-opacity-10">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-4">Project Details</h5>
                        <div>
                            <a href="{{ route('task.index', $project->id) }}" class="btn btn-success me-1">Project Tasks</a>
                            <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" value="{{ $project->title }}" class="form-control bg-light" id="title" readonly>
                    </div>
                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control bg-light" id="description" name="description" rows="3" readonly>{{ $project->description }}</textarea>
                    </div>
                    <div class="form-group col-12 col-md-6 mb-3">
                        <p class="form-label">Assigned To</p>
                        @if ($project->users->isNotEmpty())
                            @foreach ($project->users as $staff)
                                <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                            @endforeach
                        @else
                            <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                        @endif
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <p class="form-label"><span class="me-1">Status</span></p>
                        @if ($project->status == 'Not Started')
                            <span class="badge rounded-pill text-bg-secondary">Not Started</span>
                        @elseif ($project->status == 'In Progress')
                            <span class="badge rounded-pill text-bg-info">In Progress</span>
                        @elseif ($project->status == 'Completed')
                            <span class="badge rounded-pill text-bg-success">Completed</span>
                        @elseif ($project->status == 'Pending')
                            <span class="badge rounded-pill text-bg-warning">Pending</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
