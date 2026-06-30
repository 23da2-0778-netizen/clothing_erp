@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
            <i class="bi bi-shop text-primary" style="font-size: 2.5rem;"></i>
            <h2 class="fw-bold mt-2">Clothing Shop ERP</h2>
            <p class="text-muted">Sign in to manage your shop</p>
        </div>

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">
                <i class="bi bi-box-arrow-in-right"></i> Sign in
            </button>
        </form>

        <hr class="my-4">
        <div class="small text-muted">
            <p class="mb-1 fw-semibold">Demo accounts (seeded):</p>
            <p class="mb-1">Admin: admin@clothingerp.test / Admin@1234</p>
            <p class="mb-1">Cashier: cashier@clothingerp.test / Cashier@1234</p>
            <p class="mb-0">Manager: manager@clothingerp.test / Manager@1234</p>
        </div>
    </div>
</div>
@endsection
