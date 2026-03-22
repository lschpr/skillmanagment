{{-- 
    Dit is de e-mail template voor nieuwe chatberichten.
    Ik gebruik 'Str::limit' om een voorproefje van het bericht te tonen.
--}}
<x-mail::message>
# Je hebt een nieuw bericht ontvangen

Beste {{ $msg->receiver->name }},

Je hebt een nieuw bericht ontvangen van **{{ $msg->sender->name }}**.

**Bericht:**  
{{ Str::limit($msg->content, 100) }}

<x-mail::button :url="route('messages.show', $msg->sender)">
Beantwoord Bericht
</x-mail::button>

Bedankt,<br>
{{ config('app.name') }}
</x-mail::message>
