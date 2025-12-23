<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{
    /**
     * Tampilkan halaman daftar alamat (opsional)
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $addresses = $user->addresses()->get();

        return view('address.index', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * Simpan alamat baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'max:500'],
            'type' => ['required', 'in:shipping,billing'],
        ]);

        $request->user()->addresses()->create($validated);

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    /**
     * Update alamat
     */
    public function update(Request $request, Address $address): RedirectResponse
    {
        // Pastikan user hanya bisa update alamat miliknya sendiri
        $this->authorize('update', $address);

        $validated = $request->validate([
            'address' => ['required', 'string', 'max:500'],
            'type' => ['required', 'in:shipping,billing'],
        ]);

        $address->update($validated);

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * Hapus alamat
     */
    public function destroy(Request $request, Address $address): RedirectResponse
    {
        // Pastikan user hanya bisa delete alamat miliknya sendiri
        $this->authorize('delete', $address);

        $address->delete();

        return back()->with('success', 'Alamat berhasil dihapus!');
    }
}
