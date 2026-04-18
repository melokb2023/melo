<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melo | My Tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-color: #1e293b;
            --text-light: #64748b;
            --primary-color: #6366f1;
            --border-color: #e2e8f0;
            --accent-bg: #f1f5f9;
            --danger-color: #ef4444;
        }

        [data-theme="dark"] {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-color: #f1f5f9;
            --text-light: #94a3b8;
            --border-color: #334155;
            --accent-bg: #0f172a;
        }

        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', system-ui, sans-serif; margin: 0; line-height: 1.5; transition: all 0.3s ease; }
        .app-container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }

        /* Header & Dropdown */
        .header-content { display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; margin-bottom: 2rem; }
        .user-menu-container { position: relative; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 25px; border: 1px solid var(--border-color); background: var(--card-bg); }
        .avatar-placeholder { width: 32px; height: 32px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; }
        .dropdown-menu { position: absolute; right: 0; top: 50px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); width: 220px; display: none; z-index: 1000; }
        .dropdown-menu a { display: block; padding: 12px 15px; text-decoration: none; color: var(--text-color); font-size: 0.9rem; transition: background 0.2s; }
        .dropdown-menu a:hover { background: var(--accent-bg); }
        .theme-btn { background: none; border: 1px solid var(--border-color); color: var(--text-color); padding: 8px 12px; border-radius: 8px; cursor: pointer; }

        /* Existing Task Styles */
        .stats-bar { display: flex; gap: 24px; margin-bottom: 2rem; padding: 1rem; background: var(--accent-bg); border-radius: 12px; font-size: 0.9rem; }
        .stat-val { font-weight: 700; color: var(--primary-color); }
        .task-creator-card { background: var(--card-bg); padding: 1.5rem; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); margin-bottom: 2.5rem; border: 2px solid var(--border-color); }
        input, textarea, select { width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-color); color: var(--text-color); box-sizing: border-box; font-size: 0.95rem; }
        .grid-inputs { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-top: 1rem; }
        .btn-primary { background: var(--primary-color); color: white; border: none; padding: 1rem; border-radius: 10px; font-weight: 600; cursor: pointer; width: 100%; margin-top: 1.5rem; }
        .btn-cancel { background: #94a3b8; margin-top: 0.5rem; }
        .task-list { list-style: none; padding: 0; }
        .task-item { background: var(--card-bg); margin-bottom: 12px; padding: 1.25rem; border-radius: 14px; border: 1px solid var(--border-color); }
        .task-main { display: flex; align-items: flex-start; gap: 16px; }
        .task-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: var(--primary-color); margin-top: 4px; }
        .task-title { font-weight: 600; font-size: 1.1rem; }
        .task-title.completed { text-decoration: line-through; opacity: 0.5; }
        .task-meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: 0.75rem; margin-top: 6px; color: var(--text-light); }
        .badge-priority { padding: 2px 8px; border-radius: 6px; font-weight: 700; text-transform: uppercase; }
        .btn-icon { background: none; border: none; color: var(--text-light); cursor: pointer; padding: 8px; font-size: 1.1rem; }
        .task-desc { margin: 10px 0 0 36px; font-size: 0.88rem; color: var(--text-light); background: var(--accent-bg); padding: 8px 12px; border-radius: 8px; border-left: 3px solid var(--primary-color); }
    </style>
</head>
<body>

<div class="app-container">
    <header class="header-content">
        <h1>Melo<span style="color:var(--primary-color)">.</span></h1>
        <div style="display: flex; gap: 12px; align-items: center;">
            <button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button>
            <div class="user-menu-container">
                <div class="user-profile" id="userProfileBtn">
                    <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span style="font-weight: 600; font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.7rem; color: var(--text-light);"></i>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <div style="padding: 15px; border-bottom: 1px solid var(--border-color);">
                        <div style="font-weight: 700;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">{{ auth()->user()->email }}</div>
                    </div>
                    <a href="/dashboard"><i class="fas fa-th-large"></i> Dashboard</a>
                    <a href="{{ route('adminprofile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                    <a href="/settings/security"><i class="fas fa-lock"></i> Password & Security</a>
                    <div style="border-top: 1px solid var(--border-color); margin-top: 5px;">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" style="border:none; background:none; padding:12px 15px; color:var(--danger-color); cursor:pointer; font-weight:600; width: 100%; text-align: left;">
                                <i class="fas fa-sign-out-alt"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="stats-bar">
        <span>Total Tasks: <span id="totalTasks" class="stat-val">0</span></span>
        <span>Completed: <span id="completedTasks" class="stat-val">0</span></span>
    </div>

    <div class="task-creator-card" id="creatorCard">
        <input type="hidden" id="editTaskId">
        <input type="text" id="taskInput" placeholder="What's the main goal?" style="font-weight: 700; font-size: 1.1rem;">
        <div class="grid-inputs">
            <select id="taskCategory"><option>General</option><option>Work</option><option>Personal</option></select>
            <select id="taskPriority"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option></select>
            <input type="date" id="taskDate">
        </div>
        <textarea id="taskDesc" placeholder="Description..." rows="2" style="margin-top:1rem"></textarea>
        <button id="addTaskBtn" class="btn-primary">Create Task</button>
    </div>

    <ul id="taskList" class="task-list"></ul>
</div>

<div id="php-data" data-tasks="{{ json_encode($tasks) }}" data-csrf="{{ csrf_token() }}" style="display: none;"></div>

<script>
    // Dropdown Logic
    const userProfileBtn = document.getElementById('userProfileBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    userProfileBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block'; });
    window.addEventListener('click', () => dropdownMenu.style.display = 'none');

    // Theme & Existing Logic
    document.getElementById('themeToggle').addEventListener('click', () => {
        const body = document.body;
        const isDark = body.getAttribute('data-theme') === 'dark';
        body.setAttribute('data-theme', isDark ? 'light' : 'dark');
        document.getElementById('themeToggle').innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });
    
    // ... (All your existing renderTasks, fetch, and helper functions go here)
    // Note: Ensure all your logic from the previous script tag is placed here.
</script>
</body>
</html>