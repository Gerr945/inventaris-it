<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Exports\PengembalianExport;
use Maatwebsite\Excel\Facades\Excel;

class PengembalianController extends Controller
{
    public function index()
    {
        return view('user.pengembalian.index');
    }

    public function store(Request $request)
    {
        return redirect()
            ->route('user.pengembalian')
            ->with(
                'success',
                'Silakan datang ke ROOM IT untuk mengembalikan barang. Admin akan memproses pengembalian secara langsung.'
            );
    }

    public function adminIndex(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $perPage = $request->input('per_page', 10);

        if (!in_array((int) $perPage, [10, 20, 50, 100])) {
            $perPage = 10;
        }

        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */

        $now = now();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK CARD
        |--------------------------------------------------------------------------
        |
        | Total Disetujui
        | = Semua peminjaman yang sudah disetujui.
        |
        | Sudah Dikembalikan
        | = Peminjaman approved yang sudah memiliki data pengembalian.
        |
        | Belum Kembali
        | = SEMUA peminjaman approved yang BELUM memiliki data pengembalian.
        |
        | Terlambat
        | = Bagian dari Belum Kembali yang sudah melewati batas waktu.
        |
        | Jadi:
        |
        | Total Disetujui
        | = Sudah Dikembalikan + Belum Kembali
        |
        | Dan:
        |
        | Terlambat <= Belum Kembali
        |
        */

        // Total semua peminjaman yang sudah disetujui
        $totalDisetujui = Peminjaman::where('status', 'approved')
            ->count();

        // Semua peminjaman approved yang sudah benar-benar dikembalikan
        $sudahDikembalikan = Peminjaman::where('status', 'approved')
            ->whereHas('pengembalian')
            ->count();

        // SEMUA peminjaman approved yang belum dikembalikan
        // Termasuk yang sudah terlambat.
        $belumKembali = Peminjaman::where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->count();

        // Dari peminjaman yang belum kembali,
        // hitung yang sudah melewati batas pengembalian.
        $terlambat = Peminjaman::where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->whereNotNull('tanggal_kembali')
            ->whereNotNull('jam_kembali')
            ->whereRaw(
                "TIMESTAMP(tanggal_kembali, jam_kembali) < ?",
                [$now]
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | DATA TABEL
        |--------------------------------------------------------------------------
        */

        $peminjaman = Peminjaman::with([
            'user',
            'detailPeminjaman.barang',
            'pengembalian'
        ])
            ->where('status', 'approved')

            /*
            |--------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------
            */

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('nama', 'like', "%{$search}%")
                            ->orWhere('departemen', 'like', "%{$search}%");

                    })

                    ->orWhereHas('detailPeminjaman', function ($detail) use ($search) {

                        $detail->whereHas('barang', function ($barang) use ($search) {

                            $barang->where(
                                'nama_barang',
                                'like',
                                "%{$search}%"
                            );

                        });

                    });

                });
            })

            /*
            |--------------------------------------------------------------
            | FILTER BELUM KEMBALI
            |--------------------------------------------------------------
            |
            | Belum Kembali pada FILTER berarti:
            | belum dikembalikan dan belum terlambat.
            |
            | Karena yang terlambat memiliki filter tersendiri.
            |
            */

            ->when($status === 'belum', function ($query) use ($now) {

                $query->whereDoesntHave('pengembalian')
                    ->whereNotNull('tanggal_kembali')
                    ->whereNotNull('jam_kembali')
                    ->whereRaw(
                        "TIMESTAMP(tanggal_kembali, jam_kembali) >= ?",
                        [$now]
                    );

            })

            /*
            |--------------------------------------------------------------
            | FILTER TERLAMBAT
            |--------------------------------------------------------------
            */

            ->when($status === 'terlambat', function ($query) use ($now) {

                $query->whereDoesntHave('pengembalian')
                    ->whereNotNull('tanggal_kembali')
                    ->whereNotNull('jam_kembali')
                    ->whereRaw(
                        "TIMESTAMP(tanggal_kembali, jam_kembali) < ?",
                        [$now]
                    );

            })

            /*
            |--------------------------------------------------------------
            | FILTER SUDAH DIKEMBALIKAN
            |--------------------------------------------------------------
            */

            ->when($status === 'sudah', function ($query) {

                $query->whereHas('pengembalian');

            })

            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.pengembalian.index',
            compact(
                'peminjaman',
                'totalDisetujui',
                'belumKembali',
                'sudahDikembalikan',
                'terlambat'
            )
        );
    }

    public function manual($id)
    {
        $peminjaman = Peminjaman::with([
            'detailPeminjaman.barang',
            'pengembalian'
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        if ($peminjaman->status != 'approved') {
            return back()->with(
                'error',
                'Peminjaman belum disetujui.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI SUDAH DIKEMBALIKAN
        |--------------------------------------------------------------------------
        */

        if ($peminjaman->pengembalian) {
            return back()->with(
                'error',
                'Barang sudah pernah dikembalikan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal'       => now()->toDateString(),
            'jam'           => now()->format('H:i'),
            'nama_penerima' => session('nama'),
            'status'        => 'approved',
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEMBALIKAN STOK BARANG
        |--------------------------------------------------------------------------
        |
        | Jumlah stok dikembalikan sesuai jumlah barang yang dipinjam.
        |
        */

        $namaBarang = [];

        foreach ($peminjaman->detailPeminjaman as $detail) {

            $barang = $detail->barang;

            $namaBarang[] =
                $barang->nama_barang .
                ' x' .
                $detail->jumlah;

            // Kembalikan stok sesuai jumlah yang dipinjam
            $barang->increment(
                'stok',
                $detail->jumlah
            );

            /*
            | Jika stok sudah tersedia kembali,
            | barang menjadi Tersedia.
            */

            if ($barang->fresh()->stok > 0) {

                $barang->update([
                    'status' => 'Tersedia'
                ]);

            }
        }

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI USER
        |--------------------------------------------------------------------------
        */

        Notifikasi::create([
            'user_id' => $peminjaman->user_id,
            'judul'   => 'Barang Dikembalikan',
            'pesan'   =>
                'Barang "' .
                implode(', ', $namaBarang) .
                '" telah diterima oleh Admin. Terima kasih telah mengembalikan barang.',
            'dibaca'  => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE HALAMAN PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.pengembalian')
            ->with(
                'success',
                'Pengembalian berhasil diproses.'
            );
    }

    public function export()
    {
        return Excel::download(
            new PengembalianExport,
            'data-pengembalian.xlsx'
        );
    }
}