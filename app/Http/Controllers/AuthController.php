<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; 
use Illuminate\Support\Facades\Cookie; // Ini tidak diperlukan, tapi dibiarkan.

class AuthController extends Controller
{
    // ----------------------------------------------------------
    // 1. LOGIN FORM (GET /login)
    // ----------------------------------------------------------
    public function showLoginForm()
    {
        // Jika user sudah login, arahkan berdasarkan role
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('dashboard.index')
                : redirect()->route('landing.index'); // User biasa ke landing page
        }

        return view('admin.login');
    }
    // [Perbaikan: Kurung kurawal penutup untuk fungsi showLoginForm() dan class AuthController telah diperbaiki]

    // ----------------------------------------------------------
    // 2. LOGIN PROCESS (POST /login)
    // ----------------------------------------------------------
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Auth::user()->role === 'admin'
                ? redirect()->intended(route('dashboard.index'))
                : redirect()->intended(route('landing.index'));
        }

        throw ValidationException::withMessages([
            'username' => ['Username atau password salah.'],
        ]);
    }

    // ----------------------------------------------------------
    // 3. REGISTER FORM (GET /register)
    // ----------------------------------------------------------
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // ----------------------------------------------------------
    // 4. REGISTER PROCESS (POST /register)
    // ----------------------------------------------------------
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:5|confirmed',
            'role'     => 'required' // Ini seharusnya dihilangkan jika role selalu 'user'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role // Menggunakan role dari input (Hati-hati: admin bisa dibuat disini)
        ]);

        Auth::login($user);
        return redirect()->route('landing.index')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // ----------------------------------------------------------
    // 5. LOGOUT (POST /logout)
    // ----------------------------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ----------------------------------------------------------
    // 6. USER CRUD (ADMIN)
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
            'email'    => 'required|email|unique:users', // Tambahan: email untuk konsistensi
            'password' => 'required|min:5',
            'role'     => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
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
            'email'    => 'required|email|unique:users,email,' . $user->id, // Tambahan: email untuk konsistensi
            'role'     => 'required'
        ]);

        $user->username = $request->username;
        $user->role     = $request->role;
        $user->email    = $request->email; // Tambahan: email untuk konsistensi

        if ($request->password) {
            $request->validate(['password' => 'min:5']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    // Menambahkan kembali fungsi destroy
    public function destroy(User $user)
    {
        // Pencegahan: Admin tidak boleh menghapus akunnya sendiri
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}