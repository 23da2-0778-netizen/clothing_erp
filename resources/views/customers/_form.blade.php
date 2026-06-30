@php($customer = $customer ?? null)

<div class="mb-3">
    <label for="name" class="form-label">Customer Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name" value="{{ old('name', $customer?->name) }}" 
           placeholder="e.g. John Doe" required minlength="2" maxlength="255">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Minimum 2 characters, only letters, spaces, or hyphens.</div>
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone Number</label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror"
           id="phone" name="phone" value="{{ old('phone', $customer?->phone) }}"
           placeholder="e.g. +94 77 123 4567" pattern="[0-9\s\-\+\(\)]*"
           title="Only numbers, spaces, dashes, parentheses, and plus sign are allowed.">
    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Optional. Only numbers, spaces, dashes (-), parentheses (), and (+) are allowed.</div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror"
           id="email" name="email" value="{{ old('email', $customer?->email) }}"
           placeholder="e.g. johndoe@example.com">
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Optional. Must be a valid unique email address.</div>
</div>
