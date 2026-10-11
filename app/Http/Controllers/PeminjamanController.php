<?php

namespace App\Http\Controllers;

use App\Mail\PengajuanPeminjamanMail;
use App\Mail\NotifikasiPeminjamanMail;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // ===========================
    // USER
    // ===========================

    public function index()
    {
        $barang = Barang::where('status', 'Tersedia')
            ->where('stok', '>', 0)
            ->get();

        $peminjaman = Peminjaman::with(
            'detailPeminjaman.barang',
            'user',
            'pengembalian'
        )
            ->where('user_id', session('user_id'))
            ->latest()
            ->get();

        return view(
            'user.peminjaman.index',
            compact('barang', 'peminjaman')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'exists:barang,id',

            'tanggal' => 'required|date',
            'jam' => 'required',

            'tanggal_kembali' => 'required|date|after_or_equal:tanggal',
            'jam_kembali' => 'required',
        ], [
            'barang_id.required' => 'Silakan pilih minimal satu barang.',
            'tanggal_kembali.after_or_equal' => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
        ]);

        // ===========================
        // Cek waktu peminjaman
        // ===========================

        $waktuMulai = Carbon::parse(
            $request->tanggal . ' ' . $request->jam
        );

        $waktuKembali = Carbon::parse(
            $request->tanggal_kembali . ' ' . $request->jam_kembali
        );

        if ($waktuKembali->lessThanOrEqualTo($waktuMulai)) {

            return back()
                ->withInput()
                ->withErrors([
                    'tanggal_kembali' =>
                        'Waktu pengembalian harus setelah waktu mulai peminjaman.'
                ]);
        }

        // ===========================
        // Cek stok terlebih dahulu
        // ===========================

        foreach ($request->barang_id as $barangId) {

            $barang = Barang::findOrFail($barangId);

            $jumlah = $request->jumlah[$barangId] ?? 0;

            if ($jumlah < 1) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'barang_id' =>
                            'Jumlah barang harus minimal 1.'
                    ]);
            }

            if ($jumlah > $barang->stok) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'barang_id' =>
                            $barang->nama_barang .
                            ' hanya memiliki stok ' .
                            $barang->stok .
                            '.'
                    ]);
            }
        }

        // ===========================
        // Simpan peminjaman
        // ===========================

        $peminjaman = Peminjaman::create([
            'user_id' => session('user_id'),
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'jam_kembali' => $request->jam_kembali,
            'status' => 'pending',
        ]);

        // ===========================
        // Simpan detail barang
        // ===========================

        foreach ($request->barang_id as $barangId) {

            $barang = Barang::findOrFail($barangId);

            $jumlah = $request->jumlah[$barangId];

            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'barang_id' => $barangId,
                'jumlah' => $jumlah,
            ]);

            $barang->decrement('stok', $jumlah);

            if ($barang->fresh()->stok <= 0) {

                $barang->update([
                    'status' => 'Dipinjam'
                ]);
            }
        }

        // ===========================
        // Email Admin
        // ===========================

        $peminjaman->load(
            'user',
            'detailPeminjaman.barang'
        );

        Mail::to('admininventarisit@gmail.com')
            ->send(
                new PengajuanPeminjamanMail($peminjaman)
            );

        return back()->with(
            'success',
            'Pengajuan berhasil dikirim.'
        );
    }

    // ===========================
    // ADMIN
    // ===========================

    public function adminIndex(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $perPage = $request->input('per_page', 10);

        $peminjaman = Peminjaman::with(
            'user',
            'detailPeminjaman.barang',
            'approvedBy',
        )
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('user', function ($user) use ($search) {

                        $user->where('nama', 'like', "%{$search}%")
                            ->orWhere(
                                'departemen',
                                'like',
                                "%{$search}%"
                            );

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
            ->when($status, function ($query) use ($status) {

                $query->where('status', $status);

            })
            ->latest()
            ->paginate($perPage);

        return view(
            'admin.peminjaman.index',
            compact('peminjaman')
        );
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(
            'user',
            'detailPeminjaman.barang',
            'approvedBy',
        )->findOrFail($id);

        return view(
            'admin.peminjaman.show',
            compact('peminjaman')
        );
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::with(
            'detailPeminjaman.barang'
        )->findOrFail($id);

        if ($peminjaman->status != 'pending') {

            return back()->with(
                'error',
                'Peminjaman sudah diproses.'
            );
        }

        $peminjaman->update([
            'status' => 'approved',
            'approved_by' => session('user_id'),
        ]);

        $namaBarang = $peminjaman->detailPeminjaman
            ->pluck('barang.nama_barang')
            ->implode(', ');

        Notifikasi::create([
            'user_id' => $peminjaman->user_id,
            'judul' => 'Peminjaman Disetujui',
            'pesan' =>
                'Pengajuan peminjaman barang "' .
                $namaBarang .
                '" telah disetujui.',
            'dibaca' => false,
        ]);

        // Kirim email ke user
        $peminjaman->load('user', 'detailPeminjaman.barang');

        if ($peminjaman->user->email) {

            Mail::to($peminjaman->user->email)
                ->send(
                    new NotifikasiPeminjamanMail(
                        $peminjaman,
                        'Peminjaman Disetujui',
                        'Pengajuan peminjaman barang "' .
                        $namaBarang .
                        '" telah disetujui oleh Admin.'
                    )
                );
        }

        return redirect()
            ->route('admin.peminjaman')
            ->with(
                'success',
                'Peminjaman berhasil disetujui.'
            );
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::with(
            'detailPeminjaman.barang'
        )->findOrFail($id);

        if ($peminjaman->status != 'pending') {

            return back()->with(
                'error',
                'Peminjaman sudah diproses.'
            );
        }

        foreach ($peminjaman->detailPeminjaman as $detail) {

            $barang = $detail->barang;

            $barang->increment(
                'stok',
                $detail->jumlah
            );

            if ($barang->fresh()->stok > 0) {

                $barang->update([
                    'status' => 'Tersedia'
                ]);
            }
        }

        $peminjaman->update([
            'status' => 'rejected',
            'approved_by' => session('user_id'),
        ]);

        $namaBarang = $peminjaman->detailPeminjaman
            ->pluck('barang.nama_barang')
            ->implode(', ');

        Notifikasi::create([
            'user_id' => $peminjaman->user_id,
            'judul' => 'Peminjaman Ditolak',
            'pesan' =>
                'Pengajuan peminjaman barang "' .
                $namaBarang .
                '" ditolak oleh Admin.',
            'dibaca' => false,
        ]);

        // Kirim email ke user
        $peminjaman->load('user', 'detailPeminjaman.barang');

        if ($peminjaman->user->email) {

            Mail::to($peminjaman->user->email)
                ->send(
                    new NotifikasiPeminjamanMail(
                        $peminjaman,
                        'Peminjaman Ditolak',
                        'Pengajuan peminjaman barang "' .
                        $namaBarang .
                        '" ditolak oleh Admin.'
                    )
                );
        }

        return redirect()
            ->route('admin.peminjaman')
            ->with(
                'success',
                'Peminjaman ditolak.'
            );
    }

    public function export()
    {
        return Excel::download(
            new PeminjamanExport,
            'data-peminjaman.xlsx'
        );
    }
}