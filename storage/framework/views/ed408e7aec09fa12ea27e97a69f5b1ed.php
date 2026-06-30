<?php $__env->startSection('title', 'Record Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center mb-4">
            <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-cart-plus"></i> Record New Sale</h5>
            </div>
            <div class="card-body">
                <?php if($products->isEmpty()): ?>
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle"></i> No products are currently in stock. Please ask an admin to add inventory before recording a sale.
                    </div>
                <?php else: ?>
                <form method="POST" action="<?php echo e(route('sales.store')); ?>" id="saleForm">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Products</label>
                        <div id="saleItems">
                            <?php
                                $oldProducts = old('product_id', [null]);
                                $oldQuantities = old('quantity', [1]);
                            ?>
                            <?php $__currentLoopData = $oldProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $oldProductId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="sale-item row g-2 align-items-end mb-3">
                                    <div class="col-8 col-md-5">
                                        <label class="form-label visually-hidden">Product</label>
                                        <select class="form-select product-select" name="product_id[]" required>
                                            <option value="">-- Select a product --</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->product_id); ?>"
                                                    data-price="<?php echo e($product->price); ?>"
                                                    data-stock="<?php echo e($product->quantity); ?>"
                                                    <?php echo e((string) old('product_id.' . $index, $oldProductId) === (string) $product->product_id ? 'selected' : ''); ?>>
                                                    <?php echo e($product->product_name); ?> — Rs. <?php echo e(number_format($product->price, 2)); ?> (<?php echo e($product->quantity); ?> in stock)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-4 col-md-3">
                                        <label class="form-label visually-hidden">Quantity</label>
                                        <input type="number" min="1" class="form-control quantity-input" name="quantity[]"
                                               value="<?php echo e(old('quantity.' . $index, $oldQuantities[$index] ?? 1)); ?>" required>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="addItemBtn">Add another product</button>
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer <span class="text-muted">(optional)</span></label>
                        <select class="form-select <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="customer_id" name="customer_id">
                            <option value="">Walk-in customer</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->customer_id); ?>" <?php echo e(old('customer_id') == $customer->customer_id ? 'selected' : ''); ?>>
                                <?php echo e($customer->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="sale_date" class="form-label">Sale Date</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['sale_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="sale_date" name="sale_date" value="<?php echo e(old('sale_date', date('Y-m-d'))); ?>" required>
                        <?php $__errorArgs = ['sale_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">Discount <span class="text-muted">(optional)</span></label>
                        <input type="number" step="0.01" min="0" class="form-control <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="discount" name="discount" value="<?php echo e(old('discount', 0)); ?>">
                        <div class="form-text">Enter a discount amount to reduce the invoice total.</div>
                        <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div id="totalAmountWrapper" class="alert alert-info d-flex justify-content-between align-items-center">
                        <span>Total Amount:</span>
                        <strong id="totalDisplay">Rs.0.00</strong>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle"></i> Complete Sale
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const saleItemsContainer = document.getElementById('saleItems');
    const addItemBtn = document.getElementById('addItemBtn');
    const discountInput = document.getElementById('discount');

    const productOptionsHtml = `
        <option value="">-- Select a product --</option>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($product->product_id); ?>" data-price="<?php echo e($product->price); ?>" data-stock="<?php echo e($product->quantity); ?>">
                <?php echo e($product->product_name); ?> — Rs. <?php echo e(number_format($product->price, 2)); ?> (<?php echo e($product->quantity); ?> in stock)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/sales/create.blade.php ENDPATH**/ ?>