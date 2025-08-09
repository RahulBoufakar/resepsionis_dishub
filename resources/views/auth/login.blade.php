<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Surat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
            height: 100vh;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg border-0" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Instansi" style="width: 100px;">
                <h4 class="fw-bold mt-3 text-primary">Sistem Surat</h4>
                <p class="text-muted">Silakan masuk untuk melanjutkan</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-muted">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-muted">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label text-muted">Ingat saya</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">Masuk</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-decoration-none">Buat akun baru</a>
            </div>

            <div class="mt-3 text-center">
                <small class="text-white">© {{ date('Y') }} Instansi Anda</small>
            </div>
        </div>
    </div>
</div>
</body>
</html>