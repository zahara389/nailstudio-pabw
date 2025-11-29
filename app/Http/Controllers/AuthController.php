<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; 
use Illuminate\Support\Facades\Cookie; 

class AuthController extends Controller
{
    // ----------------------------------------------------------
    // 1. LOGIN FORM (GET /login)
    // ----------------------------------------------------------
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('dashboard.index')
                // PERBAIKAN: Arahkan user ke landing.index (bukan booking.index)
                : redirect()->route('landing.index'); 
        }

        return view('admin.login');
    }

    // ----------------------------------------------------------
    // 2. LOGIN PROCESS (POST /login)
    // ----------------------------------------------------------
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('dashboard.index'));
            } else {
                // PERBAIKAN: User diarahkan ke landing.index
                return redirect()->intended(route('landing.index')); 
            }
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    // ----------------------------------------------------------
    // 3. LOGOUT (GET /logout)
    // ----------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    
    // ----------------------------------------------------------
    // 4. REGISTER PROCESS (POST /register)
    // ----------------------------------------------------------
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users', 
            'password' => 'required|min:5|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', 
        ]);

        Auth::login($user); 

        // PERBAIKAN: User baru diarahkan ke landing.index
        return redirect()->route('landing.index');
    }

    // ----------------------------------------------------------
    // 5. USER CRUD (ADMIN) - Sisanya
    // ----------------------------------------------------------
    public function index()
    {
        return view('admin.users.index', ['users' => User::all()]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:5',
            'role'     => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'role'     => 'required'
        ]);

        $user->username = $request->username;
        $user->role     = $request->role;

        if ($request->password) {
            $request->validate(['password' => 'min:5']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}