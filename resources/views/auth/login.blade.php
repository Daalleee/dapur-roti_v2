@extends('layouts.app')

@section('title', 'Login - DapurRoti')

@section('content')
<div class="container mt-7" style="margin-top: 8rem !important;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-3" style="background-color: #052c65 !important;">
                    <h4 class="mb-0">Masuk Akun</h4>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email Anda" required autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <script>
                            function togglePasswordVisibility() {
                                const passwordInput = document.getElementById('password');
                                const toggleButton = document.getElementById('togglePassword');
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
                        
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="text-decoration-none" style="color: #052c65;">Lupa Password?</a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-5 fw-bold shadow-sm" style="background-color: #052c65; border: none; border-radius: 10px;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #052c65;">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection