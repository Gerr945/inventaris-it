<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Peminjaman Barang</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background:#f5f5f5; padding:20px;">

    <div style="
        max-width:700px;
        margin:auto;
        background:#ffffff;
        padding:30px;
        border-radius:10px;
    ">

        <h2 style="color:#198754;">
            Pengajuan Peminjaman Barang Baru
        </h2>

        <p>
            Halo Admin,
        </p>

        <p>
            Ada pengajuan peminjaman barang baru dengan detail berikut:
        </p>


        <!-- DATA PEMINJAMAN -->

        <table
            cellpadding="8"
            cellspacing="0"
            border="1"
            width="100%"
            style="border-collapse:collapse;"
        >

            <tr>
                <td width="180">
                    <strong>Nama User</strong>
                </td>

                <td>
                    {{ $peminjaman->user->nama }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Departemen</strong>
                </td>

                <td>
                    {{ $peminjaman->user->departemen }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Tanggal Peminjaman</strong>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d/m/Y') }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Jam Peminjaman</strong>
                </td>

                <td>
                    {{ $peminjaman->jam }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Tanggal Pengembalian</strong>
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Jam Pengembalian</strong>
                </td>

                <td>
                    {{ $peminjaman->jam_kembali }}
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Status</strong>
                </td>

                <td>
                    {{ ucfirst($peminjaman->status) }}
                </td>
            </tr>

        </table>


        <br>


        <!-- DAFTAR BARANG -->

        <h3>
            Daftar Barang
        </h3>

        <table
            cellpadding="8"
            cellspacing="0"
            border="1"
            width="100%"
            style="border-collapse:collapse;"
        >

            <tr>
                <th align="left">
                    Nama Barang
                </th>

                <th width="120">
                    Jumlah
                </th>
            </tr>


            @foreach($peminjaman->detailPeminjaman as $detail)

                <tr>

                    <td>
                        {{ $detail->barang->nama_barang }}
                    </td>

                    <td align="center">
                        {{ $detail->jumlah }}
                    </td>

                </tr>

            @endforeach

        </table>


        <br>


        <p>
            Klik tombol di bawah ini untuk membuka detail pengajuan.
        </p>


        <div style="text-align:center; margin:30px 0;">

            <a
                href="{{ route('email.peminjaman', $peminjaman->id) }}"
                style="
                    background:#198754;
                    color:#ffffff;
                    padding:12px 25px;
                    border-radius:8px;
                    text-decoration:none;
                    display:inline-block;
                "
            >
                Lihat Detail Pengajuan
            </a>

        </div>


        <p>
            Jika tombol tidak dapat diklik, gunakan link berikut:
        </p>


        <p>
            {{ route('email.peminjaman', $peminjaman->id) }}
        </p>


        <hr>


        <small style="color:#777;">
            Email ini dikirim otomatis oleh Sistem Inventaris IT.
        </small>

    </div>

</body>

</html>