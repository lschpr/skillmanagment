<x-app-layout>
    {{-- Hier kan het bedrijf de opdracht aanpassen --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Opdracht Bewerken') }}: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 leading-relaxed">
                    {{-- Ik gebruik @method('PATCH') omdat we een bestaande opdracht updaten --}}
                    <form method="POST" action="{{ route('assignments.update', $assignment) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="title" :value="__('Titel van de Opdracht')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $assignment->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Type Opdracht')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="stage" {{ $assignment->type == 'stage' ? 'selected' : '' }}>Stage</option>
                                <option value="afstuderen" {{ $assignment->type == 'afstuderen' ? 'selected' : '' }}>Afstuderen</option>
                                <option value="freelance" {{ $assignment->type == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="region" :value="__('Regio / Stad')" />
                            <x-text-input id="region" name="region" type="text" class="mt-1 block w-full" :value="old('region', $assignment->region)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('region')" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="open" {{ $assignment->status == 'open' ? 'selected' : '' }}>Open (Zichtbaar voor studenten)</option>
                                <option value="closed" {{ $assignment->status == 'closed' ? 'selected' : '' }}>Gesloten (Niet meer zichtbaar)</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Beschrijving')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="10" required>{{ old('description', $assignment->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Wijzigingen Opslaan') }}</x-primary-button>
                            <a href="{{ route('assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Annuleren en terug</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
