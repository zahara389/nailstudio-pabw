<?php
// File: app/Http/Controllers/StockManagementController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StockManagementController extends Controller
{
    
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
            
        $statuses = ['draft', 'published', 'low stock'];

        return view('admin.stockmanagement', compact(
            'products',
            'categories',
            'statuses'
        ));
    }

   
    public function create()
    {
        $categories = Product::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->toArray();
            
        return view('admin.products.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaproduct' => 'required|string|max:100',
            'category' => ['required', 'string', Rule::in(['nail polish','nail tools','nail care','nail kit'])],
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => ['nullable', Rule::in(['draft','published','low stock'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->namaproduct,
                'slug' => Str::slug($request->namaproduct),
                'category' => $request->category,
                'stock' => $request->stock,
                'price' => $request->price,
                'discount' => $request->discount ?? 0,
                'description' => $request->description,
                'status' => $request->status ?? 'draft',
            ];
            
            // Handle upload gambar
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $data['image'] = 'uploads/products/' . $imageName;
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

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    
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

    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'namaproduct' => 'required|string|max:100',
            'category' => ['required', 'string', Rule::in(['nail polish','nail tools','nail care','nail kit'])],
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => ['nullable', Rule::in(['draft','published','low stock'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'name' => $request->namaproduct,
                'slug' => Str::slug($request->namaproduct),
                'category' => $request->category,
                'stock' => $request->stock,
                'price' => $request->price,
                'discount' => $request->discount ?? 0,
                'description' => $request->description,
                'status' => $request->status ?? $product->status,
            ];
            
            // Handle upload gambar baru
            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $data['image'] = 'uploads/products/' . $imageName;
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

    
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Hapus file gambar
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $product->delete();

            return redirect()->route('stock.index')
                ->with('success', 'Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    
    public function updateStock(Request $request, $id)
    {
    $request->validate([
        'stock' => 'required|numeric|min:0'
    ]);

    $product = Product::findOrFail($id);
    $product->stock = $request->stock;
    $product->save();

    return back()->with('success', 'Stock berhasil diperbarui!');
    }

    
    public function updatePrice(Request $request, $id)
{
    $request->validate([
        'price' => 'required|numeric|min:0'
    ]);

    $product = Product::findOrFail($id);
    $product->price = $request->price;
    $product->save();

    return back()->with('success', 'Harga berhasil diperbarui!');
}

    
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