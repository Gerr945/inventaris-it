<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeminjamanExport implements FromCollection, WithHeadings
{
    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        return Peminjaman::with([
            'user',
            'approvedBy',
            'detailPeminjaman.barang'
        ])
            ->latest()
            ->get()
            ->map(function ($peminjaman) {

                $barang = $peminjaman->detailPeminjaman
                    ->map(function ($detail) {
                        return $detail->barang->nama_barang .
                            ' (' . $detail->jumlah . ' unit)';
                    })
                    ->implode(', ');

                return [
                    'Nama Peminjam' => $peminjaman->user->nama ?? '-',
                    'Username' => $peminjaman->user->username ?? '-',
                    'Departemen' => $peminjaman->user->departemen ?? '-',
                    'Tanggal Peminjaman' => $peminjaman->tanggal,
                    'Jam Peminjaman' => $peminjaman->jam,
                    'Tanggal Pengembalian' => $peminjaman->tanggal_kembali,
                    'Jam Pengembalian' => $peminjaman->jam_kembali,
                    'Barang' => $barang ?: '-',
                    'Status' => ucfirst($peminjaman->status),
                    'Disetujui Oleh' => $peminjaman->approvedBy->nama ?? '-',
                ];
            });
    }

    /**
     * Judul kolom Excel
     */
    public function headings(): array
    {
        return [
            'Nama Peminjam',
            'Username',
            'Departemen',
            'Tanggal Peminjaman',
            'Jam Peminjaman',
            'Tanggal Pengembalian',
            'Jam Pengembalian',
            'Barang',
            'Status',
            'Disetujui Oleh',
        ];
    }
}