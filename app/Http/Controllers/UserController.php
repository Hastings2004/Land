<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user's own profile edit form
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    /**
     * Update user's own profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . $user->id,
            'phone_number' => 'required|numeric',
        ]);

        $user->update($validated);
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id != $id) {
            abort(403, 'Unauthorized action.');
        }
        $editUser = User::findOrFail($id);
        return view('users.edit', compact('editUser'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id != $id) {
            abort(403, 'Unauthorized action.');
        }
        $editUser = User::findOrFail($id);
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'phone_number' => 'required|numeric',
        ]);
        $editUser->update($validated);
        return redirect()->route('user.edit', $editUser->id)->with('success', 'User details updated successfully.');
    }

        public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Password changed successfully.');
    }
}
