@extends('layouts.app')
@section('title', 'Edit Task')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('task.index', $project->id) }}" class="link-primary">Tasks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $task->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white rounded-4 border border-opacity-10">
                @if (Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-4">Edit Task</h5>
                            <a href="{{ route('task.index', $project->id) }}" class="btn btn-secondary">Back</a>
                        </div>

                        <form action="{{ route('task.update', ['projectId' => $project->id, 'taskId' => $task->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light @error('title') is-invalid @enderror" id="title" name="title" value="{{ (old('title')) ? old('title') : $task->title }}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="description" class="form-label">Description <small class="text-secondary">(optional)</small></label>
                                <textarea class="form-control bg-light @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ (old('description')) ? old('description') : $task->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="start-date" class="form-label">Start Date</label>
                                <input type="date" class="form-control bg-light @error('start_date') is-invalid @enderror" id="start-date" name="start_date" value="{{ old('start_date') ? old('start_date') : $task->start_date }}">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="end-date" class="form-label">End Date</label>
                                <input type="date" class="form-control bg-light @error('end_date') is-invalid @enderror" id="end-date" name="end_date" value="{{ old('end_date') ? old('end_date') : $task->end_date }}">
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="user_id" class="form-label">Assign Staff <small class="text-secondary">(multiple select)</small></label>
                                <select class="form-select bg-light @error('user_id') is-invalid @enderror" id="user_id" name="user_id[]" size="4" multiple>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->id }}" {{ in_array($staff->id, $selectedStaffIds) ? 'selected' : '' }}>
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6 mb-4">
                                <p class="form-label">Status</p>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault1" value="Not Started" {{ old('status', $task->status) == 'Not Started' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Not Started
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault2" value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        In Progress
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault3" value="Completed" {{ old('status', $task->status) == 'Completed' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Completed
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault4" value="Pending" {{ old('status', $task->status) == 'Pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Pending
                                    </label>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                @else
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-4">Edit Task</h5>
                            <a href="{{ route('task.index', $project->id) }}" class="btn btn-secondary">Back</a>
                        </div>

                        <form action="{{ route('task.update', ['projectId' => $project->id, 'taskId' => $task->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" value="{{ $task->title }}" class="form-control bg-light" id="title" readonly>
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control bg-light" id="description" name="description" rows="3" readonly>{{ $task->description }}</textarea>
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="start-date" class="form-label">Start Date</label>
                                <input type="text" value="{{ date('F d, Y', strtotime($task->start_date)) }}" class="form-control bg-light" id="start-date" readonly>
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="end-date" class="form-label">End Date</label>
                                <input type="text" value="{{ date('F d, Y', strtotime($task->end_date)) }}" class="form-control bg-light" id="end-date" readonly>
                            </div>
                            <div class="form-group col-12 col-md-6 mb-3">
                                <p class="form-label">Assigned To</p>
                                @if ($task->users->isNotEmpty())
                                    @foreach ($task->users as $staff)
                                        <span class="badge rounded-pill text-bg-primary">{{ $staff->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge rounded-pill text-bg-secondary">No Staff Assigned</span>
                                @endif
                            </div>
                            <div class="form-group col-12 col-md-6 mb-4">
                                <p class="form-label">Status</p>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault1" value="Not Started" {{ old('status', $task->status) == 'Not Started' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Not Started
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault2" value="In Progress" {{ old('status', $task->status) == 'In Progress' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        In Progress
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault3" value="Completed" {{ old('status', $task->status) == 'Completed' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Completed
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="radio" name="status" id="flexRadioDefault4" value="Pending" {{ old('status', $task->status) == 'Pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Pending
                                    </label>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
