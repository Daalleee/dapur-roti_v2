@extends('layouts.app')

@section('title', 'Register - DapurRoti')

@section('content')
<div class="container mt-7" style="margin-top: 8rem !important;">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-3" style="background-color: #052c65 !important;">
                    <h4 class="mb-0">Daftar Akun</h4>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap Anda" required>
                                </div>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email Anda" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="no_hp" class="form-label fw-bold">Nomor HP</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan No.HP" required>
                                </div>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-house"></i>
                                    </span>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat lengkap Anda" required>{{ old('alamat') }}</textarea>
                                </div>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm" onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordConfirm')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function togglePasswordVisibility(fieldId, buttonId) {
                                const passwordInput = document.getElementById(fieldId);
                                const toggleButton = document.getElementById(buttonId);
                                const icon = toggleButton.querySelector('i');
                                
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.remove('bi-eye');
                                    icon.classList.add('bi-eye-slash');
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('bi-eye-slash');
                                    icon.classList.add('bi-eye');
                                }
                            }
                        </script>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-5 fw-bold shadow-sm" style="background-color: #052c65; border: none; border-radius: 10px;">
                            <i class="bi bi-person-plus me-2"></i>Daftar
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #052c65;">Masuk di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection