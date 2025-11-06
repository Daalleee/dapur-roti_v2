@extends('layouts.admin.app')

@section('title', 'Laporan Penjualan - DapurRoti Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="downloadReport" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="downloadReport">
                <li><a class="dropdown-item" href="{{ route('admin.reports.excel') }}?{{ http_build_query(request()->all()) }}"><i class="fas fa-file-excel text-success"></i> Excel</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.csv') }}?{{ http_build_query(request()->all()) }}"><i class="fas fa-file-csv text-info"></i> CSV</a></li>
            </ul>
        </div>
    </div>

    <!-- Total Revenue Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Semua Pesanan Pelanggan</h6>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="start_date">Tanggal Awal:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">Tanggal Akhir:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="product_id">Produk:</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option value="">Semua Produk</option>
                                    @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->nama_produk }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders ?? [] as $order)
                                <tr>
                                    <td>{{ $order->custom_order_id ?? $order->id }}</td>
                                    <td>{{ $order->user->nama ?? 'N/A' }}</td>
                                    <td>{{ $order->product->nama_produk ?? 'N/A' }}</td>
                                    <td>{{ $order->jumlah }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'Selesai') 
                                                bg-success 
                                            @elseif($order->status == 'Dikirim') 
                                                bg-info
                                            @elseif($order->status == 'Diproses') 
                                                bg-warning 
                                            @elseif($order->status == 'Menunggu') 
                                                bg-secondary
                                            @elseif($order->status == 'Dibatalkan') 
                                                bg-danger 
                                            @else 
                                                bg-default
                                            @endif">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data penjualan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection