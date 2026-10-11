<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Inventaris IT</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #10b981 100%);
            --accent-orange: #f97316;
            --bg-light: #f4f7fe;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #2d3748;
        }

        /* Vibrant Modern Navbar */
        .navbar-custom {
            background: var(--primary-gradient);
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.25);
            padding: 10px 0;
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 800;
            color: #ffffff !important;
            letter-spacing: -0.3px;
        }

        .brand-icon {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin: 0 4px;
            padding: 9px 18px !important;
            border-radius: 12px;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link.active {
            color: #0f766e !important;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Profile Button Colorful */
        .profile-btn {
            color: #ffffff;
            text-decoration: none;
            padding: 5px 14px 5px 6px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(5px);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        /* Badge Custom */
        .badge-notification {
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 7px;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.4);
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-radius: 16px;
            padding: 10px;
            margin-top: 12px !important;
        }

        .dropdown-item {
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #fee2e2;
        }

        .content {
            padding: 30px;
        }

        @media (max-width: 991px) {
            .content {
                padding: 20px;
            }
            .navbar-nav {
                padding: 15px 0;
            }
            .navbar-nav .nav-link {
                margin: 4px 0;
            }
            .profile-btn {
                margin-top: 10px;
                justify-content: flex-start;
                border-radius: 14px;
            }
        }
    </style>
</head>

<body>

@php
    $jumlahPesan = \App\Models\Notifikasi::where('user_id', session('user_id'))
        ->where('dibaca', false)
        ->count();
    $namaUser = session('nama') ?? 'User';
    $inisial = strtoupper(substr($namaUser, 0, 1));
@endphp

<nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container-fluid px-lg-4">

        {{-- Brand Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('user.dashboard') }}">
            <div class="brand-icon">
                <i class="bi bi-pc-display"></i>
            </div>
            <span>Inventaris IT</span>
        </a>

        {{-- Toggle Mobile --}}
        <button class="navbar-toggler border-0 text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <i class="bi bi-list fs-2"></i>
        </button>

        {{-- Menu Navigasi --}}
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}"
                       class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.peminjaman') }}"
                       class="nav-link {{ request()->is('user/peminjaman*') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Peminjaman</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.pesan') }}"
                       class="nav-link {{ request()->is('user/pesan-admin*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Pesan</span>
                        @if($jumlahPesan > 0)
                            <span class="badge-notification">
                                {{ $jumlahPesan }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.riwayat') }}"
                       class="nav-link {{ request()->is('user/riwayat*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
            </ul>

            {{-- User Profile Dropdown --}}
            <div class="dropdown">
                <a href="#" class="profile-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fw-bold small me-1">{{ $namaUser }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2">
                        <div class="fw-bold text-dark">{{ $namaUser }}</div>
                        <div class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small mt-1">Pengguna Aktif</div>
                    </li>
                    <li><hr class="dropdown-divider my-2"></li>
                    <li>
                        <a href="/logout" class="dropdown-item text-danger d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar (Logout)</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>

<main class="content">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>