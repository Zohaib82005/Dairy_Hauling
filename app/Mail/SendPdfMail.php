<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
// use Barryvdh\DomPDF\Facade\Pdf;

class SendPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketID;
    public $userId;
    protected $pdf; 

    public function __construct(public array $data)
    {
        $this->pdf = Pdf::loadView('pdfsend', $data);
        $this->ticketID = $data['ticketID'];
        $this->userId = $data['userId'];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Daily Progress Report',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'pdfsend',
            with: [
                'ticketID' => $this->ticketID,
                'userId' => $this->userId
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdf->output(), 'report.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
