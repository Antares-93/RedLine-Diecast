@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-white mb-1">
            {{ auth()->user()->isCustomer() ? 'Beli Koleksi Diecast' : 'Transaksi Penjualan Kasir' }}
        </h3>
        <p class="text-secondary small mb-0">
            {{ auth()->user()->isCustomer() ? 'Pilih miniatur mobil yang ingin kamu beli dan tentukan jumlah unitnya.' : 'Input transaksi kasir untuk pembelian offline maupun online.' }}
        </p>
    </div>
    <a href="{{ route('products.index') }}" class="btn-pill-outline">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom p-4 mb-4">
            <h5 class="fw-bold text-white mb-3">Item Pembelian</h5>

            <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                @csrf

                <!-- DAFTAR ITEM DINAMIS -->
                <div id="itemsContainer">
                   <div class="item-row p-3 rounded-4 mb-3" style="background: #101017; border: 1px solid rgba(255,255,255,0.08);">
                        <div class="d-flex align-items-center gap-4">
                            
                            <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
                                style="width: 115px; height: 140px; background: #0b0b0e; border: 1px solid rgba(255,255,255,0.15);">
                                <img src="" class="product-preview-img w-100 h-100" style="object-fit: cover; display: none;" alt="Diecast">
                                <i class="fa-solid fa-car text-secondary product-placeholder-icon fs-1"></i>
                            </div>

                            <div class="row g-3 align-items-end flex-grow-1">
                                <div class="col-md-5">
                                    <label class="form-label small text-secondary fw-semibold">Pilih Unit Diecast</label>
                                    <select name="items[0][product_id]" class="form-select product-select" required onchange="updateRow(this)">
                                        <option value="" data-price="0" data-stock="0" data-image="">-- Pilih Unit Diecast --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    data-price="{{ $product->selling_price }}" 
                                                    data-stock="{{ $product->stock }}"
                                                    data-image="{{ $product->image ? asset($product->image) : '' }}"
                                                    {{ (request('product_id') == $product->id) ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->brand }}) — Sisa Stok: {{ $product->stock }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small text-secondary fw-semibold">Harga Satuan</label>
                                    <input type="text" class="form-control price-display" value="Rp 0" readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small text-secondary fw-semibold">Jumlah (Qty)</label>
                                    <input type="number" name="items[0][quantity]" class="form-control qty-input" min="1" value="1" required oninput="calculateTotal()">
                                </div>

                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-outline-danger rounded-pill w-100 py-2 btn-remove-item" onclick="removeItem(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button type="button" class="btn-pill-outline btn-sm mb-4" onclick="addItemRow()">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Item Lain
                </button>

                @if(!auth()->user()->isCustomer())
                    <!-- JIKA ADMIN/STAFF: PILIH PELANGGAN -->
                    <div class="mb-4 pt-3 border-top border-secondary border-opacity-25">
                        <label class="form-label small text-secondary fw-semibold">Pelanggan / Kolektor</label>
                      <select name="customer_id" class="form-select ...">
                            <option value="">-- Pilih Pelanggan / Kolektor --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                @endif

                <div class="mb-3">
                    <label class="form-label small text-secondary fw-semibold">Catatan Transaksi (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Catatan pesanan atau instruksi pengiriman..."></textarea>
                </div>

                <button type="submit" class="btn-pill-red w-100 py-3 justify-content-center fs-6">
                    <i class="fa-solid fa-cart-check me-2"></i> Konfirmasi Pembelian
                </button>
            </form>
        </div>
    </div>

    <!-- RINGKASAN PEMBAYARAN -->
    <div class="col-lg-4">
        <div class="card-custom p-4 sticky-top" style="top: 100px;">
            <h5 class="fw-bold text-white mb-3">Ringkasan Pesanan</h5>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small">Total Item</span>
                <span class="text-light fw-bold" id="totalItemsCount">0 Unit</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-secondary small">Status Stok</span>
                <span class="badge bg-success rounded-pill px-3">Tersedia</span>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-white fw-bold">Total Tagihan</span>
                <span class="fs-4 fw-bold text-danger" id="grandTotalDisplay">Rp 0</span>
            </div>

            @if(!auth()->user()->isCustomer())
                <div class="p-3 rounded-3" style="background: rgba(220, 38, 38, 0.08); border: 1px dashed rgba(220, 38, 38, 0.3);">
                    <small class="text-secondary d-block" style="font-size: 0.75rem; line-height: 1.4;">
                        Stok diecast akan langsung terpotong secara otomatis dari garasi RedLine setelah transaksi berhasil dikonfirmasi.
                    </small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let itemIndex = 1;

    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function updateRow(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const maxStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const imageUrl = selectedOption.getAttribute('data-image'); 
        
        const row = selectElement.closest('.item-row');
        row.querySelector('.price-display').value = formatRupiah(price);
        
        const imgEl = row.querySelector('.product-preview-img');
        const iconEl = row.querySelector('.product-placeholder-icon');
        if (imageUrl) {
            imgEl.src = imageUrl;
            imgEl.style.display = 'block';
            if (iconEl) iconEl.style.display = 'none';
        } else {
            imgEl.src = '';
            imgEl.style.display = 'none';
            if (iconEl) iconEl.style.display = 'block';
        }
        
        const qtyInput = row.querySelector('.qty-input');
        if (maxStock > 0) {
            qtyInput.max = maxStock;
        }
        
        calculateTotal();
    }

    function calculateTotal() {
        let grandTotal = 0;
        let totalItems = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const selectedOption = select.options[select.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;

            grandTotal += (price * qty);
            totalItems += qty;
        });

        document.getElementById('grandTotalDisplay').innerText = formatRupiah(grandTotal);
        document.getElementById('totalItemsCount').innerText = totalItems + ' Unit';
    }

    function addItemRow() {
    const container = document.getElementById('itemsContainer');
    const firstRow = container.querySelector('.item-row');
    const newRow = firstRow.cloneNode(true);

    newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
    newRow.querySelector('.product-select').selectedIndex = 0;
    newRow.querySelector('.price-display').value = 'Rp 0';
    newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
    newRow.querySelector('.qty-input').value = 1;

    const newImg = newRow.querySelector('.product-preview-img');
    const newIcon = newRow.querySelector('.product-placeholder-icon');
    if (newImg) { newImg.src = ''; newImg.style.display = 'none'; }
    if (newIcon) { newIcon.style.display = 'block'; }

    container.appendChild(newRow);
    itemIndex++;
    calculateTotal();
}

    function removeItem(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('.item-row').remove();
            calculateTotal();
        } else {
            alert('Minimal harus ada 1 unit diecast yang dibeli.');
        }
    }

    // Hitung otomatis saat pertama kali halaman terbuka
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-select').forEach(select => {
            if(select.value) updateRow(select);
        });
        calculateTotal();
    });
</script>
@endpush