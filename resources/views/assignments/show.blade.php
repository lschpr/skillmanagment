<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <span class="bg-indigo-100 text-indigo-800 text-sm font-bold px-3 py-1 rounded-full uppercase">
                            {{ $assignment->type }}
                        </span>
                        <span class="ml-4 text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $assignment->region }}</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Geplaatst door: <strong>{{ $assignment->company->name }}</strong>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                    <h3 class="text-2xl font-bold mb-4">Omschrijving</h3>
                    <div class="whitespace-pre-line text-gray-700 leading-relaxed">
                        {{ $assignment->description }}
                    </div>
                </div>

                <hr class="my-8">

                @if(Auth::user()->isStudent())
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h4 class="text-lg font-bold mb-4">Reageren op deze opdracht</h4>
                        <form action="{{ route('applications.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                            <div class="mb-4">
                                <x-input-label for="message" :value="__('Motivatie / Bericht')" />
                                <textarea id="message" name="message" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5" required placeholder="Vertel kort waarom je interesse hebt..."></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                            </div>
                            <x-primary-button>Verstuur Reactie</x-primary-button>
                        </form>
                    </div>
                @elseif(Auth::id() === $assignment->user_id)
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-bold text-indigo-700">Beheer deze opdracht</h4>
                        <div class="flex space-x-4">
                            <a href="{{ route('assignments.edit', $assignment) }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Bewerken</a>
                            <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Weet je het zeker?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Verwijderen</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h4 class="text-lg font-bold mb-4">Reacties ({{ $assignment->applications->count() }})</h4>
                        <div class="space-y-4">
                            @foreach($assignment->applications as $application)
                                <div class="border p-4 rounded-md bg-white hover:bg-gray-50 transition">
                                    <div class="flex justify-between mb-2">
                                        <span class="font-bold">{{ $application->student->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $application->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3 italic">"{{ $application->message }}"</p>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('applications.update', $application) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Selecteren</button>
                                        </form>
                                        <form action="{{ route('applications.update', $application) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="text-xs bg-red-400 text-white px-2 py-1 rounded hover:bg-red-500">Afwijzen</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
