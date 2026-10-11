<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifikasiPeminjamanMail extends Mailable
{
    use Queueable, SerializesModels;

    public Peminjaman $peminjaman;
    public string $judul;
    public string $pesan;

    public function __construct(
        Peminjaman $peminjaman,
        string $judul,
        string $pesan
    ) {
        $this->peminjaman = $peminjaman;
        $this->judul = $judul;
        $this->pesan = $pesan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notifikasi-peminjaman',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}