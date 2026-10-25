@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5" style="position: relative; z-index: 10;">
    <div class="col-md-5">
        <div class="p-4 rounded-4 text-center shadow-lg" style="background: #101017; border: 1px solid rgba(255,255,255,0.1);">
            <div class="mb-3">
                <i class="fa-solid fa-wallet text-danger fs-1"></i>
            </div>
            <h4 class="fw-bold text-white mb-1">Selesaikan Pembayaran</h4>
            <p class="text-secondary small mb-4">No. Faktur: {{ $sale->sale_number }}</p>

            <div class="p-3 rounded-3 mb-4" style="background: #0b0b0e; border: 1px solid rgba(255,255,255,0.06);">
                <span class="text-secondary small d-block mb-1">Total Tagihan</span>
                <span class="fs-3 fw-bold text-danger">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>

            <button type="button" id="pay-button" class="btn btn-danger w-100 py-3 rounded-pill fw-bold mb-3 shadow">
                Bayar Sekarang
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill small">
                Bayar Nanti (Cek Riwayat)
            </a>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function () {
               window.snap.pay('{{ $sale->snap_token }}', {
                    onSuccess: function(result) {
                        let method = 'Midtrans';

                        // Mendeteksi jenis Virtual Account (BCA, BNI, BRI, dll)
                        if (result.va_numbers && result.va_numbers.length > 0) {
                            method = result.va_numbers[0].bank.toUpperCase() + ' Virtual Account';
                        } else if (result.payment_type === 'echannel') {
                            method = 'Mandiri Bill';
                        } else if (result.payment_type === 'qris') {
                            method = 'QRIS';
                        } else if (result.payment_type === 'gopay') {
                            method = 'GoPay';
                        } else if (result.payment_type) {
                            method = result.payment_type.toUpperCase();
                        }

                        window.location.href = "{{ route('sales.success', $sale->id) }}?payment_type=" + encodeURIComponent(method);
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('sales.index') }}";
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                    }
                });
            });
        }
    });
</script>
@endsection