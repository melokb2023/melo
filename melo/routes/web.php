<?php
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController; // Crucial: Import your Controller
use Illuminate\Support\Facades\Route;

// --- Welcome Page ---
Route::get('/', function () {
    return view('welcome');
});

// --- Auth Routes ---
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// --- Protected Routes ---
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index2']);
    Route::post('/tasks', [TaskController::class, 'store']);
    
    // ADD THIS LINE FOR THE UPDATE BUTTON TO WORK
    Route::put('/tasks/{task}', [TaskController::class, 'update']); 
    
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});