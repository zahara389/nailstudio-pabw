<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    // ----------------------------------------------------------
    // LOGIN FORM
    // ----------------------------------------------------------
    public function showLoginForm()
    {
        if (session('loggedin')) {
            return session('role') === 'admin'
                ? redirect()->route('dashboard.index')
                : redirect('/');
        }

        return view('admin.login', [
            'error' => session('error')
        ]);
    }

    // ----------------------------------------------------------
    // REGISTER FORM
    // ----------------------------------------------------------
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    // ----------------------------------------------------------
    // REGISTER PROCESS
    // ----------------------------------------------------------
    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'username' => 'required|unique:users',
        'password' => 'required|min:5|confirmed',
        'role'     => 'required'
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'role'     => $request->role
    ]);

    return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
}


    // ----------------------------------------------------------
    // LOGIN PROCESS
    // ----------------------------------------------------------
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // SET SESSION
        session([
            'loggedin' => true,
            'id'       => $user->id,
            'username' => $user->username,
            'role'     => $user->role,
        ]);

        return $user->role === 'admin'
            ? redirect()->route('dashboard.index')
            : redirect('/');
    }

    // ----------------------------------------------------------
    // LOGOUT
    // ----------------------------------------------------------
    public function logout()
    {
        session()->flush();
        session()->regenerate(true);

        Cookie::forget('user_id');
        Cookie::forget('user_name');
        Cookie::forget('user_email');

        return redirect()->route('login');
    }

    // ----------------------------------------------------------
    // USER CRUD
    // ----------------------------------------------------------
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::all()
        ]);
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
            $request->validate([
                'password' => 'min:5'
            ]);

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
