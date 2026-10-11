<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Notifikasi;

class PesanController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', session('user_id'))
            ->latest()
            ->get();

        // Tandai semua notifikasi sebagai sudah dibaca
        Notifikasi::where('user_id', session('user_id'))
            ->where('dibaca', false)
            ->update([
                'dibaca' => true
            ]);

        return view(
            'user.pesan.index',
            compact('notifikasi')
        );
    }
}