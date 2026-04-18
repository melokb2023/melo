<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'current_password' => ['required', 'current_password'], // Securely checks current password
            'password' => ['required', 'confirmed'],                // Ensures password matches confirmation
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),           // Hashes and saves the new password
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
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed'],
    ]);

    $request->user()->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('status', 'Password updated successfully!');
}
}
