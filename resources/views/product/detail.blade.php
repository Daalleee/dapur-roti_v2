@extends('layouts.app')

@section('title', $product->nama_produk . ' - DapurRoti')

@section('content')
<div class="container mt-4" style="margin-top: 10rem !important;">
    <div class="row">
        <div class="col-md-6">
            <!-- Product Image Gallery -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $allImages = collect();
                        if($product->foto) {
                            $allImages->push((object)['image_path' => $product->foto]);
                        }
                        $allImages = $allImages->merge($product->images);
                    @endphp
                    
                    @forelse($allImages as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100 rounded" alt="{{ $product->nama_produk }}" style="height: 500px; object-fit: cover;">
                    </div>
                    @empty
                    <div class="carousel-item active">
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 500px;">
                            <i class="bi bi-image" style="font-size: 6rem; color: #ccc;"></i>
                        </div>
                    </div>
                    @endforelse
                </div>
                @if($allImages->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" style="filter: invert(1);"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" style="filter: invert(1);"></span>
                </button>
                
                <!-- Carousel Indicators -->
                @if($allImages->count() > 1)
                <div class="carousel-indicators">
                    @for($i = 0; $i < $allImages->count(); $i++)
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"></button>
                    @endfor
                </div>
                @endif
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <h4>{{ $product->nama_produk }}</h4>
            
            <!-- Product Information Table -->
            <div class="card mt-3">
                <div class="card-body p-3">
                    <table class="table table-sm">
                        <tr>
                            <td width="35%"><strong>Kategori</strong></td>
                            <td>{{ $product->category->nama_kategori ?? 'Umum' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga</strong></td>
                            <td>
                                @if($product->isOnSale())
                                    <span class="harga-asli text-decoration-line-through">Rp {{ number_format($product->harga, 0, ',', '.') }}</span><br>
                                    <span class="harga-diskon fw-bold text-success">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                        @if($product->isOnSale())
                        <tr>
                            <td><strong>Keterangan</strong></td>
                            <td>
                                <span class="badge bg-success">Diskon</span>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Stok</strong></td>
                            <td>{{ $product->stok }}</td>
                        </tr>
                        <tr>
                            <td><strong>Deskripsi</strong></td>
                            <td class="text-muted">{!! nl2br(e($product->deskripsi)) !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @auth
            <div class="mt-3">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#pesanSekarangModal">
                    <i class="bi bi-cart-plus"></i> Pesan Sekarang
                </button>
            </div>
            
            <!-- Pesan Sekarang Modal -->
            <div class="modal fade" id="pesanSekarangModal" tabindex="-1" aria-labelledby="pesanSekarangModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pesanSekarangModalLabel">Pesan Sekarang - {{ $product->nama_produk }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jumlah" class="form-label">Jumlah Beli</label>
                                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" min="1" max="{{ $product->stok }}" value="1" required>
                                            @error('jumlah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                                            <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ Auth::user()->alamat ?? '' }}</textarea>
                                            @error('alamat_pengiriman')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bukti_pembayaran" class="form-label">Upload Bukti Pembayaran</label>
                                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>
                                            <div class="form-text">Format: JPG, PNG, PDF. Ukuran maksimal: 2MB</div>
                                            @error('bukti_pembayaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Ringkasan Pesanan</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td>Produk:</td>
                                                        <td>{{ $product->nama_produk }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga:</td>
                                                        <td>Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah:</td>
                                                        <td><span id="jumlahSummary">1</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Total:</td>
                                                        <td class="text-success fw-bold"><span id="totalSummary">Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Buat Pesanan & Upload Bukti</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                document.getElementById('jumlah').addEventListener('input', function() {
                    const jumlah = parseInt(this.value) || 1;
                    const harga = {{ $product->getFinalPrice() }};
                    const total = jumlah * harga;
                    
                    document.getElementById('jumlahSummary').textContent = jumlah;
                    document.getElementById('totalSummary').textContent = 'Rp ' + total.toLocaleString('id-ID');
                });
            </script>
            @else
            <div class="mt-3">
                <a href="{{ route('login') }}?redirectTo={{ route('product.detail', $product->id) }}" class="btn btn-primary w-100">
                    <i class="bi bi-cart-plus"></i> Pesan Sekarang
                </a>
                <p class="text-center mt-2"><small>Anda harus login terlebih dahulu</small></p>
            </div>
            @endauth
        </div>
    </div>
    
    <!-- Similar Products -->
    <div class="mt-5">
        <h3>Produk Serupa</h3>
        <div class="row">
            @php
                $relatedProducts = \App\Models\Product::where('kategori_id', $product->kategori_id)
                    ->where('id', '!=', $product->id)
                    ->limit(4)
                    ->get();
            @endphp
            
            @forelse($relatedProducts as $relatedProduct)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    @if($relatedProduct->foto)
                        <img src="{{ asset('storage/' . $relatedProduct->foto) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $relatedProduct->nama_produk }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $relatedProduct->nama_produk }}</h5>
                        @if($relatedProduct->isOnSale())
                            <div class="harga-asli">Rp {{ number_format($relatedProduct->harga, 0, ',', '.') }}</div>
                            <div class="harga-diskon">Rp {{ number_format($relatedProduct->harga_diskon, 0, ',', '.') }}</div>
                        @else
                            <div>Rp {{ number_format($relatedProduct->harga, 0, ',', '.') }}</div>
                        @endif
                        <a href="{{ route('product.detail', $relatedProduct->id) }}" class="btn btn-outline-primary mt-auto">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center">Tidak ada produk serupa.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection