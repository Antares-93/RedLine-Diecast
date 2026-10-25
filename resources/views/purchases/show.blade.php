@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Faktur Pembelian & Restock</h3>
        <p class="text-muted small mb-0">Rincian penerimaan unit diecast dari distributor.</p>
    </div>
    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="card card-custom bg-white p-4 p-md-5" style="max-width: 800px; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-0">Faktur Masuk: {{ $purchase->purchase_number }}</h5>
            <small class="text-muted">Pemasok: {{ $purchase->supplier->name }}</small>
        </div>
        <span class="badge bg-primary px-3 py-2 text-uppercase">{{ $purchase->status }}</span>
    </div>

    <div class="row mb-4 small">
        <div class="col-6">
            <div class="text-muted">Alamat Distributor:</div>
            <div>{{ $purchase->supplier->address ?? '-' }}</div>
            <div>Kontak: {{ $purchase->supplier->phone ?? '-' }}</div>
        </div>
        <div class="col-6 text-end">
            <div class="text-muted">Petugas Penerima:</div>
            <div class="fw-bold">{{ $purchase->user->name }}</div>
            <div class="text-muted">{{ $purchase->created_at->format('d F Y, H:i') }}</div>
        </div>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Unit Diecast</th>
                <th class="text-center">Qty Masuk</th>
                <th class="text-end">Harga Beli Modal</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase->items as $item)
            <tr>
                <td>{{ $item->product->name }} <br><small class="text-muted">{{ $item->product->sku }}</small></td>
                <td class="text-center fw-bold">{{ $item->quantity }}</td>
                <td class="text-end">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end py-3">Total Biaya Kulakan:</th>
                <th class="text-end py-3 text-primary fs-5">Rp {{ number_format($purchase->total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection 