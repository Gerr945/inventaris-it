<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengembalianExport implements FromCollection, WithHeadings
{
    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        return Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPeminjaman.barang',
        ])
            ->latest()
            ->get()
            ->map(function ($pengembalian) {

                $peminjaman = $pengembalian->peminjaman;

                $barang = $peminjaman?->detailPeminjaman
                    ->map(function ($detail) {
                        return ($detail->barang->nama_barang ?? 'Barang') .
                            ' (' . $detail->jumlah . ' unit)';
                    })
                    ->implode(', ');

                return [
                    'Nama Peminjam' => $peminjaman?->user?->nama ?? '-',
                    'Username' => $peminjaman?->user?->username ?? '-',
                    'Departemen' => $peminjaman?->user?->departemen ?? '-',

                    'Tanggal Peminjaman' => $peminjaman?->tanggal ?? '-',
                    'Jam Peminjaman' => $peminjaman?->jam ?? '-',

                    'Tanggal Pengembalian' => $pengembalian->tanggal,
                    'Jam Pengembalian' => $pengembalian->jam,

                    'Nama Penerima' => $pengembalian->nama_penerima ?? '-',

                    'Barang' => $barang ?: '-',

                    'Status' => ucfirst($pengembalian->status),
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
            'Nama Penerima',
            'Barang',
            'Status',
        ];
    }
}