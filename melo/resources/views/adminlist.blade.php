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

        body { background-color: var(--bg-secondary); color: var(--text-color); font-family: 'Inter', sans-serif; margin: 0; transition: all 0.3s ease; }
        .app-container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .app-header { margin-bottom: 30px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        h1 { font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; margin: 0; }
        
        /* Stats Bar Styling */
        .stats-bar { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 30px; }
        .stat-item { background: var(--bg-color); padding: 20px; border-radius: 12px; box-shadow: var(--shadow); text-align: center; border: 1px solid var(--border-color); }
        .stat-count { display: block; font-size: 2rem; font-weight: 800; color: var(--primary-color); }
        .stat-label { color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; font-weight: 600; }

        .search-container { background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 20px; display: flex; align-items: center; margin-bottom: 25px; box-shadow: var(--shadow); }
        .search-container input { border: none; background: transparent; color: var(--text-color); flex: 1; padding: 10px; outline: none; font-size: 1rem; }
        
        .task-list-container { background: var(--bg-color); border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow); overflow: hidden; }
        .task-item { padding: 15px 25px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; transition: background 0.2s; }
        .task-item:hover { background: var(--bg-secondary); }
        .owner-badge { background: var(--primary-color); color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; margin-right: 12px; }
        .priority-tag { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 8px; border-radius: 4px; }
        .high { background: #fee2e2; color: #ef4444; } .medium { background: #fef3c7; color: #f59e0b; } .low { background: #dcfce7; color: #22c55e; }
        
        /* Dropdown & Avatar */
        .theme-btn { background: none; border: 1px solid var(--border-color); color: var(--text-color); width: 40px; height: 40px; border-radius: 8px; cursor: pointer; }
        .user-menu-container { position: relative; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 25px; border: 1px solid var(--border-color); background: var(--bg-color); }
        .avatar-placeholder { width: 32px; height: 32px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; }
        
        .dropdown-menu { position: absolute; right: 0; top: 50px; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: var(--shadow); width: 220px; display: none; z-index: 100; }
        .dropdown-menu a, .logout-link { display: block; padding: 12px 15px; text-decoration: none; color: var(--text-color); cursor: pointer; border: none; background: none; width: 100%; text-align: left; font-size: 0.9rem; }
        .dropdown-menu a:hover { background: var(--bg-secondary); }
        .dropdown-menu i { width: 20px; margin-right: 8px; color: var(--text-light); }
        .logout-link { color: var(--danger-color); font-weight: 600; }
    </style>
</head>
<body>

<div class="app-container">
    <header class="app-header">
        <div class="header-content">
            <h1>Melo<span style="color:var(--primary-color)">.</span> Admin</h1>
            <div style="display: flex; gap: 12px; align-items: center;">
                <button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button>
                
                <div class="user-menu-container">
                    <div class="user-profile" id="userProfileBtn">
                        <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span style="font-weight: 500; font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.7rem; color: var(--text-light);"></i>
                    </div>
                    
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div style="padding: 15px; border-bottom: 1px solid var(--border-color);">
                            <div style="font-weight: 700; font-size: 0.95rem;">{{ auth()->user()->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="/profile"><i class="fas fa-user"></i> Edit Profiles</a>
                        <a href="/settings/security"><i class="fas fa-lock"></i> Change Password</a>
                        <div style="border-top: 1px solid var(--border-color); margin-top: 5px;">
                            <form action="/logout" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-link"><i class="fas fa-sign-out-alt"></i> Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
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
            <ul id="taskList" style="list-style: none; padding: 0; margin: 0;">
                @foreach($tasks as $task)
                <li class="task-item">
                    <div class="task-info">
                        <span class="owner-badge"><i class="fas fa-user"></i> {{ $task->user->name }}</span>
                        <span class="task-text">{{ $task->title }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="priority-tag {{ $task->priority }}">{{ $task->priority }}</span>
                        <i class="fas {{ $task->is_completed ? 'fa-check-circle' : 'fa-clock' }}" style="color: {{ $task->is_completed ? '#22c55e' : '#f59e0b' }}"></i>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </main>
</div>

<script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    themeToggle.addEventListener('click', () => {
        const isDark = document.body.getAttribute('data-theme') === 'dark';
        document.body.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeToggle.innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });

    // Search
    document.getElementById('adminSearch').addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.task-item').forEach(item => {
            item.style.display = item.textContent.toLowerCase().includes(term) ? 'flex' : 'none';
        });
    });

    // Dropdown
    const userProfileBtn = document.getElementById('userProfileBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    userProfileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });
    window.addEventListener('click', () => dropdownMenu.style.display = 'none');
</script>

</body>
</html>