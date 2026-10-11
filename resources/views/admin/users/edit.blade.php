@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid py-3">

        <!-- Hero Header Banner -->
        <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
            style="background: linear-gradient(135deg, #0d9488 0%, #4f46e5 100%);">
            <div class="card-body p-4 position-relative">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="z-1">
                        <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">
                            <i class="bi bi-pencil-square me-1"></i> Form Update Pengguna
                        </span>
                        <h2 class="fw-bold mb-1 text-white">Edit Data User</h2>
                        <p class="mb-0 text-white-50 small">Perbarui profil dan hak akses pengguna: <strong
                                class="text-white">{{ $user->nama }}</strong></p>
                    </div>
                    <div class="z-1">
                        <a href="{{ route('users.index') }}"
                            class="btn btn-light text-teal rounded-3 px-3 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Multi Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger border-0 border-start border-danger border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-start">
                    <div class="bg-danger text-white p-2 rounded-circle me-3 mt-1 d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-danger mb-1">Terjadi kesalahan input:</h6>
                        <ul class="mb-0 ps-3 text-dark small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-3">
                        <i class="bi bi-sliders text-teal me-2"></i>Ubah Informasi User
                    </h5>

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-person text-teal me-1"></i>Nama Lengkap <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="nama"
                                    class="form-control bg-light border-0 py-2 @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-at text-teal me-1"></i>Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="username"
                                    class="form-control bg-light border-0 py-2 @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-envelope text-teal me-1"></i>Email <span class="text-danger">*</span>
                                </label>

                                <input type="email" name="email"
                                    class="form-control bg-light border-0 py-2 @error('email') is-invalid @enderror"
                                    placeholder="contoh@gmail.com" value="{{ old('email', $user->email) }}" required>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Departemen -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-building text-teal me-1"></i>Departemen / Divisi
                                </label>
                                <input type="text" name="departemen"
                                    class="form-control bg-light border-0 py-2 @error('departemen') is-invalid @enderror"
                                    value="{{ old('departemen', $user->departemen) }}">
                                @error('departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-shield-lock text-teal me-1"></i>Role Access <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="role"
                                    class="form-select bg-light border-0 py-2 @error('role') is-invalid @enderror" required>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                        Administrator</option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User Biasa
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Baru (Optional) -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">
                                    <i class="bi bi-key text-teal me-1"></i>Password Baru <span
                                        class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" id="passwordInput" name="password"
                                        class="form-control bg-light border-0 py-2 @error('password') is-invalid @enderror"
                                        placeholder="Masukkan password baru jika ingin diubah...">
                                    <button class="btn btn-light border-0 px-3 text-secondary" type="button"
                                        id="togglePassword">
                                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1 fs-7">
                                    <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengganti kata
                                    sandi.
                                </small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-warning text-dark px-4 py-2 fw-bold rounded-3 shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('users.index') }}"
                                class="btn btn-light border px-4 py-2 fw-semibold rounded-3 text-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Toggle Password Visibility -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        });
    </script>
@endsection

