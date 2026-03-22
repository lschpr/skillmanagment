{{-- 
    Dit is een Markdown e-mail template.
    Laravel zet dit automatisch om naar een mooie HTML e-mail.
    Ik gebruik {{ $application }} om de data te tonen die ik in de 
    Mailable klasse heb klaargezet.
--}}
<x-mail::message>
# Nieuwe sollicitatie ontvangen

Beste {{ $application->assignment->company->name }},

Er is een nieuwe reactie geplaatst op uw opdracht: **{{ $application->assignment->title }}**.

**Student:** {{ $application->student->name }}  
**Bericht:**  
{{ $application->message }}

{{-- De x-mail::button component maakt een nette knop die werkt in alle mail-programma's --}}
<x-mail::button :url="route('assignments.show', $application->assignment)">
Bekijk Sollicitatie
</x-mail::button>

Bedankt,<br>
{{ config('app.name') }}
</x-mail::message>
