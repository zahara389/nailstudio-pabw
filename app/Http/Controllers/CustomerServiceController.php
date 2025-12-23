<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Visitor;
use App\Models\Contact; 
use Carbon\Carbon;

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

        // 2. Ambil data FAQ untuk ditampilkan di accordion
        $faqs = Faq::orderBy('id', 'asc')->get();

        return view('landing_page.about', compact('faqs'));
    }

    /**
     * Fungsi untuk menyimpan pesan dari form Hubungi Support
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil terkirim ke tim kami!');
    }
}