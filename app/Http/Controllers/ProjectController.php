<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $projects = Project::with('users')->paginate(10);
        } else {
            $projects = Auth::user()->projects()->with('users')->paginate(10);
        }

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staffs = User::where('user_type', User::TYPE_STAFF)->get();

        return view('project.create', compact('staffs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id',
        ]);

        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        if (isset($data['user_id'])) {
            $project->users()->attach($data['user_id']);
        }

        return redirect()->route('project.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $project = Project::findOrFail($id);
        } else {
            $project = Project::where('id', $id)
                ->whereHas('users', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->firstOrFail();
        }

        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::user()->user_type != User::TYPE_ADMIN && !$project->users->contains(Auth::user())) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $staffs = User::where('user_type', User::TYPE_STAFF)->get();
        $selectedStaffIds = $project->users->pluck('id')->toArray();

        return view('project.edit', compact('project', 'staffs', 'selectedStaffIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::user()->user_type != User::TYPE_ADMIN && !$project->users->contains(Auth::user())) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Not Started,In Progress,Pending,Completed',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id',
        ]);

        $project->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);

        if (isset($data['user_id'])) {
            $project->users()->sync($data['user_id']);
        } else {
            $project->users()->detach();
        }

        return redirect()->route('project.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if (Auth::user()->user_type != User::TYPE_ADMIN && !$project->users->contains(Auth::user())) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $project->delete();

        return redirect()->route('project.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Search the resource from storage.
     */
    public function searchProject(Request $request)
    {
        $query = $request->input('query');

        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $projects = Project::where('title', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->orWhere('status', 'LIKE', "%$query%")
                ->with('users')
                ->paginate(10);
        } else {
            $projects = Auth::user()->projects()
                ->where('title', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->orWhere('status', 'LIKE', "%$query%")
                ->with('users')
                ->paginate(10);
        }

        return view('project.index', compact('projects'))->with('query', $query);
    }
}
