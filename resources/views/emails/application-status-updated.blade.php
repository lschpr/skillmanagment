<x-mail::message>
# Status update van je sollicitatie

Beste {{ $application->student->name }},

De status van je sollicitatie voor **{{ $application->assignment->title }}** is bijgewerkt naar: **{{ ucfirst($application->status) }}**.

@if($application->status == 'accepted')
Gefeliciteerd! Het bedrijf heeft interesse getoond. Je kunt nu contact met hen opnemen via het platform.
@else
Helaas is de keuze niet op jou gevallen voor deze opdracht. Bekijk andere opdrachten op ons platform.
@endif

<x-mail::button :url="route('assignments.show', $application->assignment)">
Bekijk Opdracht
</x-mail::button>

Bedankt,<br>
{{ config('app.name') }}
</x-mail::message>
