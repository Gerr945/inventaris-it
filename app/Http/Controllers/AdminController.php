<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBarang = Barang::count();

        $barangTersedia = Barang::where('status', 'Tersedia')->count();

        $barangDipinjam = Barang::where('status', 'Dipinjam')->count();

        $maintenance = Barang::where('status', 'Maintenance')->count();

        $totalUser = User::where('role', 'user')->count();

        $pendingPeminjaman = Peminjaman::where('status', 'pending')->count();

        $pendingPengembalian = Pengembalian::where('status', 'pending')->count();

        $totalPeminjaman = Peminjaman::count();

        $totalPengembalian = Pengembalian::count();


        // Aktivitas terbaru
        $aktivitas = Peminjaman::with([
            'user',
            'detailPeminjaman.barang'
        ])
            ->latest()
            ->take(5)
            ->get();


        // Mengambil barang yang sedang dipinjam
        // berdasarkan peminjaman yang sudah disetujui
        $peminjamanAktif = Peminjaman::with('detailPeminjaman.barang')
            ->where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->latest()
            ->get();

        $barangAktif = collect();

        foreach ($peminjamanAktif as $peminjaman) {
            foreach ($peminjaman->detailPeminjaman as $detail) {

                if ($detail->barang && !$barangAktif->contains('id', $detail->barang->id)) {
                    $barangAktif->push($detail->barang);
                }

            }
        }

        $barangAktif = $barangAktif->take(5);


        return view('admin.dashboard', compact(
            'totalBarang',
            'barangTersedia',
            'barangDipinjam',
            'maintenance',
            'totalUser',
            'pendingPeminjaman',
            'pendingPengembalian',
            'totalPeminjaman',
            'totalPengembalian',
            'aktivitas',
            'barangAktif'
        ));
    }
}