<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Jika user belum login
        if (!Auth::check()) {
            return back()->with('alert_login', 'Silakan login terlebih dahulu.');
        }

        // Validasi email
        $request->validate([
            'email' => 'required|email'
        ]);

        // Cek email sudah terdaftar
        if (NewsletterSubscriber::where('email', $request->email)->exists()) {
            return back()->with('alert', 'Email sudah terdaftar!');
        }

        // Simpan data newsletter
        NewsletterSubscriber::create([
            'email' => $request->email,
            'user_id' => Auth::id(),
        ]);

        // Notifikasi sukses
        return back()->with('alert', 'Email berhasil ditambahkan ke newsletter!');
    }
}
