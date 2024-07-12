<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->user_type == User::TYPE_ADMIN) {
            $totalProjects = Project::count();
            $completedProjects = Project::where('status', 'Completed')->count();
            $completionProjectsRate = $totalProjects > 0 ? ($completedProjects / $totalProjects) * 100 : 0;

            $totalTasks = Task::count();
            $completedTasks = Task::where('status', 'Completed')->count();
            $completionTasksRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            $tasksDueToday = Task::whereDate('end_date', Carbon::today())->count();
            $overdueTasks = Task::where('end_date', '<', Carbon::today())->where('status', '!=', 'Completed')->count();
            $upcomingTasks = Task::whereBetween('end_date', [Carbon::today(), Carbon::today()->addWeek()])->count();

            $tasksByStaff = User::withCount('tasks')->where('user_type', User::TYPE_STAFF)->paginate(5);
            $tasksByProject = Project::withCount('tasks')->paginate(5);

            $countNotStarted = Task::where('status', 'Not Started')->count();
            $countInProgress = Task::where('status', 'In Progress')->count();
            $countCompleted = Task::where('status', 'Completed')->count();
            $countPending = Task::where('status', 'Pending')->count();

            return view('dashboard', compact([
                'totalProjects',
                'completedProjects',
                'completionProjectsRate',

                'totalTasks',
                'completedTasks',
                'completionTasksRate',

                'tasksDueToday',
                'overdueTasks',
                'upcomingTasks',

                'tasksByStaff',
                'tasksByProject',

                'countNotStarted',
                'countInProgress',
                'countCompleted',
                'countPending',
            ]));
        } else {
            $userProjects = $user->projects()->pluck('projects.id');
            $userTasks = $user->tasks()->pluck('tasks.id');

            $totalProjects = Project::whereIn('id', $userProjects)->count();
            $completedProjects = Project::whereIn('id', $userProjects)->where('status', 'Completed')->count();
            $completionProjectsRate = $totalProjects > 0 ? ($completedProjects / $totalProjects) * 100 : 0;

            $totalTasks = Task::whereIn('id', $userTasks)->count();
            $completedTasks = Task::whereIn('id', $userTasks)->where('status', 'Completed')->count();
            $completionTasksRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            $tasksDueToday = Task::whereIn('id', $userTasks)->whereDate('end_date', Carbon::today())->count();
            $overdueTasks = Task::whereIn('id', $userTasks)->where('end_date', '<', Carbon::today())->where('status', '!=', 'Completed')->count();
            $upcomingTasks = Task::whereIn('id', $userTasks)->whereBetween('end_date', [Carbon::today(), Carbon::today()->addWeek()])->count();

            $myTasksNotStarted = $user->tasks()->where('status', 'Not Started')->count();
            $myTasksInProgress = $user->tasks()->where('status', 'In Progress')->count();
            $myTasksCompleted = $user->tasks()->where('status', 'Completed')->count();
            $myTasksPending = $user->tasks()->where('status', 'Pending')->count();

            return view('dashboard', compact([
                'totalProjects',
                'completedProjects',
                'completionProjectsRate',

                'totalTasks',
                'completedTasks',
                'completionTasksRate',

                'tasksDueToday',
                'overdueTasks',
                'upcomingTasks',

                'myTasksNotStarted',
                'myTasksInProgress',
                'myTasksCompleted',
                'myTasksPending',
            ]));
        }
    }
}
