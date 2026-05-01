<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Melo</title>
    <style>
        /* Unified Styles from your Registration UI */
        * { margin: 0; padding: 0; box-sizing: border-box; }
         body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    /* Changed to a modern, soft indigo/purple gradient */
    background: #6366f1; 
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    line-height: 1.6;
    color: #334155;
}


.input-wrapper input:focus + label,
.input-wrapper input:not(:placeholder-shown) + label {
    transform: translateY(-22px) scale(0.85);
    color: #6366f1;
    font-weight: 500;
    background: white; 
    padding: 0 4px;
}
        .login-container { width: 100%; max-width: 400px; }
        .login-card { background: white; border-radius: 12px; padding: 32px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .login-header { text-align: center; margin-bottom: 32px; }
        .login-header h2 { font-size: 1.875rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .login-header p { color: #64748b; font-size: 0.875rem; }
        .error-card {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}
        .form-group { margin-bottom: 20px; position: relative; }
        .input-wrapper { position: relative; display: flex; flex-direction: column; }
        .input-wrapper input { background: white; border: 2px solid #e2e8f0; border-radius: 8px; padding: 12px 16px 8px 16px; color: #1e293b; font-size: 16px; transition: all 0.2s ease; width: 100%; outline: none; }
        
        /* Label Animation */
        .input-wrapper label { position: absolute; left: 16px; top: 12px; color: #64748b; font-size: 16px; transition: all 0.2s ease; pointer-events: none; }
        .input-wrapper input:focus + label, .input-wrapper input:not(:placeholder-shown) + label { transform: translateY(-22px) scale(0.85); color: #6366f1; font-weight: 500; background: white; padding: 0 4px; }
        .input-wrapper input:focus { border-color: #6366f1; }
        
        .login-btn { width: 100%; background: #6366f1; border: none; border-radius: 8px; padding: 12px 24px; color: white; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; margin-top: 10px; }
        .login-btn:hover { background: #4f46e5; }
        
        .signup-link { text-align: center; margin-top: 24px; }
        .signup-link a { color: #6366f1; text-decoration: none; font-weight: 500; }
        
        /* New helper classes for the 2-step flow */
        .hidden { display: none; }
        .step-transition { transition: all 0.3s ease; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2 id="step-title">Reset Password</h2>
                <p id="step-desc">Please enter the following details.</p>
            </div>
            
           <form action="{{ route('password.update.direct') }}" method="POST">
    @csrf
    @if ($errors->any())
        <div class="error-card">
            <ul style="list-style-position: inside;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="form-group">
        <div class="input-wrapper">
            <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder=" ">
            <label for="email">Email Address</label>
        </div>
    </div>

    <div class="form-group">
        <div class="input-wrapper">
            <input type="password" name="password" id="password" required placeholder=" ">
            <label for="password">New Password</label>
        </div>
    </div>

    <div class="form-group">
        <div class="input-wrapper">
            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder=" ">
            <label for="password_confirmation">Confirm Password</label>
        </div>
    </div>

    <button type="submit" class="login-btn">Change Password</button>
</form>

            <div class="signup-link">
                <p><a href="/login">Back to Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>