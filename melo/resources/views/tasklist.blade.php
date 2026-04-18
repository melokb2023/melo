<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melo | My Tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f8fafc; --card-bg: #ffffff; --text-color: #1e293b;
            --text-light: #64748b; --primary-color: #6366f1; --border-color: #e2e8f0;
            --accent-bg: #f1f5f9; --danger-color: #ef4444;
        }
        [data-theme="dark"] {
            --bg-color: #0f172a; --card-bg: #1e293b; --text-color: #f1f5f9;
            --text-light: #94a3b8; --border-color: #334155; --accent-bg: #0f172a;
        }
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', system-ui, sans-serif; margin: 0; transition: all 0.3s ease; }
        .app-container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .header-content { display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; margin-bottom: 2rem; }
        .user-menu-container { position: relative; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 25px; border: 1px solid var(--border-color); background: var(--card-bg); }
        .avatar-placeholder { width: 32px; height: 32px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; }
        .dropdown-menu { position: absolute; right: 0; top: 50px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); width: 220px; display: none; z-index: 1000; }
        .dropdown-menu a { display: block; padding: 12px 15px; text-decoration: none; color: var(--text-color); font-size: 0.9rem; }
        .dropdown-menu a:hover { background: var(--accent-bg); }
        .stats-bar { display: flex; gap: 24px; margin-bottom: 2rem; padding: 1rem; background: var(--accent-bg); border-radius: 12px; }
        .stat-val { font-weight: 700; color: var(--primary-color); }
        .task-creator-card { background: var(--card-bg); padding: 1.5rem; border-radius: 16px; border: 2px solid var(--border-color); margin-bottom: 2.5rem; }
        input, select, textarea { width: 100%; padding: 0.8rem; margin: 5px 0; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-color); color: var(--text-color); }
        .btn-primary { background: var(--primary-color); color: white; border: none; padding: 1rem; border-radius: 10px; cursor: pointer; width: 100%; margin-top: 1rem; }
        .task-item { background: var(--card-bg); margin-bottom: 12px; padding: 1.25rem; border-radius: 14px; border: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; }
        .task-title.completed { text-decoration: line-through; opacity: 0.5; }
    </style>
</head>
<body>

<div class="app-container">
    <header class="header-content">
        <h1>Melo<span style="color:var(--primary-color)">.</span></h1>
        <div style="display: flex; gap: 12px; align-items: center;">
            <button id="themeToggle" class="user-profile"><i class="fas fa-moon"></i></button>
            <div class="user-menu-container">
                <div class="user-profile" id="userProfileBtn">
                    <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
                    <a href="{{ route('adminprofile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" style="border:none; background:none; padding:12px 15px; color:var(--danger-color); cursor:pointer; width: 100%; text-align: left;">Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="stats-bar">
        <span>Total: <span id="totalTasks" class="stat-val">0</span></span>
        <span>Done: <span id="completedTasks" class="stat-val">0</span></span>
    </div>

    <div class="task-creator-card">
        <input type="text" id="taskInput" placeholder="New task title...">
        <button id="addTaskBtn" class="btn-primary">Add Task</button>
    </div>

    <ul id="taskList" style="list-style: none; padding: 0;"></ul>
</div>

<div id="php-data" data-tasks="{{ json_encode($tasks) }}" data-csrf="{{ csrf_token() }}" style="display:none;"></div>

<script>
    // State
    const dataElement = document.getElementById('php-data');
    let tasks = JSON.parse(dataElement.dataset.tasks || "[]");
    const csrf = dataElement.dataset.csrf;

    // UI Helpers
    const updateStats = () => {
        document.getElementById('totalTasks').innerText = tasks.length;
        document.getElementById('completedTasks').innerText = tasks.filter(t => t.is_completed).length;
    };

    const render = () => {
        const list = document.getElementById('taskList');
        list.innerHTML = tasks.map(t => `
            <li class="task-item">
                <div class="task-title ${t.is_completed ? 'completed' : ''}">${t.title}</div>
                <input type="checkbox" ${t.is_completed ? 'checked' : ''} onchange="toggleTask(${t.id})">
            </li>
        `).join('');
        updateStats();
    };

    // Actions
    window.toggleTask = async (id) => {
        const task = tasks.find(t => t.id === id);
        task.is_completed = !task.is_completed;
        render();
        await fetch(`/tasks/${id}/toggle`, { method: 'PATCH', headers: { 'X-CSRF-TOKEN': csrf } });
    };

    document.getElementById('addTaskBtn').onclick = async () => {
        const title = document.getElementById('taskInput').value;
        if(!title) return;
        const res = await fetch('/tasks', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ title })
        });
        const newTask = await res.json();
        tasks.unshift(newTask);
        document.getElementById('taskInput').value = '';
        render();
    };

    // Listeners
    document.getElementById('userProfileBtn').onclick = (e) => { e.stopPropagation(); document.getElementById('dropdownMenu').style.display = 'block'; };
    window.onclick = () => document.getElementById('dropdownMenu').style.display = 'none';
    document.getElementById('themeToggle').onclick = () => {
        const isDark = document.body.dataset.theme === 'dark';
        document.body.dataset.theme = isDark ? 'light' : 'dark';
    };

    render();
</script>
</body>
</html>