<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Deze mailable verstuur ik naar de student wanneer de status 
 * van zijn/haar sollicitatie is aangepast door een bedrijf.
 */
class ApplicationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Het onderwerp van de mail bevat de titel van de opdracht.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update over uw sollicitatie voor: ' . $this->application->assignment->title,
        );
    }

    /**
     * De inhoud wordt gerenderd vanuit de 'emails.application-status-updated' view.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-status-updated',
        );
    }
}
