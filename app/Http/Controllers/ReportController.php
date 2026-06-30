<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function daily(Request $request): View
    {
        $date = $request->query('date', now()->toDateString());

        $sales = Sale::with(['product', 'customer'])
            ->whereDate('sale_date', $date)
            ->orderBy('sale_id')
            ->get();

        $totalAmount = $sales->sum('total_amount');
        $totalItems = $sales->sum('quantity');

        return view('reports.daily', [
            'sales' => $sales,
            'date' => $date,
            'totalAmount' => $totalAmount,
            'totalItems' => $totalItems,
        ]);
    }

    public function monthly(Request $request): View
    {
        $month = (int) $request->query('month', now()->month);
        $year = (int) $request->query('year', now()->year);

        $sales = Sale::with(['product', 'customer'])
            ->whereMonth('sale_date', $month)
            ->whereYear('sale_date', $year)
            ->orderBy('sale_date')
            ->get();

        $totalAmount = $sales->sum('total_amount');
        $totalItems = $sales->sum('quantity');

        $dailyBreakdown = $sales->groupBy(fn ($sale) => $sale->sale_date->format('Y-m-d'))
            ->map(fn ($daySales) => [
                'count' => $daySales->count(),
                'total' => $daySales->sum('total_amount'),
            ]);

        return view('reports.monthly', [
            'sales' => $sales,
            'month' => $month,
            'year' => $year,
            'totalAmount' => $totalAmount,
            'totalItems' => $totalItems,
            'dailyBreakdown' => $dailyBreakdown,
        ]);
    }

    public function stock(): View
    {
        $products = Product::orderBy('quantity')->get();
        $lowStockThreshold = 5;

        return view('reports.stock', [
            'products' => $products,
            'lowStockThreshold' => $lowStockThreshold,
        ]);
    }

    public function customerPurchases(Request $request): View
    {
        $customers = Customer::with(['sales' => function ($query) {
            $query->orderByDesc('sale_date');
        }])->orderBy('name')->get();

        return view('reports.customer-purchases', [
            'customers' => $customers,
        ]);
    }
}
