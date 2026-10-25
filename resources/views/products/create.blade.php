@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Tambah Diecast Baru</h3>
        <p class="text-muted small mb-0">Input spesifikasi unit mobil baru ke sistem.</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card card-custom bg-white p-4" style="max-width: 800px;">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Kode SKU / Seri Blister <span class="text-danger">*</span></label>
                <input type="text" name="sku" class="form-control" placeholder="Contoh: RL-HW-R34-05" value="{{ old('sku') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Kategori Diecast <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Nama Mobil & Casting <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: '90 Honda Civic EF Hatchback Red" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Merek / Brand</label>
                <input type="text" name="brand" class="form-control" placeholder="Hot Wheels, Mini GT, Tomica, dll." value="{{ old('brand', 'Hot Wheels') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Skala</label>
                <input type="text" name="scale" class="form-control" value="{{ old('scale', '1:64') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Harga Modal Kulakan (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="purchase_price" class="form-control" min="0" value="{{ old('purchase_price') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Harga Jual Toko (Rp) <span class="text-danger">*</span></label>
                <input type="number" name="selling_price" class="form-control" min="0" value="{{ old('selling_price') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" min="0" value="{{ old('stock', 0) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Batas Minimum Stok (Alert) <span class="text-danger">*</span></label>
                <input type="number" name="minimum_stock" class="form-control" min="0" value="{{ old('minimum_stock', 3) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Foto Kemasan Blister / Diecast</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, WEBP. Maksimal 2MB.</small>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top text-end">
            <button type="submit" class="btn btn-danger px-4"><i class="fa-solid fa-save me-1"></i> Simpan Koleksi</button>
        </div>
    </form>
</div>
@endsection