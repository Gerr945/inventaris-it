<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;

class RiwayatController extends Controller
{
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $peminjaman = Peminjaman::with('detailPeminjaman.barang')
            ->where('user_id', session('user_id'))

            ->when($search, function ($q) use ($search) {

                $q->whereHas('detailPeminjaman.barang', function ($barang) use ($search) {

                    $barang->where('nama_barang', 'like', "%{$search}%");

                });

            })

            ->when($status, function ($q) use ($status) {

                $q->where('status', $status);

            })

            ->latest()

            ->paginate(5, ['*'], 'pinjam');

        $pengembalian = Pengembalian::with('peminjaman.detailPeminjaman.barang')

            ->whereHas('peminjaman', function ($q) {

                $q->where('user_id', session('user_id'));

            })

            ->when($search, function ($q) use ($search) {

                $q->whereHas('peminjaman.detailPeminjaman.barang', function ($barang) use ($search) {

                    $barang->where('nama_barang', 'like', "%{$search}%");

                });

            })

            ->when($status, function ($q) use ($status) {

                $q->where('status', $status);

            })

            ->latest()

            ->paginate(5, ['*'], 'kembali');

        return view(
            'user.riwayat.index',
            compact('peminjaman', 'pengembalian')
        );
    }
}