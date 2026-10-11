@extends('layouts.admin')

@section('title', 'Riwayat Penambahan Stok')

@section('content')

<div class="container-fluid py-3">

    {{-- Header --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden"
         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);">

        <div class="card-body p-4 text-white">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                <div>

                    <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-2">

                        <i class="bi bi-clock-history me-1"></i>
                        Riwayat Stok

                    </span>

                    <h2 class="fw-bold mb-1">
                        {{ $barang->nama_barang }}
                    </h2>

                    <p class="mb-0 text-white-50 small">

                        <i class="bi bi-qr-code me-1"></i>
                        {{ $barang->kode_barang }}

                        <span class="mx-2">•</span>

                        Stok saat ini:
                        <strong>{{ $barang->stok }} Unit</strong>

                    </p>

                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('admin.stok-masuk.create', $barang->id) }}"
                       class="btn btn-light text-success fw-semibold rounded-3">

                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Stok

                    </a>

                    <a href="{{ route('barang.show', $barang->id) }}"
                       class="btn btn-light text-primary fw-semibold rounded-3">

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

            <h5 class="fw-bold mb-1">

                <i class="bi bi-journal-text text-primary me-2"></i>
                Riwayat Penambahan Stok

            </h5>

            <small class="text-muted">

                Daftar seluruh penambahan stok untuk
                <strong>{{ $barang->nama_barang }}</strong>.

            </small>

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
                            Jumlah Ditambahkan
                        </th>

                        <th>
                            Admin
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayat as $item)

                        <tr>

                            <td class="text-center fw-bold text-muted">

                                {{ $riwayat->firstItem() + $loop->index }}

                            </td>


                            <td>

                                <div class="fw-semibold">

                                    <i class="bi bi-calendar-event text-primary me-1"></i>

                                    {{ $item->created_at->format('d M Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ $item->created_at->format('H:i') }}

                                </small>

                            </td>


                            <td>

                                <span class="badge bg-success rounded-pill px-3 py-2">

                                    <i class="bi bi-plus-circle me-1"></i>

                                    +{{ $item->jumlah }} Unit

                                </span>

                            </td>


                            <td>

                                <i class="bi bi-person-circle text-secondary me-1"></i>

                                {{ $item->admin->nama ?? 'Admin' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center py-5">

                                <i class="bi bi-inbox fs-1 text-muted"></i>

                                <h5 class="fw-bold mt-3">
                                    Belum Ada Riwayat
                                </h5>

                                <p class="text-muted mb-0">

                                    Belum ada penambahan stok untuk
                                    {{ $barang->nama_barang }}.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($riwayat->hasPages())

            <div class="card-footer bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">

                        Menampilkan
                        <strong>{{ $riwayat->firstItem() }}</strong>
                        -
                        <strong>{{ $riwayat->lastItem() }}</strong>
                        dari
                        <strong>{{ $riwayat->total() }}</strong>
                        riwayat

                    </small>

                    {{ $riwayat->links('pagination::bootstrap-5') }}

                </div>

            </div>

        @endif

    </div>

</div>

@endsection