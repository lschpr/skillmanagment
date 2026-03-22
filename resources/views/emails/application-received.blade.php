<x-mail::message>
# Nieuwe sollicitatie ontvangen

Beste {{ $application->assignment->company->name }},

Er is een nieuwe reactie geplaatst op uw opdracht: **{{ $application->assignment->title }}**.

**Student:** {{ $application->student->name }}  
**Bericht:**  
{{ $application->message }}

<x-mail::button :url="route('assignments.show', $application->assignment)">
Bekijk Sollicitatie
</x-mail::button>

Bedankt,<br>
{{ config('app.name') }}
</x-mail::message>
