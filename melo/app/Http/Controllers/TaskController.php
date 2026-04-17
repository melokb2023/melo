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
    public function index()
    {
        $user = Auth::user();

        // Check the role defined in your melo_db users table
        if ($user->role === 'admin') {
            // Admin: Fetch ALL tasks from ALL users
            // We use with('user') to get the owner's name without slowing down the DB
            $tasks = Task::with('user')->latest()->get();
            return view('adminlist', compact('tasks'));
        }
        

        // Regular User: Fetch only their own tasks
        $tasks = Task::where('user_id', $user->id)->latest()->get();
        return view('tasklist', compact('tasks'));
    }

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

public function destroy(Task $task) {
    $task->delete();
    return response()->json(['success' => true]);
}

public function update(Request $request, \App\Models\Task $task)
{
    // Ensure the user owns this task
    if ($task->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $task->update([
        'title'       => $request->title,
        'description' => $request->description,
        'category'    => $request->category,
        'priority'    => $request->priority,
        'due_date'    => $request->due_date,
    ]);

    // Return the updated task so the JS can update the list without refreshing
    return response()->json($task);
}
  public function index2() {
    if (auth()->user()->role === 'admin') {
        // We use 'with(user)' to prevent the app from slowing down
        $tasks = Task::with('user')->latest()->get();
        return view('adminlist', compact('tasks')); // Ensure this matches your filename
    } else {
        $tasks = Task::where('user_id', auth()->id())->latest()->get();
        return view('tasklist', compact('tasks'));
    }
}
    
}