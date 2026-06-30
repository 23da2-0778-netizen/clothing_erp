<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="h3 mb-4">Welcome, <?php echo e($user->name); ?> <span class="badge bg-secondary text-uppercase fs-6"><?php echo e($user->role); ?></span></h1>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Products</p>
                        <h3 class="mb-0"><?php echo e($totalProducts); ?></h3>
                    </div>
                    <i class="bi bi-bag-fill text-primary fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Low Stock Items</p>
                        <h3 class="mb-0 <?php echo e($lowStockCount > 0 ? 'text-danger' : ''); ?>"><?php echo e($lowStockCount); ?></h3>
                    </div>
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Customers</p>
                        <h3 class="mb-0"><?php echo e($totalCustomers); ?></h3>
                    </div>
                    <i class="bi bi-people-fill text-info fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Today's Sales</p>
                        <h3 class="mb-0">Rs. <?php echo e(number_format($todaySalesTotal, 2)); ?></h3>
                    </div>
                    <i class="bi bi-cash-coin text-success fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Sales</h5>
            </div>
            <div class="card-body p-0">
                <?php if($recentSales->isEmpty()): ?>
                    <p class="text-muted p-3 mb-0">No sales recorded yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($sale->sale_date->format('M d, Y')); ?></td>
                                <td><?php echo e($sale->product->product_name ?? 'N/A'); ?></td>
                                <td><?php echo e($sale->customer->name ?? 'Walk-in'); ?></td>
                                <td><?php echo e($sale->quantity); ?></td>
                                <td>Rs. <?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning-charge"></i> Quick Actions</h5>
            </div>
            <div class="card-body d-grid gap-2">
                <?php if(in_array($user->role, ['admin', 'cashier'])): ?>
                <a href="<?php echo e(route('sales.create')); ?>" class="btn btn-primary"><i class="bi bi-cart-plus"></i> Record New Sale</a>
                <?php endif; ?>
                <?php if($user->role === 'admin'): ?>
                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-outline-secondary"><i class="bi bi-plus-circle"></i> Add Product</a>
                <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-outline-secondary"><i class="bi bi-person-plus"></i> Add Customer</a>
                <?php endif; ?>
                <?php if(in_array($user->role, ['admin', 'manager'])): ?>
                <a href="<?php echo e(route('reports.daily')); ?>" class="btn btn-outline-dark"><i class="bi bi-file-earmark-bar-graph"></i> View Reports</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body">
                <p class="text-muted small mb-1">This Month's Sales</p>
                <h4 class="mb-0">Rs. <?php echo e(number_format($monthSalesTotal, 2)); ?></h4>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/dashboard/index.blade.php ENDPATH**/ ?>