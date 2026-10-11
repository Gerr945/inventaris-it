<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $judul }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f6f8; padding: 30px;">

    <div style="
        max-width: 600px;
        margin: auto;
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    ">

        <h2 style="margin-top: 0; color: #198754;">
            {{ $judul }}
        </h2>

        <p>
            Halo <strong>{{ $peminjaman->user->nama }}</strong>,
        </p>

        <p>
            {{ $pesan }}
        </p>

        <hr>

        <h4>Detail Peminjaman</h4>

        <table style="width: 100%; border-collapse: collapse;">

            <tr>
                <td style="padding: 8px 0;">
                    <strong>Nama</strong>
                </td>
                <td>
                    {{ $peminjaman->user->nama }}
                </td>
            </tr>

            <tr>
                <td style="padding: 8px 0;">
                    <strong>Departemen</strong>
                </td>
                <td>
                    {{ $peminjaman->user->departemen }}
                </td>
            </tr>

            <tr>
                <td style="padding: 8px 0;">
                    <strong>Status</strong>
                </td>
                <td>
                    {{ ucfirst($peminjaman->status) }}
                </td>
            </tr>

            <tr>
                <td style="padding: 8px 0;">
                    <strong>Mulai Peminjaman</strong>
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d F Y') }}
                    {{ $peminjaman->jam }}
                </td>
            </tr>

            <tr>
                <td style="padding: 8px 0;">
                    <strong>Pengembalian</strong>
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d F Y') }}
                    {{ $peminjaman->jam_kembali }}
                </td>
            </tr>

        </table>

        <hr>

        <h4>Barang</h4>

        <ul>

            @foreach($peminjaman->detailPeminjaman as $detail)

                <li>
                    {{ $detail->barang->nama_barang }}
                    — jumlah {{ $detail->jumlah }}
                </li>

            @endforeach

        </ul>

        <p style="margin-top: 30px; color: #777; font-size: 13px;">
            Email ini dikirim otomatis oleh Sistem Inventaris IT.
        </p>

    </div>

</body>

</html>