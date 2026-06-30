<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $lowStockCount = Product::where('quantity', '<=', 5)->count();
        $totalCustomers = Customer::count();
        $todaySalesTotal = Sale::whereDate('sale_date', today())->sum('total_amount');
        $monthSalesTotal = Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total_amount');
        $recentSales = Sale::with(['product', 'customer'])
            ->latest('sale_date')
            ->latest('sale_id')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'totalProducts' => $totalProducts,
            'lowStockCount' => $lowStockCount,
            'totalCustomers' => $totalCustomers,
            'todaySalesTotal' => $todaySalesTotal,
            'monthSalesTotal' => $monthSalesTotal,
            'recentSales' => $recentSales,
            'user' => Auth::user(),
        ]);
    }
}
