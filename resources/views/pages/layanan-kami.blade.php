@extends('layouts.app')

@section('title', 'Layanan Kami - DapurRoti')

@section('content')
<div class="container mt-4" style="margin-top: 7rem !important;">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Layanan Kami</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #007BFF;"></i>
                        <h4 class="mt-3">Pelayanan Terbaik dari DapurRoti Weri, Larantuka</h4>
                        <p class="text-muted">Kami melayani dengan sepenuh hati untuk pelanggan setia kami di NTT</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-cart-check" style="font-size: 2rem; color: #28A745;"></i>
                                    <h5 class="card-title mt-2">Pesan Antar</h5>
                                    <p class="card-text">Kami siap antar pesanan Anda langsung ke rumah</p>
                                    <p class="text-muted">07:00 - 21:00 WITA</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-shop" style="font-size: 2rem; color: #FFC107;"></i>
                                    <h5 class="card-title mt-2">Beli di Tempat</h5>
                                    <p class="card-text">Datang langsung ke toko kami di Weri, Larantuka</p>
                                    <p class="text-muted">Lorong Depnaker RT02 RW05</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-whatsapp" style="font-size: 2rem; color: #25D366;"></i>
                                    <h5 class="card-title mt-2">Pesan via WhatsApp</h5>
                                    <p class="card-text">0828-9183-83 untuk pemesanan praktis</p>
                                    <p class="text-muted">Layanan cepat dan responsif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mt-4">Berlokasi di NTT - Flores Timur</h5>
                    <p class="mt-3">
                        DapurRoti berlokasi strategis di <strong>Weri, Larantuka, Flores Timur, NTT</strong>. 
                        Kami siap melayani pelanggan setia kami di seluruh wilayah NTT dengan produk-produk 
                        berkualitas tinggi dan pelayanan yang ramah serta cepat.
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="bi bi-geo-alt me-2"></i>Alamat Lengkap</h6>
                                    <p class="mb-0">
                                        Lorong Depnaker RT02 RW05<br>
                                        Weri, Larantuka<br>
                                        Flores Timur<br>
                                        Nusa Tenggara Timur (NTT)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="bi bi-person me-2"></i>Kontak Pemilik</h6>
                                    <p class="mb-0">
                                        <strong>Leonardus Dale Masan</strong><br>
                                        WhatsApp: 0828-9183-83<br>
                                        Email: dalemasan@gmail.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-light mt-4">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="bi bi-clock me-2"></i>Jam Operasional</h5>
                            <p class="fs-4 mb-2"><strong>07:00 Pagi - 21:00 Malam</strong></p>
                            <p class="mb-0">Buka Setiap Hari | Melayani Antar & Beli di Tempat</p>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection