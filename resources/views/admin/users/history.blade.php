@extends('layouts.admin')

@section('title', 'Riwayat Peminjaman User')

@section('content')

    <div class="container-fluid py-3">

        {{-- Header --}}
        <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden" 
        style="background: linear-gradient(135deg, #f5f6f6 0%, #807dc6 100%);">

            <div class="card-body p-4">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                    <div>

                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-2">

                            <i class="bi bi-clock-history me-1"></i>

                            Riwayat Peminjaman

                        </span>

                        <h2 class="fw-bold mb-1">
                            {{ $user->nama }}
                        </h2>

                        <p class="text-muted mb-0">

                            <i class="bi bi-building me-1"></i>

                            {{ $user->departemen }}

                            <span class="mx-2">•</span>

                            <i class="bi bi-person-badge me-1"></i>

                            {{ $user->username }}

                        </p>

                    </div>

                    <div>

                        <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-3 px-4">

                            <i class="bi bi-arrow-left me-1"></i>

                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Tabel Riwayat --}}
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">

            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-journal-text text-primary me-2"></i>
                            Riwayat Barang yang Pernah Dipinjam
                        </h5>

                        <small class="text-muted">
                            Daftar seluruh transaksi peminjaman {{ $user->nama }}
                        </small>
                    </div>

                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        {{ $peminjaman->total() }} Transaksi
                    </span>
                </div>
            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead style="background-color: #f8fafc;">
                        <tr>

                            <th class="text-center" width="70">
                                No
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                ID Transaksi
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th class="text-center" width="120">
                                Detail
                            </th>

                        </tr>
                    </thead>


                    <tbody>

                        @forelse($peminjaman as $item)

                            <tr>

                                {{-- No --}}
                                <td class="text-center fw-bold text-muted">
                                    {{ $peminjaman->firstItem() + $loop->index }}
                                </td>


                                {{-- Tanggal --}}
                                <td>

                                    <div class="fw-semibold">
                                        <i class="bi bi-calendar-event text-primary me-1"></i>

                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $item->jam }}
                                    </small>

                                </td>


                                {{-- ID Transaksi --}}
                                <td>

                                    <span class="badge bg-dark rounded-2 px-2 py-2">

                                        PMJ-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="text-center">

                                    @if($item->status == 'approved')

                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Disetujui

                                        </span>

                                    @elseif($item->status == 'pending')

                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                                            <i class="bi bi-clock-history me-1"></i>
                                            Menunggu

                                        </span>

                                    @else

                                        <span class="badge bg-danger rounded-pill px-3 py-2">

                                            <i class="bi bi-x-circle-fill me-1"></i>
                                            Ditolak

                                        </span>

                                    @endif

                                </td>


                                {{-- Detail --}}
                                <td class="text-center">

                                    <button type="button" class="btn btn-primary btn-sm rounded-3 px-3" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}">

                                        <i class="bi bi-eye me-1"></i>
                                        Detail

                                    </button>

                                </td>

                            </tr>


                            {{-- ========================= --}}
                            {{-- MODAL DETAIL PEMINJAMAN --}}
                            {{-- ========================= --}}

                            <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content border-0 shadow rounded-4">

                                        {{-- Header Modal --}}
                                        <div class="modal-header border-0">

                                            <div>

                                                <h5 class="modal-title fw-bold">

                                                    <i class="bi bi-box-seam text-primary me-2"></i>

                                                    Detail Peminjaman

                                                </h5>

                                                <small class="text-muted">

                                                    PMJ-{{ $item->created_at->format('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}

                                                </small>

                                            </div>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>

                                        </div>


                                        {{-- Body --}}
                                        <div class="modal-body pt-0">

                                            {{-- Informasi Transaksi --}}
                                            <div class="bg-light rounded-3 p-3 mb-3">

                                                <div class="row g-2">

                                                    <div class="col-6">

                                                        <small class="text-muted d-block">
                                                            Tanggal
                                                        </small>

                                                        <span class="fw-semibold">
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                                        </span>

                                                    </div>


                                                    <div class="col-6">

                                                        <small class="text-muted d-block">
                                                            Jam
                                                        </small>

                                                        <span class="fw-semibold">
                                                            {{ $item->jam }}
                                                        </span>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Daftar Barang --}}
                                            <h6 class="fw-bold mb-3">

                                                <i class="bi bi-boxes text-primary me-1"></i>

                                                Barang yang Dipinjam

                                            </h6>


                                            @foreach($item->detailPeminjaman as $detail)

                                                <div
                                                    class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2">

                                                    <div class="d-flex align-items-center">

                                                        <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3">

                                                            <i class="bi bi-box-seam fs-5"></i>

                                                        </div>

                                                        <div>

                                                            <div class="fw-semibold">
                                                                {{ $detail->barang->nama_barang }}
                                                            </div>

                                                            <small class="text-muted">
                                                                {{ $detail->barang->kode_barang }}
                                                            </small>

                                                        </div>

                                                    </div>


                                                    <span class="badge bg-primary rounded-pill px-3 py-2">

                                                        x{{ $detail->jumlah }}

                                                    </span>

                                                </div>

                                            @endforeach

                                        </div>


                                        {{-- Footer --}}
                                        <div class="modal-footer border-0">

                                            <button type="button" class="btn btn-light border rounded-3 px-4"
                                                data-bs-dismiss="modal">

                                                Tutup

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-muted"></i>

                                    <h5 class="fw-bold mt-3">
                                        Belum Ada Riwayat
                                    </h5>

                                    <p class="text-muted mb-0">
                                        User ini belum pernah melakukan pengajuan peminjaman barang.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($peminjaman->hasPages())

                <div class="card-footer bg-white border-0 py-3">

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">

                        <small class="text-muted">

                            Menampilkan
                            {{ $peminjaman->firstItem() }}
                            -
                            {{ $peminjaman->lastItem() }}
                            dari
                            {{ $peminjaman->total() }}
                            transaksi

                        </small>


                        <div>

                            {{ $peminjaman->links() }}

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection