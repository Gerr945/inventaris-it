<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'peminjaman_id',
    'tanggal',
    'jam',
    'nama_penerima',
    'status',
])]
class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }
}