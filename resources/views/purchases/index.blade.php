@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Riwayat Restock Distributor (PO)</h3>
        <p class="text-muted small mb-0">Pencatatan faktur barang masuk dari agen distributor.</p>
    </div>
    <a href="{{ route('purchases.create') }}" class="btn btn-danger">
        <i class="fa-solid fa-plus me-1"></i> Buat PO Restock Baru
    </a>
</div>

<div class="card card-custom bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No PO</th>
                    <th>Distributor Pemasok</th>
                    <th>Petugas Input</th>
                    <th>Tanggal Masuk</th>
                    <th>Total Nilai Kulakan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $po)
                <tr>
                    <td><span class="badge bg-secondary">{{ $po->purchase_number }}</span></td>
                    <td class="fw-semibold">{{ $po->supplier->name }}</td>
                    <td>{{ $po->user->name }}</td>
                    <td>{{ $po->created_at->format('d M Y, H:i') }}</td>
                    <td class="fw-bold text-primary">Rp {{ number_format($po->total, 0, ',', '.') }}</td>
                    <td class="text-end">
                            <a href="{{ route('purchases.show', $po->id) }}" class="btn btn-sm btn-danger text-white fw-semibold px-3 py-1 rounded-3">
    <i class="fa-solid fa-file-lines me-1"></i> Detail PO
</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat faktur pembelian stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex justify-content-end mt-3">
    {{ $purchases->links('pagination::bootstrap-5') }}
</div>
@endsection