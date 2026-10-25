<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - RedLine Diecast Vault</title>
    <!-- Google Font: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --rl-red: #dc2626;
            --rl-red-hover: #b91c1c;
            --rl-dark-bg: #0b0b0e;
            --rl-card: #16161f;
            --rl-card-inner: #0f0f15;
            --rl-border: rgba(255, 255, 255, 0.1);
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: var(--rl-dark-bg);
            color: #f4f4f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background-image: 
                radial-gradient(circle at 50% 20%, rgba(220, 38, 38, 0.18) 0%, transparent 55%),
                radial-gradient(circle at 80% 80%, rgba(220, 38, 38, 0.08) 0%, transparent 45%);
            background-attachment: fixed;
        }

        .login-card {
            background-color: var(--rl-card);
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 28px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75);
            max-width: 460px;
            width: 100%;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--rl-red), transparent);
        }

        .login-tab-btn {
            border-radius: 9999px;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #9ca3af;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.25s ease;
        }
        .login-tab-btn.active {
            background: var(--rl-red);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.45);
        }

        .form-control {
            background-color: var(--rl-card-inner);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            font-size: 0.92rem;
        }
        .form-control:focus {
            background-color: #1a1a24;
            border-color: var(--rl-red);
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
        }
        .form-control::placeholder {
            color: #6b7280;
        }

        .btn-pill-red {
            background-color: var(--rl-red);
            color: #ffffff;
            border-radius: 9999px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            width: 100%;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-pill-red:hover {
            background-color: var(--rl-red-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.5);
        }

        .btn-pill-outline {
            background: transparent;
            color: #f4f4f5;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 0.45rem 1rem;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-pill-outline:hover {
            border-color: var(--rl-red);
            color: #ffffff;
            background: rgba(220, 38, 38, 0.1);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- LOGO RESMI REDLINE -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="RedLine Logo" style="height: 52px; width: auto; object-fit: contain;" class="mb-2">
            <h3 class="fw-bold mb-0 text-white">Red<span class="text-danger">Line</span></h3>
            <span class="d-block text-secondary small" style="letter-spacing: 0.12em; text-transform: uppercase; color: #cbd5e1 !important; font-size: 0.72rem; font-weight: 600;">DIECAST VAULT</span>
        </div>

        <!-- SWITCH TAB: KOLEKTOR VS PETUGAS TOKO -->
        <div class="d-flex p-1 rounded-pill mb-3" style="background: #0f0f15; border: 1px solid rgba(255,255,255,0.08);">
            <button type="button" class="login-tab-btn flex-fill active" id="tabCustomerBtn" onclick="switchLoginTab('customer')">
                Kolektor
            </button>
            <button type="button" class="login-tab-btn flex-fill" id="tabPetugasBtn" onclick="switchLoginTab('petugas')">
                Petugas Toko
            </button>
        </div>

        <p class="text-secondary small text-center mb-4" id="loginSubtitle">
            Masuk ke akun kolektor untuk membeli unit diecast dan melihat faktur.
        </p>

        <!-- FLASH NOTIFICATION -->
        @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success small rounded-3 py-2 px-3 mb-3">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger small rounded-3 py-2 px-3 mb-3">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM LOGIN -->
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold text-light">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary" style="border-radius: 14px 0 0 14px;">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" id="inputEmail" class="form-control" style="border-radius: 0 14px 14px 0;" placeholder="nama@redline.test" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold text-light">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary" style="border-radius: 14px 0 0 14px;">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="inputPassword" class="form-control" style="border-radius: 0 14px 14px 0;" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                    <label class="form-check-label text-secondary small" for="rememberMe">Ingat Saya</label>
                </div>
                <a href="{{ route('register') }}" class="text-danger small text-decoration-none fw-semibold">Daftar Akun Baru</a>
            </div>

            <button type="submit" class="btn-pill-red mb-3">
                Masuk ke Sistem <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </form>

    </div>

    <script>
        function switchLoginTab(type) {
            const btnCust = document.getElementById('tabCustomerBtn');
            const btnPet = document.getElementById('tabPetugasBtn');
            const sub = document.getElementById('loginSubtitle');

            if (type === 'customer') {
                btnCust.classList.add('active');
                btnPet.classList.remove('active');
                sub.innerText = 'Masuk sebagai Kolektor Diecast untuk memproses pesanan dan melihat nota belanja Anda.';
            } else {
                btnPet.classList.add('active');
                btnCust.classList.remove('active');
                sub.innerText = 'Akses khusus Admin & Staff Gudang untuk input restock barang masuk (PO) dan master data.';
            }
        }

        function fillCreds(email, password, type) {
            switchLoginTab(type);
            document.getElementById('inputEmail').value = email;
            document.getElementById('inputPassword').value = password;
        }
    </script>
</body>
</html>