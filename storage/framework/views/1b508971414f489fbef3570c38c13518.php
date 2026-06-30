<?php $__env->startSection('title', 'Sale Receipt'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2 d-print-none">
    <a href="<?php echo e(route('sales.index')); ?>" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Sales</a>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" onclick="window.print()" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Print</button>
        <button type="button" class="btn btn-primary" data-pdf-download data-pdf-target="#pdfContent" data-pdf-filename="bill-<?php echo e($sale->sale_id); ?>.pdf">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </button>
    </div>
</div>

<div id="pdfContent">
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-shop"></i> Clothing Shop ERP</h4>
                    <p class="text-muted mb-0">Sales Receipt</p>
                </div>

                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Bill No.</span>
                    <strong>#<?php echo e(str_pad($sale->sale_id, 6, '0', STR_PAD_LEFT)); ?></strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Date</span>
                    <strong><?php echo e($sale->sale_date->format('F d, Y')); ?></strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Customer</span>
                    <strong><?php echo e($sale->customer->name ?? 'Walk-in Customer'); ?></strong>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="text-muted">Served by</span>
                    <strong><?php echo e($sale->cashier->name ?? 'N/A'); ?></strong>
                </div>

                <table class="table table-borderless mb-3">
                    <thead>
                        <tr class="border-bottom">
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sale->saleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->product->product_name ?? 'N/A'); ?></td>
                            <td class="text-center"><?php echo e($item->quantity); ?></td>
                            <td class="text-end">Rs.<?php echo e(number_format($item->unit_price, 2)); ?></td>
                            <td class="text-end">Rs.<?php echo e(number_format($item->total_amount, 2)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td><?php echo e($sale->product->product_name ?? 'N/A'); ?></td>
                            <td class="text-center"><?php echo e($sale->quantity); ?></td>
                            <td class="text-end">Rs.<?php echo e(number_format($sale->unit_price, 2)); ?></td>
                            <td class="text-end">Rs.<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if($sale->discount > 0): ?>
                <div class="d-flex justify-content-between border-top pt-3 mb-2">
                    <span class="text-muted">Discount</span>
                    <strong>- Rs.<?php echo e(number_format($sale->discount, 2)); ?></strong>
                </div>
                <?php endif; ?>
                <div class="d-flex justify-content-between border-top pt-3">
                    <h5>Total</h5>
                    <h5>Rs.<?php echo e(number_format($sale->total_amount, 2)); ?></h5>
                </div>

                <p class="text-center text-muted small mt-4 mb-0">Thank you for shopping with us!</p>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<style>
    @media print {
        .navbar, footer, .d-print-none { display: none !important; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/sales/show.blade.php ENDPATH**/ ?>