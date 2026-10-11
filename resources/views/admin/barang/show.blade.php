@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')

<div class="container-fluid py-3">

    {{-- HEADER --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
        style="background:linear-gradient(135deg,#4f46e5,#7c3aed 50%,#2563eb);">

        <div class="card-body p-3 p-md-4">

            <div class="d-flex flex-column flex-md-row
                justify-content-between align-items-md-center gap-3">

                <div class="min-width-0">

                    <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-1 mb-2">
                        <i class="bi bi-box-seam me-1"></i>
                        Detail Inventaris
                    </span>

                    <h2 class="fw-bold mb-1 text-white text-truncate">
                        {{ $barang->nama_barang }}
                    </h2>

                    <p class="mb-0 text-white-50 small">
                        Detail informasi dan kondisi barang inventaris.
                    </p>

                </div>

                <a href="{{ route('barang.index') }}"
                    class="btn btn-light text-primary rounded-3 fw-semibold
                    shadow-sm flex-shrink-0">

                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali

                </a>

            </div>

        </div>

    </div>


    {{-- CONTENT --}}
    <div class="row g-3 g-lg-4">


        {{-- FOTO --}}
        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-3 p-md-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-image text-primary me-2"></i>
                            Foto Barang
                        </h6>

                        @if($barang->foto)
                            <span class="badge bg-success-subtle text-success rounded-pill">
                                <i class="bi bi-check-circle me-1"></i>
                                Tersedia
                            </span>
                        @endif

                    </div>


                    @if($barang->foto)

                        <div class="bg-light rounded-4 p-2">

                            <img src="{{ asset('uploads/barang/' . $barang->foto) }}"
                                alt="{{ $barang->nama_barang }}"
                                class="img-fluid rounded-3 w-100"
                                style="height:300px;object-fit:contain;">

                        </div>

                    @else

                        <div class="bg-light rounded-4 d-flex
                            flex-column align-items-center justify-content-center"
                            style="height:300px;">

                            <i class="bi bi-box-seam text-primary display-4"></i>

                            <span class="text-muted small mt-2">
                                Tidak ada foto barang
                            </span>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- INFORMASI --}}
        <div class="col-12 col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-3 p-md-4">


                    {{-- TITLE + ACTION --}}
                    <div class="mb-4">

                        <div class="d-flex justify-content-between
                            align-items-center mb-3">

                            <div>

                                <h6 class="fw-bold mb-1">
                                    <i class="bi bi-info-circle text-primary me-2"></i>
                                    Informasi Barang
                                </h6>

                                <small class="text-muted">
                                    Data lengkap inventaris
                                </small>

                            </div>

                        </div>


                        {{-- ACTION BUTTON --}}
                        <div class="row g-2">

                            <div class="col-4">

                                <a href="{{ route('barang.edit', $barang->id) }}"
                                    class="btn btn-warning text-dark fw-semibold
                                    rounded-3 w-100 py-2">

                                    <i class="bi bi-pencil-square me-1"></i>
                                    <span class="d-none d-sm-inline">Edit</span>

                                </a>

                            </div>

                            <div class="col-4">

                                <a href="{{ route('admin.stok-masuk.create', $barang->id) }}"
                                    class="btn btn-success fw-semibold
                                    rounded-3 w-100 py-2">

                                    <i class="bi bi-plus-circle me-1"></i>
                                    <span class="d-none d-sm-inline">Tambah Stok</span>

                                </a>

                            </div>

                            <div class="col-4">

                                <a href="{{ route('admin.stok-masuk.history', $barang->id) }}"
                                    class="btn btn-info text-white fw-semibold
                                    rounded-3 w-100 py-2">

                                    <i class="bi bi-clock-history me-1"></i>
                                    <span class="d-none d-sm-inline">Riwayat</span>

                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- INFORMASI GRID --}}
                    <div class="row g-2">


                        {{-- KODE --}}
                        <div class="col-12 col-md-6">

                            <div class="bg-light rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-qr-code me-1"></i>
                                    Kode Barang
                                </small>

                                <span class="fw-bold font-monospace text-primary">
                                    {{ $barang->kode_barang }}
                                </span>

                            </div>

                        </div>


                        {{-- NAMA --}}
                        <div class="col-12 col-md-6">

                            <div class="bg-light rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Nama Barang
                                </small>

                                <span class="fw-bold text-dark">
                                    {{ $barang->nama_barang }}
                                </span>

                            </div>

                        </div>


                        {{-- STOK --}}
                        <div class="col-12 col-md-6">

                            <div class="bg-light rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-stack me-1"></i>
                                    Stok Saat Ini
                                </small>

                                @if($barang->stok == 0)

                                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Habis
                                    </span>

                                @elseif($barang->stok <= 3)

                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $barang->stok }} Unit
                                    </span>

                                @else

                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ $barang->stok }} Unit
                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- KONDISI --}}
                        <div class="col-12 col-md-6">

                            <div class="bg-light rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Kondisi
                                </small>

                                <span class="fw-semibold text-dark">
                                    {{ $barang->kondisi }}
                                </span>

                            </div>

                        </div>


                        {{-- LOKASI --}}
                        <div class="col-12">

                            <div class="bg-light rounded-3 p-3">

                                <small class="text-muted d-block mb-1">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    Lokasi Barang
                                </small>

                                <span class="fw-semibold text-dark">
                                    {{ $barang->lokasi }}
                                </span>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
