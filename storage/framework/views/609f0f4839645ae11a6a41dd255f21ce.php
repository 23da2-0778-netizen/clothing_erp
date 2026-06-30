<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - Clothing Shop ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-shop"></i> Clothing Shop ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('products.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('products.index')); ?>">
                            <i class="bi bi-bag"></i> Products
                        </a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(in_array(auth()->user()->role, ['admin', 'manager', 'cashier'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('sales.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('sales.index')); ?>">
                            <i class="bi bi-cart-check"></i> Sales
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('customers.*') ? 'active fw-bold' : ''); ?>" href="<?php echo e(route('customers.index')); ?>">
                            <i class="bi bi-people"></i> Customers
                        </a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(in_array(auth()->user()->role, ['admin', 'manager'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e(request()->routeIs('reports.*') ? 'active fw-bold' : ''); ?>" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bar-chart"></i> Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('reports.daily')); ?>">Daily Sales Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('reports.monthly')); ?>">Monthly Sales Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('reports.stock')); ?>">Product Stock Report</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('reports.customer-purchases')); ?>">Customer Purchase Report</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <?php if(auth()->guard()->check()): ?>
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center me-3">
                        <span class="badge bg-secondary text-uppercase"><?php echo e(auth()->user()->role); ?></span>
                        <span class="text-light ms-2"><?php echo e(auth()->user()->name); ?></span>
                    </li>
                    <li class="nav-item">
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-outline-light btn-sm" type="submit">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <footer class="text-center text-muted py-4 border-top mt-4">
        <small>&copy; <?php echo e(date('Y')); ?> Clothing Shop ERP Management System</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-pdf-download]').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    var targetSelector = button.dataset.pdfTarget || '#pdfContent';
                    var content = document.querySelector(targetSelector);
                    if (!content) {
                        return;
                    }
                    var filename = button.dataset.pdfFilename || 'document.pdf';
                    var options = {
                        margin: 0.4,
                        filename: filename,
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2, useCORS: true },
                        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                    };
                    html2pdf().set(options).from(content).save();
                });
            });
        });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MSI PC\Desktop\clothing-erp\clothing-erp\resources\views/layouts/app.blade.php ENDPATH**/ ?>