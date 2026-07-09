<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
        }
        .login-card {
            border-top: 5px solid #0d6efd;
            border-radius: 12px;
        }
        .brand-icon {
            font-size: 3rem;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card login-card shadow-lg border-0 bg-white">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <div class="brand-icon mb-2">📦</div>
                        <h4 class="fw-bold text-dark mb-1">Aplikasi Gudang</h4>
                        <p class="text-muted small">Sistem Manajemen & Inventaris Barang</p>
                    </div>

                    <div class="alert alert-primary bg-primary bg-opacity-10 border-0 text-primary text-center py-2 mb-4 small fw-semibold">
                        👋 Selamat Datang! Silakan masuk ke akun Anda.
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                            ⚠️ {{ session('error') }}
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-secondary">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">✉️</span>
                                <input type="email" name="email" id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="nama@email.com" 
                                    value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold small text-secondary">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">🔒</span>
                                <input type="password" name="password" id="password" 
                                    class="form-control" 
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold fs-6">
                                Masuk ke Sistem ➔
                            </button>
                        </div>
                    </form>

                    <div class="border-top pt-3 mt-4 text-center">
                        <p class="text-muted mb-0" style="font-size: 0.75rem;">
                            &copy; {{ date('Y') }} Gudang App. All rights reserved.
                        </p>
                    </div>

                </div>
            </div>
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>