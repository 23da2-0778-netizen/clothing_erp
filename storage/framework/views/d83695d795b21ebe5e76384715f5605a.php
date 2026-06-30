<?php $__env->startSection('title', 'Customers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0"><i class="bi bi-people"></i> Customer Management</h1>
    <?php if(auth()->user()->role === 'admin'): ?>
    <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> Add New Customer
    </a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('customers.index')); ?>" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by name, phone, or email..." value="<?php echo e($search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Search</button>
            </div>
            <?php if($search): ?>
            <div class="col-md-2">
                <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-outline-secondary w-100">Clear</a>
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>#<?php echo e($customer->customer_id); ?></td>
                        <td><?php echo e($customer->name); ?></td>
                        <td><?php echo e($customer->phone ?: '—'); ?></td>
                        <td><?php echo e($customer->email ?: '—'); ?></td>
                        <td class="text-end">
                            <a href="<?php echo e(route('customers.show', $customer)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-clock-history"></i> <span class="d-none d-sm-inline">History</span>
                            </a>
                            <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer?');">
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
                        <td colspan="5" class="text-center text-muted py-4">No customers found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($customers->hasPages()): ?>
<div class="card-footer bg-white">
    <?php echo e($customers->links()); ?>

</div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/customers/index.blade.php ENDPATH**/ ?>