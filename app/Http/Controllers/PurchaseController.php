<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function show(Purchase $purchase)
    {
        $purchase->load(['items.product', 'supplier', 'user']);

        return view('purchases.show', compact('purchase'));
    }

    public function index()
    {
        $purchases = Purchase::with(['supplier', 'items.product'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = \App\Models\Supplier::all();
        $products = \App\Models\Product::all();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.cost_price'   => 'required|numeric|min:0',
            'items.*.quantity'     => 'required|integer|min:1',
            'notes'                => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += ($item['cost_price'] * $item['quantity']);
            }

            $purchase = new Purchase();
            $purchase->purchase_number = 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            $purchase->supplier_id     = $request->supplier_id;
            $purchase->user_id         = auth()->id() ?? 1; 
            $purchase->total           = $totalAmount;
            $purchase->notes           = $request->notes;
            $purchase->save();

            // Simpan setiap item PO & update stok barang
            foreach ($request->items as $item) {
                $pItem = new PurchaseItem();
                $pItem->purchase_id = $purchase->id;
                $pItem->product_id  = $item['product_id'];
                $pItem->unit_cost   = $item['cost_price'];
                $pItem->quantity    = $item['quantity'];
                $pItem->subtotal    = $item['cost_price'] * $item['quantity'];
                $pItem->save();

                // Tambah stok fisik diecast
                $product = Product::findOrFail($item['product_id']);
                $product->increment('stock', $item['quantity']);

                if ($item['cost_price'] > 0) {
                    $product->purchase_price = $item['cost_price'];
                    $product->save();
                }
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'PO Restock berhasil disimpan dan stok gudang sudah bertambah!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan restock: ' . $e->getMessage());
        }
    }
}