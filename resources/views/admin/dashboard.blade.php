@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-2">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Dashboard</h3>
            <p class="text-muted small mb-0">Ringkasan aktivitas peminjaman dan status inventaris barang.</p>
        </div>
        <div>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">
                <i class="bi bi-calendar3 me-1 text-primary"></i> {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Section 1: Ringkasan Utama & Status Pengajuan -->
    <div class="row g-3 mb-4">
        <!-- Total Barang -->
        <div class="col-xl-4 col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Total Barang</span>
                            <h3 class="fw-bold mb-0 mt-1 text-dark">{{ $totalBarang }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="col-xl-4 col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Total User</span>
                            <h3 class="fw-bold mb-0 mt-1 text-dark">{{ $totalUser }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Pinjam -->
        <div class="col-xl-4 col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Pending Pinjam</span>
                            <h3 class="fw-bold mb-0 mt-1 text-warning">{{ $pendingPeminjaman }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Total Transaksi Selesai -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 bg-gradient">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white p-3 rounded-3 me-3">
                            <i class="bi bi-box-arrow-in-right fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">Total Peminjaman</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalPeminjaman }} <span class="fs-6 fw-normal text-muted">transaksi</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white p-3 rounded-3 me-3">
                            <i class="bi bi-box-arrow-left fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold">Total Pengembalian</span>
                            <h4 class="fw-bold mb-0 text-dark">{{ $totalPengembalian }} <span class="fs-6 fw-normal text-muted">transaksi</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Status Inventaris Fisik -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 border-start border-4 border-success">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">Barang Tersedia</span>
                        <h2 class="fw-bold mb-0 text-success">{{ $barangTersedia }}</h2>
                    </div>
                    <i class="bi bi-check-circle-fill text-success opacity-25 display-6"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3 border-start border-4 border-warning">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">Sedang Dipinjam</span>
                        <h2 class="fw-bold mb-0 text-warning">{{ $barangDipinjam }}</h2>
                    </div>
                    <i class="bi bi-arrow-left-right text-warning opacity-25 display-6"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Tabel Aktivitas Terbaru & Widget Barang Aktif -->
    <div class="row g-4">
        <!-- Log Peminjaman -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-journal-text me-2 text-primary"></i>Log Peminjaman Terbaru
                    </h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-3 border-0">Tanggal</th>
                                <th class="border-0">ID Transaksi</th>
                                <th class="border-0">Peminjam</th>
                                <th class="border-0">Item Barang</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aktivitas as $item)
                                <tr>
                                    <td class="ps-3 text-muted small">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="font-monospace fw-bold text-primary">
                                            PMJ-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light text-dark rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold border" style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($item->user->nama, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $item->user->nama }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($item->detailPeminjaman as $detail)
                                            <span class="badge bg-light text-dark border me-1 my-1">
                                                <i class="bi bi-box me-1 text-muted"></i>{{ $detail->barang->nama_barang }}
                                            </span>
                                            @if(!$loop->last) <br> @endif
                                        @endforeach
                                    </td>
                                    <td class="text-end pe-3 text-center">
                                        @if($item->status == 'approved')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                                                <i class="bi bi-check-circle me-1"></i>Disetujui
                                            </span>
                                        @elseif($item->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill fw-semibold">
                                                <i class="bi bi-hourglass-split me-1"></i>Pending
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill fw-semibold">
                                                <i class="bi bi-x-circle me-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block text-secondary mb-2"></i>
                                        Belum ada aktivitas peminjaman terbaru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar List: Barang Sedang Dipinjam -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-box-seam me-2 text-warning"></i>Barang Dipinjam Saat Ini
                    </h5>
                </div>
                <div class="card-body p-3">
                    @forelse($barangAktif as $barang)
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded-3 bg-light border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded-3 me-3 text-warning shadow-sm">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold text-dark">{{ $barang->nama_barang }}</h6>
                                    <small class="text-muted">Status: Aktif Dipakai</small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark px-2 py-1 rounded">
                                Dipinjam
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-check-all fs-1 text-success d-block mb-1"></i>
                            <p class="mb-0 small">Semua barang saat ini tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection