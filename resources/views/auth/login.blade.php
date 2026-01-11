@extends('layouts.app')

@section('content')
<style>
    /* Background halus untuk seluruh halaman login */
    body {
        background-color: #f8f9fa;
    }

    /* Card Styling */
    .login-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    /* Header Styling */
    .login-header {
        background: linear-gradient(45deg, #0d6efd, #004dbd);
        padding: 30px;
        border: none;
    }

    /* Input Field Styling */
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #dee2e6;
        background-color: #fcfcfc;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    /* Button Login */
    .btn-login {
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        background: #4e73df;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background: #224abe;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Google Button */
    .btn-google {
        border-radius: 12px;
        padding: 10px;
        border: 1px solid #dadce0;
        transition: all 0.2s;
        font-weight: 500;
    }

    .btn-google:hover {
        background-color: #f8f9fa;
        border-color: #d2d4d7;
    }

    /* Checkbox & Links */
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .login-footer-link {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5"> {{-- Ukuran diperkecil ke 5 agar lebih proporsional --}}
            <div class="card login-card shadow-lg">
                {{-- Header dengan Gradient --}}
                <div class="card-header login-header text-white text-center">
                    <h3 class="fw-bold mb-1">Selamat Datang!</h3>
                    <p class="mb-0 opacity-75 small">Silahkan login ke akun JeytSport Anda</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold small text-muted">ALAMAT EMAIL</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autofocus 
                                   placeholder="nama@contoh.com">
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-bold small text-muted">PASSWORD</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa?</a>
                                @endif
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">Ingat saya di perangkat ini</label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-login">
                                MASUK SEKARANG
                            </button>
                        </div>

                        <div class="position-relative mb-4">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">atau</span>
                        </div>

                        {{-- Social Login --}}
                        <div class="d-grid mb-4">
                            <a href="{{ route('auth.google') }}" class="btn btn-google d-flex align-items-center justify-content-center">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
                                <span class="text-dark small">Masuk dengan Google</span>
                            </a>
                        </div>

                        {{-- Footer --}}
                        <p class="text-center mb-0 login-footer-link">
                            Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Daftar Sekarang</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection