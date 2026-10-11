@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="container-fluid py-3">

    <!-- Hero Header Banner -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #2563eb 100%);">
        <div class="card-body p-4 position-relative">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-1 rounded-pill small">
                        <i class="bi bi-pencil-square me-1"></i> Form Update
                    </span>
                    <h2 class="fw-bold mb-1 text-white">Edit Data Barang</h2>
                    <p class="mb-0 text-white-50 small">Perbarui rincian data inventaris barang: <strong class="text-white">{{ $barang->nama_barang }}</strong></p>
                </div>
                <div>
                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-light text-primary rounded-3 px-3 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
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
    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

        <!-- Right Column: Media Preview & File Upload -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white h-100">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="bi bi-image text-primary me-2"></i>Foto Barang
                    </h5>

                    <div class="text-center my-auto py-2">
                        <!-- Image Container with Live Preview -->
                        <div class="mb-3 position-relative d-inline-block">
                            @if($barang->foto)
                                <img id="imgPreview" src="{{ asset('uploads/barang/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" 
                                     class="rounded-4 shadow-sm border border-2 border-primary object-fit-cover" 
                                     style="width: 200px; height: 200px;">
                                <div id="imgPlaceholder" class="d-none"></div>
                            @else
                                <img id="imgPreview" src="#" alt="Preview Foto" 
                                     class="rounded-4 shadow-sm border border-2 border-primary object-fit-cover d-none" 
                                     style="width: 200px; height: 200px;">
                                <div id="imgPlaceholder" 
                                     class="bg-indigo-subtle text-primary rounded-4 d-flex flex-column align-items-center justify-content-center mx-auto border border-2 border-dashed border-primary-subtle" 
                                     style="width: 200px; height: 200px; background-color: #f0f4ff;">
                                    <i class="bi bi-image display-4 mb-2 text-primary opacity-50"></i>
                                    <span class="small fw-semibold text-secondary">Belum ada foto</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-2">
                            <label for="fotoInput" class="form-label small fw-semibold text-secondary d-block text-start">Ganti Foto Baru (Opsional)</label>
                            <input type="file" class="form-control bg-light border-0 py-2 @error('foto') is-invalid @enderror" 
                                   id="fotoInput" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback d-block text-start">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted d-block text-start fs-7">
                            <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengubah foto. Format: <strong>JPG, JPEG, PNG</strong>.
                        </small>
                    </div>
                </div>
            </div>
            <!-- Left Column: Primary Data Inputs -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="bi bi-sliders text-primary me-2"></i>Ubah Informasi Barang
                    </h5>

                    <div class="row g-3">
                        <!-- Kode Barang -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-qr-code text-primary me-1"></i>Kode Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_barang" 
                                   class="form-control bg-light border-0 py-2 @error('kode_barang') is-invalid @enderror" 
                                   value="{{ old('kode_barang', $barang->kode_barang) }}" required>
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Barang -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-box-seam text-primary me-1"></i>Nama Barang <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_barang" 
                                   class="form-control bg-light border-0 py-2 @error('nama_barang') is-invalid @enderror" 
                                   value="{{ old('nama_barang', $barang->nama_barang) }}" required>
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
                                   value="{{ old('stok', $barang->stok) }}" required>
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
                                <option value="Baik" {{ old('kondisi', $barang->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi', $barang->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi', $barang->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            @error('kondisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark small">
                                <i class="bi bi-geo-alt text-primary me-1"></i>Lokasi Penyimpanan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" 
                                   class="form-control bg-light border-0 py-2 @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi', $barang->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-warning text-dark px-4 py-2 fw-bold rounded-3 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-light border px-4 py-2 fw-semibold rounded-3 text-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript Live Preview Handler -->
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
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection