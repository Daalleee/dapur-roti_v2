@extends('layouts.app')

@section('title', 'DapurRoti - Toko Roti & Kue')

@section('content')
<!-- Banner Section -->
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-bottom: 0;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('beaner/beanrer3.png') }}" class="d-block w-100" alt="Banner 1" style="height: 290px;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('beaner/beaner2.png') }}" class="d-block w-100" alt="Banner 2" style="height: 290px;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Products Section -->
<div class="container mt-5">
    <h3 class="text-center mb-5">Menu Spesial Kami</h3>
    
    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card produk-card h-100">
                @if($product->foto)
                    <img src="{{ asset('storage/' . $product->foto) }}" class="card-img-top produk-image" alt="{{ $product->nama_produk }}" style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center produk-image" style="height: 180px;">
                        <i class="bi bi-image" style="font-size: 2.5rem; color: #ccc;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column text-center">
                    @if($product->is_best_seller)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size: 0.7rem;">BEST SELLER</span>
                    @endif
                    <h6 class="card-title">{{ $product->nama_produk }}</h6>
                    <div class="flex-grow-1 d-flex flex-column justify-content-center">
                        @if($product->isOnSale())
                            <div class="harga-asli" style="font-size: 0.9rem;">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            <div class="harga-diskon" style="font-size: 0.9rem; font-weight: bold;">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</div>
                        @else
                            <div style="font-size: 0.9rem;">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        @endif
                        <div class="d-flex flex-column align-items-center" style="margin: 5px 0;">
                            @if($product->sold_count > 0)
                                <span class="text-muted" style="font-size: 0.75rem;">Terjual: {{ $product->sold_count }}</span>
                            @else
                                <span style="font-size: 0.75rem; visibility: hidden;">Terjual: 0</span>
                            @endif
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm w-100 mt-auto">Lihat Detail</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100 mt-auto">Pesan Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Belum ada produk tersedia.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- About Section -->
<div class="container mt-5">
    <div class="text-center mb-4">
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-cupcake" style="font-size: 4rem; color: #0056b3;"></i>
                    </div>
                    <p class="mb-0">
                        <strong>Buka Setiap Hari: 07:00 Pagi - 21:00 Malam</strong><br>
                        <i class="bi bi-check-circle-fill text-success"></i> Bisa Antar & Beli di Tempat
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection