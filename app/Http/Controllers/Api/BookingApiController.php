<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15|regex:/^[0-9]+$/',
            'location'       => 'required|string|max:255',
            'service'        => 'required|string|max:255',
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required|date_format:H:i',
            'notes'          => 'nullable|string',
        ]);

        // cek bentrok jadwal
        $isBooked = Booking::where('booking_date', $validated['date'])
            ->where('booking_time', $validated['time'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return response()->json([
                'success' => false,
                'message' => 'Slot waktu sudah terisi, silakan pilih jam lain'
            ], 409);
        }

        $booking = Booking::create([
            'user_id'        => Auth::id(),
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'location'       => $validated['location'],
            'service'        => $validated['service'],
            'booking_date'   => $validated['date'],
            'booking_time'   => $validated['time'],
            'notes'          => $validated['notes'] ?? null,
            'status'         => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dikirim',
            'data' => $booking
        ], 201);
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Booking::orderBy('created_at', 'desc')->get()
        ]);
    }
}
