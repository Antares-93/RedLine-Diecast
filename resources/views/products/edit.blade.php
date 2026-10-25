@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Edit Data Diecast</h3>
        <p class="text-muted small mb-0">Ubah detail spesifikasi unit mobil.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card card-custom bg-white p-4" style="max-width: 800px;">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Kode SKU / Seri Blister</label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Kategori Diecast</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Nama Mobil & Casting</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Merek / Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Skala</label>
                <input type="text" name="scale" class="form-control" value="{{ old('scale', $product->scale) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Harga Modal Kulakan (Rp)</label>
                <input type="number" name="purchase_price" class="form-control" min="0" value="{{ old('purchase_price', $product->purchase_price) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Harga Jual Toko (Rp)</label>
                <input type="number" name="selling_price" class="form-control" min="0" value="{{ old('selling_price', $product->selling_price) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Stok Aktual</label>
                <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', $product->stock) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Batas Minimum Stok</label>
                <input type="number" name="minimum_stock" class="form-control" min="0" value="{{ old('minimum_stock', $product->minimum_stock) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Ganti Foto Fisik</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset($product->image) }}" alt="Preview" style="height: 70px; border-radius: 6px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
        </div>
        <div class="mt-4 pt-3 border-top text-end">
            <button type="submit" class="btn btn-danger px-4"><i class="fa-solid fa-save me-1"></i> Perbarui Data</button>
        </div>
    </form>
</div>
@endsection