<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        try {
            $user = Auth::user();
            
            $validated = $request->validate([
                'username' => 'required|string|max:50',
                'email' => 'required|email|max:50|unique:users,email,' . $user->id,
                'phone_number' => 'required|string|max:20',
            ]);

            // Clean phone number (remove spaces, +, and formatting)
            $validated['phone_number'] = preg_replace('/[\s\+]/', '', $validated['phone_number']);
            
            // Ensure it's a valid Malawian phone number
            if (!preg_match('/^(265|0)\d{8,9}$/', $validated['phone_number'])) {
                return back()->withErrors(['phone_number' => 'Please enter a valid Malawian phone number.']);
            }

            // Log the update attempt
            Log::info('Profile update attempt', [
                'user_id' => $user->id,
                'username' => $user->username,
                'new_data' => $validated
            ]);

            // Update the user
            $updated = $user->update($validated);
            
            // Refresh the user from database to confirm changes
            $user->refresh();
            
            // Log the result
            Log::info('Profile update result', [
                'user_id' => $user->id,
                'updated' => $updated,
                'current_data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number
                ]
            ]);
            
            if ($updated) {
                return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
            } else {
                return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
            }
            
        } catch (\Exception $e) {
            Log::error('Profile update error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An error occurred while updating your profile: ' . $e->getMessage()]);
        }
    }

    /**
     * Change user's password
     */
    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
            }

            // Log the password change attempt
            Log::info('Password change attempt', [
                'user_id' => $user->id,
                'username' => $user->username
            ]);

            $user->password = Hash::make($validated['password']);
            $saved = $user->save();
            
            // Log the result
            Log::info('Password change result', [
                'user_id' => $user->id,
                'saved' => $saved
            ]);
            
            if ($saved) {
                return redirect()->route('profile.edit')->with('success', 'Password changed successfully!');
            } else {
                return back()->withErrors(['error' => 'Failed to change password. Please try again.']);
            }
            
        } catch (\Exception $e) {
            Log::error('Password change error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'An error occurred while changing your password: ' . $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $editUser = User::findOrFail($id);
        
        // Only allow editing admin users
        if ($editUser->role !== 'admin') {
            abort(403, 'You can only edit admin users.');
        }
        
        return view('users.edit', compact('editUser'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $editUser = User::findOrFail($id);
        
        // Only allow updating admin users
        if ($editUser->role !== 'admin') {
            abort(403, 'You can only update admin users.');
        }
        
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'phone_number' => 'required|string|max:15',
        ]);
        $editUser->update($validated);
        return redirect()->route('admin.users.edit', $editUser->id)->with('success', 'User details updated successfully.');
    }


}
