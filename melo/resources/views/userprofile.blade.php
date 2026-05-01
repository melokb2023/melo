<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Melo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #6366f1; --danger-color: #ef4444; --text-color: #1e293b; --text-light: #64748b; --bg-color: #ffffff; --bg-secondary: #f8fafc; --border-color: #e2e8f0; --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        [data-theme="dark"] { --bg-color: #0f172a; --bg-secondary: #1e293b; --text-color: #f1f5f9; --text-light: #94a3b8; --border-color: #334155; --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3); }
     body {
    background-color: var(--bg-secondary);
    color: var(--text-color);
    font-family: 'Inter', sans-serif;
    margin: 0;
    transition: all 0.3s ease;
    
    /* The Frame: Top, Bottom, and Sides */
    border: 8px solid #6366f1; 
    box-sizing: border-box;
    min-height: 100vh;
    
    /* If you want that gradient look instead of solid purple */
    border-image: linear-gradient(135deg, #6366f1 0%, #a855f7 100%) 1;
}

/* Ensure the frame stays fixed while you scroll */
body::after {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    border: 8px solid transparent;
    border-image: linear-gradient(135deg, #6366f1 0%, #a855f7 100%) 1;
    pointer-events: none; /* Allows you to click things 'under' the border */
    z-index: 9999;
}
        .header-content { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { font-size: 1.8rem; font-weight: 800; margin: 0; }
        .management-card { background: var(--bg-color); padding: 30px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow); }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-light); }
        input { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; box-sizing: border-box; background: var(--bg-color); color: var(--text-color); }
        .save-btn { background: var(--primary-color); color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; }
        .back-btn { text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; color: var(--text-light); border: 1px solid var(--border-color); }
        .user-menu-container { position: relative; }
        .user-profile { display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 6px 12px; border-radius: 25px; border: 1px solid var(--border-color); background: var(--bg-color); }
         .avatar-placeholder { width: 32px; height: 32px; background-color: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600; }
        .dropdown-menu { position: absolute; right: 0; top: 55px; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: var(--shadow); width: 220px; display: none; z-index: 100; }
        .dropdown-menu a { display: block; padding: 12px 15px; text-decoration: none; color: var(--text-color); font-size: 0.9rem; }
        .dropdown-menu a:hover { background: var(--bg-secondary); }
    </style>
</head>
<body>

<div class="app-container">
    <header class="header-content">
        <h1>Edit User Profile<span style="color:var(--primary-color)"></span></h1>
        <div class="user-menu-container">
            <div class="user-profile" id="userProfileBtn">
                    <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span>{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.7rem; color: var(--text-light);"></i>
                </div>
            <div class="dropdown-menu" id="dropdownMenu">
                <a href="user/profile/update"><i class="fas fa-user"></i>Edit User Profile</a>
                <a href="user/settings/security"><i class="fas fa-lock"></i> Change Password</a>
                <div style="border-top: 1px solid var(--border-color);">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" style="border:none; background:none; padding:12px 15px; color:var(--danger-color); cursor:pointer; width:100%; text-align:left;">
                            <i class="fas fa-sign-out-alt"></i> Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="management-card">
        <form action="{{ route('userprofile.update') }}" method="POST">
            @csrf
            @if (session('status'))
                <div style="color: #22c55e; margin-bottom: 15px; font-weight: 600;">{{ session('status') }}</div>
            @endif
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>
            <button type="submit" class="save-btn">Save Changes</button>
            <a href="/tasks" class="back-btn">Back to Tasks</a>
        </form>
    </main>
</div>

<script>
    const userProfileBtn = document.getElementById('userProfileBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');
    userProfileBtn.addEventListener('click', (e) => { e.stopPropagation(); dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block'; });
    window.addEventListener('click', () => dropdownMenu.style.display = 'none');
</script>

</body>
</html>