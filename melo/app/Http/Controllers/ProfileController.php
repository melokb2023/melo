<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Display the edit form
    public function edit()
    {
        return view('adminprofile');
    }

    // Handle the update request
   public function update(Request $request)
{
    // 1. Validate the incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
    ]);

    // 2. Perform the update directly
    // This method handles everything: assigning the values and persisting to the DB
    auth()->user()->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // 3. Redirect back with a success status
    return back()->with('status', 'Profile updated successfully!');
}
public function edit2() 
    { 
        return view('userprofile'); 
    }

    public function update2(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('status', 'Profile updated successfully!');
    }
  public function editPassword() 
    { 
        return view('adminchangepassword'); 
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
        // 1. Validates that current_password matches the actual database record
        'current_password' => ['required', 'current_password'], 
        
        // 2. 'different:current_password' forces the new password to be unique
        // 3. 'Password::min(8)' ensures security
        'password' => [
            'required', 
            'confirmed', 
            Password::min(8), 
            'different:current_password'
        ],
    ], [
        // Custom error message for the unique constraint
        'password.different' => 'Your new password cannot be the same as your current password.',
    ]);

    // Update the authenticated user
    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

        return back()->with('status', 'Password updated successfully!');
    }
public function editPassword2() 
{ 
    return view('userchangepassword'); 
}

public function updatePassword2(Request $request)
{
    $request->validate([
        // 1. Validates that current_password matches the actual database record
        'current_password' => ['required', 'current_password'], 
        
        // 2. 'different:current_password' forces the new password to be unique
        // 3. 'Password::min(8)' ensures security
        'password' => [
            'required', 
            'confirmed', 
            Password::min(8), 
            'different:current_password'
        ],
    ], [
        // Custom error message for the unique constraint
        'password.different' => 'Your new password cannot be the same as your current password.',
    ]);

    // Update the authenticated user
    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('status', 'Your password has been updated successfully!');
}

public function showForgotPassword() 
{
    // Make sure 'forgotpassword' matches the name of your .blade.php file
    return view('forgotpassword');
}
public function updatePasswordDirect(Request $request)
    {
        // 1. Validate: Email must exist, password must be confirmed
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'email.exists' => 'No account found with this email.',
        ]);

        // 2. Find and Update
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // 3. Success
        return redirect('/login')->with('status', 'Your password has been updated successfully.');
    }
}
