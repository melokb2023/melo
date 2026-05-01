<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Melo</title>
    <style>
        
        /* Unified CSS Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.875rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .input-wrapper input {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px 8px 16px;
            color: #1e293b;
            font-size: 16px;
            transition: all 0.2s ease;
            width: 100%;
            outline: none;
        }

        .input-wrapper label {
            position: absolute;
            left: 16px;
            top: 12px;
            color: #64748b;
            font-size: 16px;
            transition: all 0.2s ease;
            pointer-events: none;
            transform-origin: left top;
        }

        /* Label floating animation */
        .input-wrapper input:focus + label,
        .input-wrapper input:not(:placeholder-shown) + label {
            transform: translateY(-22px) scale(0.85);
            color: #6366f1;
            font-weight: 500;
            background: white;
            padding: 0 4px;
        }

        .input-wrapper input:focus {
            border-color: #6366f1;
        }

        .error-message {
            display: block;
            color: #ef4444;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 4px;
        }

        /* Update the button margin if needed */
.login-btn {
    width: 100%;
    background: #6366f1;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 24px;
    margin-top: 10px; /* Added slight top margin for balance */
}

        .login-btn:hover {
            background: #4f46e5;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }

        .signup-link {
            text-align: center;
        }

        .signup-link a, .forgot-password {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Sign In</h2>
                <p>Enter your credentials to access your account</p>
            </div>
            
            <form action="/login" method="POST" class="login-form">
                @csrf <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required placeholder=" " value="{{ old('email') }}">
                        <label for="email">Email Address</label>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required placeholder=" ">
                        <label for="password">Password</label>
                    </div>
                    <div style="margin-top: 8px; text-align: right;">
            <a href="{{ route('password.request') }}" class="forgot-password" style="font-size: 0.8rem;">Forgot password?</a>
        </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>

            <div class="signup-link">
                <p>Don't have an account? <a href="/register">Create one</a></p>
            </div>
        </div>
    </div>
</body>
</html>