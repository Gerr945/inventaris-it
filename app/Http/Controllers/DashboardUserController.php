<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DashboardUserController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        /*
        |--------------------------------------------------------------------------
        | TOTAL PEMINJAMAN AKTIF
        |--------------------------------------------------------------------------
        | Peminjaman sudah disetujui dan belum dikembalikan oleh Admin.
        | Peminjaman terlambat tetap dihitung sebagai barang yang masih dipinjam.
        */

        $barangDipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        $pendingPeminjaman = Peminjaman::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        $pendingPengembalian = Pengembalian::whereHas('peminjaman', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'pending')
        ->count();


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        $riwayat = Pengembalian::whereHas('peminjaman', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'approved')
        ->count();


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN TERLAMBAT
        |--------------------------------------------------------------------------
        | Terlambat apabila:
        | 1. Milik user yang login
        | 2. Sudah approved
        | 3. Belum ada pengembalian
        | 4. Ada tanggal dan jam batas pengembalian
        | 5. Waktu sekarang sudah melewati batas
        */

        $terlambat = Peminjaman::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->whereNotNull('tanggal_kembali')
            ->whereNotNull('jam_kembali')
            ->whereRaw(
                "TIMESTAMP(tanggal_kembali, jam_kembali) < ?",
                [now()]
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $aktivitas = Peminjaman::with([
            'detailPeminjaman.barang'
        ])
        ->where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | BARANG YANG MASIH DIPINJAM
        |--------------------------------------------------------------------------
        | Termasuk barang yang sudah terlambat.
        | Barang baru hilang dari daftar setelah Admin menerima pengembalian.
        */

        $barangAktif = Peminjaman::with([
            'detailPeminjaman.barang'
        ])
        ->where('user_id', $userId)
        ->where('status', 'approved')
        ->whereDoesntHave('pengembalian')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('user.dashboard', compact(
            'barangDipinjam',
            'pendingPeminjaman',
            'pendingPengembalian',
            'riwayat',
            'terlambat',
            'aktivitas',
            'barangAktif'
        ));
    }
}