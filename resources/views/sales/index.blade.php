@extends('layouts.app')

@section('title', 'Sales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0"><i class="bi bi-cart-check"></i> Sales Management</h1>
    @if(in_array(auth()->user()->role, ['admin', 'cashier']))
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="bi bi-cart-plus"></i> Record New Sale
    </a>
    @endif
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('sales.index') }}" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by sale ID, product, or customer name..." value="{{ $search }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Search</button>
            </div>
            @if($search)
            <div class="col-md-2">
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sale #</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Cashier</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>#{{ $sale->sale_id }}</td>
                        <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                        <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>Rs.{{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->cashier->name ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-receipt"></i> <span class="d-none d-sm-inline">Bill</span>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline" onsubmit="return confirm('Void this sale and restore stock?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No sales recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($sales->hasPages())
    <div class="card-footer bg-white">
        {{ $sales->links('vendor.pagination.sales') }}
    </div>
    @endif
</div>
@endsection
