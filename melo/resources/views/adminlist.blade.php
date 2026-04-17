<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Melo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --danger-color: #ef4444;
            --text-color: #1e293b;
            --text-light: #64748b;
            --bg-color: #ffffff;
            --bg-secondary: #f8fafc;
            --border-color: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-color: #0f172a;
            --bg-secondary: #1e293b;
            --text-color: #f1f5f9;
            --text-light: #94a3b8;
            --border-color: #334155;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        body {
            background-color: var(--bg-secondary);
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            margin: 0;
            transition: all 0.3s ease;
        }

        .app-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 { font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-item {
            background: var(--bg-color);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .stat-count { display: block; font-size: 2rem; font-weight: 800; color: var(--primary-color); }
        .stat-label { color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; font-weight: 600; }

        .search-container {
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: var(--shadow);
        }

        .search-container input {
            border: none;
            background: transparent;
            color: var(--text-color);
            flex: 1;
            padding: 10px;
            outline: none;
            font-size: 1rem;
        }

        .task-list-container {
            background: var(--bg-color);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .task-item {
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.2s;
        }

        .task-item:hover { background: var(--bg-secondary); }

        .owner-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            margin-right: 12px;
        }

        .task-text { font-weight: 500; }

        .priority-tag {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .high { background: #fee2e2; color: #ef4444; }
        .medium { background: #fef3c7; color: #f59e0b; }
        .low { background: #dcfce7; color: #22c55e; }

        .btn-logout {
            background-color: var(--danger-color);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-logout:hover { opacity: 0.9; }

        .theme-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="app-container">
    <header class="app-header">
        <div class="header-content">
            <h1>Melo<span style="color:var(--primary-color)">.</span> Admin</h1>
            <div style="display: flex; gap: 12px; align-items: center;">
                <button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button>
                <form action="/logout" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-count">{{ $tasks->count() }}</span>
                <span class="stat-label">Global Tasks</span>
            </div>
            <div class="stat-item">
                <span class="stat-count">{{ $tasks->where('is_completed', true)->count() }}</span>
                <span class="stat-label">Total Completed</span>
            </div>
        </div>
    </header>

    <main class="app-main">
        <div class="search-container">
            <i class="fas fa-search" style="color: var(--text-light)"></i>
            <input type="text" id="adminSearch" placeholder="Search tasks or usernames...">
        </div>

        <div class="task-list-container">
            <ul id="taskList" class="task-list" style="list-style: none; padding: 0; margin: 0;">
                @foreach($tasks as $task)
                <li class="task-item">
                    <div class="task-info">
                        <span class="owner-badge"><i class="fas fa-user"></i> {{ $task->user->name }}</span>
                        <span class="task-text">{{ $task->title }}</span>
                    </div>

                    <div class="task-meta" style="display: flex; align-items: center; gap: 15px;">
                        <span class="priority-tag {{ $task->priority }}">
                            {{ $task->priority }}
                        </span>
                        @if($task->is_completed)
                            <i class="fas fa-check-circle" style="color: #22c55e;" title="Completed"></i>
                        @else
                            <i class="fas fa-clock" style="color: #f59e0b;" title="Pending"></i>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </main>
</div>

<script>
    // 1. Theme Toggle Logic
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    themeToggle.addEventListener('click', () => {
        const isDark = body.getAttribute('data-theme') === 'dark';
        body.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeToggle.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });

    // 2. Real-time Search Filter
    const searchInput = document.getElementById('adminSearch');
    const taskItems = document.querySelectorAll('.task-item');

    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        
        taskItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? 'flex' : 'none';
        });
    });
</script>

</body>
</html>