<?php ($product = $product ?? null); ?>

<div class="mb-3">
    <label for="product_name" class="form-label">Product Name</label>
    <input type="text" class="form-control <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           id="product_name" name="product_name" value="<?php echo e(old('product_name', $product?->product_name)); ?>" 
           placeholder="e.g. Premium Cotton T-Shirt" required minlength="2" maxlength="255">
    <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <div class="form-text">Minimum 2 characters, must be a unique product name.</div>
</div>

<div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <input type="text" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           id="category" name="category" value="<?php echo e(old('category', $product?->category)); ?>"
           list="categorySuggestions" placeholder="e.g. Men, Women, Kids, Accessories" required maxlength="255">
    <datalist id="categorySuggestions">
        <option value="Men">
        <option value="Women">
        <option value="Kids">
        <option value="Unisex">
        <option value="Accessories">
        <option value="Outerwear">
    </datalist>
    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <div class="form-text">Choose from suggestions or type a custom category.</div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="price" class="form-label">Price (Rs.)</label>
        <input type="number" step="0.01" min="0" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="price" name="price" value="<?php echo e(old('price', $product?->price)); ?>" 
               placeholder="0.00" required>
        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="form-text">Must be a positive number or zero.</div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label">Stock Quantity</label>
        <input type="number" min="0" class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               id="quantity" name="quantity" value="<?php echo e(old('quantity', $product?->quantity)); ?>" 
               placeholder="0" required>
        <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="form-text">Must be a positive integer or zero.</div>
    </div>
</div>
<?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/products/_form.blade.php ENDPATH**/ ?>