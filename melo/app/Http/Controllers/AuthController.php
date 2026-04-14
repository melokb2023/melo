<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Show the forms
    public function showRegister() { return view('register'); }
    public function showLogin() { return view('login'); }

    // 2. Handle Manual Registration with Bcrypt
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // This line fulfills your "Manual Password Hashing" requirement
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // This is Bcrypt
            'role' => 'user', // Default role for new sign-ups
        ]);

        return redirect('/login')->with('success', 'Account created! Please login.');
    }

    // 3. Handle Secure Login & Session Management
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Success! Regenerate session to prevent "Session Fixation" attacks
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // 4. Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}