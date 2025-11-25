<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Nail Studio</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        .error { color: red; margin-bottom: 15px; }
        .success { color: green; margin-bottom: 15px; }
        .right-panel { display: flex; flex-direction: column; justify-content: center; }
        .form-container { width: 100%; max-width: 600px; }
        h2 { text-align: left; margin-bottom: 25px; }
        input[type="text"], input[type="email"], input[type="password"] {
            height: 50px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .toggle-link { margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo-container">
                <img src="{{ asset('images/logonails.png') }}" alt="Nail Studio Logo">
            </div>
            <p>Buat akun baru dan bergabung dengan komunitas pecinta nail art kami.</p>
        </div>

        <div class="right-panel">
            <div class="welcome-box">Sign Up</div>

            <div class="form-container">
                <h2>Register</h2>

                @if ($errors->any())
                    <div class="error">
                        <ul style="padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('register.post') }}" method="post">
                    @csrf
                    <input type="hidden" name="role" value="member">

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>

                    <button type="submit" class="signup-btn">Daftar</button>
                </form>

                <div class="toggle-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
