@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran - DapurRoti')

@section('content')
<div class="container mt-4">
    <h2>Upload Bukti Pembayaran</h2>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Form Upload Bukti Pembayaran</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('upload.proof') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orderId }}">
                        
                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">File Bukti Pembayaran</label>
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">Format: JPG, PNG, PDF. Ukuran maksimal: 2MB</div>
                            @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Order details sidebar -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Pesanan</h5>
                </div>
                <div class="card-body">
                    @php
                        $order = \App\Models\Order::with('product')->find($orderId);
                    @endphp
                    
                    @if($order && $order->product)
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="fw-bold">Produk:</td>
                            <td>{{ $order->product->nama_produk }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah:</td>
                            <td>{{ $order->jumlah }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Harga:</td>
                            <td class="text-success fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status:</td>
                            <td>
                                @switch($order->status)
                                    @case('Menunggu')
                                        <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                        @break
                                    @case('Diproses')
                                        <span class="badge bg-primary">{{ $order->status }}</span>
                                        @break
                                    @case('Dikirim')
                                        <span class="badge bg-info">{{ $order->status }}</span>
                                        @break
                                    @case('Selesai')
                                        <span class="badge bg-success">{{ $order->status }}</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                    </table>
                    @else
                    <p class="text-center text-muted">Data pesanan tidak ditemukan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection