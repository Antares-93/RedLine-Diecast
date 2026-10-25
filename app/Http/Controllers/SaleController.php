<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Customer;
use Midtrans\Config;
use Midtrans\Snap;

class SaleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isCustomer()) {
            $sales = Sale::where('user_id', $user->id)
                ->with(['items.product'])
                ->latest()
                ->paginate(10);
        } else {
            $sales = Sale::with(['user', 'items.product'])
                ->latest()
                ->paginate(10);
        }

        return view('sales.index', compact('sales'));
    }

        public function create()
        {
            $products = Product::where('stock', '>', 0)->orderBy('name')->get();

           $customers = \App\Models\User::orderBy('name')->get();

            return view('sales.create', compact('products', 'customers'));
        }

   public function store(Request $request)
    {
        $saleNumber = 'SL-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // 1. Hitung total harga
        $totalAmount = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $price = $product->selling_price ?? $product->price ?? 0;
                    $totalAmount += $price * $item['quantity'];
                }
            }
        }

        // 2. Simpan transaksi utama (memakai kolom 'total')
        $sale = Sale::create([
            'sale_number'    => $saleNumber,
            'user_id'        => auth()->id(),
            'total'          => $totalAmount,
            'status'         => auth()->user()->isCustomer() ? 'pending' : 'completed',
            'sold_at'        => now(),
            'payment_status' => auth()->user()->isCustomer() ? 'pending' : 'paid',
        ]);

        // 3. Simpan rincian barang
        foreach ($request->items as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $qty = $item['quantity'];
                $unitPrice = $product->selling_price ?? $product->price ?? 0;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal'   => $unitPrice * $qty,
                ]);

                // Potong stok langsung jika transaksi kasir toko (Petugas)
                if (!auth()->user()->isCustomer()) {
                    $product->decrement('stock', $qty);
                }
            }
        }

        // 4. JIKA PETUGAS/KASIR: Langsung selesai
        if (!auth()->user()->isCustomer()) {
            return redirect()->route('sales.index')->with('success', 'Transaksi kasir berhasil dicatat!');
        }

        // 5. JIKA CUSTOMER: Hubungkan ke Midtrans Snap
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $sale->sale_number,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $sale->update(['snap_token' => $snapToken]);

        return redirect()->route('sales.payment', $sale->id);
    }


    public function show(Sale $sale)
    {
        $user = auth()->user();

        // Cegah customer mengintip invoice milik customer lain
        if ($user->isCustomer() && $sale->user_id !== $user->id) {
            abort(403, 'Akses ditolak. Anda tidak berhak melihat transaksi ini.');
        }

        $sale->load(['user', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    public function payment(Sale $sale)
    {
        if (empty($sale->snap_token)) {
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $sale->sale_number . '-' . time(),
                    'gross_amount' => (int) $sale->total,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'callbacks' => [
                    'finish' => url('/sales'), 
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $sale->update(['snap_token' => $snapToken]);
        }

        return view('sales.payment', compact('sale'));
    }

    public function paymentSuccess(\Illuminate\Http\Request $request, Sale $sale)
    {
        // Cegah stok terpotong ganda jika user me-refresh halaman
        if ($sale->payment_status !== 'paid') {
            foreach ($sale->items as $item) {
                \App\Models\Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
            }
        }

        $sale->update([
            'payment_status' => 'paid',
            'status'         => 'completed',
            'payment_type'   => $request->query('payment_type', 'Midtrans Sandbox'),
        ]);

        return redirect()->route('sales.index')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }       

}