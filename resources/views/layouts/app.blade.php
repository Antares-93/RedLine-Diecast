<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RedLine') }} - Max Out Your Collection</title>
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
            --rl-border: rgba(255, 255, 255, 0.08);
            --rl-text: #f4f4f5;
            --rl-muted: #9ca3af;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: var(--rl-dark-bg);
            color: var(--rl-text);
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 10%, rgba(220, 38, 38, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(220, 38, 38, 0.06) 0%, transparent 45%);
            background-attachment: fixed;
        }

        .navbar-capsule-wrap {
            padding-top: 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .navbar-capsule {
            background: rgba(20, 20, 26, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            padding: 0.65rem 1.75rem;
            box-shadow: 0 12px 35px rgba(0,0,0,0.55);
        }

        .nav-link-top {
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 0.5rem 1.15rem;
            border-radius: 9999px;
            text-decoration: none;
            white-space: nowrap;
            display: inline-block;
            transition: all 0.2s ease;
        }
        .nav-link-top:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }
        .nav-link-top.active {
            color: #ffffff;
            background-color: var(--rl-red);
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
        }

        .dropdown-menu-dark-custom {
            background-color: #161620;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.65);
            padding: 0.6rem;
            margin-top: 0.6rem;
        }
        .dropdown-menu-dark-custom .dropdown-item {
            color: #cbd5e1;
            font-size: 0.88rem;
            padding: 0.55rem 1rem;
            border-radius: 10px;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .dropdown-menu-dark-custom .dropdown-item:hover {
            background-color: rgba(220, 38, 38, 0.15);
            color: #ffffff;
        }

        .card-custom {
            background-color: var(--rl-card);
            border: 1px solid var(--rl-border);
            border-radius: 24px;
            color: var(--rl-text);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .table {
            --bs-table-bg: transparent !important;
            --bs-table-color: #f4f4f5 !important;
            --bs-table-striped-bg: transparent !important;
            --bs-table-striped-color: #f4f4f5 !important;
            --bs-table-active-bg: transparent !important;
            --bs-table-active-color: #f4f4f5 !important;
            --bs-table-hover-bg: rgba(220, 38, 38, 0.08) !important;
            --bs-table-hover-color: #ffffff !important;
            color: #f4f4f5 !important;
            background-color: transparent !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            margin-bottom: 0 !important;
        }

        .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #e4e4e7 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            box-shadow: none !important; 
            padding: 0.85rem 1rem !important;
        }

        .table thead th {
            background-color: #111116 !important;
            color: #9ca3af !important;
            font-size: 0.76rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: none !important;
        }

        .table-responsive {
            background-color: transparent !important;
            border-radius: 16px;
        }

        input, textarea, select, .form-control, .form-select {
            background-color: #0f0f15 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            border-radius: 14px !important;
            padding: 0.7rem 1rem !important;
        }
        input:focus, textarea:focus, select:focus, .form-control:focus, .form-select:focus {
            background-color: #171722 !important;
            border-color: var(--rl-red) !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25) !important;
            outline: none !important;
        }
        input::placeholder, textarea::placeholder {
            color: #6b7280 !important;
        }

        .text-dark { color: #ffffff !important; }
        .text-muted { color: #9ca3af !important; }
        .bg-white { background-color: var(--rl-card) !important; color: var(--rl-text) !important; }
        .bg-light { background-color: var(--rl-card-inner) !important; color: var(--rl-text) !important; }

        .btn-pill-red {
            background-color: var(--rl-red);
            color: #ffffff;
            border-radius: 9999px;
            padding: 0.55rem 1.4rem;
            font-weight: 600;
            font-size: 0.88rem;
            border: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-pill-red:hover {
            background-color: var(--rl-red-hover);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-pill-outline {
            background: transparent;
            color: #f4f4f5;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 0.45rem 1.1rem;
            font-weight: 500;
            font-size: 0.82rem;
            text-decoration: none;
            white-space: nowrap;
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

    <div class="container navbar-capsule-wrap mb-4">
        <header class="navbar-capsule d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none" title="Ke Dashboard">
                <img src="{{ asset('images/logo.png') }}" alt="RedLine Logo" style="height: 38px; width: auto; object-fit: contain;">
                <div class="lh-1 d-none d-sm-block">
                    <span class="fs-4 fw-bold text-white tracking-wide">Red<span class="text-danger">Line</span></span>
                    <span class="d-block text-secondary" style="font-size: 0.6rem; letter-spacing: 0.12em; text-transform: uppercase; color: #cbd5e1 !important; font-weight: 600;">MAX OUT YOUR COLLECTION.</span>
                </div>
            </a>

            <!-- MENU UTAMA (KATALOG DIECAST DI PALING DEPAN / UTAMA) -->
            <nav class="d-flex align-items-center gap-1">
                <!-- 1. UTAMA: KATALOG DIECAST -->
                <a href="{{ route('products.index') }}" class="nav-link-top {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    Katalog Diecast
                </a>

                <!-- 2. DASHBOARD -->
                @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="nav-link-top {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                @endif

                <!-- 3. PESANAN SAYA (CUSTOMER) / PENJUALAN (STAFF & ADMIN) -->
                @if(auth()->check())
                    <a href="{{ route('sales.index') }}" class="nav-link-top {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                        {{ auth()->user()->isCustomer() ? 'Pesanan Saya' : 'Penjualan' }}
                    </a>

                    <!-- 4. RESTOCK PO (STAFF & ADMIN) -->
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <a href="{{ route('purchases.index') }}" class="nav-link-top {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                        Restock (PO)
                    </a>
                    @endif

                    <!-- 5. MASTER DATA (ADMIN) -->
                    @if(auth()->user()->isAdmin())
                    <div class="dropdown">
                        <a class="nav-link-top dropdown-toggle {{ request()->routeIs('categories.*', 'suppliers.*', 'users.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Master Data
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark-custom">
                            <li><a class="dropdown-item" href="{{ route('categories.index') }}">Kategori Diecast</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Distributor Pemasok</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">Kelola Pengguna</a></li>
                        </ul>
                    </div>
                    @endif
                @endif
            </nav>

            <div class="d-flex align-items-center gap-2">
                @if(auth()->check())
                    <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : (auth()->user()->isStaff() ? 'bg-primary' : 'bg-success') }} rounded-pill px-3 py-2 text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.06em; font-weight: 700;">
                        {{ auth()->user()->role }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar dari akun RedLine?');" class="d-inline"> 
                        @csrf
                        <button type="submit" class="btn-pill-outline py-1 px-3 text-secondary" title="Keluar dari akun">
                            Keluar
                        </button>
                    </form>
                @endif
            </div>
        </header>
    </div>

    <main class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-10 text-danger rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>