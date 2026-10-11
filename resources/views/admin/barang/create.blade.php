@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="container-fluid py-3">

    <!-- Hero Header Banner -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden" 
         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);">
        <div class="card-body p-4 position-relative">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">
                        <i class="bi bi-plus-circle me-1"></i> Form Inventaris
                    </span>
                    <h2 class="fw-bold mb-1 text-white">Tambah Barang Baru</h2>
                    <p class="mb-0 text-white-50 small">Isi formulir di bawah ini untuk menginputkan unit barang baru ke dalam sistem.</p>
                </div>
                <div>
                    <a href="{{ route('barang.index') }}" class="btn btn-light text-primary rounded-3 px-3 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Multi Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 border-start border-danger border-4 shadow-sm rounded-3 mb-4 bg-white d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-start">
                <div class="bg-danger text-white p-2 rounded-circle me-3 mt-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-danger mb-1">Terjadi kesalahan input:</h6>
                    <ul class="mb-0 ps-3 text-dark small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Section -->
    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

        <!-- Right Column: Media & Image Preview -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white h-100">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="bi bi-image text-primary me-2"></i>Foto Barang
                    </h5>

                    <div class="text-center my-auto py-3">
                        <!-- Dynamic Image Preview Container -->
                        <div class="mb-3 position-relative d-inline-block">
                            <img id="imgPreview" src="#" alt="Preview Foto" 
                                 class="rounded-4 shadow-sm border border-2 border-primary object-fit-cover d-none" 
                                 style="width: 200px; height: 200px;">
                            
                            <div id="imgPlaceholder" 
                                 class="bg-indigo-subtle text-primary rounded-4 d-flex flex-column align-items-center justify-content-center mx-auto border border-2 border-dashed border-primary-subtle" 
                                 style="width: 200px; height: 200px; background-color: #f0f4ff;">
                                <i class="bi bi-cloud-arrow-up display-4 mb-2 text-primary"></i>
                                <span class="small fw-semibold text-secondary">Unggah Foto Produk</span>
                            </div>
                        </div>

                        <div class="mb-2">
                            <input type="file" class="form-control bg-light border-0 py-2 @error('foto') is-invalid @enderror" 
                                   id="fotoInput" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted d-block text-start fs-7">
                            <i class="bi bi-info-circle me-1"></i>Format yang didukung: <strong>JPG, JPEG, PNG</strong> (Maks. 2MB).
                        </small>
                    </div>
                </div>
            </div>
            <!-- Left Column: Data Input -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="bi bi-card-checklist text-primary me-2"></i>Informasi Detail Barang
                    </h5>

                    <div class="row g-3">
                        <!-- Kode Barang -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-qr-code text-primary me-1"></i>Kode Barang
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-magic text-primary"></i>
                                </span>

                                <input type="text"
                                    class="form-control bg-light border-0 py-2 text-muted"
                                    value="Otomatis oleh sistem"
                                    readonly>
                            </div>

                            <small class="text-muted">
                                Kode akan dibuat otomatis saat barang disimpan.
                            </small>
                        </div>

                        <!-- Nama Barang -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-box-seam text-primary me-1"></i>Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_barang" 
                                   class="form-control bg-light border-0 py-2 @error('nama_barang') is-invalid @enderror" 
                                   placeholder="Masukkan nama barang" 
                                   value="{{ old('nama_barang') }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-stack text-primary me-1"></i>Jumlah Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="stok" min="0" 
                                   class="form-control bg-light border-0 py-2 @error('stok') is-invalid @enderror" 
                                   placeholder="0" 
                                   value="{{ old('stok') }}" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kondisi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-shield-check text-primary me-1"></i>Kondisi Barang <span class="text-danger">*</span>
                            </label>
                            <select name="kondisi" class="form-select bg-light border-0 py-2 @error('kondisi') is-invalid @enderror" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('kondisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-geo-alt text-primary me-1"></i>Lokasi Penyimpanan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" 
                                   class="form-control bg-light border-0 py-2 @error('lokasi') is-invalid @enderror" 
                                   placeholder="Masukkan nama lokasi penyimpanan barang" 
                                   value="{{ old('lokasi') }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit & Cancel Action Buttons -->
                    <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-light border px-4 py-2 fw-semibold rounded-3 text-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Simple JS Image Preview Handler -->
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imgPreview');
        const placeholder = document.getElementById('imgPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection