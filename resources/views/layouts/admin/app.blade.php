<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DapurRoti Admin')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F6FA;
            overflow-x: hidden;
        }
        
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(135deg, #052c65, #0d47a1);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.75rem 1.5rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .content-main {
            flex: 1;
            padding: 20px;
            overflow-x: auto;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            .sidebar .nav-link span {
                display: none;
            }
            .sidebar .nav-link {
                justify-content: center;
            }
            .sidebar .nav-link i {
                margin-right: 0;
            }
            .content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 250px; /* Keep full sidebar on mobile */
            }
            .sidebar .nav-link span {
                display: inline;
            }
            .sidebar .nav-link {
                justify-content: flex-start;
            }
            .sidebar .nav-link i {
                margin-right: 10px;
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
        }
        
        .navbar-brand {
            color: white !important;
        }
        
        .bg-primary {
            background-color: #052c65 !important;
        }
        
        .bg-light {
            background-color: #F8F9FA !important;
        }
        
        .bg-white {
            background-color: #FFFFFF !important;
        }
    </style>
</head>
<body>
    <div class="wrapper d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="p-3 text-center">
                <img src="{{ asset('logo.png') }}" alt="DapurRoti Logo" height="60" class="mb-2">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" 
                       href="{{ route('admin.products.index') }}">
                        <i class="bi bi-cart"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i> Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt"></i> Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-file-earmark-bar-graph"></i> Laporan
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <a class="nav-link" href="{{ route('admin.logout') }}" 
                       onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin logout?')) { document.getElementById('logout-form').submit(); }">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="content-main">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>