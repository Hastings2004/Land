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
        $user = Auth::user();
        if ($user->role == 'admin') {
            $users = User::all();
            return view('admin.users.index', compact('users'));
        }

        if ($user->role == 'customer') {
            return view('components.profile', compact('user'));
        }

        abort(403, 'Unauthorized action.');
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

    public function changePassword(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id != $id) {
            abort(403, 'Unauthorized action.');
        }
        
        $editUser = User::findOrFail($id);
        
        // Admins don't need to provide the current password
        if ($user->role === 'admin') {
            $validated = $request->validate([
                'password' => 'required|string|min:4|confirmed',
            ]);
        } else {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:4|confirmed',
            ]);

            if (!Hash::check($validated['current_password'], $editUser->password)) {
                return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
            }
        }
        
        $editUser->password = Hash::make($validated['password']);
        $editUser->save();
        
        return redirect()->route('user.edit', $editUser->id)->with('success', 'Password changed successfully.');
    }
}
