@extends('layouts.user')

@section('title', 'Riwayat Transaksi')

@section('content')

{{-- Header Section --}}
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h3 class="fw-bold text-dark mb-1">Riwayat Transaksi</h3>
        <p class="text-muted small mb-0">Rekapitulasi seluruh riwayat pengajuan peminjaman dan pengembalian barang Anda.</p>
    </div>
</div>

{{-- Navigation Tabs & Card Wrapper --}}
<div class="card border-0 shadow-sm roundedA-4 overflow-hidden mb-5">
    <div class="card-header bg-white border-bottom p-0">
        <ul class="nav nav-tabs nav-justified card-header-tabs border-bottom-0" id="riwayatTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-item nav-link active py-3 fw-semibold d-flex align-items-center justify-content-center gap-2" 
                        id="peminjaman-tab" data-bs-toggle="tab" data-bs-target="#peminjaman-pane" type="button" role="tab" aria-controls="peminjaman-pane" aria-selected="true">
                    <i class="bi bi-box-arrow-in-right text-primary fs-5"></i>
                    <span>Riwayat Peminjaman</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill ms-1">{{ $peminjaman->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-item nav-link py-3 fw-semibold d-flex align-items-center justify-content-center gap-2" 
                        id="pengembalian-tab" data-bs-toggle="tab" data-bs-target="#pengembalian-pane" type="button" role="tab" aria-controls="pengembalian-pane" aria-selected="false">
                    <i class="bi bi-box-arrow-left text-success fs-5"></i>
                    <span>Riwayat Pengembalian</span>
                    <span class="badge bg-success-subtle text-success rounded-pill ms-1">{{ $pengembalian->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="riwayatTabContent">

        {{-- Indikator halaman yang sedang dibuka --}}
        <div class="px-4 py-3 bg-light border-bottom">
            <div id="riwayat-indicator" class="d-flex align-items-center gap-2">
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Sedang Dibuka
                </span>

                <span class="fw-semibold text-dark" id="riwayat-indicator-text">
                    Riwayat Peminjaman
                </span>
            </div>
        </div>
        
        {{-- TAB 1: RIWAYAT PEMINJAMAN --}}
        <div class="tab-pane fade show active" id="peminjaman-pane" role="tabpanel" aria-labelledby="peminjaman-tab" tabindex="0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">ID Transaksi</th>
                            <th class="py-3">Daftar Barang</th>
                            <th class="py-3">Tanggal Pinjam</th>
                            <th class="py-3">Jam</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($peminjaman as $item)
                            <tr>
                                <td class="px-4 fw-medium text-secondary small">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fw-normal px-2 py-1">
                                        PMJ-{{ optional($item->created_at)->format('Ymd') ?? date('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if(isset($item->detailPeminjaman) && $item->detailPeminjaman->count() > 0)
                                            @foreach($item->detailPeminjaman as $detail)
                                                <div class="small fw-semibold text-dark d-flex align-items-center gap-1">
                                                    <i class="bi bi-box-seam text-primary me-1"></i>
                                                    {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                                    @if(isset($detail->jumlah))
                                                        <span class="text-muted fw-normal">({{ $detail->jumlah }} unit)</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @elseif(isset($item->barang))
                                            <div class="small fw-semibold text-dark d-flex align-items-center gap-1">
                                                <i class="bi bi-box-seam text-primary me-1"></i>
                                                {{ $item->barang->nama_barang }}
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-medium text-dark">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="small text-secondary">{{ $item->jam }}</td>
                                <td class="text-center">
                                    @if($item->isTerlambat())
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Terlambat
                                        </span>
                                    @else
                                        @switch(strtolower($item->status))
                                            @case('approved')
                                            @case('disetujui')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                    <i class="bi bi-check-circle me-1"></i>Approved
                                                </span>
                                                @break

                                        @case('pending')
                                        @case('menunggu')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-clock-history me-1"></i>Pending
                                            </span>
                                            @break

                                            @default
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                    <i class="bi bi-x-circle me-1"></i>Rejected
                                                </span>
                                        @endswitch
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-black-50"></i>
                                        <p class="mb-0 fw-medium">Belum ada riwayat peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 2: RIWAYAT PENGEMBALIAN --}}
        <div class="tab-pane fade" id="pengembalian-pane" role="tabpanel" aria-labelledby="pengembalian-tab" tabindex="0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">ID Transaksi</th>
                            <th class="py-3">Daftar Barang</th>
                            <th class="py-3">Tanggal Kembali</th>
                            <th class="py-3">Jam</th>
                            <th class="py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($pengembalian as $item)
                            <tr>
                                <td class="px-4 fw-medium text-secondary small">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fw-normal px-2 py-1">
                                        PMJ-{{ optional($item->created_at)->format('Ymd') ?? date('Ymd') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if(isset($item->peminjaman->detailPeminjaman) && $item->peminjaman->detailPeminjaman->count() > 0)
                                            @foreach($item->peminjaman->detailPeminjaman as $detail)
                                                <div class="small fw-semibold text-dark d-flex align-items-center gap-1">
                                                    <i class="bi bi-box-seam text-success me-1"></i>
                                                    {{ $detail->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                                </div>
                                            @endforeach
                                        @elseif(isset($item->peminjaman->barang))
                                            <div class="small fw-semibold text-dark d-flex align-items-center gap-1">
                                                <i class="bi bi-box-seam text-success me-1"></i>
                                                {{ $item->peminjaman->barang->nama_barang }}
                                            </div>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-medium text-dark">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="small text-secondary">{{ $item->jam }}</td>
                                <td class="text-center">
                                    @switch(strtolower($item->status))
                                        @case('approved')
                                        @case('disetujui')
                                        @case('selesai')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-check-circle me-1"></i>Approved
                                            </span>
                                            @break

                                        @case('pending')
                                        @case('menunggu')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-clock-history me-1"></i>Pending
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                                <i class="bi bi-x-circle me-1"></i>Rejected
                                            </span>
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-black-50"></i>
                                        <p class="mb-0 fw-medium">Belum ada riwayat pengembalian.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const peminjamanTab = document.getElementById('peminjaman-tab');
        const pengembalianTab = document.getElementById('pengembalian-tab');

        const indicatorText = document.getElementById('riwayat-indicator-text');
        const indicator = document.querySelector('#riwayat-indicator .badge');

        peminjamanTab.addEventListener('shown.bs.tab', function () {

            indicatorText.textContent = 'Riwayat Peminjaman';

            indicator.className = 'badge bg-primary rounded-pill px-3 py-2';

            indicator.innerHTML = `
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Sedang Dibuka
            `;
        });

        pengembalianTab.addEventListener('shown.bs.tab', function () {

            indicatorText.textContent = 'Riwayat Pengembalian';

            indicator.className = 'badge bg-success rounded-pill px-3 py-2';

            indicator.innerHTML = `
                <i class="bi bi-box-arrow-left me-1"></i>
                Sedang Dibuka
            `;
        });

    });
</script>

@endsection