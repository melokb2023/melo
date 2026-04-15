<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Melo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reuse your existing Task List CSS here */
        /* ... (Keep all the styles you have for .app-container, .task-list, etc.) ... */

        /* Add this specific style for the Admin "Owner" Badge */
        .owner-badge {
            font-size: 0.75rem;
            background: #6366f1;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            margin-right: 10px;
            font-weight: 600;
        }

        .user-tag {
            color: #64748b;
            font-size: 0.85rem;
            font-style: italic;
        }
        :root {
    --primary-color: #4a6fa5;
    --primary-hover: #3a5a8f;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
    --text-color: #212529;
    --text-light: #6c757d;
    --bg-color: #ffffff;
    --bg-secondary: #f8f9fa;
    --border-color: #dee2e6;
    --shadow-color: rgba(0, 0, 0, 0.1);
    --transition-speed: 0.3s;
}

[data-theme="dark"] {
    --primary-color: #5d8acd;
    --primary-hover: #4a7bc1;
    --secondary-color: #6c757d;
    --text-color: #f8f9fa;
    --text-light: #adb5bd;
    --bg-color: #212529;
    --bg-secondary: #343a40;
    --border-color: #495057;
    --shadow-color: rgba(0, 0, 0, 0.3);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: var(--bg-secondary);
    color: var(--text-color);
    transition: background-color var(--transition-speed) ease;
}

.app-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.app-header {
    margin-bottom: 30px;
    animation: fadeIn 0.5s ease;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

h1 {
    font-size: 2.5rem;
    color: var(--primary-color);
    font-weight: 700;
}

.stats-bar {
    display: flex;
    justify-content: space-around;
    background-color: var(--bg-color);
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 10px var(--shadow-color);
    margin-top: 15px;
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-count {
    display: block;
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--primary-color);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-light);
}

.app-main {
    flex: 1;
}

.controls-section {
    margin-bottom: 25px;
}

.task-input-container {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.task-input-container input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    background-color: var(--bg-color);
    color: var(--text-color);
    transition: border-color var(--transition-speed) ease;
}

.task-input-container input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    transition: background-color var(--transition-speed) ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background-color var(--transition-speed) ease;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-icon {
    background-color: transparent;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    font-size: 1rem;
    padding: 5px;
    transition: color var(--transition-speed) ease;
}

.btn-icon:hover {
    color: var(--primary-color);
}

.task-options {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.task-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.filter-select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background-color: var(--bg-color);
    color: var(--text-color);
    font-size: 0.9rem;
    cursor: pointer;
    transition: border-color var(--transition-speed) ease;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
}

.search-container {
    display: flex;
    align-items: center;
    background-color: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    padding: 5px 10px;
    transition: border-color var(--transition-speed) ease;
}

.search-container:focus-within {
    border-color: var(--primary-color);
}

.search-container input {
    border: none;
    padding: 8px;
    font-size: 0.9rem;
    background-color: transparent;
    color: var(--text-color);
    width: 150px;
}

.search-container input:focus {
    outline: none;
}

.task-list-container {
    background-color: var(--bg-color);
    border-radius: 8px;
    box-shadow: 0 2px 10px var(--shadow-color);
    overflow: hidden;
}

.task-list {
    list-style: none;
}

.task-item {
    padding: 15px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 15px;
    transition: transform 0.2s ease, background-color var(--transition-speed) ease;
    cursor: grab;
}

.task-item:last-child {
    border-bottom: none;
}

.task-item:hover {
    background-color: var(--bg-secondary);
}

.task-item.dragging {
    opacity: 0.5;
    background-color: rgba(74, 111, 165, 0.1);
}

.task-checkbox {
    min-width: 20px;
    min-height: 20px;
    cursor: pointer;
    accent-color: var(--primary-color);
}

.task-text {
    flex: 1;
    font-size: 1rem;
    word-break: break-word;
}

.task-text.completed {
    text-decoration: line-through;
    color: var(--text-light);
}

.task-priority {
    font-size: 0.8rem;
    padding: 3px 8px;
    border-radius: 12px;
    font-weight: 600;
    text-transform: uppercase;
    margin-right: 10px;
}

.priority-high {
    background-color: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

.priority-medium {
    background-color: rgba(255, 193, 7, 0.1);
    color: var(--warning-color);
}

.priority-low {
    background-color: rgba(23, 162, 184, 0.1);
    color: var(--info-color);
}

.task-due-date {
    font-size: 0.8rem;
    color: var(--text-light);
    margin-right: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.task-due-date.overdue {
    color: var(--danger-color);
    font-weight: 600;
}

.task-category {
    font-size: 0.8rem;
    padding: 3px 8px;
    border-radius: 12px;
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
    margin-right: 10px;
}

.task-actions {
    display: flex;
    gap: 10px;
}

.task-details-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background-color: var(--bg-color);
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    position: relative;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-light);
    transition: color var(--transition-speed) ease;
}

.close-modal:hover {
    color: var(--danger-color);
}

.modal-body {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-color);
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 1rem;
    background-color: var(--bg-color);
    color: var(--text-color);
    transition: border-color var(--transition-speed) ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.2);
}

.category-input-container {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

.category-input-container input {
    flex: 1;
}

.category-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.category-tag {
    background-color: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.category-tag button {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    font-size: 0.7rem;
    padding: 0;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-light);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 20px;
    color: var(--border-color);
}

.empty-state p {
    font-size: 1.1rem;
    margin-bottom: 15px;
}

.theme-toggle button {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: var(--text-color);
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color var(--transition-speed) ease;
}

.theme-toggle button:hover {
    background-color: var(--bg-secondary);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@media (max-width: 768px) {
    .app-container {
        padding: 15px;
    }
    
    .task-options {
        flex-direction: column;
    }
    
    .task-filters {
        flex-direction: column;
    }
    
    .search-container {
        width: 100%;
    }
    
    .search-container input {
        width: 100%;
    }
    
    .task-item {
        flex-wrap: wrap;
    }
    
    .task-actions {
        margin-left: auto;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 2rem;
    }
    
    .modal-content {
        width: 95%;
        padding: 15px;
    }
    
    .modal-actions {
        flex-direction: column;
    }
    
    .modal-actions button {
        width: 100%;
    }
}
    </style>
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <h1>Admin: All User Tasks</h1>
                <div class="theme-toggle">
                    <button id="themeToggle"><i class="fas fa-moon"></i></button>
                </div>
            </div>
            
            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-count">{{ $tasks->count() }}</span>
                    <span class="stat-label">Global Total</span>
                </div>
                <div class="stat-item">
                    <span class="stat-count">{{ $tasks->where('is_completed', true)->count() }}</span>
                    <span class="stat-label">Completed</span>
                </div>
            </div>
        </header>

        <main class="app-main">
            <div class="controls-section">
                <div class="search-container" style="width: 100%;">
                    <input type="text" id="searchInput" placeholder="Search by task or username..." autocomplete="off">
                    <button id="searchBtn" class="btn-icon">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="task-list-container">
                <ul id="taskList" class="task-list">
                    @foreach($tasks as $task)
                    <li class="task-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; border-bottom: 1px solid #e2e8f0;">
                        <div class="task-content">
                            <span class="owner-badge">User: {{ $task->user->name }}</span>
                            <span class="task-text">{{ $task->title }}</span>
                        </div>

                        <div class="task-actions">
                            <span class="priority-tag {{ $task->priority }}" style="margin-right: 10px;">
                                {{ ucfirst($task->priority) }}
                            </span>
                            @if($task->is_completed)
                                <i class="fas fa-check-circle" style="color: #22c55e;"></i>
                            @else
                                <i class="fas fa-clock" style="color: #f59e0b;"></i>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>