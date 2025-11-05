@extends('layouts.app')

@section('title', 'Tentang Kami - DapurRoti')

@section('content')
<div class="container mt-5" style="margin-top: 7rem !important;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Tentang Kami</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-shop" style="font-size: 3rem; color: #007BFF;"></i>
                    </div>
                    
                    <h4 class="text-center">DapurRoti - Toko Roti & Kue</h4>
                    
                    <p class="mt-4">
                        DapurRoti adalah toko roti & kue buatan rumahan yang berlokasi di Weri, Larantuka, Flores Timur, NTT. 
                        Kami menyediakan berbagai jenis roti, kue, dan pastry segar dengan bahan-bahan pilihan dan resep tradisional 
                        yang diolah dengan penuh cinta.
                    </p>
                    
                    <p>
                        Didirikan oleh <strong>Leonardus Dale Masan</strong>, DapurRoti hadir untuk memenuhi kebutuhan masyarakat 
                        akan produk-produk roti dan kue yang berkualitas tinggi dengan harga terjangkau. Kami berkomitmen untuk 
                        menyediakan produk-produk segar setiap hari dengan rasa yang lezat dan memuaskan.
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Alamat Toko</h5>
                            <p>
                                <i class="bi bi-geo-alt me-2"></i>
                                Lorong Depnaker RT02 RW05<br>
                                Weri, Larantuka<br>
                                Flores Timur, NTT
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Info Kontak</h5>
                            <p>
                                <i class="bi bi-person me-2"></i>
                                Leonardus Dale Masan<br>
                                <i class="bi bi-envelope me-2"></i>
                                dalemasan@gmail.com<br>
                                <i class="bi bi-telephone me-2"></i>
                                0828-9183-83
                            </p>
                        </div>
                    </div>
                    
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h5 class="card-title text-center"><i class="bi bi-clock me-2"></i>Jam Operasional</h5>
                            <p class="text-center fs-5">
                                <strong>Buka Setiap Hari</strong><br>
                                07:00 Pagi - 21:00 Malam
                            </p>
                            <p class="text-center mt-3">
                                <strong>Bisa Antar & Beli di Tempat</strong>
                            </p>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection