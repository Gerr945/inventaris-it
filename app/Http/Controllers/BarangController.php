<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // MENAMPILKAN SEMUA BARANG//
    public function index(Request $request)
    {
        $search = $request->search;

        $barang = Barang::when($search, function ($query) use ($search) {

            $query->where('kode_barang', 'like', "%{$search}%")
                ->orWhere('nama_barang', 'like', "%{$search}%")
                ->orWhere('lokasi', 'like', "%{$search}%")
                ->orWhere('kondisi', 'like', "%{$search}%");

        })
            ->latest()
            ->paginate(10);

        return view('admin.barang.index', compact('barang'));
    }

    public function export()
    {
        return Excel::download(
            new BarangExport,
            'data-barang.xlsx'
        );
    }

    // FORM TAMBAH BARANG
    public function create()
    {
        return view('admin.barang.create');
    }


    // ==========================================
    // SIMPAN BARANG BARU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang',
            'nama_barang' => 'required',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $namaFoto = null;

        // Upload foto
        if ($request->hasFile('foto')) {

            $namaFoto = time() . '_' .
                $request->foto->getClientOriginalName();

            $request->foto->move(
                public_path('uploads/barang'),
                $namaFoto
            );
        }

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'foto' => $namaFoto,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'lokasi' => $request->lokasi,
            'status' => 'Tersedia',
        ]);

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Data barang berhasil ditambahkan.'
            );
    }


    // ==========================================
    // DETAIL BARANG
    // ==========================================
    public function show($id)
    {
        $barang = Barang::findOrFail($id);

        return view(
            'admin.barang.show',
            compact('barang')
        );
    }


    // ==========================================
    // FORM EDIT BARANG
    // ==========================================
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        return view(
            'admin.barang.edit',
            compact('barang')
        );
    }


    // ==========================================
    // UPDATE DATA BARANG
    // ==========================================
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $id,
            'nama_barang' => 'required',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ======================================
        // UPLOAD FOTO BARU
        // ======================================

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if (
                $barang->foto &&
                file_exists(
                    public_path(
                        'uploads/barang/' . $barang->foto
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/barang/' . $barang->foto
                    )
                );
            }

            // Simpan foto baru
            $namaFoto = time() . '_' .
                $request->foto->getClientOriginalName();

            $request->foto->move(
                public_path('uploads/barang'),
                $namaFoto
            );

            $barang->foto = $namaFoto;
        }

        // ======================================
        // UPDATE DATA
        // ======================================

        $barang->kode_barang = $request->kode_barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->kondisi = $request->kondisi;
        $barang->lokasi = $request->lokasi;

        // Stok TIDAK diubah di sini.
        // Stok hanya diubah melalui fitur Tambah Stok.

        $barang->save();

        return redirect()
            ->route('barang.show', $barang->id)
            ->with(
                'success',
                'Data barang berhasil diperbarui.'
            );
    }


    // ==========================================
    // AKTIF / NONAKTIF BARANG
    // ==========================================
    public function toggleStatus($id)
    {
        $barang = Barang::findOrFail($id);

        // Barang yang sedang dipinjam tidak boleh dinonaktifkan
        if ($barang->status === 'Dipinjam') {

            return back()->with(
                'error',
                'Barang sedang dipinjam, sehingga tidak dapat dinonaktifkan.'
            );
        }

        // Jika sekarang Nonaktif → Aktifkan
        if ($barang->status === 'Nonaktif') {

            $barang->status = 'Tersedia';

            $pesan = 'Barang berhasil diaktifkan kembali.';

        } else {

            // Jika sekarang aktif → Nonaktifkan
            $barang->status = 'Nonaktif';

            $pesan = 'Barang berhasil dinonaktifkan.';
        }

        $barang->save();

        return back()->with('success', $pesan);
    }
}