<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str; 
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        
        // Format products untuk view
        $formattedProducts = $products->map(function($product) {
            $priceDiscounted = $product->final_price;
            
            // Tentukan status class dan text
            $statusClass = 'status-draft';
            $statusText = ucfirst($product->status);
            
            if ($product->status === 'published') {
                $statusClass = 'status-published';
            } elseif ($product->status === 'low stock') {
                $statusClass = 'status-low';
                $statusText = 'Low Stock';
            }
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => Str::headline($product->category),
                'stock' => number_format($product->stock),
                'price' => number_format($product->price, 0, ',', '.'),
                'discount' => $product->discount,
                'price_discounted' => number_format($priceDiscounted, 0, ',', '.'),
                'status_class' => $statusClass,
                'status_text' => $statusText,
                'added_date' => Carbon::parse($product->created_at)->format('d M Y'),
                'image' => $product->image ?? 'images/products/default.jpg',
            ];
        });
        
        return view('admin/product', compact('formattedProducts'));
    }

    public function create() 
    { 
        return view('admin/create');
    }

    public function store(Request $request) 
    { 
        $request->validate([
            'namaproduct' => 'required|string|max:100|unique:products,name',
            'category'    => ['required', Rule::in(['nail polish','nail tools','nail care','nail kit'])],
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'status'      => ['required', Rule::in(['draft', 'published', 'low stock'])],
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'     => $request->namaproduct,
            'slug'     => Str::slug($request->namaproduct),
            'category' => $request->category,
            'stock'    => $request->stock,
            'price'    => $request->price,
            'discount' => $request->discount ?? 0,
            'status'   => $request->status ?? 'draft',
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Product berhasil ditambahkan!'); 
    }

    public function edit($id) 
    { 
        $product = Product::findOrFail($id);
        return view('admin/edit', compact('product'));
    }

    public function update(Request $request, $id) 
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'namaproduct' => [
            'required', 'string', 'max:100', 
                Rule::unique('products', 'name')->ignore($product->id)
            ],
            'category'    => ['required', Rule::in(['nail polish','nail tools','nail care','nail kit'])],
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'status'      => ['required', Rule::in(['draft', 'published', 'low stock'])],
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'     => $request->namaproduct,
            'slug'     => Str::slug($request->namaproduct),
            'category' => $request->category,
            'stock'    => $request->stock,
            'price'    => $request->price,
            'discount' => $request->discount ?? 0,
            'status'   => $request->status,
        ];

        if ($request->hasFile('image')) {
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

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus!'); 
    }
}