@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('products.index') }}" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Product</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    @include('products._form')
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle"></i> Save Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
