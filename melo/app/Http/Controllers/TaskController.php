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
        $request->validate([
            'title' => 'required|max:255',
            'priority' => 'required|in:low,medium,high',
        ]);

        Task::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'priority' => $request->priority,
            'is_completed' => false,
        ]);

        return redirect()->back()->with('success', 'Task added successfully!');
    }

    /**
     * Update task status (Complete/Incomplete).
     */
    public function toggle(Task $task)
    {
        // Security check: Only the owner can toggle their task
        if (Auth::id() !== $task->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return redirect()->back();
    }
}