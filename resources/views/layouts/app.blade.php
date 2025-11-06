<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DapurRoti - Toko Roti & Kue')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Additional CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F6FA;
        }
        
        .btn-primary {
            background-color: #1E88E5;
            border-color: #1E88E5;
        }
        
        .btn-primary:hover {
            background-color: #42A5F5;
            border-color: #42A5F5;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }
        
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .produk-card {
            height: 100%;
        }
        
        .produk-image {
            height: 200px;
            object-fit: cover;
            border-radius: 0.375rem 0.375rem 0 0;
        }
        
        .harga-asli {
            text-decoration: line-through;
            color: #6c757d !important;
        }
        
        .harga-diskon {
            color: #28a745;
            font-weight: 600;
        }
        
        .footer {
            background-color: #052c65;
            color: white;
        }
        
        .bg-primary {
            background-color: #1E88E5 !important;
        }
        
        .bg-light {
            background-color: #F5F6FA !important;
        }
        
        .bg-white {
            background-color: #FFFFFF !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="padding-top: 0.8rem; padding-bottom: 0.8rem;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="DapurRoti Logo" height="50">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kategoriDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                            @forelse($categories ?? [] as $category)
                                <li><a class="dropdown-item" href="{{ route('category.show', $category->id) }}">{{ $category->nama_kategori }}</a></li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Belum ada kategori</span></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tentang-kami') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="komunikasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Komunikasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="komunikasiDropdown">
                            <li><a class="dropdown-item" href="/kontak">Kontak Kami</a></li>
                            <li><a class="dropdown-item" href="/layanan-pelanggan">Layanan Pelanggan</a></li>
                        </ul>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.orders') }}">Pesananku</a>
                    </li>
                    @endauth
                </ul>
                
                <ul class="navbar-nav ms-auto ps-2">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown" style="margin-left: 20px;">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><span class="dropdown-item-text text-muted">Selamat Datang, {{ Auth::user()->nama }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin logout?')) { document.getElementById('logout-form').submit(); }">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>DapurRoti</h5>
                    <p>Menyediakan berbagai jenis roti, kue, dan pastry segar buatan rumahan dengan kualitas terbaik.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Alamat</h5>
                    <p>Lorong Depnaker RT02 RW05<br>Weri, Larantuka<br>Flores Timur, NTT</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Kontak</h5>
                    <p><i class="bi bi-whatsapp"></i> 0828-9183-83</p>
                    <p><i class="bi bi-envelope"></i> dalemasan@gmail.com</p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="text-center">
                <p>&copy; 2025 DapurRoti. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/62828918383" target="_blank" class="btn btn-success btn-lg rounded-circle shadow position-fixed" 
       style="bottom: 30px; right: 30px; z-index: 1000; background-color: #25D366; border: none; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-whatsapp" style="font-size: 2rem;"></i>
    </a>
    
    
    @yield('scripts')
</body>
</html>