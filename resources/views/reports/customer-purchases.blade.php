@extends('layouts.app')

@section('title', 'Customer Purchase Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
    <h1 class="h3 mb-0"><i class="bi bi-person-lines-fill"></i> Customer Purchase Report</h1>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" onclick="window.print()" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Print</button>
        <button type="button" class="btn btn-primary" data-pdf-download data-pdf-target="#pdfContent" data-pdf-filename="customer-purchase-report.pdf">
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
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total Purchases</th>
                        <th>Total Spent</th>
                        <th>Last Purchase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone ?: '—' }}</td>
                        <td>{{ $customer->sales->count() }}</td>
                        <td>Rs. {{ number_format($customer->sales->sum('total_amount'), 2) }}</td>
                        <td>{{ optional($customer->sales->first())->sale_date?->format('M d, Y') ?? 'No purchases yet' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
