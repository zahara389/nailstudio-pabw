<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;       
use App\Models\Product;
use App\Models\OrderItem;   
use App\Models\Visitor;     
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        
        $filter = $request->get('filter', 'year');

        $salesData = $this->getSalesAnalytics($filter);
        
        $visitorData = $this->getVisitorStatistics();
        
        $productData = $this->getTopProducts();
        
        $orderStatusData = $this->getOrderStatusDistribution();
        
        $summary = $this->getSummaryData();

        return view('admin.analytics', [
            'filter'        => $filter,
            'bulan'         => $salesData['labels'],
            'penjualan'     => $salesData['data'],
            'visitor_day'   => $visitorData['visitor_day'],
            'visitor_count' => $visitorData['visitor_count'],
            'product_label' => $productData['product_label'],
            'product_qty'   => $productData['product_qty'],
            'all_status'    => $orderStatusData['all_status'],
            'status_count'  => $orderStatusData['status_count'],
            'summary'       => $summary,
        ]);
    }

    private function getSalesAnalytics($filter)
    {
        $labels = [];
        $data = [];

        if ($filter == 'weeks') {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('d M');
                $data[] = (int) Order::where('order_status', 'Completed')
                            ->whereDate('created_at', $date->toDateString())
                            ->sum('total_amount');
            }
        } elseif ($filter == 'month') {
            for ($i = 1; $i <= 4; $i++) {
                $labels[] = "Minggu " . $i;
                $start = Carbon::now()->startOfMonth()->addWeeks($i-1);
                $end = ($i == 4) ? Carbon::now()->endOfMonth() : Carbon::now()->startOfMonth()->addWeeks($i)->subDay();
                
                $data[] = (int) Order::where('order_status', 'Completed')
                            ->whereBetween('created_at', [$start, $end])
                            ->sum('total_amount');
            }
        } else {
            $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
                ->whereYear('created_at', Carbon::now()->year)
                ->where('order_status', 'Completed')
                ->groupBy('month')->pluck('total', 'month')->toArray();

            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            foreach (range(1, 12) as $m) {
                $data[] = (int) ($sales[$m] ?? 0);
            }
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getVisitorStatistics()
    {
        $visitors = Visitor::selectRaw('visit_date as date, COUNT(*) as count')
            ->where('visit_date', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')->pluck('count', 'date')->toArray();

        $visitor_day = [];
        $visitor_count = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $visitor_day[] = $date->format('D');
            $visitor_count[] = $visitors[$date->format('Y-m-d')] ?? 0;
        }

        return ['visitor_day' => $visitor_day, 'visitor_count' => $visitor_count];
    }

    private function getTopProducts()
    {
        $top = OrderItem::select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_status', 'Completed') 
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')->limit(5)->get();

        return [
            'product_label' => $top->pluck('name')->toArray(),
            'product_qty'   => $top->pluck('total_qty')->toArray()
        ];
    }

    private function getOrderStatusDistribution()
    {
        $statusCounts = Order::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')->pluck('count', 'order_status')->toArray();

        // Urutan Tetap untuk Warna Sinkron
        $all_status = ['Completed', 'Pending', 'Processing', 'Shipped', 'Cancelled'];
        $status_count = [];

        foreach ($all_status as $status) {
            $status_count[] = $statusCounts[$status] ?? 0;
        }

        return ['all_status' => $all_status, 'status_count' => $status_count];
    }

    private function getSummaryData()
    {
        return [
            'total_sales'     => Order::where('order_status', 'Completed')->sum('total_amount'),
            'total_orders'    => Order::count(),
            'total_customers' => DB::table('users')->where('role', 'member')->count(),
            'pending_orders'  => Order::where('order_status', 'Pending')->count(),
        ];
    }
}