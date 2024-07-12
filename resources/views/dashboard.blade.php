@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-white rounded-4 p-3 mb-5 border">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="mb-4">
        <h4>Hello, {{ Auth::user()->name }}!</h4>
        <p>Welcome to Universiti Malaya | Task Management System</p>
    </div>

    @if (Auth::user()->user_type == \App\Models\User::TYPE_ADMIN)
    <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-primary shadow p-2 mb-1 fs-5"><i class="bi bi-inboxes text-primary"></i></span></p>
                    <h5 class="card-title">Total Projects</h5>
                    <h1>{{ $totalProjects }}</h1>
                    @if ($completionProjectsRate > 0)
                        <h6 class="text-secondary"><span class="text-success me-1"><i class="bi bi-caret-up-fill me-1"></i>{{ number_format($completionProjectsRate, 1) }}%</span>projects completed</h6>
                    @else
                        <h6 class="text-secondary"><span class="text-danger me-1"><i class="bi bi-caret-down-fill me-1"></i>{{ number_format($completionProjectsRate, 1) }}%</span>projects completed</h6>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-primary shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard-data text-primary"></i></span></p>
                    <h5 class="card-title">Total Tasks</h5>
                    <h1>{{ $totalTasks }}</h1>
                    @if ($completionTasksRate > 0)
                    <h6 class="text-secondary"><span class="text-success me-1"><i class="bi bi-caret-up-fill me-1"></i>{{ number_format($completionTasksRate, 1) }}%</span>tasks completed</h6>
                    @else
                        <h6 class="text-secondary"><span class="text-danger me-1"><i class="bi bi-caret-down-fill me-1"></i>{{ number_format($completionTasksRate, 1) }}%</span>tasks completed</h6>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-danger shadow p-2 mb-1 fs-5"><i class="bi bi-alarm text-danger"></i></span></p>
                    <h5 class="card-title">Tasks Due Today</h5>
                    <h1>{{ $tasksDueToday }}</h1>
                    <h6 class="text-secondary">{{ $overdueTasks }} task overdue</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-warning shadow p-2 mb-1 fs-5"><i class="bi bi-calendar2-week text-warning"></i></span></p>
                    <h5 class="card-title">Upcoming Tasks</h5>
                    <h1>{{ $upcomingTasks }}</h1>
                    <h6 class="text-secondary">tasks due in the next 7 days</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-secondary shadow p-2 mb-1 fs-5"><i class="bi bi-calendar2-week-fill text-secondary"></i></span></p>
                    <h5 class="card-title">Not Started Tasks</h5>
                    <h1>{{ $countNotStarted }}</h1>
                    <h6 class="text-secondary">total not started tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-info shadow p-2 mb-1 fs-5"><i class="bi bi-hourglass-split text-info"></i></span></p>
                    <h5 class="card-title">In Progress Tasks</h5>
                    <h1>{{ $countInProgress }}</h1>
                    <h6 class="text-secondary">total in progress tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-success shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard2-check text-success"></i></span></p>
                    <h5 class="card-title">Completed Tasks</h5>
                    <h1>{{ $countCompleted }}</h1>
                    <h6 class="text-secondary">total completed tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-warning shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard-x text-warning"></i></span></p>
                    <h5 class="card-title">Pending Tasks</h5>
                    <h1>{{ $countPending }}</h1>
                    <h6 class="text-secondary">total pending tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <h5>Task Distribution by Staff <i class="bi bi-people align-middle ms-2"></i></h5>
                    <h6 class="text-secondary mb-4">total number of tasks assigned to each staff member</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th class="text-center">#ID</th>
                                    <th>Staff Name</th>
                                    <th class="text-center">Tasks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tasksByStaff->count())
                                    @foreach ($tasksByStaff as $taskByStaff)
                                        <tr>
                                            <td class="align-middle text-center">{{ $taskByStaff->id }}</td>
                                            <td class="align-middle">{{  $taskByStaff->name }}</td>
                                            <td class="align-middle text-center">{{  $taskByStaff->tasks->count() }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="align-middle text-center py-3">There is no data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small>Showing {{$tasksByStaff->count()}} of {{ $tasksByStaff->total() }} staff(s).</small>
                        {!! $tasksByStaff->links() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <h5>Task by Project <i class="bi bi-inboxes align-middle ms-2"></i></h5>
                    <h6 class="text-secondary mb-4">total number of tasks created for each project</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-custom">
                            <thead>
                                <tr>
                                    <th class="text-center">#ID</th>
                                    <th>Project Title</th>
                                    <th class="text-center">Tasks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($tasksByProject->count())
                                    @foreach ($tasksByProject as $taskByProject)
                                        <tr>
                                            <td class="align-middle text-center">{{ $taskByProject->id }}</td>
                                            <td class="align-middle">{{  $taskByProject->title }}</td>
                                            <td class="align-middle text-center">{{  $taskByProject->tasks->count() }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12" class="align-middle text-center py-3">There is no data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small>Showing {{$tasksByProject->count()}} of {{ $tasksByProject->total() }} project(s).</small>
                        {!! $tasksByProject->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row g-3">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-primary shadow p-2 mb-1 fs-5"><i class="bi bi-inboxes text-primary"></i></span></p>
                    <h5 class="card-title">Total Projects</h5>
                    <h1>{{ $totalProjects }}</h1>
                    @if ($completionProjectsRate > 0)
                        <h6 class="text-secondary"><span class="text-success me-1"><i class="bi bi-caret-up-fill me-1"></i>{{ number_format($completionProjectsRate, 1) }}%</span>projects completed</h6>
                    @else
                        <h6 class="text-secondary"><span class="text-danger me-1"><i class="bi bi-caret-down-fill me-1"></i>{{ number_format($completionProjectsRate, 1) }}%</span>projects completed</h6>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-primary shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard-data text-primary"></i></span></p>
                    <h5 class="card-title">Total Tasks</h5>
                    <h1>{{ $totalTasks }}</h1>
                    @if ($completionTasksRate > 0)
                    <h6 class="text-secondary"><span class="text-success me-1"><i class="bi bi-caret-up-fill me-1"></i>{{ number_format($completionTasksRate, 1) }}%</span>tasks completed</h6>
                    @else
                        <h6 class="text-secondary"><span class="text-danger me-1"><i class="bi bi-caret-down-fill me-1"></i>{{ number_format($completionTasksRate, 1) }}%</span>tasks completed</h6>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-danger shadow p-2 mb-1 fs-5"><i class="bi bi-alarm text-danger"></i></span></p>
                    <h5 class="card-title">Tasks Due Today</h5>
                    <h1>{{ $tasksDueToday }}</h1>
                    <h6 class="text-secondary">{{ $overdueTasks }} task overdue</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-warning shadow p-2 mb-1 fs-5"><i class="bi bi-calendar2-week text-warning"></i></span></p>
                    <h5 class="card-title">Upcoming Tasks</h5>
                    <h1>{{ $upcomingTasks }}</h1>
                    <h6 class="text-secondary">tasks due in the next 7 days</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-secondary shadow p-2 mb-1 fs-5"><i class="bi bi-calendar2-week-fill text-secondary"></i></span></p>
                    <h5 class="card-title">Not Started Tasks</h5>
                    <h1>{{ $myTasksNotStarted }}</h1>
                    <h6 class="text-secondary">total not started tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-info shadow p-2 mb-1 fs-5"><i class="bi bi-hourglass-split text-info"></i></span></p>
                    <h5 class="card-title">In Progress Tasks</h5>
                    <h1>{{ $myTasksInProgress }}</h1>
                    <h6 class="text-secondary">total in progress tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-success shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard2-check text-success"></i></span></p>
                    <h5 class="card-title">Completed Tasks</h5>
                    <h1>{{ $myTasksCompleted }}</h1>
                    <h6 class="text-secondary">total completed tasks</h6>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card border border-opacity-10 rounded-4 bg-white p-2 h-100">
                <div class="card-body">
                    <p><span class="badge alert alert-warning shadow p-2 mb-1 fs-5"><i class="bi bi-clipboard-x text-warning"></i></span></p>
                    <h5 class="card-title">Pending Tasks</h5>
                    <h1>{{ $myTasksPending }}</h1>
                    <h6 class="text-secondary">total pending tasks</h6>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
