<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mijn Reacties') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($applications->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 italic">Je hebt nog op geen enkele opdracht gereageerd.</p>
                            <a href="{{ route('assignments.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline">
                                Bekijk beschikbare opdrachten
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        {{-- 'th': De headers van mijn tabel --}}
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Opdracht</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Bedrijf</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Datum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    {{-- Loop door alle reacties van de student --}}
                                    @foreach($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{-- Ik haal hier de titel van de opdracht op via de relatie in het model --}}
                                                <div class="text-sm font-medium text-gray-900">{{ $application->assignment->title }}</div>
                                                <div class="text-xs text-gray-500">{{ $application->assignment->type }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{-- Link naar het publieke profiel van het bedrijf --}}
                                                <a href="{{ route('profile.show', $application->assignment->company) }}" class="text-sm text-indigo-600 hover:underline">
                                                    {{ $application->assignment->company->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{-- Carbon datum formatting: dag-maand-jaar --}}
                                                {{ $application->created_at->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{-- Dynamische kleuren voor de status badge met PHP ternary operators --}}
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $application->status == 'accepted' ? 'bg-green-100 text-green-800' : ($application->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('assignments.show', $application->assignment) }}" class="text-indigo-600 hover:text-indigo-900">Bekijk Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
