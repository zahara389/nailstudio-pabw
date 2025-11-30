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
        $recent_orders = Cart::with(['user', 'items'])
                             ->orderBy('created_at', 'desc')
                             ->limit(10)
                             ->get();
        
        // 2. Total Penjualan (Total Sales)
        $completed_carts = Cart::whereIn('status', ['completed', 'shipped'])
                               ->with('items')
                               ->get();
        
        $total_sales = $completed_carts->sum(function($cart) {
            return $cart->total_price;
        });

        // 3. ✅ Total User yang Order/Aktif Hari Ini (GANTI INI)
        $total_login = Cart::whereDate('created_at', today())
                           ->distinct('user_id')
                           ->count('user_id');
        
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