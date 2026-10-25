<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RedLine - Max Out Your Collection</title>
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
            --rl-surface: #141419;
            --rl-card: #16161f;
            --rl-border: rgba(255, 255, 255, 0.08);
            --rl-text: #f4f4f5;
            --rl-muted: #9ca3af;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--rl-dark-bg);
            color: var(--rl-text);
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(220, 38, 38, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 85% 65%, rgba(220, 38, 38, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }

        /* 1. FLOATING PILL NAVBAR */
        .navbar-capsule-wrap {
            padding-top: 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .navbar-capsule {
            background: rgba(20, 20, 26, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            padding: 0.65rem 1.75rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .nav-link-custom {
            color: #d1d5db;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.4rem 1rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .nav-link-custom:hover {
            color: #ffffff;
        }
        .btn-pill-red {
            background-color: var(--rl-red);
            color: #ffffff;
            border-radius: 9999px;
            padding: 0.5rem 1.4rem;
            font-weight: 600;
            font-size: 0.88rem;
            border: none;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }
        .btn-pill-red:hover {
            background-color: var(--rl-red-hover);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-pill-outline {
            background: transparent;
            color: #f4f4f5;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9999px;
            padding: 0.5rem 1.2rem;
            font-weight: 500;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .btn-pill-outline:hover {
            border-color: var(--rl-red);
            color: #ffffff;
            background: rgba(220, 38, 38, 0.12);
        }

        /* 2. HERO BANNER ATAS */
        .hero-banner {
            background: linear-gradient(145deg, #181820 0%, #101015 100%);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            padding: 4.5rem 3.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            margin-top: 1rem;
        }
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-badge {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.35);
            color: #fca5a5;
            border-radius: 9999px;
            padding: 0.35rem 1.1rem;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.25rem;
        }
        .hero-title {
            font-size: 3.25rem;
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 1.25rem;
        }
        .hero-title span {
            color: var(--rl-red);
            text-shadow: 0 0 25px rgba(220, 38, 38, 0.4);
        }

        /* 3. FLOATING SEARCH CAPSULE */
        .search-capsule-wrapper {
            margin-top: -2.25rem;
            position: relative;
            z-index: 10;
        }
        .search-capsule {
            background: rgba(24, 24, 30, 0.95);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
            padding: 0.6rem 0.8rem 0.6rem 1.75rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5), 0 0 0 1px rgba(220, 38, 38, 0.15);
        }
        .search-capsule input, .search-capsule select {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 0.92rem;
            outline: none;
            width: 100%;
        }
        .search-capsule input::placeholder {
            color: #9ca3af;
        }
        .search-capsule select option {
            background: #181820;
            color: #fff;
        }
        .search-divider {
            width: 1px;
            height: 32px;
            background: rgba(255, 255, 255, 0.15);
        }

        /* 4. SHOWCASE SPOTLIGHT CARD */
        .section-target {
            scroll-margin-top: 100px;
        }
        .showcase-card {
            background: #161620;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 2.5rem;
        }

        /* 5. DIECAST CARD */
        .diecast-card {
            background: #16161f;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s ease;
        }
        .diecast-card:hover {
            transform: translateY(-4px);
            border-color: var(--rl-red);
            box-shadow: 0 12px 25px rgba(220, 38, 38, 0.2);
        }
        .diecast-img-box {
            background: #0f0f15;
            aspect-ratio: 108 / 165;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            margin: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .diecast-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .diecast-card:hover .diecast-img-box img {
            transform: scale(1.05);
        }

        .sku-tag {
            color: #cbd5e1 !important;
            background: #0f0f14;
            padding: 0.15rem 0.45rem;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: inline-block;
        }

        /* MODAL LOGIN */
        .modal-custom .modal-content {
            background: #14141c;
            border-radius: 28px;
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fff;
            box-shadow: 0 25px 60px rgba(0,0,0,0.7);
        }
        .login-tab-btn {
            border-radius: 9999px;
            padding: 0.55rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #9ca3af;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.2s ease;
        }
        .login-tab-btn.active {
            background: var(--rl-red);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
        }
    </style>
</head>
<body>

    <!-- 1. FLOATING ISLAND NAVBAR -->
    <div class="container navbar-capsule-wrap">
        <header class="navbar-capsule d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="RedLine Logo" style="height: 38px; width: auto; object-fit: contain;">
                <div class="lh-1">
                    <span class="fs-4 fw-bold text-white tracking-wide">Red<span class="text-danger">Line</span></span>
                    <span class="d-block text-secondary" style="font-size: 0.62rem; letter-spacing: 0.12em; text-transform: uppercase; color: #cbd5e1 !important; font-weight: 600;">MAX OUT YOUR COLLECTION.</span>
                </div>
            </a>

            <!-- Navigasi Menu Tengah -->
            <nav class="d-none d-md-flex align-items-center gap-1">
                <a href="#katalog" class="nav-link-custom">Koleksi Diecast</a>
                <a href="#spotlight" class="nav-link-custom">Pilihan Spesial</a>
                <a href="#distributor" class="nav-link-custom">Distributor</a>
            </nav>

            <!-- Aksi Tombol Masuk / Status Akun -->
            <div class="d-flex align-items-center gap-2">
                @if(auth()->check())
                    <span class="badge {{ auth()->user()->isAdmin() ? 'bg-danger' : (auth()->user()->isStaff() ? 'bg-primary' : 'bg-success') }} px-3 py-2 rounded-pill">
                        {{ auth()->user()->role }}
                    </span>
                    <a href="{{ route('dashboard') }}" class="btn-pill-red">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-pill-outline py-1 px-3 text-secondary" title="Keluar">
                            Keluar
                        </button>
                    </form>
                @else
                    <button class="btn-pill-outline d-none d-sm-inline-flex" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="switchLoginTab('petugas')">
                        Portal Petugas
                    </button>
                    <button class="btn-pill-red" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="switchLoginTab('customer')">
                        Masuk Kolektor
                    </button>
                @endif
            </div>
        </header>
    </div>

    <!-- 2. HERO BANNER ATAS (DENGAN FOTO MESIN hero_banner.jpg - TIDAK BERUBAH) -->
    <section class="container mt-3">
        <div class="hero-banner">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        Koleksi Multi-Skala & Miniatur Balap
                    </div>
                    <h1 class="hero-title">
                        Koleksi Diecast Langka, Presisi <span>Maksimal.</span>
                    </h1>
                    <p class="text-secondary fs-6 mb-4" style="max-width: 540px; line-height: 1.6;">
                        Eksplorasi lini resmi skala 1:64, 1:43 F1 Racing, 1:24, hingga 1:18 Supercar dari brand ternama Hot Wheels, Mini GT, Bburago, dan Maisto dengan stok transparan.
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="#katalog" class="btn-pill-red py-3 px-4 fs-6">
                            Jelajahi Garasi Koleksi
                        </a>
                        @if(!auth()->check())
                        <button class="btn-pill-outline py-3 px-4 fs-6" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="switchLoginTab('customer')">
                            Masuk Sebagai Kolektor
                        </button>
                        @endif
                    </div>
                </div>

                <!-- FOTO HERO BANNER DIECAST ENGINE DETAIL -->
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('images/hero_banner.jpg') }}" 
                         alt="RedLine Custom Diecast Engine Works" 
                         class="img-fluid rounded-4 shadow-lg border border-secondary border-opacity-25"
                         style="max-height: 340px; width: 100%; object-fit: cover; box-shadow: 0 20px 40px rgba(0,0,0,0.65);">
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FLOATING SEARCH & FILTER CAPSULE -->
    <section class="container search-capsule-wrapper section-target" id="katalog">
        <div class="search-capsule d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center flex-grow-1 gap-2 ps-2">
                <i class="fa-solid fa-magnifying-glass text-danger"></i>
                <input type="text" id="liveSearch" placeholder="Cari Nissan Skyline, Civic EF, F1 Red Bull...">
            </div>
            
            <div class="search-divider d-none d-md-block"></div>

            <div class="d-flex align-items-center gap-2" style="min-width: 170px;">
                <select id="filterScale">
                    <option value="">Semua Skala</option>
                    @foreach($scales as $sc)
                        <option value="{{ $sc }}">{{ $sc }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-divider d-none d-md-block"></div>

            <div class="d-flex align-items-center gap-2" style="min-width: 190px;">
                <select id="filterCategory">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="search-divider d-none d-md-block"></div>

            <div>
                <button type="button" class="btn-pill-red px-4 py-2" onclick="applySearchFilter()">
                    Terapkan
                </button>
            </div>
        </div>
    </section>

    <!-- 4. SPOTLIGHT: PILIHAN SPESIAL REDLINE CLUB (DI BAWAH SEARCH BAR) -->
    <section class="container py-5 mt-4 section-target" id="spotlight">
        <div class="showcase-card">
            <div class="row align-items-center g-4">
                <!-- KOTAK PREVIEW DINAMIS REDLINE CLUB -->
                <div class="col-md-5">
                    <div class="p-4 rounded-4 text-center position-relative overflow-hidden" style="background: #101015; border: 1px solid rgba(220, 38, 38, 0.35); box-shadow: 0 10px 30px rgba(220,38,38,0.15);">
                        <span class="badge bg-danger rounded-pill px-3 py-1 mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            Edisi Khusus Kolektor
                        </span>

                        @if($rlcSpecial)
                            <!-- Foto Card Blister RLC -->
                            <div class="mx-auto rounded-3 overflow-hidden shadow-lg mb-3" style="max-width: 160px; aspect-ratio: 108 / 165; background: #0b0b0e; border: 1px solid rgba(255,255,255,0.15);">
                                @if($rlcSpecial->image)
                                    <img src="{{ asset($rlcSpecial->image) }}" alt="{{ $rlcSpecial->name }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-car-side text-secondary display-5 opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="fw-bold text-white mb-1 text-truncate" title="{{ $rlcSpecial->name }}">{{ $rlcSpecial->name }}</h5>
                            <span class="text-danger fw-bold fs-5 d-block mb-1">Rp {{ number_format($rlcSpecial->selling_price, 0, ',', '.') }}</span>
                            <span class="badge bg-dark border border-secondary border-opacity-50 text-secondary" style="font-size: 0.7rem;">Stok Tersedia: {{ $rlcSpecial->stock }} Unit</span>
                        @else
                            <h4 class="fw-bold text-white mb-1">Red Line Club & Chase Cars</h4>
                            <p class="text-secondary small mt-3 mb-0">
                                Unit eksklusif dengan cat spectraflame, ban karet Real Riders, dan nomor seri terbatas.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="col-md-7 ps-md-4">
                    <span class="text-danger fw-bold small text-uppercase tracking-wider">Pilihan Spesial Minggu Ini</span>
                    <h2 class="fw-bold text-white mt-1 mb-3">Autentisitas & Kondisi Blister Terjamin</h2>
                    <p class="text-secondary leading-relaxed mb-4">
                        Setiap unit yang masuk ke inventaris RedLine melewati tahap kurasi fisik kemasan blister (*card & bubble mint condition*), bebas lipatan, dan tercatat otomatis di kartu stok sistem.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <button class="btn-pill-red" onclick="filterRLCOnly()">
                            Tampilkan Edisi RLC Saja
                        </button>
                        <a href="#katalog" class="btn-pill-outline">
                            Lihat Semua Stok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. GRID KATALOG PREVIEW (BERSIH DARI TULISAN ANEH) -->
    <section class="container pb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-danger fw-bold small text-uppercase">Etalase Toko</span>
                <h3 class="fw-bold text-white mb-0">Koleksi Diecast Tersedia</h3>
            </div>
            <span class="text-secondary small">Total {{ $products->total() }} Unit Terdaftar</span>
        </div>

        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 mb-4" id="diecastGrid">
            @forelse($products as $p)
            <div class="col product-card-item" data-name="{{ strtolower($p->name . ' ' . $p->brand) }}" data-cat="{{ $p->category->name }}" data-scale="{{ $p->scale }}">
                <div class="diecast-card h-100">
                    <div class="diecast-img-box">
                        @if($p->image)
                            <img src="{{ asset($p->image) }}" alt="{{ $p->name }}">
                        @else
                            <i class="fa-solid fa-car-side text-secondary display-5 opacity-25"></i>
                        @endif
                        <span class="position-absolute top-0 start-0 m-1 badge bg-dark border border-secondary border-opacity-50 rounded-pill" style="font-size: 0.65rem; padding: 0.2rem 0.45rem;">
                            {{ $p->scale }}
                        </span>
                        <span class="position-absolute top-0 end-0 m-1 badge {{ $p->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill" style="font-size: 0.65rem; padding: 0.2rem 0.45rem;">
                            {{ $p->stock > 0 ? 'Stok: ' . $p->stock : 'Habis' }}
                        </span>
                    </div>

                    <div class="p-2 pt-0 d-flex flex-column flex-grow-1 justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-danger fw-bold" style="font-size: 0.75rem;">{{ $p->brand ?? 'Diecast' }}</span>
                                <small class="text-secondary" style="font-size: 0.68rem;">{{ Str::limit($p->category->name, 12) }}</small>
                            </div>
                            <div class="fw-bold text-white text-truncate mb-1" style="font-size: 0.86rem;" title="{{ $p->name }}">
                                {{ $p->name }}
                            </div>
                            <div class="mb-2">
                                <span class="sku-tag" style="font-size: 0.68rem;">SKU: <strong>{{ $p->sku }}</strong></span>
                            </div>
                        </div>

                        <div class="pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-secondary d-block" style="font-size: 0.62rem;">Harga Resmi</small>
                                <span class="fw-bold text-white" style="font-size: 0.92rem;">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</span>
                            </div>

                            @if(auth()->check())
                                <a href="{{ route('sales.create') }}" class="btn-pill-red py-1 px-3" style="font-size: 0.78rem;">
                                    Beli
                                </a>
                            @else
                                <button class="btn-pill-red py-1 px-3" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#loginModal" onclick="switchLoginTab('customer')">
                                    Checkout
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                Belum ada produk diecast yang dipajang.
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </section>

    <!-- 6. SEKSI DISTRIBUTOR RESMI -->
    <section class="container py-5 section-target" id="distributor">
        <div class="border-top border-secondary border-opacity-25 pt-5">
            <div class="text-center mb-5">
                <span class="text-danger fw-bold small text-uppercase" style="letter-spacing: 0.1em;">Mitra Suplai Resmi</span>
                <h3 class="fw-bold text-white mt-1">Distributor Pemasok Diecast</h3>
                <p class="text-secondary small mx-auto" style="max-width: 580px;">
                    Semua stok diecast di sistem RedLine disuplai langsung oleh distributor berbadan hukum resmi melalui dokumen faktur pembelian (*Purchase Order*).
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($suppliers as $sup)
                <div class="col-md-6 col-lg-5">
                    <div class="card-custom p-4 text-center h-100 d-flex flex-column justify-content-between" style="border-radius: 24px;">
                        <div>
                            <!-- IKON GUDANG DENGAN AMBIENT MERAH -->
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 56px; height: 56px; background: rgba(220, 38, 38, 0.12); border: 1px solid rgba(220, 38, 38, 0.3);">
                                <i class="fa-solid fa-warehouse text-danger fs-5"></i>
                            </div>

                            <!-- BADGE MITRA RESMI -->
                            <span class="badge bg-dark border border-secondary border-opacity-50 text-secondary rounded-pill px-3 py-1 mb-2" style="font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase;">
                                Official Partner
                            </span>

                            <h5 class="fw-bold text-white mb-2">{{ $sup->name }}</h5>
                            <p class="text-secondary small mb-3" style="line-height: 1.5;">{{ $sup->address ?? 'Pemasok Nasional Indonesia' }}</p>
                        </div>

                        <!-- NOMOR TELEPON RAPI BERBENTUK KAPSUL -->
                        <div class="pt-3 border-top border-secondary border-opacity-25">
                            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm" style="background: #0f0f15; border: 1px solid rgba(255, 255, 255, 0.12);">
                                <i class="fa-solid fa-phone text-danger" style="font-size: 0.75rem;"></i>
                                <span class="font-monospace text-light fw-semibold" style="font-size: 0.85rem; letter-spacing: 0.05em;">
                                    {{ $sup->phone ?? '-' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-top border-secondary border-opacity-25 py-4 mt-5 text-center text-muted small">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-white">Red<span class="text-danger">Line</span></span>
                <span>— Max Out Your Collection.</span>
            </div>
        </div>
    </footer>

    <!-- MODAL LOGIN INTERAKTIF -->
    <div class="modal fade modal-custom" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="RedLine Logo" style="height: 32px; width: auto;">
                        <span class="fs-4 fw-bold text-white">Red<span class="text-danger">Line</span></span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- SWITCH TAB -->
                <div class="d-flex p-1 rounded-pill mb-4" style="background: #0b0b0e; border: 1px solid rgba(255,255,255,0.08);">
                    <button type="button" class="login-tab-btn flex-fill active" id="tabCustomerBtn" onclick="switchLoginTab('customer')">
                        Kolektor 
                    </button>
                    <button type="button" class="login-tab-btn flex-fill" id="tabPetugasBtn" onclick="switchLoginTab('petugas')">
                        Petugas 
                    </button>
                </div>

                <p class="text-secondary small mb-3" id="loginSubtitle">
                    Masuk ke akun kolektor untuk membeli unit dan melihat nota pesanan.
                </p>

                <!-- FORM -->
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light">Alamat Email</label>
                        <input type="email" name="email" id="modalEmail" class="form-control" placeholder="nama@redline.test" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-light">Kata Sandi</label>
                        <input type="password" name="password" id="modalPassword" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="modalRemember">
                            <label class="form-check-label text-secondary small" for="modalRemember">Ingat Saya</label>
                        </div>
                        <a href="{{ route('register') }}" class="text-danger small text-decoration-none">Daftar Akun Baru</a>
                    </div>

                    <button type="submit" class="btn-pill-red w-100 py-2 justify-content-center fs-6">
                        Masuk Sekarang
                    </button>
                </form>


            </div>
        </div>
    </div>

    <!-- SCRIPT BOOTSTRAP & LOGIKA FILTER -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchLoginTab(type) {
            const tabCust = document.getElementById('tabCustomerBtn');
            const tabPet = document.getElementById('tabPetugasBtn');
            const sub = document.getElementById('loginSubtitle');

            if (type === 'customer') {
                tabCust.classList.add('active');
                tabPet.classList.remove('active');
                sub.innerText = 'Masuk sebagai Kolektor Diecast untuk memproses pesanan dan melihat nota belanja Anda.';
            } else {
                tabPet.classList.add('active');
                tabCust.classList.remove('active');
                sub.innerText = 'Akses khusus Admin & Staff Gudang untuk input restock barang masuk (PO) dan master data.';
            }
        }

        function fillCredentials(email, password, type) {
            switchLoginTab(type);
            document.getElementById('modalEmail').value = email;
            document.getElementById('modalPassword').value = password;
        }

        function applySearchFilter() {
            const query = document.getElementById('liveSearch').value.toLowerCase();
            const cat = document.getElementById('filterCategory').value;
            const scale = document.getElementById('filterScale').value;
            const items = document.querySelectorAll('.product-card-item');

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                const itemCat = item.getAttribute('data-cat');
                const itemScale = item.getAttribute('data-scale');

                const matchQuery = !query || name.includes(query);
                const matchCat = !cat || itemCat === cat;
                const matchScale = !scale || itemScale === scale;

                if (matchQuery && matchCat && matchScale) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function filterRLCOnly() {
            const select = document.getElementById('filterCategory');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.includes('Red Line Club') || select.options[i].text.includes('RLC')) {
                    select.selectedIndex = i;
                    break;
                }
            }
            applySearchFilter();
            document.getElementById('katalog').scrollIntoView({ behavior: 'smooth' });
        }

        document.getElementById('liveSearch').addEventListener('input', applySearchFilter);
        document.getElementById('filterCategory').addEventListener('change', applySearchFilter);
        document.getElementById('filterScale').addEventListener('change', applySearchFilter);
    </script>
</body>
</html>