<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kolektor Baru - RedLine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            max-width: 460px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="register-card p-4 p-sm-5 my-4">
        <div class="text-center mb-4">
            <i class="fa-solid fa-user-plus text-danger display-5"></i>
            <h3 class="fw-bold text-dark mt-2 mb-0">Gabung RedLine</h3>
            <p class="text-muted small">Registrasi Akun Customer / Kolektor Diecast</p>
        </div>

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Budi Diecaster">
                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Alamat Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="budi@example.com">
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold">Kata Sandi</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 6 karakter">
                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi kata sandi">
            </div>

            <button type="submit" class="btn btn-danger w-100 py-2 fw-semibold shadow-sm">
                Daftar Sebagai Customer <i class="fa-solid fa-check ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="small text-muted">Sudah punya akun? </span>
            <a href="{{ route('login') }}" class="small text-danger fw-semibold text-decoration-none">Masuk Disini</a>
        </div>
    </div>
</body>
</html>