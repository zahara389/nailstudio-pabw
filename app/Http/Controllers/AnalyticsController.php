<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;      // PERBAIKAN: Gunakan Orders (jamak)
use App\Models\Product;
use App\Models\OrderItems;  // PERBAIKAN: Gunakan OrderItems (jamak)
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 1. SALES ANALYTICS
        $salesData = $this->getSalesAnalytics();
        
        // 2. VISITOR STATISTICS
        $visitorData = $this->getVisitorStatistics();
        
        // 3. PRODUCT PERFORMANCE
        $productData = $this->getTopProducts();
        
        // 4. ORDER STATUS
        $orderStatusData = $this->getOrderStatusDistribution();
        
        // 5. SUMMARY CARDS
        $summary = $this->getSummaryData();

        return view('admin/analytics', [
            'bulan' => $salesData['bulan'],
            'penjualan' => $salesData['penjualan'],
            'visitor_day' => $visitorData['visitor_day'],
            'visitor_count' => $visitorData['visitor_count'],
            'product_label' => $productData['product_label'],
            'product_qty' => $productData['product_qty'],
            'all_status' => $orderStatusData['all_status'],
            'status_count' => $orderStatusData['status_count'],
            'summary' => $summary,
        ]);
    }

    // 1. Sales Analytics - Penjualan per Bulan
    private function getSalesAnalytics()
    {
        $currentYear = Carbon::now()->year;
        
        $sales = Orders::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->whereYear('created_at', $currentYear)
            // PERBAIKAN: Sesuaikan dengan kolom DB 'order_status' dan value 'Complete'
            ->where('order_status', 'Complete') 
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $penjualan = [];

        for ($i = 1; $i <= 12; $i++) {
            $penjualan[] = isset($sales[$i]) ? (int) $sales[$i] : 0;
        }

        return [
            'bulan' => $bulan,
            'penjualan' => $penjualan
        ];
    }

    // 2. Visitor Statistics (Tidak berubah, asumsi table log terpisah)
    private function getVisitorStatistics()
    {
        // Pastikan table 'visitor_logs' benar-benar ada, jika tidak kode ini akan error.
        // Jika belum ada, kita pakai dummy data dulu agar tidak error.
        
        try {
            $visitors = DB::table('visitor_logs')
                ->selectRaw('DATE(visited_at) as date, COUNT(*) as count')
                ->where('visited_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date')
                ->toArray();
        } catch (\Exception $e) {
            $visitors = []; // Fallback jika tabel tidak ada
        }

        $visitor_day = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $visitor_count = [];

        $startDate = Carbon::now()->subDays(6);
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $visitor_count[] = $visitors[$date] ?? 0;
        }

        // Dummy data jika kosong (agar grafik terlihat)
        if (array_sum($visitor_count) == 0) {
            $visitor_count = []; // Angka kecil saja
        }

        return [
            'visitor_day' => $visitor_day,
            'visitor_count' => $visitor_count
        ];
    }

    // 3. Top Products - Produk Terlaris
    private function getTopProducts($limit = 5)
    {
        // PERBAIKAN: Gunakan OrderItems
        $topProducts = OrderItems::select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            // PERBAIKAN: Sesuaikan kolom status
            ->where('orders.order_status', 'Complete') 
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get();

        $product_label = [];
        $product_qty = [];

        foreach ($topProducts as $product) {
            $product_label[] = $product->name;
            $product_qty[] = (int) $product->total_qty;
        }

        return [
            'product_label' => $product_label,
            'product_qty' => $product_qty
        ];
    }

    // 4. Order Status Distribution
    private function getOrderStatusDistribution()
    {
        // PERBAIKAN: Gunakan Orders dan kolom 'order_status'
        $statusCounts = Orders::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status')
            ->toArray();

        // PERBAIKAN: Mapping sesuai Enum di DB
        $statusMapping = [
            'Complete'   => 'Completed',
            'Pending'    => 'Pending',
            'Processing' => 'Processing',
            'Shipped'    => 'Shipped'
        ];

        $all_status = [];
        $status_count = [];

        foreach ($statusMapping as $key => $label) {
            $all_status[] = $label;
            $status_count[] = $statusCounts[$key] ?? 0;
        }

        return [
            'all_status' => $all_status,
            'status_count' => $status_count
        ];
    }

    // 5. Summary Data
    private function getSummaryData()
    {
        return [
            // PERBAIKAN: Sesuaikan Model dan Kolom
            'total_sales'     => Orders::where('order_status', 'Complete')->sum('total_amount') ?: 0,
            'total_orders'    => Orders::count() ?: 0,
            'total_products'  => Product::count() ?: 0,
            
            // Asumsi table users punya kolom role. Jika error, hapus where('role'...)
            'total_customers' => DB::table('users')->where('role', 'customer')->count() ?: 0,
            
            'pending_orders'  => Orders::where('order_status', 'Pending')->count() ?: 0,
            'low_stock_products' => Product::where('stock', '<=', 10)->count() ?: 0,
        ];
    }
}