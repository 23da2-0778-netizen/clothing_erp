<?php $__env->startSection('title', 'Add Customer'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center mb-4">
            <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-link text-decoration-none"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Add New Customer</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('customers.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo $__env->make('customers._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-check-circle"></i> Save Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/customers/create.blade.php ENDPATH**/ ?>