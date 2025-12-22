<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Visitor; 
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): View
    {
       
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(10)
            ->get();
        
        $totalSales = Order::whereIn('order_status', ['Completed', 'Shipped'])
            ->sum('total_amount');
      
        $visitorsToday = Visitor::whereDate('visit_date', today())->count();

        $totalRegisteredUsers = User::count();

        return view('admin.dashboard', [
            'recent_orders' => $recentOrders,
            'total_sales' => $totalSales,
            'total_login' => $visitorsToday,
            'total_register' => $totalRegisteredUsers,
        ]);
    }

    public function updateStatus(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'new_status' => ['required', 'in:Pending,Processing,Shipped,Completed,Cancelled'],
        ]);

        $order = Order::findOrFail($validated['order_id']);
        $order->order_status = $validated['new_status'];
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }

    public function showDetail($id): View
    {
        // Mengambil detail pesanan tanpa memanggil relasi 'images' yang tidak ada di Model Product
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        
        return view('admin.detail-order', compact('order'));
    }
}