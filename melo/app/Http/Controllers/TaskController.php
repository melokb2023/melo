<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    /**
     * Display the task list based on role.
     */
   

    /**
     * Store a new task (Regular Users only).
     */


public function store(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string',
        'due_date' => 'nullable|date',
        'priority' => 'required|in:low,medium,high',
    ]);

    // Create the task linked to the logged-in user
    $task = Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'due_date' => $validated['due_date'],
        'priority' => $validated['priority'],
        'user_id' => auth()->id(),
        'is_completed' => false,
    ]);

    return response()->json($task);
}

public function toggle(Task $task) {
    $task->update(['is_completed' => !$task->is_completed]);
    return response()->json(['success' => true]);
}

public function destroy(Task $task)
{
    // RBAC: Only the owner OR an admin can delete
    if ($task->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $task->delete();

    return response()->json([
        'success' => true,
        'message' => 'Task deleted successfully'
    ]);
}


public function update(Request $request, Task $task)
{
    // RBAC logic: 
    // DENY access only if the user is NOT the owner AND is NOT an admin.
    if ($task->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $task->update([
        'title'       => $request->title,
        'description' => $request->description,
        'category'    => $request->category,
        'priority'    => $request->priority,
        'due_date'    => $request->due_date,
    ]);

    return response()->json($task);
}

 public function index2() {
   if (auth()->user()->role === 'admin') {
        // Admins see everything + the user who owns the task
        $tasks = Task::with('user')->get();
        return view('adminlist', compact('tasks'));
    }
 else{
    // Regular users only see their own tasks
    $tasks = Task::where('user_id', auth()->id())->get();
    return view('tasklist', compact('tasks'));
 }
    
   
}
    
}