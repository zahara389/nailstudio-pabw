<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'service' => 'required',
            'date' => 'required',
            'time' => 'required',
            'name' => 'required',
            'phone' => 'required'
        ]);

        // Convert date + time ke DATETIME MySQL
        $start_time = $request->date . ' ' . date("H:i:s", strtotime($request->time));

        // Ambil harga berdasarkan layanan
        $price = $this->getServicePrice($request->service);

        // Simpan ke database
        Booking::create([
            'user_id' => auth()->id() ?? 1, // sementara 1 jika belum login
            'start_time' => $start_time,
            'total_price' => $price,
            'payment_method' => null,
            'payment_status' => 'Pending',
            'status' => 'Scheduled',
            'notes' => "Customer: {$request->name}, Phone: {$request->phone}"
        ]);

        return back()->with('success', 'Booking berhasil dibuat!');
    }

    private function getServicePrice($service)
    {
        return match($service) {
            'Classic Manicure' => 120000,
            'Gel Manicure' => 150000,
            'Nail Art Design' => 180000,
            'Pedicure' => 130000,
            'Nail Extension' => 200000,
            'Nail Care Treatment' => 90000,
            default => 100000
        };
    }
}
