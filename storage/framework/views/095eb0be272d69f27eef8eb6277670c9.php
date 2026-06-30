<?php $__env->startSection('title', 'Product Stock Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
    <h1 class="h3 mb-0"><i class="bi bi-box-seam"></i> Product Stock Report</h1>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" onclick="window.print()" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Print</button>
        <button type="button" class="btn btn-primary" data-pdf-download data-pdf-target="#pdfContent" data-pdf-filename="stock-report.pdf">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </button>
    </div>
</div>

<div id="pdfContent">
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock Level</th>
                        <th>Stock Value</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($product->quantity == 0 ? 'table-danger' : ($product->quantity <= $lowStockThreshold ? 'table-warning' : '')); ?>">
                        <td>#<?php echo e($product->product_id); ?></td>
                        <td><?php echo e($product->product_name); ?></td>
                        <td><?php echo e($product->category); ?></td>
                        <td>Rs. <?php echo e(number_format($product->price, 2)); ?></td>
                        <td><?php echo e($product->quantity); ?></td>
                        <td>Rs. <?php echo e(number_format($product->price * $product->quantity, 2)); ?></td>
                        <td>
                            <?php if($product->quantity == 0): ?>
                                <span class="badge bg-danger">Out of Stock</span>
                            <?php elseif($product->quantity <= $lowStockThreshold): ?>
                                <span class="badge bg-warning text-dark">Low Stock</span>
                            <?php else: ?>
                                <span class="badge bg-success">In Stock</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="5" class="text-end">Total Inventory Value</td>
                        <td>Rs. <?php echo e(number_format($products->sum(fn($p) => $p->price * $p->quantity), 2)); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/reports/stock.blade.php ENDPATH**/ ?>