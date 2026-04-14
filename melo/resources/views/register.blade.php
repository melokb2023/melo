<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Melo</title>
    <style>
        /* Unified Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
            color: #334155;
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

        .input-wrapper input, .input-wrapper select {
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

        /* Label Animation */
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

        /* Error Styles */
        .error-message {
            display: block;
            color: #ef4444;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 4px;
        }

        .form-group.error input {
            border-color: #ef4444;
        }

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
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #4f46e5;
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
        }

        .signup-link a {
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
                <h2>Create Account</h2>
                <p>Enter your details to register for Melo</p>
            </div>
            
            <form action="/register" method="POST">
                @csrf 

                <div class="form-group @error('name') error @enderror">
                    <div class="input-wrapper">
                        <input type="text" id="name" name="name" placeholder=" " required value="{{ old('name') }}">
                        <label for="name">Full Name</label>
                    </div>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group @error('email') error @enderror">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder=" " required value="{{ old('email') }}">
                        <label for="email">Email Address</label>
                    </div>
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group @error('password') error @enderror">
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder=" " required>
                        <label for="password">Password</label>
                    </div>
                    @error('password') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" " required>
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <select name="role" id="role" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="user">User</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="login-btn">Register Now</button>
            </form>

            <div class="signup-link">
                <p>Already have an account? <a href="/login">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>