@extends('layouts.app')
@section('title', 'Tasks')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('project.index') }}" class="link-primary">Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card bg-white rounded-4 border border-opacity-10 my-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="fw-bold">{{ $project->title }}</h4>
                    <p class="mb-2">{{ $project->description }}</p>
                    @if ($project->users->isNotEmpty())
                        @foreach ($project->users as $staff)
                            <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                        @endforeach
                    @else
                        <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                    @endif
                </div>
                <div>
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

    <div class="d-flex justify-content-end mb-4">
        @can('create.tasks')
            <a href="{{ route('task.create', $project->id) }}" class="btn btn-secondary"><i class="bi bi-plus-lg me-2"></i>Add Task</a>
        @endcan
    </div>

    <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="alert alert-secondary rounded-4 h-100">
                <h5 class="mb-4">Not Started</h5>
                @foreach ($notStartedTasks as $notStartedTask)
                    <div class="card bg-white rounded-4 mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title">{{ $notStartedTask->title }}</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                        @can('read.tasks')
                                            <li><a href="{{ route('task.show', ['projectId' => $project->id, 'taskId' => $notStartedTask->id]) }}" class="dropdown-item" type="button">View</a></li>
                                        @endcan
                                        @can('update.tasks')
                                            <li><a href="{{ route('task.edit', ['projectId' => $project->id, 'taskId' => $notStartedTask->id]) }}" class="dropdown-item" type="button">Edit</a></li>
                                        @endcan
                                        @can('delete.tasks')
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $notStartedTask->id }}">
                                                    Delete
                                                </button>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                            <h6 class="text-secondary">{{ $notStartedTask->description }}</h6>
                            @if ($notStartedTask->users->isNotEmpty())
                                @foreach ($notStartedTask->users as $staff)
                                    <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                @endforeach
                            @else
                                <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="staticBackdrop{{ $notStartedTask->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This process can't be undone! Are you sure you want to delete this task <span class="fw-bold">{{ $notStartedTask->title }}</span> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <form action="{{ route('task.delete', ['projectId' => $project->id, 'taskId' => $notStartedTask->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-0">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="alert alert-info rounded-4 h-100">
                <h5 class="mb-4">In Progress</h5>
                @foreach ($inProgressTasks as $inProgressTask)
                    <div class="card bg-white rounded-4 mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title">{{ $inProgressTask->title }}</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                        @can('read.tasks')
                                            <li><a href="{{ route('task.show', ['projectId' => $project->id, 'taskId' => $inProgressTask->id]) }}" class="dropdown-item" type="button">View</a></li>
                                        @endcan
                                        @can('update.tasks')
                                            <li><a href="{{ route('task.edit', ['projectId' => $project->id, 'taskId' => $inProgressTask->id]) }}" class="dropdown-item" type="button">Edit</a></li>
                                        @endcan
                                        @can('delete.tasks')
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $inProgressTask->id }}">
                                                    Delete
                                                </button>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                            <h6 class="text-secondary">{{ $inProgressTask->description }}</h6>
                            @if ($inProgressTask->users->isNotEmpty())
                                @foreach ($inProgressTask->users as $staff)
                                    <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                @endforeach
                            @else
                                <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="staticBackdrop{{ $inProgressTask->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This process can't be undone! Are you sure you want to delete this task <span class="fw-bold">{{ $inProgressTask->title }}</span> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <form action="{{ route('task.delete', ['projectId' => $project->id, 'taskId' => $inProgressTask->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-0">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="alert alert-warning rounded-4 h-100">
                <h5 class="mb-4">Pending</h5>
                @foreach ($pendingTasks as $pendingTask)
                    <div class="card bg-white rounded-4 mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title">{{ $pendingTask->title }}</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                        @can('read.tasks')
                                            <li><a href="{{ route('task.show', ['projectId' => $project->id, 'taskId' => $pendingTask->id]) }}" class="dropdown-item" type="button">View</a></li>
                                        @endcan
                                        @can('update.tasks')
                                            <li><a href="{{ route('task.edit', ['projectId' => $project->id, 'taskId' => $pendingTask->id]) }}" class="dropdown-item" type="button">Edit</a></li>
                                        @endcan
                                        @can('delete.tasks')
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $pendingTask->id }}">
                                                    Delete
                                                </button>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                            <h6 class="text-secondary">{{ $pendingTask->description }}</h6>
                            @if ($pendingTask->users->isNotEmpty())
                                @foreach ($pendingTask->users as $staff)
                                    <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                @endforeach
                            @else
                                <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="staticBackdrop{{ $pendingTask->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This process can't be undone! Are you sure you want to delete this task <span class="fw-bold">{{ $pendingTask->title }}</span> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <form action="{{ route('task.delete', ['projectId' => $project->id, 'taskId' => $pendingTask->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-0">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="alert alert-success rounded-4 h-100">
                <h5 class="mb-4">Completed</h5>
                @foreach ($completedTasks as $completedTask)
                    <div class="card bg-white rounded-4 mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title">{{ $completedTask->title }}</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link link-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end bg-white">
                                        @can('read.tasks')
                                            <li><a href="{{ route('task.show', ['projectId' => $project->id, 'taskId' => $completedTask->id]) }}" class="dropdown-item" type="button">View</a></li>
                                        @endcan
                                        @can('update.tasks')
                                            <li><a href="{{ route('task.edit', ['projectId' => $project->id, 'taskId' => $completedTask->id]) }}" class="dropdown-item" type="button">Edit</a></li>
                                        @endcan
                                        @can('delete.tasks')
                                            <li>
                                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $completedTask->id }}">
                                                    Delete
                                                </button>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                            <h6 class="text-secondary">{{ $completedTask->description }}</h6>
                            @if ($completedTask->users->isNotEmpty())
                                @foreach ($completedTask->users as $staff)
                                    <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                @endforeach
                            @else
                                <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                            @endif
                        </div>
                    </div>

                    <div class="modal fade" id="staticBackdrop{{ $completedTask->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Task</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This process can't be undone! Are you sure you want to delete this task <span class="fw-bold">{{ $completedTask->title }}</span> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <form action="{{ route('task.delete', ['projectId' => $project->id, 'taskId' => $completedTask->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-0">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
