<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockManagementController extends Controller
{
    // Data Dummy Statis (Mereplikasi tabel 'product')
    private function getAllDummyProducts()
    {
        return [
            ['id_product' => 101, 'namaproduct' => 'Gel Polish A', 'category' => 'Gel Polish', 'stock' => 50, 'price' => 250000, 'discount' => 10, 'status' => 'published'],
            ['id_product' => 102, 'namaproduct' => 'UV Lamp Pro', 'category' => 'Equipment', 'stock' => 5, 'price' => 850000, 'discount' => 0, 'status' => 'low stock'],
            ['id_product' => 103, 'namaproduct' => 'Cuticle Oil Pen', 'category' => 'Tools', 'stock' => 0, 'price' => 50000, 'discount' => 0, 'status' => 'draft'],
            ['id_product' => 104, 'namaproduct' => 'Nail Buffer Kit', 'category' => 'Tools', 'stock' => 15, 'price' => 120000, 'discount' => 5, 'status' => 'published'],
            ['id_product' => 105, 'namaproduct' => 'Acrylic Powder', 'category' => 'Powders', 'stock' => 2, 'price' => 180000, 'discount' => 0, 'status' => 'low stock'],
            ['id_product' => 106, 'namaproduct' => 'Base Coat', 'category' => 'Gel Polish', 'stock' => 100, 'price' => 100000, 'discount' => 15, 'status' => 'published'],
        ];
    }

    /**
     * Menampilkan daftar produk dengan pagination.
     */
    public function index(Request $request)
    {
        $allProducts = $this->getAllDummyProducts();
        
        // Ambil data unik untuk Filter
        $categories = collect($allProducts)->pluck('category')->unique()->sort()->values()->toArray();
        $statuses = collect($allProducts)->pluck('status')->unique()->sort()->values()->toArray();

        // Logika Pagination
        $page = $request->query('page', 1);
        $perPage = 2; // Mengurangi perPage agar mudah diuji
        $totalProducts = count($allProducts);
        $totalPages = ceil($totalProducts / $perPage);
        $offset = ($page - 1) * $perPage;
        
        // Simulasi array_slice
        $products = array_slice($allProducts, $offset, $perPage);

        return view('admin/stockmanagement', compact(
            'products', 
            'categories', 
            'statuses', 
            'page', 
            'totalPages'
        ));
    }

    /**
     * AJAX Endpoint: Simulasi Tambah Stock
     */
    public function updateStock(Request $request)
    {
        // Ganti 'stock_management.php' dengan endpoint ini
        $request->validate([
            'id_product' => 'required|integer',
            'add_stock' => 'required|integer|min:1',
        ]);

        // LOGIKA SIMULASI DB: UPDATE product SET stock = stock + ?
        return Response::json(['success' => true, 'message' => 'Stock berhasil ditambah (Simulasi)!']);
    }

    /**
     * AJAX Endpoint: Simulasi Update Harga dan Diskon
     */
    public function updatePrice(Request $request)
    {
        // Ganti 'stock_management.php' dengan endpoint ini
        $request->validate([
            'id_product' => 'required|integer',
            'price' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        // LOGIKA SIMULASI DB: UPDATE product SET price = ?, discount = ?
        return Response::json(['success' => true, 'message' => 'Harga berhasil diupdate (Simulasi)!']);
    }
}
