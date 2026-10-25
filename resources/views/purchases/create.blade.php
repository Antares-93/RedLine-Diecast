@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-white mb-1">Buat PO Restock Diecast</h3>
        <p class="text-secondary small mb-0">Input dokumen pengadaan barang masuk dari distributor resmi ke garasi RedLine.</p>
    </div>
    <a href="{{ route('purchases.index') }}" class="btn-pill-outline">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar PO
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom p-4 mb-4">
            <h5 class="fw-bold text-white mb-3">Informasi Distributor & Item Masuk</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i> Pengisian formulir belum lengkap / salah:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
                @csrf

                <!-- PILIH DISTRIBUTOR PEMASOK -->
                <div class="mb-4">
                    <label class="form-label small text-secondary fw-semibold">Distributor Pemasok Resmi</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Distributor Pemasok --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{$supplier->phone ?? 'Tanpa Kontak' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- DAFTAR ITEM DIECAST RESTOCK -->
                <div class="mb-2">
                    <label class="form-label small text-secondary fw-semibold">Daftar Unit Restock</label>
                </div>

                <div id="itemsContainer">
                    <div class="item-row p-3 rounded-4 mb-3" style="background: #101017; border: 1px solid rgba(255,255,255,0.08);">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small text-secondary" style="font-size: 0.75rem;">Model Diecast</label>
                                <select name="items[0][product_id]" class="form-select product-select" required onchange="updateProductPrice(this)">
                                    <option value="" data-price="0">-- Pilih Unit Diecast --</option>
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" data-price="{{ $p->purchase_price ?? $p->price ?? 0 }}">
                                            {{ $p->name }} (Stok: {{ $p->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small text-secondary" style="font-size: 0.75rem;">Harga Beli / Modal (Rp)</label>
                                <input type="number" name="items[0][cost_price]" class="form-control cost-input" min="0" value="0" required oninput="calculateTotal()">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small text-secondary" style="font-size: 0.75rem;">Jumlah Masuk</label>
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

                <button type="button" class="btn-pill-outline btn-sm mb-4" onclick="addItemRow()">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Item Unit Lain
                </button>

                <div class="mb-4 pt-3 border-top border-secondary border-opacity-25">
                    <label class="form-label small text-secondary fw-semibold">Catatan PO / Nomor Faktur Supplier (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Faktur No. INV-MTL-2026 / Barang tiba via kargo..."></textarea>
                </div>

                <button type="submit" class="btn-pill-red w-100 py-3 justify-content-center fs-6">
                    <i class="fa-solid fa-boxes-packing me-2"></i> Konfirmasi Restock (Simpan PO)
                </button>
            </form>
        </div>
    </div>

    <!-- RINGKASAN PO -->
    <div class="col-lg-4">
        <div class="card-custom p-4 sticky-top" style="top: 100px;">
            <h5 class="fw-bold text-white mb-3">Ringkasan Pengadaan</h5>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary small">Total Fisik Masuk</span>
                <span class="text-light fw-bold" id="totalQtyDisplay">0 Unit</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-secondary small">Tipe Dokumen</span>
                <span class="badge bg-danger rounded-pill px-3">Purchase Order</span>
            </div>

            <hr class="border-secondary opacity-25">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-white fw-bold">Total Nilai PO</span>
                <span class="fs-4 fw-bold text-danger" id="totalCostDisplay">Rp 0</span>
            </div>

            <div class="p-3 rounded-3" style="background: rgba(220, 38, 38, 0.08); border: 1px dashed rgba(220, 38, 38, 0.3);">
                <small class="text-secondary d-block" style="font-size: 0.75rem; line-height: 1.4;">
                    Setelah PO disimpan, jumlah unit fisik pada katalog produk akan langsung bertambah secara otomatis sesuai kuantitas yang diinput.
                </small>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemIndex = 1;

    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function updateProductPrice(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const costPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const row = selectElement.closest('.item-row');
        row.querySelector('.cost-input').value = costPrice;
        calculateTotal();
    }

    function calculateTotal() {
        let totalCost = 0;
        let totalQty = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;

            totalCost += (cost * qty);
            totalQty += qty;
        });

        document.getElementById('totalCostDisplay').innerText = formatRupiah(totalCost);
        document.getElementById('totalQtyDisplay').innerText = totalQty + ' Unit';
    }

    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelector('.product-select').name = `items[${itemIndex}][product_id]`;
        newRow.querySelector('.product-select').selectedIndex = 0;
        newRow.querySelector('.cost-input').name = `items[${itemIndex}][cost_price]`;
        newRow.querySelector('.cost-input').value = 0;
        newRow.querySelector('.qty-input').name = `items[${itemIndex}][quantity]`;
        newRow.querySelector('.qty-input').value = 1;

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
            alert('Minimal harus ada 1 item barang yang di-restock.');
        }
    }

    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endpush
@endsection