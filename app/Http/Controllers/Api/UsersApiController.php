<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File; // Untuk operasi file
use Illuminate\Support\Facades\Hash; // Untuk hash password

class UsersApiController extends Controller
{
    /**
     * Tampilkan daftar semua user.
     * GET: /api/users
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        // Format data user
        $formattedUsers = $users->map(function ($user) {
            $statusClass = 'status-active';
            $statusText = ucfirst($user->status);

            if ($user->status === 'inactive') {
                $statusClass = 'status-inactive';
            } elseif ($user->status === 'banned') {
                $statusClass = 'status-banned';
                $statusText = 'Banned';
            }

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
                'last_login' => $user->last_login ? Carbon::parse($user->last_login)->format('d M Y H:i') : null,
                'added_date' => Carbon::parse($user->created_at)->format('d M Y'),
                'photo_url' => asset($user->photo ?? 'images/users/default.jpg'),
            ];
        });

        return response()->json($formattedUsers);
    }

    /**
     * Tampilkan detail user tertentu.
     * GET: /api/users/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Format data user
        $statusClass = 'status-active';
        $statusText = ucfirst($user->status);

        if ($user->status === 'inactive') {
            $statusClass = 'status-inactive';
        } elseif ($user->status === 'banned') {
            $statusClass = 'status-banned';
            $statusText = 'Banned';
        }

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
            'last_login' => $user->last_login ? Carbon::parse($user->last_login)->format('d M Y H:i') : null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'photo_url' => asset($user->photo ?? 'images/users/default.jpg'),
        ];

        return response()->json($formattedUser);
    }

    /**
     * Simpan user baru.
     * POST: /api/users
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            // Field nullable akan otomatis terisi null jika tidak ada dalam request dan validasi lolos
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images/users'), $imageName);
            $data['photo'] = 'images/users/' . $imageName;
        }

        $user = User::create($data);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    }

    /**
     * Perbarui user tertentu.
     * PUT/PATCH: /api/users/{id}
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Validasi dengan pengecualian unique untuk user itu sendiri
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users', 'username')->ignore($user->id)
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8', // Password optional saat update
            'role' => ['required', Rule::in(['admin', 'member'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // KODE YANG DIKOREKSI: Menggunakan operator ?? untuk mencegah Undefined array key
        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            
            // Gunakan $validated[key] ?? $user->key
            // Jika key ada di $validated, gunakan nilai baru; jika tidak, gunakan nilai lama ($user->key)
            'phone' => $validated['phone'] ?? $user->phone, 
            'address' => $validated['address'] ?? $user->address,
            'city' => $validated['city'] ?? $user->city,
            'postal_code' => $validated['postal_code'] ?? $user->postal_code,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
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

    /**
     * Hapus user tertentu.
     * DELETE: /api/users/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Hapus foto terkait jika ada
        if ($user->photo && File::exists(public_path($user->photo))) {
            File::delete(public_path($user->photo));
        }

        $user->delete();

        return response()->json(['message' => 'User berhasil dihapus']);
    }

    /**
     * Paginasi user.
     * GET: /api/users/paginate
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        // Ambil jumlah per halaman dari query string, default 10
        $perPage = $request->get('per_page', 10);
        $data = User::orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'current_page' => $data->currentPage(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'last_page' => $data->lastPage(),
            'data' => $data->items(),
        ]);
    }
}