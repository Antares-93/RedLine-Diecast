<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Tampilan khusus Customer
        if ($user->isCustomer()) {
            $totalOrders = \App\Models\Sale::where('user_id', $user->id)
                ->whereIn('payment_status', ['paid', 'completed'])
                ->count();

            $totalSpent = \App\Models\Sale::where('user_id', $user->id)
                ->whereIn('payment_status', ['paid', 'completed'])
                ->sum('total');

            $recentPurchases = \App\Models\Sale::with('items')
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact('totalOrders', 'totalSpent', 'recentPurchases'));
        }

        $totalProducts = \App\Models\Product::count();
        $totalStock = \App\Models\Product::sum('stock');
        $totalRevenue = \App\Models\Sale::whereIn('payment_status', ['paid', 'completed'])->sum('total');
        $totalSalesCount = \App\Models\Sale::whereIn('payment_status', ['paid', 'completed'])->count();

        $lowStockProducts = \App\Models\Product::whereColumn('stock', '<=', 'minimum_stock')->get();
        $recentSales = \App\Models\Sale::with('user')->latest()->take(5)->get();
        $recentPurchases = \App\Models\Purchase::with('supplier')->latest()->take(5)->get();

        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');

            $dailyTotal = \App\Models\Sale::whereDate('created_at', $date->toDateString())
                ->whereIn('payment_status', ['paid', 'completed'])
                ->sum('total');

            $chartValues[] = (int) $dailyTotal;
        }

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'totalRevenue',
            'totalSalesCount',
            'lowStockProducts',
            'recentSales',
            'recentPurchases',
            'chartLabels',
            'chartValues'
        ));
    }

    
}