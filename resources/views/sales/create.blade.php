@extends('layouts.app')

@section('title', 'Record Sale')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('sales.index') }}" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Record New Sale</h5>
            </div>
            <div class="card-body">
                @if($products->isEmpty())
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle"></i> No products are currently in stock. Please ask an admin to add inventory before recording a sale.
                    </div>
                @else
                <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Products</label>
                        <div id="saleItems">
                            @php
                                $oldProducts = old('product_id', [null]);
                                $oldQuantities = old('quantity', [1]);
                            @endphp
                            @foreach($oldProducts as $index => $oldProductId)
                                <div class="sale-item row g-2 align-items-end mb-3">
                                    <div class="col-8 col-md-5">
                                        <label class="form-label visually-hidden">Product</label>
                                        <select class="form-select product-select" name="product_id[]" required>
                                            <option value="">-- Select a product --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->product_id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->quantity }}"
                                                    {{ (string) old('product_id.' . $index, $oldProductId) === (string) $product->product_id ? 'selected' : '' }}>
                                                    {{ $product->product_name }} — Rs. {{ number_format($product->price, 2) }} ({{ $product->quantity }} in stock)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <label class="form-label visually-hidden">Quantity</label>
                                        <input type="number" min="1" class="form-control quantity-input" name="quantity[]"
                                               value="{{ old('quantity.' . $index, $oldQuantities[$index] ?? 1) }}" required>
                                        <div class="form-text stock-hint"></div>
                                    </div>
                                    
                                    <div class="col-8 col-md-3">
                                        <label class="form-label">Line Total</label>
                                        <div class="form-control-plaintext fw-bold line-total">Rs.0.00</div>
                                    </div>
                                    <div class="col-4 col-md-1 text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-item" aria-label="Remove item">&times;</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="addItemBtn">Add another product</button>
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer <span class="text-muted">(optional)</span></label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id">
                            <option value="">Walk-in customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('customer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="sale_date" class="form-label">Sale Date</label>
                        <input type="date" class="form-control @error('sale_date') is-invalid @enderror"
                               id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                        @error('sale_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount <span class="text-muted">(optional)</span></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount', 0) }}">
                        <div class="form-text">Enter a discount amount to reduce the invoice total.</div>
                        @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div id="totalAmountWrapper" class="alert alert-info d-flex justify-content-between align-items-center">
                        <span>Total Amount:</span>
                        <strong id="totalDisplay">Rs.0.00</strong>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle"></i> Complete Sale
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const saleItemsContainer = document.getElementById('saleItems');
    const addItemBtn = document.getElementById('addItemBtn');
    const discountInput = document.getElementById('discount');

    const productOptionsHtml = `
        <option value="">-- Select a product --</option>
        @foreach($products as $product)
            <option value="{{ $product->product_id }}" data-price="{{ $product->price }}" data-stock="{{ $product->quantity }}">
                {{ $product->product_name }} — Rs. {{ number_format($product->price, 2) }} ({{ $product->quantity }} in stock)
            </option>
        @endforeach
    `;

    function bindSaleItemEvents(row) {
        const select = row.querySelector('.product-select');
        const quantity = row.querySelector('.quantity-input');
        const removeBtn = row.querySelector('.remove-item');

        select.addEventListener('change', () => updateRowTotal(row, true));
        quantity.addEventListener('input', () => updateRowTotal(row, false));
        quantity.addEventListener('change', () => updateRowTotal(row, true));
        removeBtn.addEventListener('click', () => {
            if (saleItemsContainer.children.length > 1) {
                row.remove();
                updateTotal();
            }
        });
    }

    function createSaleItem(selectedValue = '', quantityValue = 1) {
        const row = document.createElement('div');
        row.className = 'sale-item row g-2 align-items-end mb-3';
        row.innerHTML = `
            <div class="col-8 col-md-5">
                <label class="form-label visually-hidden">Product</label>
                <select class="form-select product-select" name="product_id[]" required>
                    ${productOptionsHtml}
                </select>
            </div>
            <div class="col-4 col-md-3">
                <label class="form-label visually-hidden">Quantity</label>
                <input type="number" step="1" min="1" class="form-control quantity-input" name="quantity[]" value="${quantityValue}" required>
                <div class="form-text stock-hint"></div>
            </div>
            <div class="col-8 col-md-3">
                <label class="form-label">Line Total</label>
                <div class="form-control-plaintext fw-bold line-total">Rs.0.00</div>
            </div>
            <div class="col-4 col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-item" aria-label="Remove item">&times;</button>
            </div>
        `;

        if (selectedValue) {
            row.querySelector('.product-select').value = selectedValue;
        }

        bindSaleItemEvents(row);

        return row;
    }

    function parseNumeric(value, fallback = 0) {
        const number = Number(value);
        if (Number.isFinite(number)) {
            return number;
        }
        const parsed = parseFloat(String(value).replace(/[^0-9.\-]/g, ''));
        return Number.isFinite(parsed) ? parsed : fallback;
    }

    function updateRowTotal(row, normalize = false) {
        const select = row.querySelector('.product-select');
        const quantity = row.querySelector('.quantity-input');
        const lineTotal = row.querySelector('.line-total');
        const stockHint = row.querySelector('.stock-hint');

        const selectedOption = select.options[select.selectedIndex];
        const price = parseNumeric(selectedOption?.dataset?.price, 0);
        const stock = parseInt(selectedOption?.dataset?.stock || 0, 10);
        let qty = parseNumeric(quantity.value, NaN);

        if (!Number.isFinite(qty) || qty < 1) {
            if (normalize) {
                qty = 1;
                quantity.value = qty;
            } else {
                qty = 0;
            }
        } else {
            qty = Math.floor(qty);
            if (normalize) {
                quantity.value = qty;
            }
        }

        if (selectedOption && selectedOption.value) {
            if (stock > 0) {
                stockHint.textContent = `${stock} unit(s) available`;
                quantity.max = stock;
                if (qty > stock) {
                    qty = stock;
                    quantity.value = qty;
                }
            } else {
                stockHint.textContent = 'Out of stock';
                quantity.removeAttribute('max');
                if (qty > 1) {
                    qty = 1;
                    quantity.value = qty;
                }
            }
        } else {
            stockHint.textContent = '';
            quantity.removeAttribute('max');
        }

        const subtotal = price * (qty > 0 ? qty : 0);
        lineTotal.textContent = `Rs.${subtotal.toFixed(2)}`;
        updateTotal();
    }

    function updateTotal() {
        const rows = saleItemsContainer.querySelectorAll('.sale-item');
        let subtotalTotal = 0;

        rows.forEach((row) => {
            const select = row.querySelector('.product-select');
            const quantity = row.querySelector('.quantity-input');
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                return;
            }

            const price = parseNumeric(selectedOption?.dataset?.price, 0);
            const qty = parseNumeric(quantity.value, 0);
            const subtotal = price * (qty > 0 ? qty : 0);
            subtotalTotal += subtotal;
        });

        let discount = 0;
        if (discountInput) {
            discount = parseNumeric(discountInput.value, 0);
            if (discount < 0) {
                discount = 0;
            }
        }

        const display = createOrGetTotalDisplay();
        if (display) {
            const netTotal = Math.max(0, subtotalTotal - discount);
            display.textContent = `Rs.${netTotal.toFixed(2)}`;
        }
    }

    function createOrGetTotalDisplay() {
        let display = document.getElementById('totalDisplay');
        if (display) {
            return display;
        }

        let totalWrapper = document.getElementById('totalAmountWrapper');
        if (!totalWrapper) {
            const saleForm = document.getElementById('saleForm');
            const submitButton = saleForm?.querySelector('button[type="submit"]');
            if (saleForm && submitButton) {
                totalWrapper = document.createElement('div');
                totalWrapper.id = 'totalAmountWrapper';
                totalWrapper.className = 'alert alert-info d-flex justify-content-between align-items-center';
                saleForm.insertBefore(totalWrapper, submitButton);
            }
        }

        if (totalWrapper) {
            display = totalWrapper.querySelector('#totalDisplay');
            if (!display) {
                const label = document.createElement('span');
                label.textContent = 'Total Amount:';
                const strong = document.createElement('strong');
                strong.id = 'totalDisplay';
                strong.textContent = 'Rs.0.00';
                totalWrapper.appendChild(label);
                totalWrapper.appendChild(strong);
                display = strong;
            }
        }
        return display;
    }

    if (saleItemsContainer) {
        addItemBtn.addEventListener('click', () => {
            const row = createSaleItem();
            saleItemsContainer.appendChild(row);
            updateRowTotal(row);
        });

        saleItemsContainer.querySelectorAll('.sale-item').forEach((row) => {
            bindSaleItemEvents(row);
            updateRowTotal(row);
        });

        if (discountInput) {
            discountInput.addEventListener('input', () => updateTotal());
            discountInput.addEventListener('change', () => updateTotal());
        }

        // Keep the total visible by recalculating periodically and restoring the wrapper if removed.
        setInterval(updateTotal, 1000);

        const observer = new MutationObserver(() => {
            if (!document.getElementById('totalAmountWrapper')) {
                const saleForm = document.getElementById('saleForm');
                const submitButton = saleForm?.querySelector('button[type="submit"]');
                if (saleForm && submitButton) {
                    const wrapper = document.createElement('div');
                    wrapper.id = 'totalAmountWrapper';
                    wrapper.className = 'alert alert-info d-flex justify-content-between align-items-center';
                    wrapper.style.display = 'flex';
                    wrapper.style.visibility = 'visible';
                    const label = document.createElement('span');
                    label.textContent = 'Total Amount:';
                    const strong = document.createElement('strong');
                    strong.id = 'totalDisplay';
                    strong.textContent = 'Rs.0.00';
                    wrapper.appendChild(label);
                    wrapper.appendChild(strong);
                    saleForm.insertBefore(wrapper, submitButton);
                    updateTotal();
                }
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }
</script>
@endsection
