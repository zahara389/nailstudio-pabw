<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Nail Studio</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <style>
        .error { color: red; margin-bottom: 15px; }
        .right-panel { display: flex; flex-direction: column; justify-content: center; }
        .form-container { width: 100%; max-width: 600px; }
        h2 { margin-bottom: 25px; }
        input { height: 50px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>

<body>
    <div class="container">

        <div class="left-panel">
            <div class="logo-container">
                <img src="{{ asset('images/logonails.png') }}" alt="Nail Studio Logo">
            </div>
            <p>Daftar dengan mengisi data lengkap di bawah.</p>
        </div>

        <div class="right-panel">

            <div class="welcome-box">Create Account</div>

            <div class="form-container">
                <h2>Sign Up</h2>

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('register.process') }}" method="POST">
    @csrf

    <label>Name</label>
    <input type="text" name="name" value="{{ old('name') }}" required>

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>

    <label>Username</label>
    <input type="text" name="username" value="{{ old('username') }}" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" required>

    <label>Role</label>
    <select name="role" required>
        <option value="member">Member</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit" class="signup-btn">Register</button>
</form>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
