<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $profile = User::findOrFail(Auth::user()->id);

        return view('profile.index', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $profile = User::findOrFail(Auth::user()->id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|min:11',
            'email' => 'required|email|unique:users,email,'.$profile->id,
            'status' => 'nullable|string|in:Active,Inactive'
        ]);

        try {
            $updateData = [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email']
            ];

            if (isset($data['status'])) {
                $updateData['status'] = $data['status'];
            }

            $profile->update($updateData);

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $profile = User::findOrFail(Auth::user()->id);

        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8|different:current_password',
        ]);

        try {
            if(!Hash::check($data['current_password'], $profile->password)) {
                return redirect()->back()->with('error', 'Current password not match our record.');

            }
            else {
                $profile->update([
                    'password' => Hash::make($data['password']),
                ]);

                return redirect()->back()->with('success', 'Password updated successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
