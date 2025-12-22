<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visitor; // 1. Import Model Visitor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; 

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('dashboard.index')
                : redirect()->route('landing.index');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 2. CATAT AKTIVITAS LOGIN (Setiap login = +1 di dashboard)
            Visitor::create([
                'ip_address' => $request->ip(),
                'visit_date' => now()->toDateString(),
            ]);

            return Auth::user()->role === 'admin'
                ? redirect()->intended(route('dashboard.index'))
                : redirect()->intended(route('landing.index'));
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:5|confirmed',
            'role'     => 'required' 
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role 
        ]);

        // 3. CATAT AKTIVITAS SETELAH REGISTRASI (Otomatis login)
        Visitor::create([
            'ip_address' => $request->ip(),
            'visit_date' => now()->toDateString(),
        ]);

        Auth::login($user);
        return redirect()->route('landing.index')->with('success', 'Registrasi berhasil!');
    }

    // Fungsi lainnya (logout, index, dll) tetap sama...
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}