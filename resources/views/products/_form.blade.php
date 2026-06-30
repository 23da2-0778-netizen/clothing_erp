@php($product = $product ?? null)

<div class="mb-3">
    <label for="product_name" class="form-label">Product Name</label>
    <input type="text" class="form-control @error('product_name') is-invalid @enderror"
           id="product_name" name="product_name" value="{{ old('product_name', $product?->product_name) }}" 
           placeholder="e.g. Premium Cotton T-Shirt" required minlength="2" maxlength="255">
    @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Minimum 2 characters, must be a unique product name.</div>
</div>

<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <input type="text" class="form-control @error('category') is-invalid @enderror"
           id="category" name="category" value="{{ old('category', $product?->category) }}"
           list="categorySuggestions" placeholder="e.g. Men, Women, Kids, Accessories" required maxlength="255">
    <datalist id="categorySuggestions">
        <option value="Men">
        <option value="Women">
        <option value="Kids">
        <option value="Unisex">
        <option value="Accessories">
        <option value="Outerwear">
    </datalist>
    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Choose from suggestions or type a custom category.</div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price (Rs.)</label>
        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
               id="price" name="price" value="{{ old('price', $product?->price) }}" 
               placeholder="0.00" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Must be a positive number or zero.</div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label">Stock Quantity</label>
        <input type="number" min="0" class="form-control @error('quantity') is-invalid @enderror"
               id="quantity" name="quantity" value="{{ old('quantity', $product?->quantity) }}" 
               placeholder="0" required>
        @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Must be a positive integer or zero.</div>
    </div>
</div>
