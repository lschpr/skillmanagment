<x-app-layout>
    {{-- Dit is mijn overzichtspagina voor alle opdrachten --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->isCompany() ? __('Mijn Opdrachten') : __('Beschikbare Opdrachten') }}
            </h2>
            @if(Auth::user()->isCompany())
                <a href="{{ route('assignments.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    + Nieuwe Opdracht
                </a>
            @endif
        </div>
    </x-slot>

    {{-- 'x-data': Ik gebruik hier Alpine.js voor razendsnelle filtering zonder de pagina te herladen --}}
    <div class="py-12" x-data="{ search: '', type: 'all' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Auth::user()->isStudent())
            <!-- Filters voor Studenten -->
            {{-- x-model: linkt de input direct aan de Alpine.js variabelen 'search' en 'type' --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6 flex space-x-4">
                <input x-model="search" type="text" placeholder="Zoek op titel of regio..." class="flex-1 border-gray-300 rounded-md">
                <select x-model="type" class="border-gray-300 rounded-md">
                    <option value="all">Alle Types</option>
                    <option value="stage">Stage</option>
                    <option value="afstuderen">Afstuderen</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- @foreach: Ik loop hier door alle opdrachten die ik vanuit de Controller heb meegegeven --}}
                @foreach($assignments as $assignment)
                {{-- x-show: Deze magische regel van Alpine.js checkt of een opdracht getoond moet worden op basis van de filters --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500"
                     x-show="(type === 'all' || '{{ $assignment->type }}' === type) && ('{{ strtolower($assignment->title . ' ' . $assignment->region) }}'.includes(search.toLowerCase()))">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold uppercase py-1 px-2 rounded {{ $assignment->type == 'stage' ? 'bg-blue-100 text-blue-800' : ($assignment->type == 'afstuderen' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($assignment->type) }}
                        </span>
                        <span class="text-gray-500 text-sm italic">{{ $assignment->region }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $assignment->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{-- Laravel helper 'Str::limit' om de tekst netjes in te korten --}}
                        {{ Str::limit($assignment->description, 150) }}
                    </p>
                    
                    <div class="flex justify-between items-center mt-auto">
                        <a href="{{ route('assignments.show', $assignment) }}" class="text-indigo-600 font-semibold hover:underline">
                            Bekijk Details &rarr;
                        </a>
                        {{-- Security check in de view: alleen de eigenaar krijgt de 'bewerk' knop te zien --}}
                        @if(Auth::id() === $assignment->user_id)
                        <div class="flex space-x-2">
                            <a href="{{ route('assignments.edit', $assignment) }}" class="text-gray-500 hover:text-gray-700">Bewerk</a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($assignments->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Geen opdrachten gevonden.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
