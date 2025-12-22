<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsersApiController extends Controller
{
    /** Tampilkan semua user */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $formattedUsers = $users->map(function ($user) {
            $statusText = ucfirst($user->status);
            $statusClass = ($user->status === 'active') ? 'status-active' : (($user->status === 'inactive') ? 'status-inactive' : 'status-banned');

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'address' => $user->address,
                'city' => $user->city,
                'postal_code' => $user->postal_code,
                'status' => $user->status,
                'status_text' => $statusText,
                'status_class' => $statusClass,
                'added_date' => Carbon::parse($user->created_at)->format('d M Y'),
                'photo_url' => asset($user->photo ?? 'images/users/default.jpg'),
            ];
        });
        return response()->json($formattedUsers);
    }

    /** Tampilkan detail user */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $statusText = ucfirst($user->status);
        $statusClass = ($user->status === 'active') ? 'status-active' : (($user->status === 'inactive') ? 'status-inactive' : 'status-banned');

        $formattedUser = [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
            'status' => $user->status,
            'status_text' => $statusText,
            'status_class' => $statusClass,
            'added_date' => Carbon::parse($user->created_at)->format('d M Y'),
            'photo_url' => asset($user->photo ?? 'images/users/default.jpg'),
        ];
        return response()->json($formattedUser);
    }

    /** Simpan user baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'member'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $validated;
        $data['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images/users'), $imageName);
            $data['photo'] = 'images/users/' . $imageName;
        }

        $user = User::create($data);
        return response()->json(['message' => 'User berhasil ditambahkan', 'data' => $user], 201);
    }

    /** Update data user (Koreksi Error 500) */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['admin', 'member'])],
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'photo' => 'nullable|image|max:2048',
        ]);

        // Menggunakan operator ?? untuk mencegah Undefined Array Key
        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? $user->phone,
            'address' => $validated['address'] ?? $user->address,
            'city' => $validated['city'] ?? $user->city,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images/users'), $imageName);
            $data['photo'] = 'images/users/' . $imageName;
        }

        $user->update($data);
        return response()->json(['message' => 'User berhasil diperbarui', 'data' => $user]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo && File::exists(public_path($user->photo))) {
            File::delete(public_path($user->photo));
        }
        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus']);
    }
}