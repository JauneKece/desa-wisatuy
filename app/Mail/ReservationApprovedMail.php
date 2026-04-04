<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Payment $payment)
    {
    }

    public function envelope(): Envelope
    {
        $reservasi = $this->payment->reservasi;
        $pelanggan = $reservasi->pelanggan;
        $customerName = $pelanggan->user->name;

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: [$pelanggan->user->email],
            subject: "Reservasi Disetujui - {$reservasi->id}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-approved',
            with: [
                'payment' => $this->payment,
                'reservasi' => $this->payment->reservasi,
                'pelanggan' => $this->payment->reservasi->pelanggan,
                'paketWisata' => $this->payment->reservasi->paketWisata,
                'penginapan' => $this->payment->reservasi->penginapan,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
