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
        try {
            Visitor::firstOrCreate([
                'ip_address' => request()->ip(),
                'visit_date' => Carbon::now()->toDateString(),
            ]);
        } catch (\Exception $e) {

        }

        $faqs = Faq::where('status', 'answered')
                   ->orderBy('created_at', 'desc')
                   ->get();

        return view('landing_page.about', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Faq::create([
            'user_id' => Auth::id(), 
            'question' => "Pesan dari " . $request->name . ": " . $request->message,
            'answer' => null,
            'status' => 'pending', 
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim! Admin akan segera menjawabnya di kolom FAQ.');
    }
}