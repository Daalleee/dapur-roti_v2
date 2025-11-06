@extends('layouts.admin.app')

@section('title', 'Daftar Pesanan - DapurRoti Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Pesanan</h2>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Kontak</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->custom_order_id ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $order->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td>{{ $order->user->nama ?? 'N/A' }}</td>
                        <td>
                            @if($order->user && $order->user->no_hp)
                                <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')'], '', $order->user->no_hp) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $order->product->nama_produk ?? 'N/A' }}</td>
                        <td>{{ $order->jumlah }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
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
                        <td>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-check-circle"></i> Konfirmasi
                            </a>
                            @if($order->bukti_pembayaran)
                                <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="bi bi-image"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection