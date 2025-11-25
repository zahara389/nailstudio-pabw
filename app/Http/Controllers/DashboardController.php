<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart; // Asumsi Model Cart sudah dibuat
use App\Models\User; // Asumsi Model User sudah dibuat

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Pesanan Terbaru (Recent Orders)
        // Ambil 5-10 pesanan terbaru. 
        // Asumsi: Kita hanya mengambil data yang paling penting untuk ditampilkan di dashboard.
        $recent_orders = Cart::with('user') // Asumsi relasi 'user' ada di model Cart
                             ->orderBy('order_date', 'desc')
                             ->limit(10)
                             ->get();
        
        // 2. Total Penjualan (Total Sales)
        // Menjumlahkan kolom total_price dari pesanan yang sudah Selesai (Completed).
        $total_sales = Cart::where('status', 'Completed')->sum('total_price');

        // 3. Total Pengunjung (Visitors - menggunakan simulasi untuk sementara)
        // Karena tabel visitor_logs terlihat kompleks, kita bisa simulasikan atau mengimplementasikannya
        // nanti. Untuk saat ini, kita ikuti variabel Anda.
        $total_login = 55; // Nanti bisa diganti dengan query ke visitor_logs
        
        // 4. Total Pendaftar (Total Register)
        $total_register = User::count(); // Menghitung total pengguna terdaftar

        return view('admin/dashboard', compact('recent_orders', 'total_login', 'total_register', 'total_sales'));
    }

    public function updateStatus(Request $request)
    {
        // Ganti simulasi dengan update database yang sebenarnya
        $order_id = $request->input('order_id');
        $new_status = $request->input('new_status');
        
        $cart = Cart::find($order_id);
        if ($cart) {
            $cart->status = $new_status;
            $cart->save();
            return redirect()->route('dashboard.index')->with('success', 'Status pesanan ID ' . $order_id . ' berhasil diupdate.');
        }

        return redirect()->route('dashboard.index')->with('error', 'Pesanan tidak ditemukan.');
    }
    
    // Fungsi showDetail akan membutuhkan data relasi yang lebih kompleks (cart_items)
    public function showDetail($id)
    {
        // Untuk showDetail, Anda perlu mengambil data Cart beserta detail itemnya (cart_items)
        $order = Cart::with(['user', 'items']) // Asumsi relasi 'items' ada ke cart_items
                     ->findOrFail($id);
                     
        $items = $order->items; // Mengambil koleksi item dari relasi

        return view('admin/detail-order', compact('order', 'items'));
    }
}