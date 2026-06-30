<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $sales = Sale::with(['product', 'customer', 'cashier', 'saleItems.product'])
            ->when($search, function ($query, $search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%");
                })->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhere('sale_id', $search);
            })
            ->latest('sale_date')
            ->latest('sale_id')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', [
            'sales' => $sales,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        $products = Product::where('quantity', '>', 0)->orderBy('product_name')->get();
        $customers = Customer::orderBy('name')->get();

        return view('sales.create', [
            'products' => $products,
            'customers' => $customers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'exists:products,product_id'],
            'quantity' => ['required', 'array', 'min:1'],
            'quantity.*' => ['required', 'integer', 'min:1'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'customer_id' => ['nullable', 'exists:customers,customer_id'],
            'sale_date' => ['required', 'date'],
        ]);

        $sale = DB::transaction(function () use ($validated) {
            $productIds = array_filter($validated['product_id'], fn ($id) => $id !== null && $id !== '');
            $products = Product::whereIn('product_id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('product_id');

            $totalAmount = 0;
            $totalQuantity = 0;
            $items = [];

            foreach ($validated['product_id'] as $index => $productId) {
                if ($productId === null || $productId === '') {
                    continue;
                }

                $quantity = (int) $validated['quantity'][$index];
                $product = $products->get($productId);

                if (! $product) {
                    abort(422, "Product with ID {$productId} not found.");
                }

                if ($product->quantity < $quantity) {
                    abort(422, "Insufficient stock. Only {$product->quantity} unit(s) of {$product->product_name} available.");
                }

                $lineTotal = $product->price * $quantity;
                $totalAmount += $lineTotal;
                $totalQuantity += $quantity;

                $items[] = [
                    'product_id' => $product->product_id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_amount' => $lineTotal,
                ];
            }

            if (empty($items)) {
                abort(422, 'No sale items provided.');
            }

            $firstItem = $items[0];

            $discount = isset($validated['discount']) ? max(0, (float) $validated['discount']) : 0;
            $sale = Sale::create([
                'product_id' => $firstItem['product_id'],
                'customer_id' => $validated['customer_id'] ?? null,
                'quantity' => $totalQuantity,
                'unit_price' => $firstItem['unit_price'],
                'total_amount' => max(0, $totalAmount - $discount),
                'discount' => $discount,
                'sale_date' => $validated['sale_date'],
                'cashier_id' => Auth::id(),
            ]);

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $product->decrement('quantity', $item['quantity']);

                SaleItem::create([
                    'sale_id' => $sale->sale_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_amount' => $item['total_amount'],
                ]);
            }

            return $sale;
        });

        return redirect()->route('sales.show', $sale->sale_id)
            ->with('success', 'Sale recorded successfully. Stock updated automatically.');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['product', 'saleItems.product', 'customer', 'cashier']);

        return view('sales.show', ['sale' => $sale]);
    }

    public function destroy(Sale $sale): RedirectResponse
    {
        DB::transaction(function () use ($sale) {
            $sale->loadMissing('saleItems.product');

            if ($sale->saleItems->isNotEmpty()) {
                foreach ($sale->saleItems as $item) {
                    $item->product?->increment('quantity', $item->quantity);
                }
            } else {
                $sale->product?->increment('quantity', $sale->quantity);
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Sale voided and stock restored.');
    }
}
