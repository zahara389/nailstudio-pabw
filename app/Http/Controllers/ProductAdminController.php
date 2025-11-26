<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('added', 'desc')->get();
        
        $formattedProducts = [];

        foreach ($products as $product) {
            $statusClass = 'status-draft';
            $statusText = 'Draft';
            
            switch ($product->status) {
                case 'published': 
                    $statusClass = 'status-published'; 
                    $statusText = 'Published'; 
                    break;
                case 'low stock': 
                    $statusClass = 'status-low'; 
                    $statusText = 'Low Stock'; 
                    break;
                case 'out of stock':
                    $statusClass = 'status-draft';
                    $statusText = 'Out of Stock'; 
                    break;
                default: 
                    if ($product->stock == 0) {
                        $statusText = 'Out of Stock';
                    }
                    break;
            }

            $formattedProducts[] = [
                'id' => $product->id_product,
                'name' => $product->namaproduct,
                'category' => $product->category,
                'stock' => $product->stock,
                'price' => number_format($product->price, 0, ',', '.'),
                'discount' => $product->discount,
                'price_discounted' => number_format($product->discounted_price, 0, ',', '.'),
                'status_class' => $statusClass,
                'status_text' => $statusText,
                'added_date' => date('d M Y', strtotime($product->added ?? $product->created_at)),
                'image' => $product->image,
            ];
        }

        return view('admin/product', [
            'formattedProducts' => $formattedProducts, 
            'success' => session('success'), 
            'error' => session('error')
        ]);
    }
    
    public function create() 
    { 
        return view('admin/create');
    }
    
    public function store(Request $request) 
    { 
        $request->validate([
            'namaproduct' => 'required|string|max:255|unique:product,namaproduct',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'nullable|in:published,low stock,draft,out of stock',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare data dengan default values
        $data = [
            'namaproduct' => $request->namaproduct,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
            'discount' => $request->discount ?? 0, // Default 0 jika kosong
            'status' => $request->status ?? 'draft', // Default draft jika kosong
            'added' => now(),
        ];

        // Handle upload image jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        } else {
            $data['image'] = null; // atau default image path
        }

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Product berhasil ditambahkan!'); 
    }
    
    public function edit($id) 
    { 
        $product = Product::findOrFail($id);
        return view('admin/edit-product', compact('product'));
    }
    
    public function update(Request $request, $id) 
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'namaproduct' => 'required|string|max:255|unique:product,namaproduct,' . $id . ',id_product',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'nullable|in:published,low stock,draft,out of stock',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Prepare data
        $data = [
            'namaproduct' => $request->namaproduct,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'status' => $request->status ?? $product->status,
        ];

        // Handle upload image jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }
        
        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product berhasil diperbarui!');
    }
    
    public function destroy($id) 
    { 
        $product = Product::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        
        $product->delete();
        
        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus!'); 
    }
}