<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\File; // Untuk operasi file

class ProductAPIController extends Controller
{
    /**
     * Tampilkan daftar semua produk.
     * GET: /api/products
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        // Menggunakan logika format yang sama dengan ProductAdminController
        $formattedProducts = $products->map(function ($product) {
            $priceDiscounted = $product->final_price;

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
                'slug' => $product->slug, // Tambahkan slug
                'category' => Str::headline($product->category),
                'raw_category' => $product->category, // Nilai kategori asli
                'stock' => (int) $product->stock, // Pastikan integer untuk API
                'price' => (float) $product->price, // Harga asli
                'discount' => (float) $product->discount, // Diskon dalam persen
                'price_discounted' => (float) $priceDiscounted, // Harga setelah diskon
                'status' => $product->status, // Status asli
                'status_text' => $statusText, // Teks status yang diformat
                'status_class' => $statusClass, // Kelas status (optional untuk API, tapi disertakan)
                'added_date' => Carbon::parse($product->created_at)->format('d M Y'),
                'image_url' => asset($product->image ?? 'images/products/default.jpg'), // Menggunakan asset() untuk URL lengkap
            ];
        });

        return response()->json($formattedProducts);
    }

    /**
     * Tampilkan detail produk tertentu berdasarkan ID.
     * GET: /api/products/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        // Format data produk yang akan ditampilkan
        $statusClass = 'status-draft';
        $statusText = ucfirst($product->status);

        if ($product->status === 'published') {
            $statusClass = 'status-published';
        } elseif ($product->status === 'low stock') {
            $statusClass = 'status-low';
            $statusText = 'Low Stock';
        }

        $formattedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => Str::headline($product->category),
            'raw_category' => $product->category,
            'description' => $product->description, // Jika ada
            'stock' => (int) $product->stock,
            'price' => (float) $product->price,
            'discount' => (float) $product->discount,
            'price_discounted' => (float) $product->final_price,
            'status' => $product->status,
            'status_text' => $statusText,
            'status_class' => $statusClass,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'image_url' => asset($product->image ?? 'images/products/default.jpg'),
        ];


        return response()->json($formattedProduct);
    }

    /**
     * Tampilkan detail produk berdasarkan category slug dan product slug.
     * GET: /api/products/{category}/{slug}
     * @param string $category
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function showBySlug(string $category, string $slug)
    {
        // Konversi category slug ke format database (e.g., 'nail-polish' -> 'nail polish')
        $categoryValue = str_replace('-', ' ', $category);

        $product = Product::query()
            ->where('slug', $slug)
            ->where('category', $categoryValue)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        // Format data produk yang akan ditampilkan
        $statusClass = 'status-draft';
        $statusText = ucfirst($product->status);

        if ($product->status === 'published') {
            $statusClass = 'status-published';
        } elseif ($product->status === 'low stock') {
            $statusClass = 'status-low';
            $statusText = 'Low Stock';
        }

        $formattedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => Str::headline($product->category),
            'raw_category' => $product->category,
            'category_slug' => str_replace(' ', '-', $product->category),
            'description' => $product->description,
            'stock' => (int) $product->stock,
            'price' => (float) $product->price,
            'discount' => (float) $product->discount,
            'price_discounted' => (float) $product->final_price,
            'status' => $product->status,
            'status_text' => $statusText,
            'status_class' => $statusClass,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'image_url' => asset($product->image ?? 'images/products/default.jpg'),
        ];

        return response()->json($formattedProduct);
    }

    /**
     * Simpan produk baru.
     * POST: /api/products
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi disesuaikan dengan ProductAdminController
        $validated = $request->validate([
            'namaproduct' => 'required|string|max:100|unique:products,name',
            'category'    => ['required', Rule::in(['nail polish', 'nail tools', 'nail care', 'nail kit'])],
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'status'      => ['required', Rule::in(['draft', 'published', 'low stock'])],
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Untuk upload file via API
        ]);

        $data = [
            'name'     => $validated['namaproduct'],
            'slug'     => Str::slug($validated['namaproduct']),
            'category' => $validated['category'],
            'stock'    => $validated['stock'],
            'price'    => $validated['price'],
            'discount' => $validated['discount'] ?? 0,
            'status'   => $validated['status'] ?? 'draft',
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product berhasil ditambahkan',
            'data' => $product,
        ], 201);
    }

    /**
     * Perbarui produk tertentu.
     * PUT/PATCH: /api/products/{id}
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        // Validasi disesuaikan dengan ProductAdminController, dengan pengecualian unique untuk produk itu sendiri
        $validated = $request->validate([
            'namaproduct' => [
                'required', 'string', 'max:100',
                Rule::unique('products', 'name')->ignore($product->id)
            ],
            'category'    => ['required', Rule::in(['nail polish', 'nail tools', 'nail care', 'nail kit'])],
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0|max:100',
            'status'      => ['required', Rule::in(['draft', 'published', 'low stock'])],
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Untuk upload file via API
        ]);

        $data = [
            'name'     => $validated['namaproduct'],
            'slug'     => Str::slug($validated['namaproduct']),
            'category' => $validated['category'],
            'stock'    => $validated['stock'],
            'price'    => $validated['price'],
            'discount' => $validated['discount'] ?? 0,
            'status'   => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        $product->update($data);

        return response()->json(['message' => 'Product berhasil diperbarui', 'data' => $product]);
    }

    /**
     * Hapus produk tertentu.
     * DELETE: /api/products/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        // Hapus gambar terkait jika ada
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return response()->json(['message' => 'Product berhasil dihapus']);
    }

    /**
     * Cari produk berdasarkan nama atau slug.
     * GET: /api/products/search/{keyword}
     * @param string $keyword
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($keyword)
    {
        $result = Product::search($keyword)->get(); // Menggunakan scopeSearch dari model Product

        if ($result->isEmpty()) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        // Format hasilnya mirip dengan index jika perlu, tapi untuk singkatnya kita kembalikan saja hasilnya
        return response()->json($result);
    }

    /**
     * Filter produk berdasarkan kategori.
     * GET: /api/products/filter/category/{category}
     * @param string $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByCategory($category)
    {
        $data = Product::byCategory($category)->get(); // Menggunakan scopeByCategory dari model Product

        return response()->json([
            'count' => $data->count(),
            'data' => $data,
        ]);
    }

    /**
     * Filter produk berdasarkan status.
     * GET: /api/products/filter/status/{status}
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByStatus($status)
    {
        $data = Product::byStatus($status)->get(); // Menggunakan scopeByStatus dari model Product

        return response()->json([
            'count' => $data->count(),
            'data' => $data,
        ]);
    }

    /**
     * Paginasi produk.
     * GET: /api/products/paginate
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate(Request $request)
    {
        // Ambil jumlah per halaman dari query string, default 10
        $perPage = $request->get('per_page', 10);
        $data = Product::orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'current_page' => $data->currentPage(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'last_page' => $data->lastPage(),
            'data' => $data->items(),
        ]);
    }
}