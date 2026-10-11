@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>

            <small class="text-muted">
                Lihat informasi lengkap pengajuan peminjaman barang.
            </small>

        </div>

    </div>
    <div class="card">

        <div class="card-body p-4">

            {{-- Header --}}

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h4 class="fw-bold mb-1">

                        Detail Pengajuan Peminjaman

                    </h4>

                    <small class="text-muted">

                        PMJ-{{ \Carbon\Carbon::parse($peminjaman->created_at)->format('Ymd') }}-{{ str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT) }}

                    </small>

                </div>

                <div>

                    @if($peminjaman->status == 'pending')

                        <span class="badge bg-warning text-dark fs-6 rounded-pill px-3 py-2">

                            <i class="bi bi-clock-history me-1"></i>

                            Menunggu

                        </span>

                    @elseif($peminjaman->status == 'approved')

                        <span class="badge bg-success fs-6 rounded-pill px-3 py-2">

                            <i class="bi bi-check-circle-fill me-1"></i>

                            Disetujui

                        </span>

                    @else

                        <span class="badge bg-danger fs-6 rounded-pill px-3 py-2">

                            <i class="bi bi-x-circle-fill me-1"></i>

                            Ditolak

                        </span>

                    @endif

                </div>

            </div>

            <hr>

            <div class="row">

                <div class="col-md-6 mb-4">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-person-circle me-2"></i>
                        Data Peminjam
                    </h6>

                    <table class="table table-borderless mb-0">

                        {{-- Nama --}}
                        <tr>
                            <td width="160">Nama</td>
                            <td>
                                <strong>{{ $peminjaman->user->nama }}</strong>
                            </td>
                        </tr>

                        {{-- Departemen --}}
                        <tr>
                            <td>Departemen</td>
                            <td>
                                {{ $peminjaman->user->departemen }}
                            </td>
                        </tr>

                        {{-- Pengajuan --}}
                        <tr>
                            <td>Pengajuan</td>
                            <td>
                                <strong class="text-primary">
                                    <i class="bi bi-send me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y') }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('H:i') }} WIB
                                </small>
                            </td>
                        </tr>

                        {{-- Mulai Peminjaman --}}
                        <tr>
                            <td>Mulai Peminjaman</td>
                            <td>
                                <strong class="text-success">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d F Y') }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->jam)->format('H:i') }} WIB
                                </small>
                            </td>
                        </tr>

                        {{-- Pengembalian --}}
                        <tr>
                            <td>Pengembalian</td>
                            <td>
                                <strong class="text-danger">
                                    <i class="bi bi-calendar2-check me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d F Y') }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($peminjaman->jam_kembali)->format('H:i') }} WIB
                                </small>
                            </td>
                        </tr>

                        {{-- Disetujui Oleh --}}
                        @if($peminjaman->status == 'approved' && $peminjaman->approvedBy)

                            <tr>
                                <td>Disetujui Oleh</td>

                                <td>
                                    <strong class="text-success">
                                        <i class="bi bi-person-check-fill me-1"></i>
                                        {{ $peminjaman->approvedBy->username }}
                                    </strong>
                                </td>
                            </tr>

                        @endif

                    </table>

                </div>

                <div class="col-md-6">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-box-seam me-2"></i>

                        Barang Dipinjam

                    </h6>

                    @foreach($peminjaman->detailPeminjaman as $detail)

                        <div class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2">

                            <div>

                                <strong>

                                    {{ $detail->barang->nama_barang }}

                                </strong>

                            </div>

                            <span class="badge bg-primary rounded-pill">

                                x{{ $detail->jumlah }}

                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

            <hr>

            <div class="d-flex flex-wrap gap-2 justify-content-end">

                @if($peminjaman->status == 'pending')

                    <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST">

                        @csrf

                        @method('PATCH')

                        <button class="btn btn-success rounded-pill">

                            <i class="bi bi-check-circle me-1"></i>

                            Setujui

                        </button>

                    </form>

                    <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}" method="POST">

                        @csrf

                        @method('PATCH')

                        <button class="btn btn-danger rounded-pill">

                            <i class="bi bi-x-circle me-1"></i>

                            Tolak

                        </button>

                    </form>

                @endif

                <a href="{{ route('admin.peminjaman') }}" class="btn btn-outline-secondary rounded-pill">

                    <i class="bi bi-arrow-left me-1"></i>

                    Kembali

                </a>

            </div>

        </div>

    </div>

@endsection