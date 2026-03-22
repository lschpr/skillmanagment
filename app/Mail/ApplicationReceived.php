<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Deze 'Mailable' klas gebruik ik om een e-mail te sturen naar het bedrijf
 * wanneer een student heeft gereageerd op een opdracht.
 */
class ApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    // Deze variabele is publiek zodat ik hem direct in de e-mail template kan gebruiken.
    public $application;

    /**
     * Bij het aanmaken van de mail geef ik de 'Application' mee vanuit de Controller.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Hier definieer ik het onderwerp (subject) van de e-mail.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuwe reactie op uw opdracht: ' . $this->application->assignment->title,
        );
    }

    /**
     * Hier geef ik aan welke Blade-file (markdown) ik wil gebruiken voor de inhoud.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.application-received',
        );
    }
}
