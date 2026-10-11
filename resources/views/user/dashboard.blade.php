@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

{{-- Header Section --}}
<div class="mb-4">

    <h3 class="fw-bold text-dark mb-1">
        Dashboard
    </h3>

    <p class="text-muted small mb-0">

        Selamat datang kembali,

        <span class="fw-bold text-success">
            {{ session('nama') }}
        </span>

        👋

    </p>

</div>


{{-- Statistics Cards --}}

<div class="row g-3 g-lg-4 mb-4">


    {{-- Total Dipinjam --}}

    <div class="col-lg-3 col-md-6 col-6">

        <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift bg-white">

            <div class="card-body p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <p class="text-secondary small fw-semibold text-uppercase tracking-wide mb-1"
                            style="font-size: 0.75rem;">

                            Total Dipinjam

                        </p>

                        <h2 class="fw-bold text-dark mb-0">
                            {{ $barangDipinjam }}
                        </h2>

                    </div>

                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">

                        <i class="bi bi-box-seam fs-4"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Pending --}}

    <div class="col-lg-3 col-md-6 col-6">

        <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift bg-white">

            <div class="card-body p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <p class="text-secondary small fw-semibold text-uppercase tracking-wide mb-1"
                            style="font-size: 0.75rem;">

                            Pending

                        </p>

                        <h2 class="fw-bold text-dark mb-0">
                            {{ $pendingPeminjaman }}
                        </h2>

                    </div>

                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">

                        <i class="bi bi-clock-history fs-4"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Terlambat --}}

    <div class="col-lg-3 col-md-6 col-6">

        <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift bg-white">

            <div class="card-body p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <p class="text-secondary small fw-semibold text-uppercase tracking-wide mb-1"
                            style="font-size: 0.75rem;">

                            Terlambat

                        </p>

                        <h2 class="fw-bold text-danger mb-0">
                            {{ $terlambat }}
                        </h2>

                    </div>

                    <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">

                        <i class="bi bi-exclamation-triangle fs-4"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Riwayat --}}

    <div class="col-lg-3 col-md-6 col-6">

        <div class="card border-0 shadow-sm h-100 rounded-4 hover-lift bg-white">

            <div class="card-body p-3 p-lg-4">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <p class="text-secondary small fw-semibold text-uppercase tracking-wide mb-1"
                            style="font-size: 0.75rem;">

                            Riwayat

                        </p>

                        <h2 class="fw-bold text-dark mb-0">
                            {{ $riwayat }}
                        </h2>

                    </div>

                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 48px; height: 48px;">

                        <i class="bi bi-check-circle fs-4"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Main Content --}}

<div class="row g-3 g-lg-4">


    {{-- Log Peminjaman --}}

    <div class="col-lg-7">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">

                <h6 class="m-0 fw-bold text-dark d-flex align-items-center gap-2">

                    <i class="bi bi-journal-text text-primary"></i>

                    Log Peminjaman Terakhir

                </h6>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="bg-light text-secondary text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.5px;">

                        <tr>

                            <th class="py-3 px-4">
                                Tanggal
                            </th>

                            <th class="py-3">
                                Kode
                            </th>

                            <th class="py-3">
                                Barang
                            </th>

                            <th class="py-3 text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="border-top-0">

                        @forelse($aktivitas as $item)

                            <tr>

                                <td class="small text-secondary fw-medium px-4">

                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

                                </td>


                                <td>

                                    <span class="badge bg-light text-dark border fw-medium font-monospace">

                                        PMJ-{{ optional($item->created_at)->format('Ymd') ?? date('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}

                                    </span>

                                </td>


                                <td>

                                    <div class="d-flex flex-wrap gap-1">

                                        @foreach($item->detailPeminjaman as $detail)

                                            <span class="badge bg-light text-secondary border fw-normal">

                                                {{ $detail->barang->nama_barang ?? 'Barang N/A' }}

                                                @if(isset($detail->jumlah) && $detail->jumlah > 1)

                                                    <span class="fw-bold text-dark">
                                                        ({{ $detail->jumlah }})
                                                    </span>

                                                @endif

                                            </span>

                                        @endforeach

                                    </div>

                                </td>


                                <td class="text-center">

                                    @if($item->status === 'approved')

                                        @if($item->isTerlambat())

                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-semibold">

                                                <i class="bi bi-exclamation-triangle me-1"></i>

                                                Terlambat

                                            </span>

                                        @else

                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-semibold">

                                                <i class="bi bi-check-circle me-1"></i>

                                                Disetujui

                                            </span>

                                        @endif

                                    @elseif($item->status === 'pending')

                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill fw-semibold">

                                            <i class="bi bi-clock me-1"></i>

                                            Menunggu

                                        </span>

                                    @else

                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-semibold">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Ditolak

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-black-50"></i>

                                        <p class="mb-0 fw-medium">
                                            Belum ada aktivitas peminjaman
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Barang Yang Sedang Dipinjam --}}

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white py-3 px-4 border-bottom">

                <h6 class="m-0 fw-bold text-dark d-flex align-items-center gap-2">

                    <i class="bi bi-box-arrow-up-right text-success"></i>

                    Barang Sedang Dipinjam

                </h6>

            </div>


            <div class="card-body p-4">

                @forelse($barangAktif as $item)

                    <div class="border border-light-subtle rounded-3 p-3 mb-3 bg-light bg-opacity-50">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            @if($item->isTerlambat())

                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-2 fw-medium">

                                    <i class="bi bi-exclamation-triangle me-1"></i>

                                    Terlambat

                                </span>

                            @else

                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-2 fw-medium">

                                    <i class="bi bi-dot me-1"></i>

                                    Aktif

                                </span>

                            @endif


                            <span class="text-muted small font-monospace">

                                PMJ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}

                            </span>

                        </div>


                        <ul class="list-unstyled mb-3">

                            @foreach($item->detailPeminjaman as $detail)

                                <li class="mb-2 d-flex align-items-center text-dark fw-medium">

                                    <i class="bi bi-box-seam text-secondary me-2"></i>

                                    <span>
                                        {{ $detail->barang->nama_barang ?? 'Barang N/A' }}
                                    </span>

                                    @if(isset($detail->jumlah) && $detail->jumlah > 1)

                                        <span class="badge bg-secondary-subtle text-secondary ms-2 small">

                                            {{ $detail->jumlah }} unit

                                        </span>

                                    @endif

                                </li>

                            @endforeach

                        </ul>


                        <div class="border-top border-light-subtle pt-2 mt-2">

                            <div class="d-flex justify-content-between text-muted small">

                                <span>

                                    <i class="bi bi-calendar-event me-1"></i>

                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

                                </span>

                                <span>

                                    <i class="bi bi-clock me-1"></i>

                                    {{ $item->jam }}

                                </span>

                            </div>


                            @if($item->waktuBatasPengembalian())

                                <div class="mt-2 text-end">

                                    <small class="{{ $item->isTerlambat() ? 'text-danger' : 'text-muted' }}">

                                        <i class="bi bi-arrow-return-left me-1"></i>

                                        Batas kembali:

                                        <strong>
                                            {{ $item->waktuBatasPengembalian()?->format('d M Y, H:i') }}
                                        </strong>

                                    </small>

                                </div>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="text-center py-4">

                        <i class="bi bi-check2-circle fs-1 d-block mb-2 text-success opacity-50"></i>

                        <p class="text-muted small mb-0">

                            Tidak ada barang yang sedang dipinjam saat ini.

                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


{{-- Custom Styles --}}

<style>

    .hover-lift {

        transition:
            transform 0.2s cubic-bezier(0.4, 0, 0.2, 1),
            box-shadow 0.2s cubic-bezier(0.4, 0, 0.2, 1);

    }


    .hover-lift:hover {

        transform: translateY(-4px);

        box-shadow:
            0 10px 25px -5px rgba(0, 0, 0, 0.05),
            0 8px 10px -6px rgba(0, 0, 0, 0.01) !important;

    }

</style>

@endsection