<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;            // Model untuk tabel 'faqs' (Data yang ditampilkan)
use App\Models\UserQuestion;   // Model untuk tabel 'user_questions' (Data masuk dari user)
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil keyword pencarian dari URL (?q=...)
        $search = $request->query('q');

        // 2. Query ke Database (Tabel 'faqs')
        // Sesuai gambar: tabel ini punya kolom 'question' dan 'answer'
        $query = Faq::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                // Mencari di kolom 'question' ATAU 'answer'
                $q->where('question', 'LIKE', "%{$search}%")
                  ->orWhere('answer', 'LIKE', "%{$search}%");
            });
        }

        // Ambil data terbaru (berdasarkan created_at)
        $faqs = $query->latest()->get();

        // 3. Logika Kirim Pertanyaan (Masuk ke tabel 'user_questions')
        // Kita pisah ke tabel 'user_questions' karena tabel 'faqs' kolom answer-nya NOT NULL
        $success = null;
        $error = null;

        if ($request->isMethod('post')) {
            // Validasi input
            $request->validate([
                'member_question' => 'required|string|min:5',
            ], [
                'member_question.required' => 'Pertanyaan wajib diisi.',
                'member_question.min' => 'Pertanyaan terlalu pendek.',
            ]);

            try {
                // Simpan ke database user_questions
                // Pastikan Anda sudah membuat Model UserQuestion dan tabelnya
                UserQuestion::create([
                    'user_id' => Auth::id(), // ID user (bisa null jika guest)
                    'question' => trim($request->input('member_question')),
                    'status' => 'Pending' // Default status menunggu dijawab admin
                ]);

                $success = 'Pertanyaan berhasil dikirim! Admin akan segera menjawab.';
            } catch (\Exception $e) {
                // Debugging: Uncomment baris bawah jika ingin lihat pesan error asli
                // dd($e->getMessage());
                $error = 'Gagal menyimpan pertanyaan. Pastikan tabel user_questions sudah dibuat.';
            }
        }

        // Data User untuk ditampilkan di view
        $user = Auth::user();
        $namaUser = $user ? $user->name : 'Guest';

        // Return view ke folder resources/views/pages/faq.blade.php
        return view('pages.faq', [
            'faqs' => $faqs,
            'search' => $search,
            'success' => $success,
            'error' => $error,
            'nama_user' => $namaUser,
        ]);
    }
}