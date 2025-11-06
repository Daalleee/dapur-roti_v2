@extends('layouts.admin.app')

@section('title', 'Edit Produk - DapurRoti Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_option" class="form-label">Kategori</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="kategori_option" id="existing_category" value="existing" checked onchange="toggleCategoryInput()">
                            <label class="form-check-label" for="existing_category">
                                Pilih Kategori yang Ada
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="kategori_option" id="new_category" value="new" onchange="toggleCategoryInput()">
                            <label class="form-check-label" for="new_category">
                                Buat Kategori Baru
                            </label>
                        </div>
                        
                        <div id="existing_category_section">
                            <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="new_category_section" style="display: none;">
                            <input type="text" class="form-control @error('new_kategori') is-invalid @enderror" id="new_kategori" name="new_kategori" placeholder="Masukkan nama kategori baru">
                            @error('new_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        @error('kategori_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="harga_diskon" class="form-label">Harga Diskon (Opsional)</label>
                        <input type="number" class="form-control @error('harga_diskon') is-invalid @enderror" id="harga_diskon" name="harga_diskon" value="{{ old('harga_diskon', $product->harga_diskon) }}">
                        @error('harga_diskon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $product->stok) }}" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Utama Produk</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                        <div class="form-text">Format: JPG, PNG. Ukuran maksimal: 2MB</div>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($product->foto)
                            <div class="mt-2">
                                <p>Foto utama saat ini:</p>
                                <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama_produk }}" width="150">
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="multiple_foto" class="form-label">Foto Tambahan Produk</label>
                        <input type="file" class="form-control @error('multiple_foto') is-invalid @enderror" id="multiple_foto" name="multiple_foto[]" accept="image/*" multiple>
                        <div class="form-text">Pilih beberapa file gambar (opsional). Format: JPG, PNG. Ukuran maksimal: 2MB per file</div>
                        @error('multiple_foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($product->images->count() > 0)
                    <div class="mb-3">
                        <p>Foto tambahan saat ini:</p>
                        <div class="row">
                            @foreach($product->images as $image)
                            <div class="col-md-3 mb-2">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Foto produk" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleCategoryInput() {
    const existingSection = document.getElementById('existing_category_section');
    const newSection = document.getElementById('new_category_section');
    const existingRadio = document.getElementById('existing_category');
    
    if (existingRadio.checked) {
        existingSection.style.display = 'block';
        newSection.style.display = 'none';
    } else {
        existingSection.style.display = 'none';
        newSection.style.display = 'block';
    }
}

// Initialize the form based on current category
document.addEventListener('DOMContentLoaded', function() {
    const categoryId = document.getElementById('kategori_id').value;
    if (!categoryId) {
        document.getElementById('new_category').checked = true;
        document.getElementById('existing_category_section').style.display = 'none';
        document.getElementById('new_category_section').style.display = 'block';
    } else {
        document.getElementById('existing_category').checked = true;
        document.getElementById('existing_category_section').style.display = 'block';
        document.getElementById('new_category_section').style.display = 'none';
    }
});
</script>
@endsection