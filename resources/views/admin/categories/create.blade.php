@extends('layouts.admin.app')

@section('title', 'Tambah Kategori - DapurRoti Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Kategori</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required>
                @error('nama_kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
        </form>
    </div>
</div>
@endsection