@extends('layouts.app')

@section('content')
<style>
    /* --- COMBINED CSS --- */
    :root {
        --bg-color: #f8fafc;
        --card-bg: #ffffff;
        --text-color: #1e293b;
        --primary-color: #6366f1;
        --border-color: #e2e8f0;
        --success-color: #22c55e;
    }

    [data-theme="dark"] {
        --bg-color: #0f172a;
        --card-bg: #1e293b;
        --text-color: #f1f5f9;
        --border-color: #334155;
    }

    .app-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }

    .app-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .stats-bar {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        font-size: 0.9rem;
        color: var(--text-color);
    }

    .stat-count {
        font-weight: bold;
        color: var(--primary-color);
    }

    .task-input-container {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    input[type="text"] {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-color);
        color: var(--text-color);
        outline: none;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    .task-list {
        list-style: none;
        padding: 0;
    }

    .task-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        gap: 1rem;
    }

    .task-text.completed {
        text-decoration: line-through;
        opacity: 0.5;
    }

    .btn-icon {
        background: none;
        border: none;
        color: var(--text-color);
        cursor: pointer;
        font-size: 1.2rem;
    }
</style>

<div class="app-container">
    <header class="app-header">
        <h1>Melo Task List</h1>
        <button id="themeToggle" class="btn-icon">
            <i class="fas fa-moon"></i>
        </button>
    </header>

    <div class="stats-bar">
        <div class="stat-item">Total: <span id="totalTasks" class="stat-count">0</span></div>
        <div class="stat-item">Completed: <span id="completedTasks" class="stat-count">0</span></div>
    </div>

    <main class="app-main">
        <div class="task-input-container">
            <input type="text" id="taskInput" placeholder="What needs to be done?" autocomplete="off">
            <button id="addTaskBtn" class="btn-primary">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>

        <div class="task-options" style="margin-bottom: 1rem;">
            <select id="filterSelect" style="padding: 0.5rem; border-radius: 5px;">
                <option value="all">All Tasks</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
            </select>
        </div>

        <ul id="taskList" class="task-list">
            </ul>
    </main>
</div>

<script>
    window.meloData = {
        tasks: @json($tasks), // This pulls the tasks from your TaskController
        csrf: '{{ csrf_token() }}'
    };
</script>
@endsection