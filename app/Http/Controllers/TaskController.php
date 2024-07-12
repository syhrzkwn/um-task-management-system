<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $projectId)
    {
        $project = Project::findOrFail($projectId);

        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $notStartedTasks = Task::where('project_id', $projectId)->where('status', 'Not Started')->get();
            $inProgressTasks = Task::where('project_id', $projectId)->where('status', 'In Progress')->get();
            $pendingTasks = Task::where('project_id', $projectId)->where('status', 'Pending')->get();
            $completedTasks = Task::where('project_id', $projectId)->where('status', 'Completed')->get();
        } else {
            $notStartedTasks = Task::where('project_id', $projectId)
                ->where('status', 'Not Started')
                ->whereHas('project', function ($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function ($query) {
                            $query->where('user_id', Auth::id());
                        });
                })->get();
            $inProgressTasks = Task::where('project_id', $projectId)->where('status', 'In Progress')
                ->whereHas('project', function($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function($query) {
                            $query->where('user_id', Auth::id());
                        });
                })->get();
            $pendingTasks = Task::where('project_id', $projectId)->where('status', 'Pending')
                ->whereHas('project', function($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function($query) {
                            $query->where('user_id', Auth::id());
                        });
                })->get();
            $completedTasks = Task::where('project_id', $projectId)->where('status', 'Completed')
                ->whereHas('project', function($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function($query) {
                            $query->where('user_id', Auth::id());
                        });
                })->get();
        }

        return view('task.index', compact('notStartedTasks', 'inProgressTasks', 'pendingTasks', 'completedTasks', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $projectId)
    {
        // Find the project that belongs to the authenticated user
        $project = Project::findOrFail($projectId);

        // Get staff members associated with the project
        $staffs = $project->users()->where('user_type', User::TYPE_STAFF)->get();

        // Current date
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('task.create', compact('staffs', 'project', 'currentDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $projectId)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id',
        ], [
            'end_date.after_or_equal' => 'The end date must be the same as or after the start date.',
        ]);

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'project_id' => $projectId,
        ]);

        // Attach the staff members to the task
        if (isset($data['user_id'])) {
            $task->users()->attach($data['user_id']);
        }

        return redirect()->route('task.index', $projectId)->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $projectId, string $taskId)
    {
        $project = Project::findOrFail($projectId);

        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $task = Task::findOrFail($taskId);
        } else {
            // Check if the user is assigned to the project
            $task = Task::where('id', $taskId)
                ->whereHas('project', function($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function($query) {
                            $query->where('user_id', Auth::id());
                        });
                })
                ->firstOrFail();
        }

        return view('task.show', compact('task', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $projectId, string $taskId)
    {
        $project = Project::findOrFail($projectId);

        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $task = Task::findOrFail($taskId);
            $staffs = $project->users()->where('user_type', User::TYPE_STAFF)->get();
            $selectedStaffIds = $task->users->pluck('id')->toArray();

            return view('task.edit', compact('task', 'project', 'staffs', 'selectedStaffIds'));
        } else {
            $task = Task::where('id', $taskId)
                ->whereHas('project', function($query) use ($projectId) {
                    $query->where('id', $projectId)
                        ->whereHas('users', function($query) {
                            $query->where('user_id', Auth::id());
                        });
                })
                ->firstOrFail();

            return view('task.edit', compact('task', 'project'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $projectId, string $taskId)
    {
        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $task = Task::findOrFail($taskId);

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date|date_format:Y-m-d',
                'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
                'user_id' => 'nullable|array',
                'user_id.*' => 'exists:users,id',
                'status' => 'required|string|in:Not Started,In Progress,Pending,Completed',
            ], [
                'end_date.after_or_equal' => 'The end date must be the same as or after the start date.',
            ]);

            $task->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status'],
                'project_id' => $projectId,
            ]);

            // Sync the staff members to the task
            if (isset($data['user_id'])) {
                $task->users()->sync($data['user_id']);
            } else {
                $task->users()->detach();
            }

            return redirect()->route('task.index', $projectId)->with('success', 'Task updated successfully.');
        } else {
            $task = Task::where('id', $taskId)
                ->whereHas('users', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->firstOrFail();

            $data = $request->validate([
                'status' => 'required|string|in:Not Started,In Progress,Pending,Completed',
            ]);

            $task->update([
                'status' => $data['status'],
            ]);

            return redirect()->route('task.index', $projectId)->with('success', 'Task status updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $projectId, string $taskId)
    {
        $project = Project::findOrFail($projectId);
        $task = Task::findOrFail($taskId);

        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $task->delete();
            return redirect()->back()->with('success', 'Task deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    /**
     * Search the resource from storage.
     */
    // public function searchTask(Request $request, string $projectId)
    // {
    //     $project = Project::findOrFail($projectId);
    //     $query = $request->input('query');

    //     // Initialize the query builder for Task model
    //     $tasksQuery = Task::with(['users']);

    //     // Restrict search to the current user's tasks if the user is not an admin
    //     if (Auth::user()->user_type == User::TYPE_STAFF) {
    //         $tasksQuery->whereHas('users', function ($query) {
    //             $query->where('user_id', Auth::id());
    //         });
    //     }

    //     // Apply the search conditions
    //     $tasks = $tasksQuery->where(function($queryBuilder) use ($query) {
    //         $queryBuilder->where('title', 'LIKE', "%{$query}%")
    //             ->orWhere('description', 'LIKE', "%{$query}%")
    //             ->orWhere('status', 'LIKE', "%{$query}%")
    //             ->orWhere('start_date', 'LIKE', "%{$query}%")
    //             ->orWhere('end_date', 'LIKE', "%{$query}%")
    //             ->orWhereHas('users', function($userQuery) use ($query) {
    //                 $userQuery->where('name', 'LIKE', "%{$query}%");
    //             });
    //     })->paginate(10);

    //     // Return the view with the paginated results
    //     return view('task.index', compact('tasks', 'project'));
    // }
}
