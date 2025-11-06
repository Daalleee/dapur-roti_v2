@extends('layouts.app')

@section('title', 'Kategori Produk - DapurRoti')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Kategori Produk</h2>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Semua Kategori</h4>
        <span class="badge bg-primary">{{ $categories->count() }} Kategori Tersedia</span>
    </div>
    
    <div class="row">
        @forelse($categories as $category)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $category->nama_kategori }}</h5>
                    <p class="card-text">{{ $category->products->count() }} produk tersedia</p>
                    <a href="{{ route('category.show', $category->id) }}" class="btn btn-primary">Lihat Produk</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">Belum ada kategori tersedia.</p>
        </div>
        @endforelse
    </div>
    
    @if($categories->count() > 0)
    <div class="text-center mt-5">
        <h4>Temukan Produk Favorit Anda</h4>
        <p class="text-muted">Jelajahi berbagai kategori produk yang kami sediakan</p>
    </div>
    @endif
</div>
@endsection