<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Inventaris IT</title>

    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Colorful Animated Background */
        body {
            background: linear-gradient(-45deg, #1A3636, #40534C, #677D6A, #D6BD98);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Glassmorphism Card Style */
        .login-card {
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 30px;
            box-shadow: 0 8px 16px -4px rgba(5, 150, 105, 0.4);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            border-color: #cbd5e1;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .form-control:focus {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
            background-color: #ffffff;
        }

        .btn-emerald {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-emerald:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.4);
            color: #ffffff;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: #f1f5f9;
            border-color: #cbd5e1;
            color: #64748b;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .input-group.has-toggle .form-control {
            border-radius: 0;
        }

        .toggle-password {
            border-radius: 0 12px 12px 0;
            background-color: #ffffff;
            border-color: #cbd5e1;
            color: #64748b;
            cursor: pointer;
        }

        .toggle-password:hover {
            color: #334155;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>

    <div class="card login-card">
        <div class="card-body p-4 p-sm-5">

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="logo-icon">
                    <i class="bi bi-pc-display"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">Peminjaman Inventaris IT</h4>
                <p class="text-muted small mb-0">Masukkan akun Anda untuk melanjutkan</p>
            </div>

            <!-- Flash Error Alert -->
            @if(session('error'))
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 py-2 px-3 mb-4 d-flex align-items-center gap-2 small">
                    <i class="bi bi-exclamation-circle-fill fs-6"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Form Login -->
            <form action="/login" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-dark">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus autocomplete="username">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold text-dark">Password</label>
                    <div class="input-group has-toggle">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" id="passwordInput" name="password" class="form-control" placeholder="Masukkan password" required autocomplete="current-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" id="togglePassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-emerald w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Masuk Ke Sistem</span>
                </button>
            </form>

        </div>
    </div>

    <!-- JavaScript Bootstrap & Toggle Password -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('toggleIcon');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });
        }
    </script>
</body>

</html>