<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        return Barang::select([
            'kode_barang',
            'nama_barang',
            'stok',
            'kondisi',
            'lokasi',
            'status',
        ])->get();
    }

    /**
     * Judul kolom Excel
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Stok',
            'Kondisi',
            'Lokasi',
            'Status',
        ];
    }
}