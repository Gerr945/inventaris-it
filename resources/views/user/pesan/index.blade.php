@extends('layouts.user')

@section('title', 'Pesan Admin')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="bi bi-chat-left-text text-primary me-2"></i>
                Pesan Admin
            </h3>

            <p class="text-muted small mb-0">
                Informasi dan pemberitahuan dari Admin Inventaris IT.
            </p>
        </div>

        <div>
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                <i class="bi bi-envelope me-1"></i>
                {{ $notifikasi->count() }} Pesan
            </span>
        </div>

    </div>


    {{-- Card Pesan --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- Header Card --}}
        <div class="card-header bg-white border-bottom py-3 px-4">

            <div class="d-flex align-items-center gap-2">

                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 42px; height: 42px;">

                    <i class="bi bi-bell-fill fs-5"></i>

                </div>

                <div>

                    <h5 class="fw-bold text-dark mb-0">
                        Daftar Pesan
                    </h5>

                    <small class="text-muted">
                        Pesan terbaru dari Admin
                    </small>

                </div>

            </div>

        </div>


        {{-- Isi Pesan --}}
        <div class="card-body p-4">

            @forelse($notifikasi as $item)

                <div class="notification-item border rounded-3 p-3 mb-3 bg-white">

                    <div class="d-flex align-items-start gap-3">

                        {{-- Icon --}}
                        <div class="notification-icon bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 44px; height: 44px;">

                            <i class="bi bi-envelope-fill"></i>

                        </div>


                        {{-- Isi --}}
                        <div class="flex-grow-1">

                            <div class="d-flex flex-column flex-md-row justify-content-between gap-1">

                                <h6 class="fw-bold text-dark mb-1">
                                    {{ $item->judul }}
                                </h6>

                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </small>

                            </div>

                            <p class="text-secondary mb-0 mt-1">
                                {{ $item->pesan }}
                            </p>

                        </div>

                    </div>

                </div>

            @empty

                {{-- Tidak Ada Pesan --}}
                <div class="text-center py-5">

                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 80px; height: 80px;">

                        <i class="bi bi-envelope-open text-muted fs-1"></i>

                    </div>

                    <h5 class="fw-bold text-dark">
                        Belum Ada Pesan
                    </h5>

                    <p class="text-muted mb-0">
                        Saat ini belum ada pesan atau pemberitahuan dari Admin.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- Style --}}
    <style>

        .notification-item {
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .notification-icon {
            transition: all 0.2s ease;
        }

        .notification-item:hover .notification-icon {
            transform: scale(1.05);
        }

        @media (max-width: 576px) {

            .notification-item {
                padding: 15px !important;
            }

            .notification-icon {
                width: 38px !important;
                height: 38px !important;
            }

        }

    </style>

@endsection