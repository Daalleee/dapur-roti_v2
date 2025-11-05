@extends('layouts.app')

@section('title', 'Pesananku - DapurRoti')

@section('content')
<div class="container mt-4" style="margin-top: 7rem !important;">
    <h2>Riwayat Pesanan</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                                @if($order->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $order->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Bukti</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection