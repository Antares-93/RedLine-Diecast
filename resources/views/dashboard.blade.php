@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-white">Dashboard Ringkasan</h3>
        <p class="text-secondary small mb-0">Panel informasi operasional RedLine Diecast Vault.</p>
    </div>
    <div class="text-end d-none d-sm-block">
        <span class="text-secondary small px-3 py-1 rounded-pill" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);">
            {{ date('d F Y') }}
        </span>
    </div>
</div>

@if(auth()->user()->isCustomer())
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.08em;">Total Pesanan Selesai</span>
                <h2 class="fw-bold text-white mt-2 mb-0">{{ $totalOrders }} <span class="fs-6 text-secondary fw-normal">Faktur</span></h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.08em;">Total Belanja Koleksi</span>
                <h2 class="fw-bold text-danger mt-2 mb-0">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <div class="card-custom">
        <div class="p-4 border-bottom border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-0 text-white">Riwayat Pesanan Anda</h5>
                <small class="text-secondary">Daftar transaksi koleksi mobil diecast yang telah selesai.</small>
            </div>
            <a href="{{ route('sales.create') }}" class="btn-pill-red btn-sm">
                Belanja Unit Baru
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Jumlah Unit</th>
                        <th>Total Bayar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPurchases as $sale)
                        <tr>
                            <td><span class="badge bg-dark border border-secondary border-opacity-50 font-monospace text-light">{{ $sale->sale_number }}</span></td>
                            <td>{{ $sale->created_at->format('d M Y, H:i') }}</td>
                            <td><span class="text-light fw-semibold">{{ $sale->items->sum('quantity') }}</span> Unit</td>
                            <td class="fw-bold text-danger">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn-pill-outline btn-sm py-1 px-3">
                                    Lihat Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                Belum ada riwayat pesanan diecast.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@else
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Varian Diecast</span>
                <h3 class="fw-bold text-white mt-2 mb-0">{{ $totalProducts }} <span class="fs-6 text-secondary fw-normal">Model</span></h3>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Unit Fisik</span>
                <h3 class="fw-bold text-white mt-2 mb-0">{{ $totalStock }} <span class="fs-6 text-secondary fw-normal">Unit</span></h3>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Omset Penjualan</span>
                <h3 class="fw-bold text-white mt-2 mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-custom p-4">
                <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Transaksi</span>
                <h3 class="fw-bold text-white mt-2 mb-0">{{ $totalSalesCount }} <span class="fs-6 text-secondary fw-normal">Faktur</span></h3>
            </div>
        </div>
    </div>

    @if($lowStockProducts->count() > 0)
    <div class="card-custom mb-4 p-4" style="border-left: 4px solid var(--rl-red, #eb2832);">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <h5 class="fw-bold text-danger mb-0">Peringatan Stok Diecast Menipis!</h5>
                <p class="text-secondary small mb-0 mt-1">Unit diecast berikut berada pada atau di bawah batas minimum stok:</p>
            </div>
            <a href="{{ route('purchases.create') }}" class="btn-pill-red btn-sm">
                Buat PO Restock
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama Unit Diecast</th>
                        <th>Brand</th>
                        <th>Stok Aktual</th>
                        <th>Batas Min.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $low)
                    <tr>
                        <td>
                            <span style="color: #cbd5e1; font-size: 0.78rem; background: #0f0f14; padding: 0.2rem 0.6rem; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.15);">
                                {{ $low->sku }}
                            </span>
                        </td>
                        <td class="fw-semibold text-white">{{ $low->name }}</td>
                        <td class="text-secondary">{{ $low->brand }}</td>
                        <td><span class="badge bg-danger rounded-pill px-3">{{ $low->stock }} Unit</span></td>
                        <td>{{ $low->minimum_stock }} Unit</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- KARTU GRAFIK PENJUALAN ADMIN --}}
    <div class="card-custom mb-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-bold text-white mb-1">Tren Omzet Penjualan (7 Hari Terakhir)</h6>
                <span class="text-secondary small">Visualisasi performa pendapatan harian toko</span>
            </div>
            <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 px-3 py-2 rounded-pill small">
                Live Data
            </span>
        </div>
        <div style="height: 280px; width: 100%;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card-custom h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-white">5 Penjualan Kasir Terakhir</h6>
                    <a href="{{ route('sales.index') }}" class="text-danger small text-decoration-none fw-semibold">Semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td><a href="{{ route('sales.show', $sale->id) }}" class="text-danger fw-semibold text-decoration-none font-monospace">{{ $sale->sale_number }}</a></td>
                                    <td class="text-light">{{ $sale->user->name }}</td>
                                    <td class="fw-bold text-success">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-secondary">Belum ada transaksi penjualan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-custom h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-white">5 Restock Distributor Terakhir (PO)</h6>
                    <a href="{{ route('purchases.index') }}" class="text-danger small text-decoration-none fw-semibold">Semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr>
                                <th>No PO</th>
                                <th>Distributor</th>
                                <th>Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPurchases as $po)
                                <tr>
                                    <td><a href="{{ route('purchases.show', $po->id) }}" class="text-primary fw-semibold text-decoration-none font-monospace">{{ $po->purchase_number }}</a></td>
                                    <td class="text-light">{{ $po->supplier->name }}</td>
                                    <td class="fw-bold text-primary">Rp {{ number_format($po->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-secondary">Belum ada transaksi barang masuk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Skrip Library Chart.js dan Inisialisasi Grafik --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chartElement = document.getElementById('salesChart');
        if (!chartElement) return;

        const ctx = chartElement.getContext('2d');

        // Gradasi warna merah neon ke transparan
        const gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(235, 40, 50, 0.45)');
        gradient.addColorStop(1, 'rgba(235, 40, 50, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels ?? ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']) !!},
                datasets: [{
                    label: 'Omzet',
                    data: {!! json_encode($chartValues ?? [0, 0, 0, 0, 0, 0, 0]) !!},
                    borderColor: '#eb2832',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    pointBackgroundColor: '#eb2832',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#14141d',
                        titleColor: '#ffffff',
                        bodyColor: '#ff6b6b',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Omzet: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#888899', font: { size: 12 } }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: {
                            color: '#888899',
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection