@extends('layouts.admin')

@section('title', 'Pengembalian Barang')

@section('content')

<div class="container-fluid py-3">

    <!-- Hero Header -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
        style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%);">

        <div class="card-body p-4 position-relative">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                <div class="z-1">

                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">

                        <i class="bi bi-arrow-return-left me-1"></i>
                        Modul Pengembalian

                    </span>

                    <h2 class="fw-bold mb-1 text-white">
                        Monitoring Pengembalian Barang
                    </h2>

                    <p class="mb-0 text-white-50 small">
                        Pantau status penerimaan barang dan konfirmasi pengembalian dari peminjam.
                    </p>

                </div>

                <div class="z-1">

                    <a href="{{ route('pengembalian.export') }}"
                        class="btn btn-success rounded-3 px-4 py-2 fw-bold shadow-sm">

                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Export Excel

                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- Mini Stat Summary -->

    <div class="row g-3 mb-4">

        <!-- Total Disetujui -->
        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4">

                <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">

                    <div>

                        <small class="fw-semibold text-uppercase opacity-75 text-primary">
                            Total Disetujui
                        </small>

                        <h4 class="fw-bold mb-0 text-primary">
                            {{ $totalDisetujui }}
                        </h4>

                    </div>

                    <i class="bi bi-box-seam-fill fs-3 text-primary opacity-50"></i>

                </div>

            </div>

        </div>


        <!-- Belum Kembali -->
        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm rounded-3 bg-warning bg-opacity-10 border-start border-warning border-4">

                <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">

                    <div>

                        <small class="fw-semibold text-uppercase opacity-75 text-dark">
                            Belum Kembali
                        </small>

                        <h4 class="fw-bold mb-0 text-dark">
                            {{ $belumKembali }}
                        </h4>

                    </div>

                    <i class="bi bi-hourglass-split fs-3 text-warning opacity-75"></i>

                </div>

            </div>

        </div>


        <!-- Sudah Dikembalikan -->
        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm rounded-3 bg-success bg-opacity-10 border-start border-success border-4">

                <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">

                    <div>

                        <small class="fw-semibold text-uppercase opacity-75 text-success">
                            Sudah Dikembalikan
                        </small>

                        <h4 class="fw-bold mb-0 text-success">
                            {{ $sudahDikembalikan }}
                        </h4>

                    </div>

                    <i class="bi bi-check-circle-fill fs-3 text-success opacity-50"></i>

                </div>

            </div>

        </div>


        <!-- Terlambat -->
        <div class="col-6 col-md-3">

            <div class="card border-0 shadow-sm rounded-3 bg-danger bg-opacity-10 border-start border-danger border-4">

                <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">

                    <div>

                        <small class="fw-semibold text-uppercase opacity-75 text-danger">
                            Terlambat
                        </small>

                        <h4 class="fw-bold mb-0 text-danger">
                            {{ $terlambat }}
                        </h4>

                    </div>

                    <i class="bi bi-clock-history fs-3 text-danger opacity-75"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Flash Success -->

    @if(session('success'))

        <div class="alert alert-success border-0 border-start border-success border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between"
            role="alert">

            <div class="d-flex align-items-center">

                <div class="bg-success text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;">

                    <i class="bi bi-check-lg"></i>

                </div>

                <span class="fw-medium text-dark">
                    {{ session('success') }}
                </span>

            </div>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif


    <!-- Flash Error -->

    @if(session('error'))

        <div class="alert alert-danger border-0 border-start border-danger border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between"
            role="alert">

            <div class="d-flex align-items-center">

                <div class="bg-danger text-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>

                <span class="fw-medium text-dark">
                    {{ session('error') }}
                </span>

            </div>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif


    <!-- Main Content -->

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


        <!-- Filter & Search -->

        <div class="card-header bg-white py-3 border-bottom border-light">

            <form action="{{ route('admin.pengembalian') }}" method="GET">

                <div class="row g-2 align-items-center">

                    <!-- Search -->

                    <div class="col-md-5 col-lg-4">

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0 text-muted ps-3">

                                <i class="bi bi-search"></i>

                            </span>

                            <input type="text"
                                name="search"
                                class="form-control bg-light border-0 py-2"
                                placeholder="Cari nama peminjam, departemen, barang..."
                                value="{{ request('search') }}">

                        </div>

                    </div>


                    <!-- Filter Status -->

                    <div class="col-md-4 col-lg-3">

                        <select name="status" class="form-select bg-light border-0 py-2">

                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>
                                Semua Status
                            </option>

                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>
                                Belum Dikembalikan
                            </option>

                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>

                            <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>
                                Sudah Dikembalikan
                            </option>

                        </select>

                    </div>


                    <!-- Per Page -->

                    <div class="col-md-3 col-lg-2">

                        <select name="per_page" class="form-select bg-light border-0 py-2">

                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                                10 Data
                            </option>

                            <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>
                                20 Data
                            </option>

                            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>
                                50 Data
                            </option>

                            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>
                                100 Data
                            </option>

                        </select>

                    </div>


                    <!-- Buttons -->

                    <div class="col-md-3 col-lg-3 d-flex gap-2">

                        <button type="submit"
                            class="btn btn-emerald text-white fw-semibold px-4 py-2 rounded-3 shadow-sm"
                            style="background-color: #059669;">

                            <i class="bi bi-funnel me-1"></i>
                            Cari

                        </button>


                        @if(request('search') || request('status') || request('per_page'))

                            <a href="{{ route('admin.pengembalian') }}"
                                class="btn btn-light border py-2 px-3 rounded-3 text-secondary"
                                title="Reset Filter">

                                <i class="bi bi-arrow-clockwise me-1"></i>
                                Reset

                            </a>

                        @endif

                    </div>

                </div>

            </form>

        </div>


        <!-- Data Table -->

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="small text-uppercase fw-bold"
                    style="background-color: #ecfdf5; color: #047857;">

                    <tr>

                        <th class="text-center border-0" width="60">
                            No
                        </th>

                        <th class="border-0" width="130">
                            Tanggal
                        </th>

                        <th class="border-0" width="170">
                            ID Transaksi
                        </th>

                        <th class="border-0">
                            Barang Dipinjam
                        </th>

                        <th class="border-0" width="200">
                            Peminjam
                        </th>

                        <th class="border-0 text-center" width="180">
                            Status
                        </th>

                        <th class="border-0 text-center pe-4" width="220">
                            Aksi Konfirmasi
                        </th>

                    </tr>

                </thead>


                <tbody class="border-top-0">

                    @forelse($peminjaman as $item)

                        <tr>

                            <!-- No -->

                            <td class="ps-4 fw-bold text-muted small">

                                {{ $peminjaman->firstItem() + $loop->index }}

                            </td>


                            <!-- Tanggal -->

                            <td>

                                <span class="small fw-semibold text-dark">

                                    <i class="bi bi-calendar3 me-1 text-muted"></i>

                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

                                </span>

                            </td>


                            <!-- ID Transaksi -->

                            <td>

                                <span class="badge bg-light text-dark border font-monospace px-2 py-1">

                                    PMJ-{{ \Carbon\Carbon::parse($item->created_at)->format('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}

                                </span>

                            </td>


                            <!-- Barang -->

                            <td>

                                <div class="d-flex flex-wrap gap-1">

                                    @foreach($item->detailPeminjaman as $detail)

                                        <span class="badge rounded-2 px-2 py-1 small fw-normal"
                                            style="background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">

                                            <i class="bi bi-box-seam me-1"></i>

                                            {{ $detail->barang->nama_barang ?? 'Barang' }}

                                            <strong class="ms-1 text-white px-1 rounded-1"
                                                style="font-size: 10px; background-color: #059669;">

                                                x{{ $detail->jumlah }}

                                            </strong>

                                        </span>

                                    @endforeach

                                </div>

                            </td>


                            <!-- Peminjam -->

                            <td>

                                <div class="fw-bold text-dark mb-0">

                                    {{ $item->user->nama ?? '-' }}

                                </div>

                                <small class="text-muted d-block">

                                    <i class="bi bi-building me-1"></i>

                                    {{ $item->user->departemen ?? '-' }}

                                </small>

                            </td>


                            <!-- Status -->

                            <td class="text-center">

                                @if($item->pengembalian)

                                    <!-- SUDAH DIKEMBALIKAN -->

                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                        Sudah Dikembalikan

                                    </span>

                                    <small class="text-muted d-block mt-1"
                                        style="font-size: 11px;">

                                        Diterima:

                                        <strong>
                                            {{ $item->pengembalian->nama_penerima ?? '-' }}
                                        </strong>

                                    </small>


                                @elseif($item->isTerlambat())

                                    <!-- TERLAMBAT -->

                                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill fw-semibold shadow-sm">

                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>

                                        Terlambat

                                    </span>

                                    <small class="text-danger d-block mt-1"
                                        style="font-size: 11px;">

                                        Batas:

                                        <strong>
                                            {{ $item->waktuBatasPengembalian()?->format('d M Y, H:i') }}
                                        </strong>

                                    </small>


                                @else

                                    <!-- BELUM DIKEMBALIKAN -->

                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">

                                        <i class="bi bi-hourglass-split me-1"></i>

                                        Belum Dikembalikan

                                    </span>

                                    @if($item->waktuBatasPengembalian())

                                        <small class="text-muted d-block mt-1"
                                            style="font-size: 11px;">

                                            Batas:

                                            <strong>
                                                {{ $item->waktuBatasPengembalian()?->format('d M Y, H:i') }}
                                            </strong>

                                        </small>

                                    @endif

                                @endif

                            </td>


                            <!-- Aksi -->

                            <td class="text-center pe-4">

                                @if(!$item->pengembalian)

                                    <form action="{{ route('admin.pengembalian.manual', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Konfirmasi bahwa seluruh barang pada transaksi ini telah diterima kembali oleh Admin IT?')">

                                        @csrf

                                        <button type="submit"
                                            class="btn btn-sm rounded-3 px-3 fw-semibold shadow-sm text-white w-100"
                                            style="background-color: #059669;">

                                            <i class="bi bi-box-arrow-in-down me-1"></i>

                                            Terima Barang

                                        </button>

                                    </form>

                                @else

                                    <button class="btn btn-light border btn-sm rounded-3 px-3 fw-semibold text-muted w-100"
                                        disabled>

                                        <i class="bi bi-check2-all me-1"></i>

                                        Selesai

                                    </button>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <div class="py-3">

                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-3 mb-3">

                                        <i class="bi bi-arrow-return-left fs-1"></i>

                                    </div>

                                    <h5 class="fw-bold text-dark mb-1">
                                        Tidak ada data pengembalian
                                    </h5>

                                    <p class="text-muted small">
                                        Belum ada pengajuan peminjaman yang disetujui atau data tidak ditemukan.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->

        @if($peminjaman->hasPages())

            <div class="card-footer bg-white border-0 py-3">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                    <div class="text-muted small">

                        Menampilkan

                        <strong>
                            {{ $peminjaman->firstItem() }}
                        </strong>

                        -

                        <strong>
                            {{ $peminjaman->lastItem() }}
                        </strong>

                        dari

                        <strong>
                            {{ $peminjaman->total() }}
                        </strong>

                        pengajuan

                    </div>


                    <div class="pagination-wrapper">

                        {{ $peminjaman->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection


<style>

    .pagination-wrapper .pagination {

        margin-bottom: 0;
        gap: 4px;

    }


    .pagination-wrapper .page-link {

        border-radius: 8px !important;
        border: 1px solid #dee2e6;
        min-width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        font-weight: 500;

    }


    .pagination-wrapper .page-item.active .page-link {

        font-weight: 600;

    }


    .pagination-wrapper .page-item.disabled .page-link {

        background-color: #f8f9fa;

    }


    @media (max-width: 576px) {

        .pagination-wrapper .page-link {

            min-width: 34px;
            height: 34px;
            font-size: 13px;

        }


        .pagination-wrapper .pagination {

            justify-content: center;

        }

    }

</style>