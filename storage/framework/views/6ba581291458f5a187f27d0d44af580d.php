<?php $__env->startSection('title', 'Sales'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0"><i class="bi bi-cart-check"></i> Sales Management</h1>
    <?php if(in_array(auth()->user()->role, ['admin', 'cashier'])): ?>
    <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-primary">
        <i class="bi bi-cart-plus"></i> Record New Sale
    </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('sales.index')); ?>" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by sale ID, product, or customer name..." value="<?php echo e($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Search</button>
            </div>
            <?php if($search): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-outline-secondary w-100">Clear</a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sale #</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Cashier</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($sale->sale_id); ?></td>
                        <td><?php echo e($sale->sale_date->format('M d, Y')); ?></td>
                        <td><?php echo e($sale->product->product_name ?? 'N/A'); ?></td>
                        <td><?php echo e($sale->customer->name ?? 'Walk-in'); ?></td>
                        <td><?php echo e($sale->quantity); ?></td>
                        <td>Rs.<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                        <td><?php echo e($sale->cashier->name ?? '—'); ?></td>
                        <td class="text-end">
                            <a href="<?php echo e(route('sales.show', $sale)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-receipt"></i> <span class="d-none d-sm-inline">Bill</span>
                            </a>
                            <?php if(auth()->user()->role === 'admin'): ?>
                            <form action="<?php echo e(route('sales.destroy', $sale)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Void this sale and restore stock?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No sales recorded yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($sales->hasPages()): ?>
    <div class="card-footer bg-white">
        <?php echo e($sales->links('vendor.pagination.sales')); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/sales/index.blade.php ENDPATH**/ ?>