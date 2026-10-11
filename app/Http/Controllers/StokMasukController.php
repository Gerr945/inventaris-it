<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokMasuk;
use Illuminate\Http\Request;

class StokMasukController extends Controller
{
    // Form tambah stok
    public function create($id)
    {
        $barang = Barang::findOrFail($id);

        return view('admin.stok-masuk.create', compact('barang'));
    }

    // Simpan stok masuk
    public function store(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan riwayat stok masuk
        StokMasuk::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'user_id' => session('user_id'),
        ]);

        // Tambahkan stok
        $barang->stok += $request->jumlah;

        // Jika sebelumnya habis, ubah menjadi tersedia
        if ($barang->stok > 0) {
            $barang->status = 'Tersedia';
        }

        $barang->save();

        return redirect()
            ->route('barang.show', $barang->id)
            ->with('success', 'Stok barang berhasil ditambahkan.');
    }

    // Riwayat stok masuk
    public function history($id)
    {
        $barang = Barang::findOrFail($id);

        $riwayat = StokMasuk::where('barang_id', $id)
            ->latest()
            ->paginate(10);

        return view('admin.stok-masuk.history', compact(
            'barang',
            'riwayat'
        ));
    }
}