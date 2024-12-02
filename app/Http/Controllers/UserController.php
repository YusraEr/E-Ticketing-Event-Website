<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function create()
    {
        try {
            return view('user.create');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load user creation form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|in:user,admin,organizer',
                'password' => 'required|min:8|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('home')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $user)
    {
        try {
            return view('user.edit', compact('user'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load user edit form.');
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|in:user,admin,organizer',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'current_password' => 'nullable|required_with:new_password',
                'new_password' => 'nullable|min:8|confirmed',
            ]);

            // Update basic information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::delete('public/' . $user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Handle password change
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->with('error', 'The current password is incorrect.');
                }

                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return redirect()->route('home')->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {

            return back()->with('error', 'Failed to update profile: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully!'
                ]);
            }
            return back()->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete user: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}


