@extends('layouts.admin.app')

@section('title', 'Update Pesanan - DapurRoti Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Update Status Pesanan #{{ $order->custom_order_id ?? $order->id }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Detail Pesanan</h5>
                <table class="table">
                    <tr>
                        <td><strong>ID Pesanan</strong></td>
                        <td>#{{ $order->custom_order_id ?? $order->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Pelanggan</strong></td>
                        <td>{{ $order->user->nama ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kontak</strong></td>
                        <td>
                            @if($order->user->no_hp)
                                <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')'], '', $order->user->no_hp) }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Alamat Pengiriman</strong></td>
                        <td>{{ $order->alamat_pengiriman }}</td>
                    </tr>
                    <tr>
                        <td><strong>Produk</strong></td>
                        <td>{{ $order->product->nama_produk ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td>{{ $order->jumlah }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Harga</strong></td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @switch($order->status)
                                @case('Menunggu')
                                    <span class="badge bg-warning text-dark" style="background-color: #ffc107 !important; color: #212529 !important;">{{ $order->status }}</span>
                                    @break
                                @case('Diproses')
                                    <span class="badge bg-primary" style="background-color: #052c65 !important; color: #ffffff !important;">{{ $order->status }}</span>
                                    @break
                                @case('Dikirim')
                                    <span class="badge bg-info text-dark" style="background-color: #0dcaf0 !important; color: #212529 !important;">{{ $order->status }}</span>
                                    @break
                                @case('Selesai')
                                    <span class="badge bg-success" style="background-color: #198754 !important; color: #ffffff !important;">{{ $order->status }}</span>
                                    @break
                                @case('Dibatalkan')
                                    <span class="badge bg-danger" style="background-color: #dc3545 !important; color: #ffffff !important;">{{ $order->status }}</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary" style="background-color: #6c757d !important; color: #ffffff !important;">{{ $order->status }}</span>
                            @endswitch
                        </td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-6">
                <h5>Update Status</h5>
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Menunggu" {{ old('status', $order->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses" {{ old('status', $order->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ old('status', $order->status) == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ old('status', $order->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ old('status', $order->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection