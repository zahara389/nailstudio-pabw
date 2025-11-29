<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // Konstruktor kini kosong, middleware diatur di routes/web.php

    /**
     * Menampilkan formulir booking (GET)
     */
    public function create()
    {
        return view('landing_page.booking');
    }

    /**
     * Menyimpan data pemesanan ke database (POST)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:15'], 

            'location'       => ['required', 'string', 'max:255'],
            'service'        => ['required', 'string', 'max:255'],
            
            // Nama input dari form adalah 'date' dan 'time'
            'date'           => ['required', 'date', 'after_or_equal:today'],
            'time'           => ['required', 'date_format:H:i'], 
            
            'notes'          => ['nullable', 'string'],
            'agreement'      => ['required', 'accepted'], 
        ]);
        
        // 2. Pemetaan dan Penyimpanan Data ke Database
        Booking::create([
            'user_id'         => Auth::id(), 
            
            // Mapping Kontak
            'customer_name'   => $validated['customer_name'],
            'customer_email'  => $validated['customer_email'],
            'customer_phone'  => $validated['customer_phone'], 
            
            // Mapping Layanan & Waktu
            'location'        => $validated['location'],
            'service'         => $validated['service'],
            'booking_date'    => $validated['date'], // Mapping: date (form) -> booking_date (DB)
            'booking_time'    => $validated['time'], // Mapping: time (form) -> booking_time (DB)
            
            'notes'           => $validated['notes'],
            'status'          => 'pending', 
        ]);

      return back()->with('alert', 
    'Pemesanan untuk layanan ' . $validated['service'] . 
    ' pada ' . $validated['date'] . 
    ' berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp.'
);
    }
}