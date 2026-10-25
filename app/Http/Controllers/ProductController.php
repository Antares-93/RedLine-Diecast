<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Fitur Pencarian & Filter Brand/Kategori
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'sku'            => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'           => ['required', 'string', 'max:255'],
            'brand'          => ['nullable', 'string', 'max:100'],
            'scale'          => ['required', 'string', 'max:20'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price'  => ['required', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'minimum_stock'  => ['required', 'integer', 'min:0'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $validated['image'] = 'uploads/products/' . $filename;
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Koleksi diecast berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'sku'            => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'name'           => ['required', 'string', 'max:255'],
            'brand'          => ['nullable', 'string', 'max:100'],
            'scale'          => ['required', 'string', 'max:20'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price'  => ['required', 'numeric', 'min:0'],
            'stock'          => ['required', 'integer', 'min:0'],
            'minimum_stock'  => ['required', 'integer', 'min:0'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $validated['image'] = 'uploads/products/' . $filename;
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Data diecast berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Cegah hapus bila produk sudah tercatat di transaksi penjualan/pembelian
        if ($product->saleItems()->exists() || $product->purchaseItems()->exists()) {
            return back()->with('error', 'Produk ini tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk diecast berhasil dihapus.');
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
        ]);

        if ($request->hasFile('banner_image')) {
            foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                $oldPath = public_path('uploads/hero_banner.' . $ext);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('banner_image');
            $filename = 'hero_banner.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        return back()->with('success', 'Foto diecast di Hero Banner berhasil diperbarui!');
    }
}