@extends('layouts.admin')

@section('title', 'Data User')

@section('content')
    <div class="container-fluid py-3">

        <!-- Hero Header Banner -->
        <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
            style="background: linear-gradient(135deg, #0d9488 0%, #4f46e5 100%);">
            <div class="card-body p-4 position-relative">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="z-1">
                        <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">
                            <i class="bi bi-people me-1"></i> Manajemen Pengguna
                        </span>
                        <h2 class="fw-bold mb-1 text-white">Daftar Pengguna System</h2>
                        <p class="mb-0 text-white-50 small">Kelola hak akses, role, dan informasi akun pengguna inventaris.
                        </p>
                    </div>
                    <div class="z-1 d-flex flex-wrap gap-2">

                        <a href="{{ route('users.export') }}"
                            class="btn btn-success rounded-3 fw-bold shadow-sm px-3 py-2"
                            style="min-width: 150px;">
                            <i class="bi bi-file-earmark-excel me-1"></i>
                            Export Excel
                        </a>

                        <a href="{{ route('users.create') }}"
                            class="btn btn-light text-primary rounded-3 px-4 py-2 fw-bold shadow-sm hover-top"
                            style="min-width: 150px;">
                            <i class="bi bi-person-plus me-1"></i>
                            Tambah User
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Stat Summary Row -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-teal bg-opacity-10 border-start border-teal border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75 text-dark">Total Pengguna</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $users->total() }}</h4>
                        </div>
                        <i class="bi bi-people-fill fs-3 text-teal opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-danger bg-opacity-10 border-start border-danger border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75 text-danger">Administrator</small>
                            <h4 class="fw-bold mb-0 text-danger">{{ $users->where('role', 'admin')->count() }}</h4>
                        </div>
                        <i class="bi bi-shield-lock-fill fs-3 text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div
                    class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75 text-primary">User</small>
                            <h4 class="fw-bold mb-0 text-primary">{{ $users->where('role', '!=', 'admin')->count() }}</h4>
                        </div>
                        <i class="bi bi-person-badge-fill fs-3 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="alert alert-success border-0 border-start border-success border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <span class="fw-medium text-dark">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 border-start border-danger border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center">
                    <div class="bg-danger text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <span class="fw-medium text-dark">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Content Container -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <!-- Filter & Search Bar -->
            <div class="card-header bg-white py-3 border-bottom border-light">
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="row g-2 align-items-center justify-content-between">
                        <div class="col-md-6 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-primary ps-3">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 py-2"
                                    placeholder="Cari nama, username, atau departemen..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('users.index') }}" class="btn btn-light border-0 text-muted py-2"
                                        title="Reset Search">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </a>
                                @endif
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Colorful User Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="small text-uppercase fw-bold" style="background-color: #f0fdf4; color: #15803d;">
                        <tr>
                            <th class="border-0 text-center" width="60">No</th>
                            <th class="border-0">Pengguna</th>
                            <th class="border-0">Username</th>
                            <th class="border-0">Departemen</th>
                            <th class="border-0 text-center">Role</th>
                            <th class="border-0 text-center pe-4" width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 fw-bold text-muted small">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">

                                        <div>
                                            <span class="fw-bold text-dark d-block mb-0">{{ $user->nama }}</span>
                                            @if(session('user_id') == $user->id)
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill small"
                                                    style="font-size: 10px;">
                                                    <i class="bi bi-check-circle-fill me-1"></i>Akun Anda
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        @ {{ $user->username }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-secondary">
                                        <i class="bi bi-building me-1 text-muted"></i>{{ $user->departemen ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                            <i class="bi bi-shield-check me-1"></i> Admin
                                        </span>
                                    @else
                                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                            <i class="bi bi-person me-1"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Riwayat --}}
                                        <a href="{{ route('users.history', $user->id) }}"
                                            class="btn btn-info btn-sm text-white fw-bold rounded-2 px-2 shadow-sm"
                                            title="Lihat Riwayat Peminjaman">

                                            <i class="bi bi-clock-history"></i>

                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm text-dark fw-bold rounded-2 px-2 shadow-sm"
                                            title="Edit User">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>


                                        {{-- Hapus --}}
                                        @if(session('user_id') != $user->id)

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm text-white fw-bold rounded-2 px-2 shadow-sm"
                                                    title="Hapus User"
                                                    onclick="return confirm('Yakin ingin menghapus user {{ $user->nama }}?')">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        @else

                                            <button class="btn btn-light border btn-sm text-muted rounded-2 px-2 shadow-sm" disabled
                                                title="Tidak bisa menghapus akun sendiri">

                                                <i class="bi bi-lock-fill"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-3">
                                        <div class="bg-teal bg-opacity-10 text-teal rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-person-x fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data user tidak ditemukan</h5>
                                        <p class="text-muted small">Coba cari dengan kata kunci lain atau tambahkan user baru.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            @if($users->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari
                        {{ $users->total() }} user</small>
                    <div>
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection