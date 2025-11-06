@extends('layouts.app')

@section('title', $category->nama_kategori . ' - DapurRoti')

@section('content')
<div class="container mt-3" style="margin-top: 7rem !important;">
    <h2 class="text-center mb-4">Kategori {{ $category->nama_kategori }}</h2>
    
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
                    <h5 class="card-title">{{ $product->nama_produk }}</h5>
                    <div class="mt-auto">
                        @if($product->isOnSale())
                            <div class="harga-asli" style="font-size: 0.9rem;">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            <div class="harga-diskon" style="font-size: 0.9rem; font-weight: bold;">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</div>
                        @else
                            <div style="font-size: 0.9rem;">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        @endif
                        @auth
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm w-100 mt-1">Lihat Detail</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100 mt-1">Pesan Sekarang</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Belum ada produk dalam kategori ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection