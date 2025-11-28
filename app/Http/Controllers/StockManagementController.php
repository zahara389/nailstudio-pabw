<?php
// File: app/Http/Controllers/StockManagementController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockManagementController extends Controller
{
    /**
     * ========================================
     * INDEX - Tampilkan list produk
     * ========================================
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $search = $request->query('search');
        $category = $request->query('category');
        $status = $request->query('status');
        $sortStock = $request->query('sort_stock');

        // Build query dengan filters
        $query = Product::query();

        // Search berdasarkan nama produk
        if ($search) {
            $query->search($search);
        }

        // Filter berdasarkan kategori
        if ($category) {
            $query->byCategory($category);
        }

        // Filter berdasarkan status
        if ($status) {
            $query->byStatus($status);
        }

        // Sort berdasarkan stock
        if ($sortStock === 'asc') {
            $query->orderBy('stock', 'asc');
        } elseif ($sortStock === 'desc') {
            $query->orderBy('stock', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        // Pagination
        $products = $query->paginate($perPage);
        
        // Data untuk dropdown filter
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
            
        $statuses = ['published', 'low stock', 'draft'];

        return view('admin.stockmanagement', compact(
            'products',
            'categories',
            'statuses'
        ));
    }

    /**
     * ========================================
     * CREATE - Tampilkan form tambah produk
     * ========================================
     */
    public function create()
    {
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
            
        return view('admin.products.create', compact('categories'));
    }

    /**
     * ========================================
     * STORE - Simpan produk baru
     * ========================================
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaproduct' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except('image');
            
            // Handle upload gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $data['image'] = $imageName;
            }

            Product::create($data);

            return redirect()->route('stock.index')
                ->with('success', 'Produk berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * ========================================
     * SHOW - Tampilkan detail produk
     * ========================================
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * ========================================
     * EDIT - Tampilkan form edit produk
     * ========================================
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
            
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * ========================================
     * UPDATE - Update produk
     * ========================================
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'namaproduct' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->except('image');
            
            // Handle upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                    unlink(public_path('uploads/products/' . $product->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $data['image'] = $imageName;
            }

            $product->update($data);

            return redirect()->route('stock.index')
                ->with('success', 'Produk berhasil diperbarui!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * ========================================
     * DESTROY - Hapus produk
     * ========================================
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Hapus file gambar
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            
            $product->delete();

            return redirect()->route('stock.index')
                ->with('success', 'Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * ========================================
     * AJAX - Tambah stock (Modal)
     * ========================================
     */
    public function updateStock(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'add_stock' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($request->id);
            $product->addStock($request->add_stock);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stock berhasil ditambahkan!',
                'new_stock' => $product->stock,
                'status' => $product->status
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal menambah stock: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ========================================
     * AJAX - Update harga & diskon (Modal)
     * ========================================
     */
    public function updatePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($request->id);
            $product->updatePrice($request->price, $request->discount);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Harga berhasil diperbarui!',
                'new_price' => $product->price,
                'new_discount' => $product->discount,
                'formatted_price' => $product->formatted_price
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal memperbarui harga: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ========================================
     * BULK DELETE - Hapus banyak produk
     * ========================================
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first()
            ], 400);
        }

        try {
            DB::beginTransaction();
            
            $products = Product::whereIn('id', $request->ids)->get();
            
            foreach ($products as $product) {
                if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                    unlink(public_path('uploads/products/' . $product->image));
                }
                $product->delete();
            }
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' produk berhasil dihapus!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }
}