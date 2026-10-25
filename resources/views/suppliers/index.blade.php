@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Distributor & Supplier Diecast</h3>
        <p class="text-muted small mb-0">Pemasok resmi barang masuk (PT Mattel, Mini GT Official, dll.).</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-custom bg-white p-3">
            <h5 class="fw-bold mb-3 text-dark">Tambah Distributor</h5>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Distributor</label>
                    <input type="text" name="name" class="form-control" required placeholder="PT Mattel Indonesia">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control" placeholder="021-xxxx">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="order@distributor.com">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Alamat Kantor / Gudang</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-save me-1"></i> Simpan Pemasok</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-custom bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Distributor</th>
                            <th>Kontak</th>
                            <th>Total Faktur PO</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $sup)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark">{{ $sup->name }}</div>
                                <small class="text-muted">{{ $sup->address ?? '-' }}</small>
                            </td>
                            <td>
                                <div>{{ $sup->phone ?? '-' }}</div>
                                <small class="text-muted">{{ $sup->email ?? '-' }}</small>
                            </td>
                            <td><span class="badge bg-primary">{{ $sup->purchases_count }} Transaksi</span></td>
                            <td class="text-end">
                                <form action="{{ route('suppliers.destroy', $sup->id) }}" method="POST" onsubmit="return confirm('Hapus distributor ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada data supplier.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection