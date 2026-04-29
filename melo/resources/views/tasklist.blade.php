<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melo | My Tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --bg-color: #f8fafc; --card-bg: #ffffff; --text-color: #1e293b; --text-light: #64748b; --primary-color: #6366f1; --border-color: #e2e8f0; --accent-bg: #f1f5f9; }
        [data-theme="dark"] { --bg-color: #0f172a; --card-bg: #1e293b; --text-color: #f1f5f9; --text-light: #94a3b8; --border-color: #334155; --accent-bg: #0f172a; }
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Inter', system-ui, sans-serif; margin: 0; line-height: 1.5; transition: all 0.3s ease; }
        .app-container { max-width: 800px; margin: 3rem auto; padding: 0 1rem; }
        .header-content { display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; margin-bottom: 2rem; }
        .user-menu-container { position: relative; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 25px; border: 1px solid var(--border-color); background: var(--card-bg); }
        .avatar-placeholder { width: 32px; height: 32px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; }
        .dropdown-menu { position: absolute; right: 0; top: 50px; background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: 0 10px 15px rgba(0,0,0,0.1); width: 220px; display: none; z-index: 1000; }
        .dropdown-menu a { display: block; padding: 12px 15px; text-decoration: none; color: var(--text-color); font-size: 0.9rem; }
        .dropdown-menu a:hover { background: var(--accent-bg); }
        .stats-bar { display: flex; gap: 24px; margin-bottom: 2rem; padding: 1rem; background: var(--accent-bg); border-radius: 12px; font-size: 0.9rem; }
        .stat-val { font-weight: 700; color: var(--primary-color); }
        .task-creator-card { background: var(--card-bg); padding: 1.5rem; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); margin-bottom: 2.5rem; border: 2px solid var(--border-color); }
        .task-creator-card.edit-mode { border-color: var(--primary-color); }
        input, textarea, select { width: 100%; padding: 0.8rem; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-color); color: var(--text-color); box-sizing: border-box; }
        .grid-inputs { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-top: 1rem; }
        .btn-primary { background: var(--primary-color); color: white; border: none; padding: 1rem; border-radius: 10px; cursor: pointer; width: 100%; margin-top: 1.5rem; display: flex; justify-content: center; align-items: center; gap: 8px; }
        .btn-cancel { background: #94a3b8; margin-top: 0.5rem; }
        .task-item { background: var(--card-bg); margin-bottom: 12px; padding: 1.25rem; border-radius: 14px; border: 1px solid var(--border-color); }
        .task-main { display: flex; align-items: flex-start; gap: 16px; }
        .task-checkbox { width: 20px; height: 20px; cursor: pointer; accent-color: var(--primary-color); margin-top: 4px; }
        .task-content { flex: 1; }
        .task-title.completed { text-decoration: line-through; opacity: 0.5; }
        .task-meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: 0.75rem; margin-top: 6px; color: var(--text-light); }
        .btn-icon { background: none; border: none; color: var(--text-light); cursor: pointer; padding: 8px; font-size: 1.1rem; border-radius: 8px; }
        .task-desc { margin: 10px 0 0 36px; font-size: 0.88rem; color: var(--text-light); background: var(--accent-bg); padding: 8px 12px; border-radius: 8px; border-left: 3px solid var(--primary-color); }
    </style>
</head>
<body>

<div class="app-container">
    <header class="header-content">
        <h1>Simplified Advanced Task List System<span style="color:var(--primary-color)"></span></h1>
        <div style="display: flex; gap: 12px; align-items: center;">
            <button id="themeToggle" class="btn-icon"><i class="fas fa-moon"></i></button>
            <div class="user-menu-container">
                <div class="user-profile" id="userProfileBtn">
                    <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('userprofile.edit') }}"><i class="fas fa-user"></i> Edit User Profile</a>
                    <a href="/user/settings/security"><i class="fas fa-lock"></i> Password & Security</a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" style="border:none; background:none; padding:12px 15px; color:#ef4444; cursor:pointer; width: 100%; text-align: left;"><i class="fas fa-sign-out-alt"></i> Sign out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

<div class="app-container">
    <div class="stats-bar">
        <span>Total Tasks: <span id="totalTasks" class="stat-val">0</span></span>
        <span>Completed: <span id="completedTasks" class="stat-val">0</span></span>
    </div>

    <div class="task-creator-card" id="creatorCard">
        <h3 id="formTitle" style="margin: 0 0 1rem 0; font-size: 0.8rem; color: var(--primary-color); display: none; text-transform: uppercase; letter-spacing: 1px; font-weight: 800;">
            <i class="fas fa-pen"></i> Editing Task Mode
        </h3>
        
        <input type="hidden" id="editTaskId">
        <input type="text" id="taskInput" placeholder="What's the main goal?" style="font-weight: 700; font-size: 1.1rem;">
        
        <div class="grid-inputs">
            <select id="taskCategory">
                <option value="General">📂 General</option>
                <option value="Work">🏢 Work</option>
                <option value="Personal">🏠 Personal</option>
            </select>
            <select id="taskPriority">
                <option value="low">Low Priority</option>
                <option value="medium" selected>Medium Priority</option>
                <option value="high">High Priority</option>
            </select>
            <input type="date" id="taskDate">
        </div>

        <textarea id="taskDesc" placeholder="Brief description (max 255 chars)..." rows="2" style="margin-top:1rem"></textarea>
        
        <button id="addTaskBtn" class="btn-primary">
            <i class="fas fa-save"></i> <span id="btnText">Create New Task</span>
        </button>
        <button id="cancelEditBtn" class="btn-primary btn-cancel" style="display: none;">
            Cancel Edit
        </button>
    </div>

    <ul id="taskList" class="task-list"></ul>
</div>

<div id="php-data" 
     data-tasks="{{ json_encode($tasks) }}" 
     data-csrf="{{ csrf_token() }}" 
     style="display: none;">
</div>

<script>
    const dataElement = document.getElementById('php-data');
    const taskList = document.getElementById('taskList');
    const addTaskBtn = document.getElementById('addTaskBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const creatorCard = document.getElementById('creatorCard');
    const btnText = document.getElementById('btnText');
    const formTitle = document.getElementById('formTitle');
    
    window.meloData = {
        tasks: JSON.parse(dataElement.getAttribute('data-tasks') || "[]"),
        csrf: dataElement.getAttribute('data-csrf'),
        editMode: false
    };

    const priorityMap = {
        high: { color: '#fee2e2', text: '#ef4444' },
        medium: { color: '#fef3c7', text: '#f59e0b' },
        low: { color: '#dcfce7', text: '#22c55e' }
    };

    function renderTasks() {
        taskList.innerHTML = '';
        window.meloData.tasks.forEach(task => {
            const p = priorityMap[task.priority] || priorityMap.medium;
            const li = document.createElement('li');
            li.className = 'task-item';
            li.innerHTML = `
                <div class="task-main">
                    <input type="checkbox" class="task-checkbox" ${task.is_completed ? 'checked' : ''} onchange="toggleTask(${task.id})">
                    <div class="task-content">
                        <div class="task-title ${task.is_completed ? 'completed' : ''}">${task.title}</div>
                        <div class="task-meta">
                            <span class="badge-priority" style="background:${p.color}; color:${p.text}">
                                <i class="fas fa-flag" style="font-size:0.7rem"></i> ${task.priority}
                            </span>
                            <span><i class="fas fa-folder"></i> ${task.category || 'General'}</span>
                            ${task.due_date ? `<span><i class="fas fa-calendar-alt"></i> ${task.due_date}</span>` : ''}
                        </div>
                    </div>
                    <div style="display: flex; gap: 4px;">
                        <button class="btn-icon edit" onclick="prepareEdit(${task.id})"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon delete" onclick="deleteTask(${task.id})"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                ${task.description ? `<div class="task-desc">${task.description}</div>` : ''}
            `;
            taskList.append(li);
        });
        updateStats();
    }

    addTaskBtn.addEventListener('click', async () => {
        const payload = {
            title: document.getElementById('taskInput').value,
            description: document.getElementById('taskDesc').value,
            category: document.getElementById('taskCategory').value,
            priority: document.getElementById('taskPriority').value,
            due_date: document.getElementById('taskDate').value
        };

        if (!payload.title.trim()) return alert("Task title is required");

        const isEdit = window.meloData.editMode;
        const id = document.getElementById('editTaskId').value;
        const url = isEdit ? `/tasks/${id}` : '/tasks';
        const method = isEdit ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.meloData.csrf 
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                const updatedTask = await response.json();
                if (isEdit) {
                    const idx = window.meloData.tasks.findIndex(t => t.id == id);
                    window.meloData.tasks[idx] = updatedTask;
                } else {
                    window.meloData.tasks.unshift(updatedTask);
                }
                resetForm();
                renderTasks();
            } else {
                const errorData = await response.json();
                alert("Error: " + (errorData.message || "Could not save task."));
            }
        } catch (e) { console.error(e); }
    });

    window.prepareEdit = (id) => {
        const task = window.meloData.tasks.find(t => t.id == id);
        if(!task) return;

        document.getElementById('editTaskId').value = task.id;
        document.getElementById('taskInput').value = task.title;
        document.getElementById('taskDesc').value = task.description || '';
        document.getElementById('taskCategory').value = task.category || 'General';
        document.getElementById('taskPriority').value = task.priority;
        document.getElementById('taskDate').value = task.due_date || '';

        window.meloData.editMode = true;
        btnText.innerText = "Update Task Details";
        cancelEditBtn.style.display = "block";
        formTitle.style.display = "block";
        creatorCard.classList.add('edit-mode');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function resetForm() {
        document.getElementById('editTaskId').value = '';
        document.getElementById('taskInput').value = '';
        document.getElementById('taskDesc').value = '';
        document.getElementById('taskDate').value = '';
        window.meloData.editMode = false;
        btnText.innerText = "Create New Task";
        cancelEditBtn.style.display = "none";
        formTitle.style.display = "none";
        creatorCard.classList.remove('edit-mode');
    }

    cancelEditBtn.addEventListener('click', resetForm);

    window.toggleTask = async (id) => {
        const task = window.meloData.tasks.find(t => t.id === id);
        if(!task) return;
        task.is_completed = !task.is_completed;
        renderTasks();
        try {
            await fetch(`/tasks/${id}/toggle`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': window.meloData.csrf, 'Accept': 'application/json' }
            });
        } catch (e) { console.error(e); }
    };

    window.deleteTask = async (id) => {
        if (!confirm("Delete this task?")) return;
        window.meloData.tasks = window.meloData.tasks.filter(t => t.id !== id);
        renderTasks();
        try {
            await fetch(`/tasks/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': window.meloData.csrf, 'Accept': 'application/json' }
            });
        } catch (e) { console.error(e); }
    };

    function updateStats() {
        document.getElementById('totalTasks').innerText = window.meloData.tasks.length;
        document.getElementById('completedTasks').innerText = window.meloData.tasks.filter(t => t.is_completed).length;
    }

    document.getElementById('themeToggle').addEventListener('click', () => {
        const body = document.body;
        const isDark = body.getAttribute('data-theme') === 'dark';
        body.setAttribute('data-theme', isDark ? 'light' : 'dark');
        document.getElementById('themeToggle').innerHTML = isDark ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
    });

    // ADD THIS SECTION HERE
    const userProfileBtn = document.getElementById('userProfileBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    userProfileBtn.addEventListener('click', (e) => {
        e.stopPropagation(); 
        const isVisible = dropdownMenu.style.display === 'block';
        dropdownMenu.style.display = isVisible ? 'none' : 'block';
    });

    window.addEventListener('click', (e) => {
        if (!userProfileBtn.contains(e.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
    // END OF ADDED SECTION

    renderTasks();
</script>
</body>
</html>