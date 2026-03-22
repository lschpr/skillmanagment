<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nieuwe Opdracht Plaatsen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 leading-relaxed">
                    <form method="POST" action="{{ route('assignments.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="title" :value="__('Titel van de Opdracht')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="type" :value="__('Type Opdracht')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="stage">Stage</option>
                                <option value="afstuderen">Afstuderen</option>
                                <option value="freelance">Freelance</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="region" :value="__('Regio / Stad')" />
                            <x-text-input id="region" name="region" type="text" class="mt-1 block w-full" :value="old('region')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('region')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Beschrijving')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="10" required>{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Plaats Opdracht') }}</x-primary-button>
                            <a href="{{ route('assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Annuleren</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
