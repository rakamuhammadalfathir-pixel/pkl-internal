@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card auth-card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Buat Akun Baru</h3>
                        <p class="text-muted">Bergabunglah dengan komunitas JeytSport</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required autocomplete="name" autofocus>
                            <label for="name">Nama Lengkap</label>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                            <label for="email">Alamat Email</label>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password">
                            <label for="password-confirm">Konfirmasi Password</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                {{ __('Daftar Sekarang') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Masuk di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .register-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
    }
    .auth-card {
        border-radius: 15px;
        overflow: hidden;
    }
    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25 darkblue;
        border-color: #4e73df;
    }
    .btn-primary {
        background: #4e73df;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: #224abe;
        transform: translateY(-1px);
    }
    .text-primary {
        color: #4e73df !important;
    }
</style>
@endsection