<?php $__env->startSection('title', 'Monthly Sales Report'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 d-print-none">
    <h1 class="h3 mb-0"><i class="bi bi-calendar-month"></i> Monthly Sales Report</h1>
    <div class="d-flex gap-2 flex-wrap">
        <button type="button" onclick="window.print()" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Print</button>
        <button type="button" class="btn btn-primary" data-pdf-download data-pdf-target="#pdfContent" data-pdf-filename="monthly-report-<?php echo e($month); ?>-<?php echo e($year); ?>.pdf">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm mb-3 d-print-none">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('reports.monthly')); ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Month</label>
                <select name="month" class="form-select">
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m); ?>" <?php echo e($month == $m ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::create()->month($m)->format('F')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Year</label>
                <select name="year" class="form-select">
                    <?php $__currentLoopData = range(now()->year, now()->year - 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">View</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted small mb-1">Total Sales — <?php echo e(\Carbon\Carbon::create()->month($month)->format('F')); ?> <?php echo e($year); ?></p>
                <h3>Rs. <?php echo e(number_format($totalAmount, 2)); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted small mb-1">Items Sold</p>
                <h3><?php echo e($totalItems); ?></h3>
            </div>
        </div>
    </div>
</div>

<div id="pdfContent">
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">Daily Breakdown</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Date</th><th>Sales</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dailyBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($day)->format('M d')); ?></td>
                                <td><?php echo e($data['count']); ?></td>
                                <td>Rs. <?php echo e(number_format($data['total'], 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">No data</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><h6 class="mb-0">All Transactions</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Date</th><th>Product</th><th>Customer</th><th>Qty</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($sale->sale_date->format('M d')); ?></td>
                                <td><?php echo e($sale->product->product_name ?? 'N/A'); ?></td>
                                <td><?php echo e($sale->customer->name ?? 'Walk-in'); ?></td>
                                <td><?php echo e($sale->quantity); ?></td>
                                <td>Rs. <?php echo e(number_format($sale->total_amount, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No sales recorded for this month.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/reports/monthly.blade.php ENDPATH**/ ?>