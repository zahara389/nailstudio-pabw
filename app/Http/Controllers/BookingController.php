<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;
use Carbon\Carbon; 

class BookingController extends Controller
{
    public function create()
    {
        $timeSlots = [
            '10:00', '12:00',  '14:00',  '16:00', '18:00'
        ];
        return view('landing_page.booking', compact('timeSlots'));
    }

    
    public function store(Request $request)
    {
        // 1. Validasi Input 
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'], 
            'location'       => ['required', 'string', 'max:255'],
            'service'        => ['required', 'string', 'max:255'],
            'date'           => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'], 
            'time'           => ['required', 'date_format:H:i'], 
            'notes'          => ['nullable', 'string'],
            'agreement'      => ['required', 'accepted'], 
        ]);
        
        // 2. Cek Bentrok Jadwal
        $is_booked = Booking::where('booking_date', $validated['date'])
                            ->where('booking_time', $validated['time'])
                            ->whereIn('status', ['pending', 'confirmed']) 
                            ->exists();

        if ($is_booked) {
             return back()->withInput()->withErrors([
                 'time' => 'Maaf, slot waktu ini (' . $validated['time'] . ') sudah terisi. Silakan pilih jam lain.'
             ]);
        }
        
        // 3. Penyimpanan Data ke Database 
        Booking::create([
            'user_id'         => Auth::id(), 
            'customer_name'   => $validated['customer_name'],
            'customer_email'  => $validated['customer_email'],
            'customer_phone'  => $validated['customer_phone'], 
            'location'        => $validated['location'],
            'service'         => $validated['service'],
            'booking_date'    => $validated['date'],
            'booking_time'    => $validated['time'],
            'notes'           => $validated['notes'],
            'status'          => 'pending', 
        ]);

        return back()->with('alert', 
            'Pemesanan untuk layanan ' . $validated['service'] . 
            ' pada ' . $validated['date'] . ' berhasil dikirim! Tim kami akan menghubungi Anda melalui WhatsApp.'
        );
    }
}