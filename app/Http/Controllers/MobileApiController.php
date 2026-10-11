<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanPeminjamanMail;
use Carbon\Carbon;

class MobileApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.',
            ], 401);
        }

        if ($user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini bukan akun User.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'departemen' => $user->departemen,
                'role' => $user->role,
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | DATA PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function peminjaman(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan.',
            ], 401);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid.',
            ], 401);
        }

        $barang = Barang::where('status', 'Tersedia')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kode_barang' => $item->kode_barang,
                    'nama_barang' => $item->nama_barang,
                    'stok' => $item->stok,
                    'kondisi' => $item->kondisi,
                    'lokasi' => $item->lokasi,
                    'status' => $item->status,
                ];
            })
            ->values();

        $peminjaman = Peminjaman::with([
            'detailPeminjaman.barang',
            'pengembalian',
        ])
            ->where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal' => $item->tanggal,
                    'jam' => $item->jam,
                    'tanggal_kembali' => $item->tanggal_kembali,
                    'jam_kembali' => $item->jam_kembali,
                    'status' => $item->status,
                    'terlambat' => $item->isTerlambat(),

                    'barang' => $item->detailPeminjaman
                        ->map(function ($detail) {
                            return [
                                'id' => $detail->barang?->id,
                                'nama' => $detail->barang?->nama_barang,
                                'jumlah' => $detail->jumlah,
                            ];
                        })
                        ->filter(function ($barang) {
                            return $barang['id'] !== null;
                        })
                        ->values(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil diambil.',
            'barang' => $barang,
            'peminjaman' => $peminjaman,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | AJUKAN PEMINJAMAN DARI MOBILE
    |--------------------------------------------------------------------------
    */

    public function storePeminjaman(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | USER ID
        |--------------------------------------------------------------------------
        */

        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan.',
            ], 401);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'barang' => ['required', 'array', 'min:1'],
            'barang.*.id' => ['required', 'integer', 'exists:barang,id'],
            'barang.*.jumlah' => ['required', 'integer', 'min:1'],

            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],

            'tanggal_kembali' => [
                'required',
                'date',
                'after_or_equal:tanggal',
            ],

            'jam_kembali' => [
                'required',
                'date_format:H:i',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI WAKTU
        |--------------------------------------------------------------------------
        */

        try {

            $waktuMulai = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validated['tanggal'] . ' ' . $validated['jam']
            );

            $waktuKembali = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validated['tanggal_kembali'] . ' ' . $validated['jam_kembali']
            );

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Format tanggal atau jam tidak valid.',
            ], 422);
        }


        if (!$waktuKembali->greaterThan($waktuMulai)) {

            return response()->json([
                'success' => false,
                'message' => 'Waktu pengembalian harus setelah waktu mulai peminjaman.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | PROSES PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        try {

            $peminjaman = DB::transaction(function () use ($validated, $userId) {

                /*
                |--------------------------------------------------------------------------
                | Buat data peminjaman
                |--------------------------------------------------------------------------
                */

                $peminjaman = Peminjaman::create([
                    'user_id' => $userId,
                    'tanggal' => $validated['tanggal'],
                    'jam' => $validated['jam'],
                    'tanggal_kembali' => $validated['tanggal_kembali'],
                    'jam_kembali' => $validated['jam_kembali'],
                    'status' => 'pending',
                ]);


                /*
                |--------------------------------------------------------------------------
                | Proses setiap barang
                |--------------------------------------------------------------------------
                */

                foreach ($validated['barang'] as $item) {

                    $barang = Barang::lockForUpdate()
                        ->find($item['id']);


                    if (!$barang) {
                        throw new \Exception(
                            'Barang dengan ID ' .
                            $item['id'] .
                            ' tidak ditemukan.'
                        );
                    }


                    if (strtolower($barang->status) !== 'tersedia') {
                        throw new \Exception(
                            'Barang "' .
                            $barang->nama_barang .
                            '" tidak tersedia untuk dipinjam.'
                        );
                    }


                    if ($barang->stok <= 0) {
                        throw new \Exception(
                            'Barang "' .
                            $barang->nama_barang .
                            '" sudah habis.'
                        );
                    }


                    if ($item['jumlah'] > $barang->stok) {
                        throw new \Exception(
                            'Jumlah barang "' .
                            $barang->nama_barang .
                            '" melebihi stok yang tersedia. ' .
                            'Stok saat ini: ' .
                            $barang->stok .
                            '.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Buat detail peminjaman
                    |--------------------------------------------------------------------------
                    */

                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'barang_id' => $barang->id,
                        'jumlah' => $item['jumlah'],
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Kurangi stok
                    |--------------------------------------------------------------------------
                    */

                    $barang->stok -= $item['jumlah'];


                    /*
                    |--------------------------------------------------------------------------
                    | Jika stok habis
                    |--------------------------------------------------------------------------
                    */

                    if ($barang->stok <= 0) {
                        $barang->stok = 0;
                        $barang->status = 'Dipinjam';
                    }


                    $barang->save();
                }


                return $peminjaman;
            });


            /*
            |--------------------------------------------------------------------------
            | LOAD RELASI
            |--------------------------------------------------------------------------
            */

            $peminjaman->load([
                'user',
                'detailPeminjaman.barang',
            ]);


            /*
            |--------------------------------------------------------------------------
            | KIRIM EMAIL KE ADMIN
            |--------------------------------------------------------------------------
            */

            Mail::to('admininventarisit@gmail.com')
                ->send(
                    new PengajuanPeminjamanMail($peminjaman)
                );


            /*
            |--------------------------------------------------------------------------
            | RESPONSE BERHASIL
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan peminjaman berhasil dikirim.',
                'peminjaman' => [
                    'id' => $peminjaman->id,
                    'tanggal' => $peminjaman->tanggal,
                    'jam' => $peminjaman->jam,
                    'tanggal_kembali' => $peminjaman->tanggal_kembali,
                    'jam_kembali' => $peminjaman->jam_kembali,
                    'status' => $peminjaman->status,
                ],
            ], 201);


        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ERROR
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => class_basename($e),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD USER MOBILE
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan.',
            ], 401);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL BARANG YANG MASIH DIPINJAM
        |--------------------------------------------------------------------------
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

        $pendingPengembalian = Pengembalian::whereHas(
            'peminjaman',
            function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        )
            ->where('status', 'pending')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENGEMBALIAN
        |--------------------------------------------------------------------------
        */

        $riwayat = Pengembalian::whereHas(
            'peminjaman',
            function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        )
            ->where('status', 'approved')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN TERLAMBAT
        |--------------------------------------------------------------------------
        */

        $terlambat = Peminjaman::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->whereNotNull('tanggal_kembali')
            ->whereNotNull('jam_kembali')
            ->whereRaw(
                'TIMESTAMP(tanggal_kembali, jam_kembali) < ?',
                [now()]
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $aktivitas = Peminjaman::with([
            'detailPeminjaman.barang',
            'pengembalian',
        ])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($peminjaman) {

                $namaBarang = $peminjaman->detailPeminjaman
                    ->map(function ($detail) {
                        return $detail->barang
                            ? $detail->barang->nama_barang
                            : null;
                    })
                    ->filter()
                    ->values()
                    ->implode(', ');

                return [
                    'id' => $peminjaman->id,
                    'nama_barang' => $namaBarang,
                    'tanggal' => $peminjaman->tanggal,
                    'jam' => $peminjaman->jam,
                    'tanggal_kembali' => $peminjaman->tanggal_kembali,
                    'jam_kembali' => $peminjaman->jam_kembali,
                    'status' => $peminjaman->status,
                    'terlambat' => $peminjaman->isTerlambat(),
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | BARANG YANG MASIH DIPINJAM
        |--------------------------------------------------------------------------
        */

        $barangAktif = Peminjaman::with([
            'detailPeminjaman.barang',
        ])
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->whereDoesntHave('pengembalian')
            ->get()
            ->map(function ($peminjaman) {

                return [
                    'id' => $peminjaman->id,
                    'tanggal' => $peminjaman->tanggal,
                    'jam' => $peminjaman->jam,
                    'tanggal_kembali' => $peminjaman->tanggal_kembali,
                    'jam_kembali' => $peminjaman->jam_kembali,
                    'terlambat' => $peminjaman->isTerlambat(),

                    'barang' => $peminjaman->detailPeminjaman
                        ->map(function ($detail) {

                            return [
                                'id' => $detail->barang?->id,
                                'nama_barang' =>
                                    $detail->barang?->nama_barang,
                                'kode_barang' =>
                                    $detail->barang?->kode_barang,
                                'jumlah' => $detail->jumlah,
                            ];
                        })
                        ->values(),
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'message' => 'Data dashboard berhasil diambil.',

            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'departemen' => $user->departemen,
            ],

            'stats' => [
                'barang_dipinjam' => $barangDipinjam,
                'pending_peminjaman' => $pendingPeminjaman,
                'pending_pengembalian' => $pendingPengembalian,
                'riwayat' => $riwayat,
                'terlambat' => $terlambat,
            ],

            'aktivitas' => $aktivitas,

            'barang_aktif' => $barangAktif,
        ]);


    }

    public function pesan(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan.',
            ], 401);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid.',
            ], 401);
        }

        $pesan = \App\Models\Notifikasi::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'pesan' => $item->pesan,
                    'dibaca' => (bool) $item->dibaca,
                    'created_at' => $item->created_at?->format('Y-m-d H:i:s'),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Data pesan berhasil diambil.',
            'pesan' => $pesan,
            'jumlah_belum_dibaca' => $pesan
                ->where('dibaca', false)
                ->count(),
        ]);
    }

    public function riwayat(Request $request)
    {
        $userId = $request->input('user_id');

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID tidak ditemukan.',
            ], 401);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'user') {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PEMINJAMAN
        |--------------------------------------------------------------------------
        | Semua peminjaman milik user yang sudah selesai/dikembalikan.
        */

        $riwayatPeminjaman = Peminjaman::with([
            'detailPeminjaman.barang',
            'pengembalian',
        ])
            ->where('user_id', $userId)
            ->whereHas('pengembalian')
            ->latest()
            ->get()
            ->map(function ($item) {

                return [
                    'id' => $item->id,

                    'tanggal' => $item->tanggal,
                    'jam' => $item->jam,

                    'tanggal_kembali' => $item->tanggal_kembali,
                    'jam_kembali' => $item->jam_kembali,

                    'status' => $item->status,

                    'terlambat' => $item->isTerlambat(),

                    'barang' => $item->detailPeminjaman
                        ->map(function ($detail) {
                            return [
                                'id' => $detail->barang?->id,
                                'nama' => $detail->barang?->nama_barang,
                                'kode_barang' => $detail->barang?->kode_barang,
                                'jumlah' => $detail->jumlah,
                            ];
                        })
                        ->filter(function ($barang) {
                            return $barang['id'] !== null;
                        })
                        ->values(),

                    'pengembalian' => $item->pengembalian
                        ? [
                            'id' => $item->pengembalian->id,
                            'tanggal' => $item->pengembalian->tanggal,
                            'jam' => $item->pengembalian->jam,
                            'status' => $item->pengembalian->status,
                            'nama_penerima' =>
                                $item->pengembalian->nama_penerima,
                        ]
                        : null,
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENGEMBALIAN
        |--------------------------------------------------------------------------
        | Hanya data pengembalian milik user yang sudah diproses Admin.
        */

        $riwayatPengembalian = Pengembalian::with([
            'peminjaman.detailPeminjaman.barang',
        ])
            ->whereHas('peminjaman', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->get()
            ->map(function ($item) {

                $peminjaman = $item->peminjaman;

                return [
                    'id' => $item->id,

                    'peminjaman_id' => $peminjaman?->id,

                    'tanggal' => $item->tanggal,
                    'jam' => $item->jam,

                    'nama_penerima' => $item->nama_penerima,

                    'status' => $item->status,

                    'barang' => $peminjaman?->detailPeminjaman
                        ? $peminjaman->detailPeminjaman
                            ->map(function ($detail) {
                                return [
                                    'id' => $detail->barang?->id,
                                    'nama' => $detail->barang?->nama_barang,
                                    'kode_barang' =>
                                        $detail->barang?->kode_barang,
                                    'jumlah' => $detail->jumlah,
                                ];
                            })
                            ->filter(function ($barang) {
                                return $barang['id'] !== null;
                            })
                            ->values()
                        : [],
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Data riwayat berhasil diambil.',

            'riwayat_peminjaman' => $riwayatPeminjaman,

            'riwayat_pengembalian' => $riwayatPengembalian,
        ]);
    }
}