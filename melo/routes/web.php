<?php
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController; // Crucial: Import your Controller
use Illuminate\Support\Facades\Route;

// --- Welcome Page ---
Route::get('/', function () {
    return view('welcome');
});

// --- Registration Routes ---
// The "GET" route runs showRegister() to show the form
Route::get('/register', [AuthController::class, 'showRegister']); 

// The "POST" route runs register() to save the data
Route::post('/register', [AuthController::class, 'register']);

// --- Login Routes ---
// The "GET" route runs showLogin() to show the form
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// The "POST" route runs login() to verify the user
Route::post('/login', [AuthController::class, 'login']);

// --- Logout Route ---
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});