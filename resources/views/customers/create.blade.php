@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('customers.index') }}" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Add New Customer</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('customers.store') }}">
                    @csrf
                    @include('customers._form')
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle"></i> Save Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
