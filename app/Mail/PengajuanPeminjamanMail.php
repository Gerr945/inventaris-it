<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PengajuanPeminjamanMail extends Mailable
{
    public $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function build()
    {
        return $this->subject('Pengajuan Peminjaman Barang Baru')
                    ->view('emails.pengajuan-peminjaman');
    }
}