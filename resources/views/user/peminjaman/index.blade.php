@extends('layouts.user')

@section('title', 'Pengajuan Peminjaman')

@section('content')

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    {{-- Alert Errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">

            <div class="d-flex align-items-center mb-1">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>

                <strong class="me-auto">
                    Terjadi Kesalahan!
                </strong>
            </div>

            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>

        </div>
    @endif


    {{-- Card Form Pengajuan --}}
    <div class="card shadow-sm border-0 mb-4 rounded-3">

        <div class="card-body p-4">

            <form action="{{ route('user.peminjaman.store') }}" method="POST">

                @csrf


                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">

                    <h4 class="fw-bold text-dark mb-0 d-flex align-items-center">

                        <i class="bi bi-box-arrow-in-right text-success me-2 fs-3"></i>

                        Pengajuan Peminjaman Barang

                    </h4>


                    <button type="submit" class="btn btn-success px-4 py-2 shadow-sm rounded-pill">

                        <i class="bi bi-send me-1"></i>

                        Ajukan Peminjaman

                    </button>

                </div>


                {{-- Opsi Pilihan Barang --}}
                <div class="mb-4">

                    <label class="form-label fw-bold text-secondary mb-2">

                        <i class="bi bi-boxes me-1"></i>

                        Pilih Barang

                    </label>


                    <div class="position-relative">

                        <input type="text" id="searchBarang" class="form-control" placeholder="Cari nama barang..."
                            autocomplete="off">

                        <div id="dropdownBarang" class="dropdown-menu w-100 shadow-sm p-0"
                            style="max-height: 250px; overflow-y: auto;">

                            @foreach($barang as $item)

                                <button type="button" class="dropdown-item py-2 barang-option" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_barang }}" data-stok="{{ $item->stok }}">

                                    {{ $item->nama_barang }}

                                </button>

                            @endforeach

                        </div>

                    </div>

                </div>


                {{-- Barang yang dipilih --}}
                <div id="barangTerpilih"></div>


                {{-- Waktu Peminjaman --}}
                <div class="card border-0 bg-light rounded-3 mb-3">

                    <div class="card-body">

                        <h6 class="fw-bold text-dark mb-3">

                            <i class="bi bi-calendar-check text-success me-2"></i>

                            Waktu Peminjaman

                        </h6>


                        <div class="row g-3">

                            {{-- Mulai Tanggal --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold text-secondary">

                                    <i class="bi bi-calendar-event me-1"></i>

                                    Mulai Peminjaman

                                </label>

                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}"
                                    required>

                            </div>


                            {{-- Mulai Jam --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold text-secondary">

                                    <i class="bi bi-clock me-1"></i>

                                    Jam Mulai

                                </label>

                                <input type="time" name="jam" id="jam" class="form-control"
                                    value="{{ old('jam', now()->format('H:i')) }}" required>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Waktu Pengembalian --}}
                <div class="card border-0 bg-light rounded-3 mb-3">

                    <div class="card-body">

                        <h6 class="fw-bold text-dark mb-3">

                            <i class="bi bi-calendar2-check text-danger me-2"></i>

                            Rencana Pengembalian

                        </h6>


                        <div class="row g-3">

                            {{-- Kembali Tanggal --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold text-secondary">

                                    <i class="bi bi-calendar-event me-1"></i>

                                    Tanggal Pengembalian

                                </label>

                                <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control"
                                    value="{{ old('tanggal_kembali', now()->format('Y-m-d')) }}"
                                    min="{{ now()->format('Y-m-d') }}" required>

                            </div>


                            {{-- Kembali Jam --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold text-secondary">

                                    <i class="bi bi-clock me-1"></i>

                                    Jam Pengembalian

                                </label>

                                <input type="time" name="jam_kembali" id="jam_kembali" class="form-control"
                                    value="{{ old('jam_kembali', now()->format('H:i')) }}" required>

                            </div>

                        </div>


                        <div class="alert alert-info border-0 mt-3 mb-0 small">

                            <i class="bi bi-info-circle me-1"></i>

                            Waktu pengembalian harus setelah waktu mulai peminjaman.

                        </div>

                    </div>

                </div>


            </form>

        </div>

    </div>


    {{-- Card Riwayat --}}
    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white py-3 border-bottom">

            <h5 class="fw-bold text-primary mb-0">

                <i class="bi bi-journal-text me-2"></i>

                Riwayat Pengajuan

            </h5>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="text-center" style="width: 50px;">
                                No
                            </th>

                            <th>
                                Barang
                            </th>

                            <th>
                                Mulai Peminjaman
                            </th>

                            <th>
                                Pengembalian
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Departemen
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($peminjaman as $item)

                            <tr>

                                <td class="text-center fw-bold">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Barang --}}
                                <td>

                                    <div class="d-flex flex-wrap gap-1">

                                        @foreach($item->detailPeminjaman as $detail)

                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">

                                                {{ $detail->barang->nama_barang }}

                                                <strong>
                                                    x{{ $detail->jumlah }}
                                                </strong>

                                            </span>

                                        @endforeach

                                    </div>

                                </td>


                                {{-- Mulai --}}
                                <td>

                                    <div class="small">

                                        <div class="fw-semibold">

                                            <i class="bi bi-calendar3 me-1 text-success"></i>

                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

                                        </div>

                                        <div class="text-muted">

                                            <i class="bi bi-clock me-1"></i>

                                            {{ $item->jam }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Pengembalian --}}
                                <td>

                                    <div class="small">

                                        <div class="fw-semibold">

                                            <i class="bi bi-calendar3 me-1 text-danger"></i>

                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}

                                        </div>

                                        <div class="text-muted">

                                            <i class="bi bi-clock me-1"></i>

                                            {{ $item->jam_kembali }}

                                        </div>

                                    </div>

                                </td>


                                {{-- Nama --}}
                                <td>
                                    {{ $item->user->nama }}
                                </td>


                                {{-- Departemen --}}
                                <td>
                                    {{ $item->user->departemen }}
                                </td>


                                {{-- Status --}}
                                <td class="text-center">

                                    @if($item->isTerlambat())

                                        <span class="badge bg-danger px-3 py-2 rounded-pill">

                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>

                                            Terlambat

                                        </span>

                                    @elseif($item->status == 'approved')

                                        <span class="badge bg-success px-3 py-2 rounded-pill">

                                            <i class="bi bi-check-circle-fill me-1"></i>

                                            Approved

                                        </span>

                                    @elseif($item->status == 'pending')

                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">

                                            <i class="bi bi-clock-history me-1"></i>

                                            Pending

                                        </span>

                                    @else

                                        <span class="badge bg-danger px-3 py-2 rounded-pill">

                                            <i class="bi bi-x-circle-fill me-1"></i>

                                            Rejected

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-4 text-muted">

                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                    Belum ada pengajuan peminjaman.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchBarang =
                document.getElementById('searchBarang');

            const dropdownBarang =
                document.getElementById('dropdownBarang');

            const barangTerpilih =
                document.getElementById('barangTerpilih');

            const options =
                document.querySelectorAll('.barang-option');


            // ===========================
            // DROPDOWN BARANG
            // ===========================

            searchBarang.addEventListener('focus', function () {

                dropdownBarang.classList.add('show');

                filterBarang();

            });


            searchBarang.addEventListener('input', function () {

                dropdownBarang.classList.add('show');

                filterBarang();

            });


            function filterBarang() {

                const keyword =
                    searchBarang.value.toLowerCase();

                options.forEach(function (option) {

                    const nama =
                        option.dataset.nama.toLowerCase();

                    if (nama.includes(keyword)) {

                        option.style.display = '';

                    } else {

                        option.style.display = 'none';

                    }

                });

            }


            // ===========================
            // PILIH BARANG
            // ===========================

            options.forEach(function (option) {

                option.addEventListener('click', function () {

                    const barangId =
                        this.dataset.id;

                    const namaBarang =
                        this.dataset.nama;

                    const stok =
                        parseInt(this.dataset.stok) || 0;


                    // Cek apakah barang sudah dipilih

                    if (
                        document.getElementById(
                            'barang-' + barangId
                        )
                    ) {

                        alert(
                            'Barang tersebut sudah dipilih.'
                        );

                        searchBarang.value = '';

                        dropdownBarang.classList.remove(
                            'show'
                        );

                        return;

                    }


                    // Jika stok kosong

                    if (stok <= 0) {

                        alert(
                            'Stok barang tersebut sedang tidak tersedia.'
                        );

                        searchBarang.value = '';

                        dropdownBarang.classList.remove(
                            'show'
                        );

                        return;

                    }


                    // Membuat container barang

                    const div =
                        document.createElement('div');

                    div.id =
                        'barang-' + barangId;

                    div.className =
                        'border rounded-3 p-3 mb-2';


                    // Isi barang

                    div.innerHTML = `

                        <div class="row g-2 align-items-end">

                            {{-- Nama Barang --}}

                            <div class="col-12 col-md-6">

                                <strong>
                                    ${namaBarang}
                                </strong>

                                <input
                                    type="hidden"
                                    name="barang_id[]"
                                    value="${barangId}">

                            </div>


                            {{-- Jumlah --}}

                            <div class="col-12 col-md-4">

                                <label class="small text-muted mb-1">
                                    Jumlah
                                </label>

                                <div class="input-group">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="kurangiJumlah('${barangId}')">

                                        −

                                    </button>


                                    <input
                                        type="number"
                                        name="jumlah[${barangId}]"
                                        id="jumlah-${barangId}"
                                        class="form-control text-center"
                                        min="1"
                                        max="${stok}"
                                        value="1"
                                        required>


                                    <button
                                        type="button"
                                        class="btn btn-outline-success"
                                        onclick="tambahJumlah('${barangId}', ${stok})">

                                        +

                                    </button>

                                </div>

                            </div>


                            {{-- Hapus Barang --}}

                            <div class="col-12 col-md-2 mt-2 mt-md-0">

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm w-100"
                                    onclick="hapusBarang('${barangId}')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </div>

                        </div>

                    `;


                    barangTerpilih.appendChild(div);


                    // Reset pencarian

                    searchBarang.value = '';

                    dropdownBarang.classList.remove(
                        'show'
                    );


                    // Tampilkan kembali semua pilihan

                    options.forEach(function (item) {

                        item.style.display = '';

                    });

                });

            });


            // ===========================
            // KLIK DI LUAR DROPDOWN
            // ===========================

            document.addEventListener('click', function (event) {

                if (
                    !searchBarang.contains(event.target) &&
                    !dropdownBarang.contains(event.target)
                ) {

                    dropdownBarang.classList.remove(
                        'show'
                    );

                }

            });


            // ===========================
            // VALIDASI TANGGAL
            // ===========================

            const tanggalMulai =
                document.getElementById('tanggal');

            const tanggalKembali =
                document.getElementById('tanggal_kembali');


            tanggalMulai.addEventListener('change', function () {

                tanggalKembali.min =
                    tanggalMulai.value;


                if (
                    tanggalKembali.value <
                    tanggalMulai.value
                ) {

                    tanggalKembali.value =
                        tanggalMulai.value;

                }

            });

        });


        // ===========================
        // HAPUS BARANG
        // ===========================

        function hapusBarang(barangId) {

            const barang =
                document.getElementById(
                    'barang-' + barangId
                );

            if (barang) {

                barang.remove();

            }

        }


        // ===========================
        // TAMBAH JUMLAH
        // ===========================

        function tambahJumlah(barangId, stok) {

            const input =
                document.getElementById(
                    'jumlah-' + barangId
                );

            if (!input) return;


            let jumlah =
                parseInt(input.value) || 1;


            if (jumlah < stok) {

                input.value =
                    jumlah + 1;

            }

        }


        // ===========================
        // KURANGI JUMLAH
        // ===========================

        function kurangiJumlah(barangId) {

            const input =
                document.getElementById(
                    'jumlah-' + barangId
                );

            if (!input) return;


            let jumlah =
                parseInt(input.value) || 1;


            if (jumlah > 1) {

                input.value =
                    jumlah - 1;

            }

        }

    </script>

@endsection