<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Een Mailable klasse representeert een e-mail die vanuit de applicatie verstuurd kan worden.
 */
class NewMessageReceived extends Mailable
{
    // Queueable: Zorgt ervoor dat de e-mail op de achtergrond verstuurd kan worden (indien ingesteld).
    // SerializesModels: Zorgt dat Eloquent modellen netjes verwerkt worden in de e-mail wachtrij.
    use Queueable, SerializesModels;

    /**
     * De variabele die we in de e-mail template (Blade) willen gebruiken.
     */
    public $msg;

    /**
     * Bij het aanmaken van de e-mail geven we het bericht-object mee.
     */
    public function __construct(Message $msg)
    {
        $this->msg = $msg;
    }

    /**
     * De 'Envelope' bevat zaken zoals het onderwerp en de afzender.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuw bericht van ' . $this->msg->sender->name,
        );
    }

    /**
     * De 'Content' definitie wijst naar de Blade-file die de inhoud van de mail bevat.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.new-message-received', // Gebruik een Markdown-template voor de mail.
        );
    }
}
