<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Clothing Shop ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-shop"></i> Clothing Shop ERP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-bag"></i> Products
                        </a>
                    </li>
                    @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager', 'cashier']))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sales.*') ? 'active fw-bold' : '' }}" href="{{ route('sales.index') }}">
                            <i class="bi bi-cart-check"></i> Sales
                        </a>
                    </li>
                    @endif
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customers.*') ? 'active fw-bold' : '' }}" href="{{ route('customers.index') }}">
                            <i class="bi bi-people"></i> Customers
                        </a>
                    </li>
                    @auth
                    @if(in_array(auth()->user()->role, ['admin', 'manager']))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active fw-bold' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bar-chart"></i> Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.daily') }}">Daily Sales Report</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.monthly') }}">Monthly Sales Report</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.stock') }}">Product Stock Report</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.customer-purchases') }}">Customer Purchase Report</a></li>
                        </ul>
                    </li>
                    @endif
                    @endauth
                </ul>
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item d-flex align-items-center me-3">
                        <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                        <span class="text-light ms-2">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-light btn-sm" type="submit">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center text-muted py-4 border-top mt-4">
        <small>&copy; {{ date('Y') }} Clothing Shop ERP Management System</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
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
    @yield('scripts')
</body>
</html>
