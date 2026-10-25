@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-white">RedLine</h3>
        <p class="text-secondary small mb-0">Jelajahi seluruh stok fisik miniatur mobil RedLine Store.</p>
    </div>
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
    <div>
        <a href="{{ route('products.create') }}" class="btn-pill-red">
            <i class="fa-solid fa-plus me-1"></i> Tambah Diecast Baru
        </a>
    </div>
    @endif
</div>

<div class="card-custom p-2 mb-4" style="background: rgba(22, 22, 31, 0.95); border-radius: 9999px; border: 1px solid rgba(255,255,255,0.12);">
    <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-wrap align-items-center justify-content-between gap-3 px-3 py-1">
        <div class="d-flex align-items-center flex-grow-1 gap-2">
            <i class="fa-solid fa-magnifying-glass text-danger"></i>
            <input type="text" name="search" class="border-0 bg-transparent text-white w-100" style="outline: none; font-size: 0.92rem;" placeholder="Cari nama mobil, brand (Hot Wheels/Mini GT), atau kode SKU..." value="{{ request('search') }}">
        </div>

        <div class="d-none d-md-block" style="width: 1px; height: 30px; background: rgba(255, 255, 255, 0.12);"></div>

        <div class="d-flex align-items-center gap-2" style="min-width: 200px;">
            <i class="fa-solid fa-tags text-secondary"></i>
            <select name="category_id" class="border-0 bg-transparent text-white w-100" style="outline: none; font-size: 0.92rem;">
                <option value="" style="background: #181820; color: #fff;">Semua Kategori Diecast</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }} style="background: #181820; color: #fff;">
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-pill-red px-4 py-2" style="font-size: 0.85rem;">
                Filter
            </button>
            @if(request('search') || request('category_id'))
                <a href="{{ route('products.index') }}" class="btn-pill-outline py-2 px-3" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- GRID KATALOG KOMPAK 4 - 5 KOLOM PER BARIS -->
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 mb-4">
    @forelse($products as $product)
    <div class="col">
        <div class="card-custom h-100 overflow-hidden d-flex flex-column justify-content-between" style="border-radius: 18px;">
            <!-- FRAME BLISTER CARD KOMPAK (RASIO HOT WHEELS 108:165) -->
            <div class="position-relative m-2 rounded-3 overflow-hidden shadow-sm" style="aspect-ratio: 108 / 165; background: #0f0f15; border: 1px solid rgba(255, 255, 255, 0.08);">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                @else
                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="fa-solid fa-car-side text-secondary display-5 opacity-25 mb-1"></i>
                        <span class="text-secondary opacity-50" style="font-size: 0.65rem;">Blister Card</span>
                    </div>
                @endif

                <!-- BADGE SKALA & STOK -->
                <span class="position-absolute top-0 start-0 m-1 badge bg-dark border border-secondary border-opacity-50 rounded-pill" style="font-size: 0.65rem; padding: 0.2rem 0.45rem;">
                    {{ $product->scale }}
                </span>
                <span class="position-absolute top-0 end-0 m-1 badge {{ $product->stock > $product->minimum_stock ? 'bg-success' : ($product->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill" style="font-size: 0.65rem; padding: 0.2rem 0.45rem;">
                    Stok: {{ $product->stock }}
                </span>
            </div>

            <!-- DETAIL DIECAST -->
            <div class="p-2 pt-0 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-danger fw-bold" style="font-size: 0.75rem;">{{ $product->brand ?? 'Diecast' }}</span>
                        <small class="text-secondary" style="font-size: 0.7rem;">{{ Str::limit($product->category->name, 12) }}</small>
                    </div>
                    <div class="fw-bold text-white text-truncate mb-1" style="font-size: 0.86rem;" title="{{ $product->name }}">
                        {{ $product->name }}
                    </div>
                    
                    <!-- TAG SKU -->
                    <div class="mb-2">
                        <span style="color: #cbd5e1; font-size: 0.68rem; background: #0f0f14; padding: 0.15rem 0.45rem; border-radius: 5px; border: 1px solid rgba(255, 255, 255, 0.12);">
                            SKU: <strong>{{ $product->sku }}</strong>
                        </span>
                    </div>
                </div>

                <div class="pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-secondary d-block" style="font-size: 0.65rem;">Harga Jual</small>
                        <span class="fw-bold text-white" style="font-size: 0.95rem;">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
                    </div>
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <div class="text-end">
                        <small class="text-secondary d-block" style="font-size: 0.65rem;">Modal</small>
                        <span class="text-secondary" style="font-size: 0.75rem;">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="p-2 pt-0 border-0">
                <div class="d-flex gap-1">
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <a href="{{ route('products.edit', $product->id) }}" class="btn-pill-outline btn-sm flex-fill text-center py-1" style="font-size: 0.78rem;">
                            Edit
                        </a>
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus unit diecast ini?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 29px; height: 29px;" title="Hapus Unit">
                                <i class="fa-solid fa-trash" style="font-size: 0.72rem;"></i>
                            </button>
                        </form>
                        @endif
                    @else
                        <a href="{{ route('sales.create', ['product_id' => $product->id]) }}" class="btn-pill-red btn-sm w-100 justify-content-center py-1" style="font-size: 0.8rem;">
                            Beli Unit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fa-solid fa-car-side fs-1 text-secondary opacity-50 mb-3 d-block"></i>
        <h5 class="text-white">Tidak ada koleksi diecast yang ditemukan</h5>
        <p class="text-secondary small">Coba ubah kata kunci pencarian atau reset filter kategori.</p>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection