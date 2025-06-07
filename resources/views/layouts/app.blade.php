<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KSM Tirta Lestari')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background-color: #e9eff4;
            font-family: 'Segoe UI', sans-serif;
        }

        .topbar {
            background-color: #0062cc;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar .app-name {
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .topbar .app-name img {
            height: 30px;
            margin-right: 10px;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
        }

        .topbar .user-info i {
            font-size: 1.5rem;
            margin-right: 5px;
        }

        .layout {
            display: flex;
            height: calc(100vh - 50px);
        }

        .sidebar {
            width: 220px;
            background-color: white;
            border-right: 1px solid #ddd;
            padding-top: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

    </style>
</head>
<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="app-name">
            <img src="{{ asset('/images/logo.jpg') }}" alt="Logo"> <!-- Ganti logo.png jika perlu -->
            KSM Tirta Lestari Flamboyan
        </div>
        <div class="dropdown user-info">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1 fs-5"></i>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- LAYOUT -->
    <div class="layout">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <a href="{{ url('/dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
            <a href="{{ route('pelanggan.index') }}"><i class="bi bi-people"></i> Data Pelanggan</a>
            <a href="{{ route('pemakaian.index') }}"><i class="bi bi-droplet-half"></i> Kelola Pemakaian Air</a>
            <a href="{{ route('tagihan.index') }}"><i class="bi bi-receipt"></i> Kelola Tagihan</a>
            <a href="{{ route('pembayaran.index') }}"><i class="bi bi-cash-coin"></i> Kelola Pembayaran</a>

            <div class="dropdown px-3 mt-2">
                <a class="dropdown-toggle text-decoration-none text-dark" href="#" id="laporanDropdown" data-bs-toggle="dropdown">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('laporan.pelanggan.list') }}">Data Pelanggan</a></li>
                    <li><a class="dropdown-item" href="{{ route('laporan.tagihan.index') }}">Data Tagihan</a></li>
                    <li><a class="dropdown-item" href="{{ route('laporan.pembayaran.index') }}">Data Pembayaran</a></li>
                </ul>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
