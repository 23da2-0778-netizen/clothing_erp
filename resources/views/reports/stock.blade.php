@extends('layouts.app')

@section('title', 'Product Stock Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
    <h1 class="h3 mb-0"><i class="bi bi-box-seam"></i> Product Stock Report</h1>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" onclick="window.print()" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Print</button>
        <button type="button" class="btn btn-primary" data-pdf-download data-pdf-target="#pdfContent" data-pdf-filename="stock-report.pdf">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </button>
    </div>
</div>

<div id="pdfContent">
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock Level</th>
                        <th>Stock Value</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="{{ $product->quantity == 0 ? 'table-danger' : ($product->quantity <= $lowStockThreshold ? 'table-warning' : '') }}">
                        <td>#{{ $product->product_id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>Rs. {{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>Rs. {{ number_format($product->price * $product->quantity, 2) }}</td>
                        <td>
                            @if($product->quantity == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->quantity <= $lowStockThreshold)
                                <span class="badge bg-warning text-dark">Low Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="5" class="text-end">Total Inventory Value</td>
                        <td>Rs. {{ number_format($products->sum(fn($p) => $p->price * $p->quantity), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
