<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    public function index()
    {
        // 1. Log Visitor (Opsional)
        try {
            Visitor::firstOrCreate([
                'ip_address' => request()->ip(),
                'visit_date' => Carbon::now()->toDateString(),
            ]);
        } catch (\Exception $e) {
            // Abaikan jika error visitor
        }

        // 2. Ambil FAQ yang SUDAH DIJAWAB saja untuk ditampilkan ke publik
        $faqs = Faq::where('status', 'answered')
                   ->orderBy('created_at', 'desc')
                   ->get();

        return view('landing_page.about', compact('faqs'));
    }

    /**
     * Fungsi untuk menyimpan pesan dari form Support ke tabel FAQ
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan data ke model Faq agar muncul di Admin FAQ
        Faq::create([
            // Jika user login, simpan ID-nya. Jika tidak, set null.
            'user_id' => Auth::id(), 
            'question' => "Pesan dari " . $request->name . ": " . $request->message,
            'answer' => null,
            'status' => 'pending', // Status awal pending agar admin tahu perlu dijawab
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim! Admin akan segera menjawabnya di kolom FAQ.');
    }
}