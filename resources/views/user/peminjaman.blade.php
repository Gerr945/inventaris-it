@extends('layouts.user')

@section('title', 'Pengajuan Peminjaman')

@section('content')

    <h2>Pengajuan Peminjaman Barang</h2>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <form method="POST" action="{{ route('user.peminjaman.store') }}">

        @csrf

        <div class="mb-3">

            <label>Barang</label>

            <select name="barang_id" class="form-select">

                @foreach($barang as $b)

                    <option value="{{ $b->id }}">

                        {{ $b->nama_barang }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Tanggal</label>

            <input type="date" name="tanggal" class="form-control">

        </div>

        <div class="mb-3">

            <label>Jam</label>

            <input type="time" name="jam" class="form-control">

        </div>

        <button class="btn btn-success">

            Ajukan

        </button>

    </form>

    <hr>

    <h4>Riwayat Pengajuan</h4>

    <table class="table table-bordered">

        <tr>

            <th>No</th>

            <th>Barang</th>

            <th>Tanggal</th>

            <th>Jam</th>

            <th>Status</th>

        </tr>

        @foreach($peminjaman as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->barang->nama_barang }}</td>

                <td>{{ $item->tanggal }}</td>

                <td>{{ $item->jam }}</td>

                <td>{{ $item->status }}</td>

            </tr>

        @endforeach

    </table>

@endsection