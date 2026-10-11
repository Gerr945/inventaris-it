<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * Data yang akan diekspor
     */
    public function collection()
    {
        return User::select([
            'nama',
            'username',
            'email',
            'departemen',
            'role',
        ])->get();
    }

    /**
     * Judul kolom Excel
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Username',
            'Email',
            'Departemen',
            'Role',
        ];
    }
}