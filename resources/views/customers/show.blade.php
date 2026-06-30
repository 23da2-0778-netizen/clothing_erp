@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('customers.index') }}" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Customers</a>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-person-circle"></i> {{ $customer->name }}</h5>
                <p class="mb-1"><i class="bi bi-telephone"></i> {{ $customer->phone ?: 'No phone on file' }}</p>
                <p class="mb-3"><i class="bi bi-envelope"></i> {{ $customer->email ?: 'No email on file' }}</p>
                <div class="border-top pt-3">
                    <p class="text-muted small mb-1">Total Spent</p>
                    <h4>Rs. {{ number_format($purchaseHistory->sum('total_amount'), 2) }}</h4>
                </div>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-pencil"></i> Edit Customer
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-bag-check"></i> Purchase History</h5>
            </div>
            <div class="card-body p-0">
                @if($purchaseHistory->isEmpty())
                    <p class="text-muted p-3 mb-0">No purchases recorded for this customer yet.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchaseHistory as $sale)
                            <tr>
                                <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                                <td>{{ $sale->product->product_name ?? 'N/A' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
