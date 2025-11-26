<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Pesanan Terbaru (Recent Orders)
        // PERBAIKAN: Menggunakan 'created_at' karena di database tidak ada 'order_date'
        $recent_orders = Cart::with('user')
                             ->orderBy('created_at', 'desc')
                             ->limit(10)
                             ->get();
        
        // 2. Total Penjualan (Total Sales)
        // PERBAIKAN: Menghitung manual dari relasi items karena kolom 'total_price' tidak ada di tabel carts
        // Kita hanya menghitung yang statusnya 'checked_out' (sesuai screenshot database)
        $carts_checkout = Cart::where('status', 'checked_out')->with('items')->get();
        
        $total_sales = 0;
        foreach($carts_checkout as $cart) {
            // Menjumlahkan (quantity * unit_price) dari setiap item
            // Pastikan Model CartItem sudah diperbaiki (qty -> quantity, price -> unit_price)
            $total_sales += $cart->items->sum(function($item) {
                return $item->quantity * $item->unit_price;
            });
        }

        // 3. Total Pengunjung (Data Dummy / Simulasi)
        $total_login = 55;
        
        // 4. Total Pendaftar (Menghitung jumlah user terdaftar)
        $total_register = User::count();

        return view('admin.dashboard', compact('recent_orders', 'total_login', 'total_register', 'total_sales'));
    }

    public function updateStatus(Request $request)
    {
        $order_id = $request->input('order_id');
        $new_status = $request->input('new_status');
        
        $cart = Cart::find($order_id);
        
        if ($cart) {
            // Update status pesanan
            $cart->status = $new_status;
            $cart->save();
            
            return redirect()->route('dashboard.index')->with('success', 'Status pesanan berhasil diperbarui.');
        }

        return redirect()->route('dashboard.index')->with('error', 'Pesanan tidak ditemukan.');
    }
    
    public function showDetail($id)
    {
        // Mengambil data cart beserta user dan item produknya
        $order = Cart::with(['user', 'items.product'])->findOrFail($id);
        
        // Mengirim data ke view detail
        $items = $order->items; 

        return view('admin.detail-order', compact('order', 'items'));
    }
}