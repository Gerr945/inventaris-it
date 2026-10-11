@extends('layouts.admin')

@section('title', 'Tambah Stok Barang')

@section('content')

<div class="container-fluid py-3">

    {{-- Header --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden"
         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill">

                        <i class="bi bi-box-arrow-in-down me-1"></i>
                        Stok Masuk

                    </span>

                    <h2 class="fw-bold mb-1 text-white">
                        Tambah Stok Barang
                    </h2>

                    <p class="mb-0 text-white-50 small">
                        Tambahkan jumlah stok untuk barang yang dipilih.
                    </p>

                </div>

                <a href="{{ route('barang.show', $barang->id) }}"
                   class="btn btn-light text-primary rounded-3 px-3 fw-semibold">

                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali

                </a>

            </div>

        </div>

    </div>


    {{-- Form --}}
    <div class="card border-0 rounded-4 shadow-sm">

        <div class="card-body p-4">

            <form action="{{ route('admin.stok-masuk.store', $barang->id) }}"
                  method="POST">

                @csrf

                {{-- Barang --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        <i class="bi bi-box-seam text-primary me-1"></i>
                        Barang
                    </label>

                    <div class="form-control bg-light border-0 py-3">

                        <div class="fw-bold">
                            {{ $barang->nama_barang }}
                        </div>

                        <small class="text-muted">
                            Kode: {{ $barang->kode_barang }}
                        </small>

                    </div>

                </div>


                <div class="row g-3">

                    {{-- Stok Saat Ini --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-stack text-primary me-1"></i>
                            Stok Saat Ini
                        </label>

                        <div class="form-control bg-light border-0 py-2">

                            {{ $barang->stok }} Unit

                        </div>

                    </div>


                    {{-- Jumlah Tambahan --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-plus-circle text-success me-1"></i>
                            Jumlah Stok Ditambahkan
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               name="jumlah"
                               min="1"
                               value="{{ old('jumlah', 1) }}"
                               class="form-control bg-light border-0 py-2"
                               required>

                    </div>


                    {{-- Keterangan --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            <i class="bi bi-chat-left-text text-primary me-1"></i>
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                                  class="form-control bg-light border-0"
                                  rows="3"
                                  placeholder="Contoh: Pembelian barang baru, pengadaan, dll.">{{ old('keterangan') }}</textarea>

                    </div>

                </div>


                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-4 pt-3 border-top">

                    <button type="submit"
                            class="btn btn-success px-4 py-2 fw-semibold rounded-3">

                        <i class="bi bi-plus-circle me-1"></i>
                        Tambahkan Stok

                    </button>

                    <a href="{{ route('barang.show', $barang->id) }}"
                       class="btn btn-light border px-4 py-2 rounded-3">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection