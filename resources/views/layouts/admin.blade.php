<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin') | Inventaris IT</title>

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.15);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.025em;
        }

        .navbar-nav .nav-link {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.925rem;
            margin: 0 4px;
            transition: all 0.2s ease;
            border-radius: 8px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-nav .nav-link:hover {
            color: #f8fafc;
            background: rgba(255, 255, 255, 0.08);
        }

        .navbar-nav .nav-link.active {
            color: #ffffff;
            background: #059669;
            font-weight: 600;
        }

        .profile-btn {
            color: #f8fafc;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .content {
            padding: 2rem 1.5rem;
            min-height: calc(100vh - 70px);
        }

        @media(max-width: 991.98px) {
            .content {
                padding: 1.25rem 0.75rem;
            }
            .navbar-nav .nav-link {
                margin: 2px 0;
            }
        }
    </style>

</head>

<body>

    @php
        // Hitung peminjaman yang membutuhkan persetujuan (status = pending)
        $pendingPinjam = \App\Models\Peminjaman::where('status', 'pending')->count();
        
        // Hitung transaksi yang belum dikembalikan (peminjaman disetujui tapi belum ada record di pengembalian)
        $pendingKembali = \App\Models\Peminjaman::where('status', 'disetujui')
                            ->doesntHave('pengembalian')
                            ->count();
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container-fluid px-lg-4">

            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <div class="bg-emerald text-white rounded-3 p-1 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background-color: #059669;">
                    <i class="bi bi-pc-display"></i>
                </div>
                <span>Inventaris IT</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAdmin">

                <ul class="navbar-nav mx-auto my-2 my-lg-0">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2"></i>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('barang*') ? 'active' : '' }}"
                           href="{{ route('barang.index') }}">
                            <i class="bi bi-box-seam"></i>
                            Barang
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}"
                           href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i>
                            User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}"
                           href="{{ route('admin.peminjaman') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Peminjaman
                            @if($pendingPinjam > 0)
                                <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 11px;">
                                    {{ $pendingPinjam }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pengembalian*') ? 'active' : '' }}"
                           href="{{ route('admin.pengembalian') }}">
                            <i class="bi bi-arrow-return-left"></i>
                            Pengembalian
                            @if($pendingKembali > 0)
                                <span class="badge bg-warning text-dark rounded-pill ms-auto" style="font-size: 11px;">
                                    {{ $pendingKembali }}
                                </span>
                            @endif
                        </a>
                    </li>

                </ul>

                <div class="dropdown border-top border-secondary border-opacity-25 pt-2 pt-lg-0 mt-2 mt-lg-0">
                    <a class="profile-btn dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5 text-emerald" style="color: #10b981;"></i>
                        <span>{{ session('nama', 'Admin') }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li>
                            <div class="px-3 py-2">
                                <p class="fw-bold mb-0 text-dark">{{ session('nama', 'Administrator') }}</p>
                                <small class="text-muted">Administrator IT</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="/logout">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="content">
        @yield('content')
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>