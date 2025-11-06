@extends('layouts.app')

@section('title', 'Checkout - DapurRoti')

@section('content')
<div class="container mt-4">
    <h2>Form Pemesanan</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($product->foto)
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_produk }}" class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                    <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h6>{{ $product->nama_produk }}</h6>
                            <p class="mb-1">Harga: Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}</p>
                            <p class="mb-1">Stok: {{ $product->stok }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Form Pemesanan</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('checkout.process') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Beli</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" min="1" max="{{ $product->stok }}" value="{{ old('jumlah', 1) }}" required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga_total" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="harga_total" value="Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control @error('alamat_pengiriman') is-invalid @enderror" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman', Auth::user()->alamat ?? '') }}</textarea>
                            @error('alamat_pengiriman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold">Produk:</td>
                            <td>{{ $product->nama_produk }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Harga:</td>
                            <td>Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah:</td>
                            <td><span id="summaryJumlah">1</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total:</td>
                            <td class="text-success fw-bold"><span id="summaryTotal">Rp {{ number_format($product->getFinalPrice(), 0, ',', '.') }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('jumlah').addEventListener('input', function() {
    const jumlah = parseInt(this.value) || 1;
    const harga = {{ $product->getFinalPrice() }};
    const total = jumlah * harga;
    
    document.getElementById('summaryJumlah').textContent = jumlah;
    document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('harga_total').value = 'Rp ' + total.toLocaleString('id-ID');
});
</script>
@endsection