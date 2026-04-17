<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Required for login()
use Illuminate\Support\Facades\Hash; // <-- Required for Hash::make()

class AuthController extends Controller
{
    // Show Register Form
    public function showRegister()
    {
        // Check if an admin exists to decide whether to show the role dropdown
        $adminExists = User::where('role', 'admin')->exists();
        return view('register', compact('adminExists'));
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Logic: Check if admin exists
        $adminExists = User::where('role', 'admin')->exists();

        // If admin exists, force role to 'user'. 
        // If no admin exists, allow them to be 'admin' if they chose it.
        $role = $adminExists ? 'user' : $request->input('role', 'user');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        // This is the method that was "Undefined"
        Auth::login($user); 

        return redirect('/tasks');
    }

    // Show Login Form
    public function showLogin()
    {
        return view('login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/tasks');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle Logout
   public function logout(Request $request)
{
    // 1. Log the user out of the application
    Auth::logout();
    // 2. Clear all session data (security best practice)
    $request->session()->invalidate();
    // 3. Prevent CSRF token fixation attacks
    $request->session()->regenerateToken();
    // 4. Redirect to the login page with a success message
    return redirect()->route('login')->with('status', 'You have been logged out.');
}
}