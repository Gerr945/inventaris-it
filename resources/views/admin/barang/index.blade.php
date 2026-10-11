@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
    <div class="container-fluid py-3">

        <!-- Hero Header Banner -->
        <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
            style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);">
            <div class="card-body p-4 position-relative">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="z-1">
                        <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">
                            <i class="bi bi-box-seam me-1"></i> Inventaris Barang
                        </span>
                        <h2 class="fw-bold mb-1 text-white">Kelola Data Barang</h2>
                        <p class="mb-0 text-white-50 small">Pantau stok, kondisi, dan lokasi ketersediaan unit barang secara real-time.</p>
                    </div>

                    <div class="z-1 d-flex flex-wrap gap-2">
                        <a href="{{ route('barang.export') }}"
                            class="btn btn-success rounded-3 fw-bold shadow-sm px-3 py-2">
                            <i class="bi bi-file-earmark-excel me-1"></i>
                            Export Excel
                        </a>

                        <a href="{{ route('barang.create') }}"
                            class="btn btn-light text-primary rounded-3 px-4 py-2 fw-bold shadow-sm hover-top">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Stat Summary Row -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 text-primary border-start border-primary border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75">Total Barang</small>
                            <h4 class="fw-bold mb-0">{{ $barang->total() }}</h4>
                        </div>
                        <i class="bi bi-boxes fs-3 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-success bg-opacity-10 text-success border-start border-success border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75">Tersedia</small>
                            <h4 class="fw-bold mb-0">{{ $barang->where('status', 'Tersedia')->count() }}</h4>
                        </div>
                        <i class="bi bi-check-circle fs-3 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-16 col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-warning bg-opacity-10 text-warning border-start border-warning border-4">
                    <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="fw-semibold text-uppercase opacity-75">Dipinjam</small>
                            <h4 class="fw-bold mb-0">{{ $barang->where('status', 'Dipinjam')->count() }}</h4>
                        </div>
                        <i class="bi bi-arrow-left-right fs-3 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="alert alert-success border-0 border-start border-success border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center">
                    <div class="bg-success text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <span class="fw-medium text-dark">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 border-start border-danger border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center">
                    <div class="bg-danger text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <span class="fw-medium text-dark">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Table Container -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <!-- Filter & Search Section -->
            <div class="card-header bg-white py-3 border-bottom border-light">
                <form action="{{ route('barang.index') }}" method="GET">
                    <div class="row g-2 align-items-center justify-content-between">
                        <div class="col-md-6 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-primary ps-3">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control bg-light border-0 py-2"
                                    placeholder="Cari nama barang, kode, atau lokasi..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <a href="{{ route('barang.index') }}" class="btn btn-light border-0 text-muted py-2" title="Reset Search">
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

            <!-- Table Data -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-indigo-subtle text-primary-emphasis small text-uppercase fw-bold" style="background-color: #f0f4ff;">
                        <tr>
                            <th class="border-0 text-center" width="60">No</th>
                            <th class="border-0">Kode</th>
                            <th class="border-0">Nama Barang</th>
                            <th class="border-0 text-center" width="90">Foto</th>
                            <th class="border-0 text-center">Stok</th>
                            <th class="border-0">Kondisi</th>
                            <th class="border-0">Lokasi</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="border-0 text-center" width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($barang as $item)
                            <tr>
                                <td class="text-center fw-bold text-muted small">
                                    {{ $barang->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2 py-1 rounded">
                                        {{ $item->kode_barang }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                </td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('uploads/barang/' . $item->foto) }}" alt="{{ $item->nama_barang }}"
                                            class="rounded-3 shadow-sm border border-2 border-white object-fit-cover" width="45" height="45">
                                    @else
                                        <div class="avatar-sm bg-gradient text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center mx-auto"
                                            style="width: 45px; height: 45px; background: linear-gradient(135deg, #a5b4fc, #6366f1);" title="Tanpa Gambar">
                                            <i class="bi bi-box-seam fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->stok == 0)
                                        <span class="badge bg-danger text-white px-3 py-1 rounded-pill fw-bold shadow-sm">Habis</span>
                                    @elseif($item->stok <= 3)
                                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold shadow-sm">
                                            {{ $item->stok }} Unit
                                        </span>
                                    @else
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-3 py-1 rounded-pill fw-bold">
                                            {{ $item->stok }} Unit
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1 fw-normal">
                                        <i class="bi bi-shield-check text-success me-1"></i>{{ $item->kondisi }}
                                    </span>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-secondary">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $item->lokasi }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($item->status == 'Tersedia')
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                            <i class="bi bi-check-circle me-1"></i> Tersedia
                                        </span>
                                    @else($item->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                            <i class="bi bi-arrow-left-right me-1"></i> Tidak Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('barang.show', $item->id) }}"
                                            class="btn btn-primary btn-sm fw-semibold rounded-2 px-2 shadow-sm" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <form action="{{ route('barang.toggle-status', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($item->status === 'Nonaktif')
                                                <button type="submit" class="btn btn-success btn-sm text-white fw-bold rounded-2 px-2 shadow-sm"
                                                    title="Aktifkan Barang" onclick="return confirm('Aktifkan kembali barang {{ $item->nama_barang }}?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-danger btn-sm text-white fw-bold rounded-2 px-2 shadow-sm"
                                                    title="Nonaktifkan Barang" onclick="return confirm('Nonaktifkan barang {{ $item->nama_barang }}?')">
                                                    <i class="bi bi-power"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="py-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-inbox fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data barang tidak ditemukan</h5>
                                        <p class="text-muted small">Coba masukkan kata kunci lain atau tambahkan data barang baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            @if($barang->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan {{ $barang->firstItem() }} - {{ $barang->lastItem() }} dari {{ $barang->total() }} barang</small>
                    <div>
                        {{ $barang->withQueryString()->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection