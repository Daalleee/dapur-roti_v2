@extends('layouts.app')

@section('title', 'Kontak Kami - DapurRoti')

@section('content')
<div class="container mt-5" style="margin-top: 7rem !important;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Kontak Kami</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="bi bi-telephone-fill" style="font-size: 3rem; color: #007BFF;"></i>
                        <h4 class="mt-3">Hubungi Toko Kami di Weri, Larantuka</h4>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-whatsapp" style="font-size: 2rem; color: #25D366;"></i>
                                    <h5 class="card-title mt-2">WhatsApp</h5>
                                    <p class="card-text fs-5">0828-9183-83</p>
                                    <p class="text-muted">Chat kami untuk pemesanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-envelope" style="font-size: 2rem; color: #007BFF;"></i>
                                    <h5 class="card-title mt-2">Email</h5>
                                    <p class="card-text">dalemasan@gmail.com</p>
                                    <p class="text-muted">Kirim pertanyaan atau saran</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-geo-alt" style="font-size: 2rem; color: #DC3545;"></i>
                                    <h5 class="card-title mt-2">Alamat Toko</h5>
                                    <p class="card-text">
                                        Lorong Depnaker RT02 RW05<br>
                                        Weri, Larantuka<br>
                                        Flores Timur, NTT
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <i class="bi bi-people" style="font-size: 2rem; color: #FFC107;"></i>
                                    <h5 class="card-title mt-2">Pemilik</h5>
                                    <p class="card-text">Leonardus Dale Masan</p>
                                    <p class="text-muted">Pemilik DapurRoti</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-light mt-4">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="bi bi-clock me-2"></i>Jam Operasional</h5>
                            <p class="fs-4 mb-2"><strong>07:00 Pagi - 21:00 Malam</strong></p>
                            <p class="mb-0">Buka Setiap Hari</p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <h5>Lokasi Kami di NTT</h5>
                        <p class="text-muted">Toko kami terletak di Weri, Larantuka, Flores Timur - Nusa Tenggara Timur</p>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Info Penting:</strong> Kami melayani pemesanan antar dan pembelian di tempat
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection