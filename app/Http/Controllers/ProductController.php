<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Visitor; // 1. WAJIB IMPORT MODEL VISITOR
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Tampilkan daftar produk per kategori
    public function index(?string $category = null)
    {
        // 2. LOGIKA MENCATAT VISITOR
        // Baris ini akan mencatat IP address pengunjung berdasarkan tanggal hari ini.
        // Jika IP yang sama mengakses di hari yang sama, data tidak akan diduplikasi (firstOrCreate).
        Visitor::firstOrCreate([
            'ip_address' => request()->ip(),
            'visit_date' => now()->toDateString(),
        ]);

        $categorySlug = $category;
        $allowedCategories = ['nail polish', 'nail tools', 'nail care', 'nail kit'];
        $categoryValue = null;

        if ($categorySlug !== null) {
            $categoryValue = Str::of($categorySlug)->lower()->replace('-', ' ')->toString();

            if (! in_array($categoryValue, $allowedCategories, true)) {
                abort(404);
            }
        }

        $products = Product::query()
            ->when($categoryValue, fn ($query, $value) => $query->where('category', $value))
            ->when(request('status'), fn ($query, $status) => $query->where('status', $status))
            ->orderBy('name')
            ->get();

        if ($products->isEmpty()) {
            $products = collect($this->sampleProducts())
                ->when($categoryValue, fn ($items) => $items->filter(fn ($attributes) => ($attributes['category'] ?? null) === $categoryValue))
                ->map(fn ($attributes) => Product::make($attributes));
        }

        $presentedProducts = $this->mapForList($products);

        return view('products.index', [
            'products' => $presentedProducts,
            'fallbackImage' => $this->fallbackImage(),
            'categorySlug' => $categorySlug,
            'categoryLabel' => $categoryValue ? Str::headline($categoryValue) : null,
        ]);
    }

    // Detail produk per slug + kategori
    public function show(string $category, string $slug)
    {
        // Opsional: Jika Anda ingin menghitung kunjungan saat melihat detail produk juga,
        // Anda bisa memindahkan logika Visitor::firstOrCreate ke sini atau ke Middleware.
        
        $product = Product::query()
            ->where('slug', $slug)
            ->first();

        if (! $product) {
            $product = Product::make($this->sampleProducts()[0]);
        }

        $presentedProduct = $this->mapForDetail($product);

        return view('products.show', [
            'product' => $presentedProduct,
            'fallbackImage' => $this->fallbackImage(),
        ]);
    }

    // Search products
    public function search()
    {
        $query = request('q', '');
        $searchTerm = trim($query);
        
        Visitor::firstOrCreate([
            'ip_address' => request()->ip(),
            'visit_date' => now()->toDateString(),
        ]);

        if (strlen($searchTerm) < 2) {
            return redirect()->route('products.index')
                ->with('message', 'Mohon ketik minimal 2 karakter untuk pencarian.');
        }

        // Search in name, category, and description
        $products = Product::query()
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        $presentedProducts = $this->mapForList($products);

        return view('products.search', [
            'products' => $presentedProducts,
            'searchQuery' => $searchTerm,
            'resultCount' => $products->count(),
            'fallbackImage' => $this->fallbackImage(),
        ]);
    }

    // ... (Sisa method mapForList, mapForDetail, sampleProducts, fallbackImage, dan slugify tetap sama)
    
    private function mapForList(Collection $products)
    {
        $fallbackImage = $this->fallbackImage();
        $statusMap = [
            'published' => ['label' => 'Tersedia', 'classes' => 'bg-emerald-100 text-emerald-600'],
            'low stock' => ['label' => 'Stok Menipis', 'classes' => 'bg-amber-100 text-amber-600'],
            'draft' => ['label' => 'Segera Hadir', 'classes' => 'bg-slate-100 text-slate-500'],
        ];

        return $products->values()->map(function (Product $product, int $index) use ($fallbackImage, $statusMap) {
            $imagePath = $product->image;
            $imageUrl = $fallbackImage;

            if ($imagePath) {
                if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    $imageUrl = $imagePath;
                } elseif (Str::startsWith($imagePath, ['storage/', 'images/', 'img/', 'uploads/'])) {
                    $imageUrl = asset($imagePath);
                } else {
                    $imageUrl = asset('storage/' . ltrim($imagePath, '/'));
                }
            }

            $statusInfo = $statusMap[$product->status] ?? ['label' => 'Status tidak diketahui', 'classes' => 'bg-slate-100 text-slate-500'];

            $product->setAttribute('card_number', str_pad($index + 1, 2, '0', STR_PAD_LEFT));
            $product->setAttribute('image_url', $imageUrl);
            $product->setAttribute('status_label', $statusInfo['label']);
            $product->setAttribute('status_classes', $statusInfo['classes']);
            $product->setAttribute('stock_label', $product->stock > 0 ? 'Stok ' . max(0, $product->stock) : 'Pre-order');
            $product->setAttribute('has_discount', $product->discount > 0);
            $product->setAttribute('added_formatted', optional($product->created_at)->translatedFormat('d M Y'));
            $product->setAttribute('slug', $product->slug ?: $this->slugify($product->name));
            $product->setAttribute('category_label', Str::headline($product->category ?? 'Kategori'));
            $product->setAttribute('category_slug', $this->slugify($product->category ?? 'kategori'));

            return $product;
        });
    }

    private function mapForDetail(Product $product)
    {
        $fallbackImage = $this->fallbackImage();
        $imagePath = $product->image;
        $imageUrl = $fallbackImage;

        if ($imagePath) {
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $imageUrl = $imagePath;
            } elseif (Str::startsWith($imagePath, ['storage/', 'images/', 'img/', 'uploads/'])) {
                $imageUrl = asset($imagePath);
            } else {
                $imageUrl = asset('storage/' . ltrim($imagePath, '/'));
            }
        }

        $product->setAttribute('image_url', $imageUrl);
        $product->setAttribute('slug', $product->slug ?: $this->slugify($product->name));
        $product->setAttribute('category_label', Str::headline($product->category ?? 'kategori'));
        $product->setAttribute('category_slug', $this->slugify($product->category ?? 'kategori'));

        $stockQuantity = max(0, (int) $product->stock);
        $inStock = $stockQuantity > 0;
        $product->setAttribute('stock_quantity', $stockQuantity);
        $product->setAttribute('is_in_stock', $inStock);
        $product->setAttribute('stock_status_text', $inStock ? 'Stok tersedia' : 'Stok habis');
        $product->setAttribute('stock_status_badge_class', $inStock ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600');
        $product->setAttribute('stock_hint', $inStock ? 'Siap dikirim segera' : 'Hubungi kami untuk pre-order atau ketersediaan terbaru');

        $product->setAttribute('final_price', $product->final_price);
        $product->setAttribute('minimum_quantity', 1);

        return $product;
    }

    private function sampleProducts(): array
    {
        return [
            [
                'name' => 'Pink Blossom Gel Art',
                'slug' => 'pink-blossom-gel-art',
                'category' => 'nail polish',
                'stock' => 12,
                'price' => 185000,
                'status' => 'published',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=640&q=80',
                'discount' => 15,
                'description' => 'Koleksi nail art bertema bunga dengan detail manik yang memesona untuk acara spesial.',
                'created_at' => now()->subDays(3),
            ],
            [
                'name' => 'Aurora Chrome Tips',
                'slug' => 'aurora-chrome-tips',
                'category' => 'nail kit',
                'stock' => 0,
                'price' => 210000,
                'status' => 'draft',
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=640&q=80',
                'discount' => 0,
                'description' => 'Efek chrome gradasi ala aurora borealis untuk tampilan futuristik dan elegan.',
                'created_at' => now()->subWeek(),
            ],
            [
                'name' => 'Minimalist Nude Set',
                'slug' => 'minimalist-nude-set',
                'category' => 'nail care',
                'stock' => 25,
                'price' => 135000,
                'status' => 'published',
                'image' => 'https://images.unsplash.com/photo-1519014816548-bf5fe059798b?auto=format&fit=crop&w=640&q=80',
                'discount' => 5,
                'description' => 'Pilihan warna nude yang lembut dengan detail garis minimalis untuk keseharian.',
                'created_at' => now()->subDays(10),
            ],
        ];
    }

    private function fallbackImage(): string
    {
        return 'https://via.placeholder.com/640x480?text=Nail+Art';
    }

    private function slugify(string $value): string
    {
        return Str::of($value)->lower()->replace(' ', '-')->slug('-');
    }
}