@php($customer = $customer ?? null)

<div class="mb-3">
    <label for="name" class="form-label">Customer Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name" value="{{ old('name', $customer?->name) }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone Number</label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror"
           id="phone" name="phone" value="{{ old('phone', $customer?->phone) }}">
    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror"
           id="email" name="email" value="{{ old('email', $customer?->email) }}">
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
