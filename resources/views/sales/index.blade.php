@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-white">{{ auth()->user()->isCustomer() ? 'Riwayat Pesanan Saya' : 'Laporan Penjualan Toko' }}</h3>
        <p class="text-secondary small mb-0">Semua faktur transaksi penjualan yang telah diproses secara atomik.</p>
    </div>
    <a href="{{ route('sales.create') }}" class="btn btn-danger">
        <i class="fa-solid fa-cart-plus me-1"></i> {{ auth()->user()->isCustomer() ? 'Beli Koleksi Baru' : 'Transaksi Baru (Kasir)' }}
    </a>
</div>

<div class="card card-custom">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>No Faktur</th>
                    @if(!auth()->user()->isCustomer()) <th>Nama Pelanggan</th> @endif
                    <th>Tanggal Transaksi</th>
                    <th>Jumlah Unit</th>
                    <th>Total Bayar</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    {{-- 1. No Faktur --}}
                    <td><span class="badge bg-dark border border-secondary">{{ $sale->sale_number }}</span></td>

                    {{-- 2. Nama Pelanggan (Khusus Tampilan Kasir/Petugas) --}}
                    @if(!auth()->user()->isCustomer())
                    <td>{{ $sale->user->name ?? 'Pelanggan Umum' }}</td>
                    @endif

                    {{-- 3. Tanggal Transaksi --}}
                    <td class="text-secondary">{{ $sale->created_at->format('d M Y, H:i') }}</td>

                    {{-- 4. Jumlah Unit --}}
                    <td>{{ $sale->items->sum('quantity') }} Mobil</td>

                    {{-- 5. Total Bayar --}}
                    <td class="fw-bold text-danger">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>

                    {{-- 6. Status & Aksi --}}
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-2">
                            @if($sale->payment_status === 'pending')
                                <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ route('sales.payment', $sale->id) }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm">
                                        Bayar
                                    </a>
                                @else
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-file-invoice me-1"></i> Nota
                                    </a>
                                @endif
                            @else
                                <span class="badge bg-success px-2 py-1">Lunas</span>
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class="fa-solid fa-file-invoice me-1"></i> Nota
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->isCustomer() ? 5 : 6 }}" class="text-center py-4 text-secondary">
                        Belum ada riwayat transaksi penjualan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $sales->links('pagination::bootstrap-5') }}
</div>
@endsection