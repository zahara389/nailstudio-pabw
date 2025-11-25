<!DOCTYPE html> 
<html lang="en"> 
<head> 	
    <meta charset="UTF-8"> 	
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 	
    <title>Login - Nail Studio</title> 	
    
    {{-- PASTIKAN FILE CSS INI ADA DI public/css/login.css --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> 	
    
    <style> 	
        /* Style override dari PHP Native */
        .error { color: red; margin-bottom: 15px; } 		
        .right-panel { display: flex; flex-direction: column; justify-content: center; }
        .form-container { width: 100%; max-width: 600px; }
        h2 { text-align: left; margin-bottom: 25px; }
        .login-link { display: flex; justify-content: center; margin-top: 15px; }
        input[type="text"], input[type="password"] {
            height: 50px; border-radius: 8px; margin-bottom: 20px;
        }
    </style> 
</head> 
<body> 	
    <div class="container"> 	
        <div class="left-panel">
            <div class="logo-container">
                {{-- Gunakan asset() untuk path gambar --}}
                <img src="{{ asset('images/logonails.png') }}" alt="Nail Studio Logo">
            </div>
            <p>Selamat datang di platform kami! Login atau daftar untuk melanjutkan.</p> 	
        </div> 	
                
        <div class="right-panel"> 		
            <div class="welcome-box">Welcome!</div> 			
                    
            <div class="form-container">
                <h2>Login</h2> 		
                            
                {{-- Menampilkan pesan sukses maupun error dari session --}}
                @if (session('success'))        
                    <div class="success">{{ session('success') }}</div>    
                @endif
                @if (session('error')) 		
                    <div class="error">{{ session('error') }}</div> 	
                @endif 	
                            
                {{-- Action form diarahkan ke route POST login --}}
                <form action="{{ route('login.post') }}" method="post"> 		
                    @csrf {{-- Wajib ada CSRF Token --}}
                    
                    <input type="hidden" name="role" value="member">
                    
                    <label for="username">Username</label> 			
                    <input type="text" id="username" name="username" required value="{{ old('username') }}"> 			
                                            
                    <label for="password">Password</label> 			
                    <input type="password" id="password" name="password" required> 			
                                            
                    <button type="submit" class="signup-btn">Login</button> 			
                </form>
                
                <div class="login-link"> 				
                    Don't have an account? <a href="{{ route('register') }}">Sign Up</a> 			
                    {{-- Menggunakan named route register untuk navigasi --}}
                </div>
            </div>
        </div> 	
    </div> 
</body> 
</html>
