<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeminjamanBaruMail extends Mailable
{
    use SerializesModels;

    public $peminjaman;

    public function __construct(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Peminjaman Barang Baru',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.peminjaman-baru',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}