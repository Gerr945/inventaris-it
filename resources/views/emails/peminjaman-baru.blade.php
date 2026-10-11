<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>

    <h2>Pengajuan Peminjaman Barang</h2>

    <p>Halo Admin,</p>

    <p>Ada pengajuan peminjaman barang baru.</p>

    <table border="1" cellpadding="8" cellspacing="0">

        <tr>
            <td><b>Nama Peminjam</b></td>
            <td>{{ $peminjaman->user->nama }}</td>
        </tr>

        <tr>
            <td><b>Departemen</b></td>
            <td>{{ $peminjaman->user->departemen }}</td>
        </tr>

        <tr>
            <td><b>Tanggal</b></td>
            <td>{{ $peminjaman->tanggal }}</td>
        </tr>

        <tr>
            <td><b>Jam</b></td>
            <td>{{ $peminjaman->jam }}</td>
        </tr>

    </table>

    <br>

    <h3>Daftar Barang</h3>

    <ul>

        @foreach($peminjaman->detailPeminjaman as $detail)

            <li>{{ $detail->barang->nama_barang }}</li>

        @endforeach

    </ul>

</body>
</html>