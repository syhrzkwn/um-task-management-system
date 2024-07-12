@extends('layouts.app')
@section('title', 'New Project')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-4 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="link-primary">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('project.index') }}" class="link-primary">Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Project</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-white rounded-4 border border-opacity-10">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-4">New Project</h5>
                        <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                    <form action="{{ route('project.store') }}" method="POST">
                        @csrf
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="description" class="form-label">Description <small class="text-secondary">(optional)</small></label>
                            <textarea class="form-control bg-light @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="user_id" class="form-label">Assign Staff <small class="text-secondary">(multiple select)</small></label>
                            <select class="form-select bg-light @error('user_id') is-invalid @enderror" id="user_id" name="user_id[]" size="4" multiple>
                                @foreach($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
