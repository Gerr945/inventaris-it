<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use Carbon\Carbon;

#[Fillable([
    'user_id',
    'tanggal',
    'jam',
    'tanggal_kembali',
    'jam_kembali',
    'status',
    'approved_by',
])]
class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Menghasilkan batas waktu pengembalian dari tanggal + jam yang ditentukan user.
     */
    public function waktuBatasPengembalian(): ?Carbon
    {
        if (!$this->tanggal_kembali || !$this->jam_kembali) {
            return null;
        }

        return Carbon::parse($this->tanggal_kembali . ' ' . $this->jam_kembali);
    }

    /**
     * Peminjaman dianggap terlambat jika sudah disetujui,
     * belum ada data pengembalian, dan waktu batas sudah terlewati.
     */
    public function isTerlambat(): bool
    {
        $batas = $this->waktuBatasPengembalian();

        return $this->status === 'approved'
            && !$this->pengembalian
            && $batas !== null
            && now()->greaterThan($batas);
    }
}