@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Faktur Penjualan</h3>
        <p class="text-muted small mb-0">Detail resmi transaksi pembelian koleksi diecast.</p>
    </div>
       <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-danger btn-sm text-white fw-semibold shadow-sm">
                <i class="fa-solid fa-print me-1"></i> Cetak Struk
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
</div>

<div id="area-cetak" class="card card-custom bg-white p-4 p-md-5" style="max-width: 800px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px; width: auto; object-fit: contain;">
            <div>
                <h4 class="mb-0 fw-bold text-white">
                    Red<span class="text-danger">Line</span>
                </h4>
                <small class="text-secondary d-block" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    MAX OUT YOUR COLLECTION.
                </small>
            </div>
        </div>

        <div class="text-end">
            <span class="badge bg-success px-3 py-2 text-uppercase">{{ $sale->status }}</span>
            <div class="fw-bold text-white mt-1">{{ $sale->sale_number }}</div>
        </div>

    </div>

    <div class="row mb-4 small">
        <div class="col-6">
            <div class="text-secondary small">Pembeli / Kolektor:</div>
            <div class="fw-bold text-white">{{ $sale->user->name }}</div>
            <div class="text-secondary small">{{ $sale->user->email }}</div>
        </div>
        <div class="col-6 text-end">
            <div class="text-muted">Waktu Transaksi:</div>
            <div class="fw-bold text-dark">{{ $sale->sold_at ? \Carbon\Carbon::parse($sale->sold_at)->format('d F Y, H:i') : $sale->created_at->format('d F Y, H:i') }}</div>
        </div>
        <div class="mt-2">
            <div class="text-secondary small">Metode Pembayaran:</div>
            <div class="fw-bold text-white">
                <span class="badge bg-secondary px-2 py-1">
                    {{ strtoupper($sale->payment_type ?? 'Midtrans Sandbox') }}
                </span>
            </div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Item Diecast</th>
                    <th class="text-center" style="width: 15%;">Qty</th>
                    <th class="text-end" style="width: 25%;">Harga Satuan</th>
                    <th class="text-end" style="width: 25%;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $item->product->name }}</div>
                        <small class="text-muted">{{ $item->product->sku }} | {{ $item->product->brand }}</small>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end py-3">Total Pembayaran:</th>
                    <th class="text-end py-3 text-danger fs-5">Rp {{ number_format($sale->total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="text-center text-muted small border-top pt-3">
        Terima kasih atas pesanan Anda di RedLine Diecast Store! Simpan nota ini sebagai bukti transaksi resmi.
        @if($sale->payment_status === 'pending')
            <div class="text-center mt-4">
                <button id="pay-button" class="btn btn-danger px-5 py-2 rounded-pill fw-bold shadow">
                    Bayar Sekarang
                </button>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    /* Sembunyikan semua elemen di layar */
    body * {
        visibility: hidden !important;
    }

    /* Hanya tampilkan area nota faktur */
    #area-cetak, #area-cetak * {
        visibility: visible !important;
    }

    /* Posisikan faktur pas di pojok kiri atas kertas */
    #area-cetak {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        top: 20px !important;
        margin: 0 auto !important; 
        width: 85% !important;     
        max-width: 720px !important;
        padding: 20px !important;
        border: none !important;
        box-shadow: none !important;
        background: #ffffff !important;
    }

    /* Pastikan seluruh teks berwarna hitam jelas */
    #area-cetak .text-white, 
    #area-cetak .text-dark, 
    #area-cetak .text-muted, 
    #area-cetak .text-secondary {
        color: #111111 !important;
    }

    #area-cetak .table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    #area-cetak .table th, 
    #area-cetak .table td {
        border: 1px solid #333333 !important;
        color: #111111 !important;
        padding: 8px !important;
    }

    @page {
        margin: 10mm;
        size: auto;
    }
}
</style>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    if (payButton) {
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $sale->snap_token }}', {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        });
    }
</script>

@endsection