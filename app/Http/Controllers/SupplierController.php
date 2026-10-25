<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('purchases')->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'email'   => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Distributor baru berhasil disimpan!');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:150'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'email'   => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Data distributor berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->purchases()->exists()) {
            return back()->with('error', 'Distributor tidak dapat dihapus karena memiliki riwayat faktur pembelian.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Data distributor berhasil dihapus.');
    }
}