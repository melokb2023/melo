<?php
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController; // Crucial: Import your Controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Welcome Page ---
Route::get('/', function () {
    return redirect()->route('login');
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
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

Route::middleware(['auth'])->group(function () {
    
    // GET: The Edit Page
    Route::get('/profile', [ProfileController::class, 'edit'])->name('adminprofile.edit');
    
    // POST: The Update Action
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('adminprofile.update');
    // Standard User routes (edit2/update2)
    Route::get('/user/profile', [ProfileController::class, 'edit2'])->name('userprofile.edit');
    Route::post('/user/profile/update', [ProfileController::class, 'update2'])->name('userprofile.update');
});

Route::middleware(['auth'])->group(function () {
    // Admin password management
    Route::get('/settings/security', [ProfileController::class, 'editPassword'])->name('admin.password.edit');
    Route::put('/settings/security', [ProfileController::class, 'updatePassword'])->name('admin.password.update');
});

Route::middleware(['auth'])->group(function () {
    // User password management
    Route::get('/user/settings/security', [ProfileController::class, 'editPassword2'])->name('user.password.edit');
    Route::put('/user/settings/security', [ProfileController::class, 'updatePassword2'])->name('user.password.update');
});
