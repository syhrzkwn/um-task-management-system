<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
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
        $staffs = User::where('user_type', User::TYPE_STAFF)
            ->paginate(10);

        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $staff = User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => User::TYPE_STAFF
            ]);
            $staff->assignRole(User::TYPE_STAFF);

            return redirect()->route('staff.index')->with('success', 'Staff registered successfully.');
        }
        catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = User::where('user_type', User::TYPE_STAFF)
            ->where('id', $id)
            ->firstOrFail();

        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff = User::where('user_type', User::TYPE_STAFF)
            ->where('id', $id)
            ->firstOrFail();

        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = User::where('user_type', User::TYPE_STAFF)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
            'email' => 'required|email|unique:users,email,'.$staff->id,
            'status' => 'required|string|in:Active,Inactive'
        ]);

        try {
            $staff->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'status' => $data['status'],
            ]);

            return redirect()->back()->with('success', 'Staff updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource password.
     */
    public function updatePassword(Request $request, string $id)
    {
        $staff = User::where('user_type', User::TYPE_STAFF)
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        try {
            $staff->update([
                'password' => Hash::make($data['password']),
            ]);

            return redirect()->back()->with('success', 'Staff password updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = User::where('user_type', User::TYPE_STAFF)
            ->where('id', $id)
            ->firstOrFail();

        try {
            $staff->delete();

            return redirect()->back()->with('success', 'Staff deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. ' .$e->getMessage());
        }
    }

    /**
     * Search the resource from storage.
     */
    public function searchStaff(Request $request) {
        $query = $request->input('query');

        $staffs = User::where('user_type', User::TYPE_STAFF)
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'LIKE', "%{$query}%")
                             ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->paginate(10);

        return view('staff.index', compact('staffs'));
    }
}
