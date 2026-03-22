<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profiel van ') }} {{ $user->name }}
            </h2>
            @if($user->isCompany())
                <span class="ml-4 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded uppercase">Bedrijf</span>
            @else
                <span class="ml-4 px-2 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded uppercase">Student</span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full md:w-1/3">
                            <div class="h-32 w-32 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-4xl font-bold mb-4 mx-auto md:mx-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h3 class="text-2xl font-bold mb-1 text-center md:text-left">{{ $user->name }}</h3>
                            <p class="text-gray-500 mb-4 text-center md:text-left italic">{{ $user->profile->location ?? 'Geen locatie opgegeven' }}</p>
                            
                            @if($user->isCompany() && isset($user->profile->website))
                                <div class="mb-4">
                                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Website</h4>
                                    <a href="{{ $user->profile->website }}" target="_blank" class="text-indigo-600 hover:underline">
                                        {{ $user->profile->website }}
                                    </a>
                                </div>
                            @endif

                            @if($user->isStudent() && isset($user->profile->skills))
                                <div class="mb-4">
                                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Vaardigheden</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $user->profile->skills) as $skill)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6">
                                <a href="{{ route('messages.show', $user) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Bericht Sturen
                                </a>
                            </div>
                        </div>

                        <div class="w-full md:w-2/3">
                            <h4 class="text-lg font-bold mb-4 pb-2 border-b">Over {{ $user->isCompany() ? 'het bedrijf' : 'mij' }}</h4>
                            <div class="prose max-w-none text-gray-700 whitespace-pre-line leading-relaxed">
                                {{ $user->profile->bio ?? 'Geen beschrijving beschikbaar.' }}
                            </div>

                            @if($user->isCompany())
                                <h4 class="text-lg font-bold mt-12 mb-4 pb-2 border-b">Openstaande Opdrachten</h4>
                                <div class="space-y-4">
                                    @forelse($user->assignments()->where('status', 'open')->latest()->get() as $assignment)
                                        <div class="border p-4 rounded-md hover:shadow transition">
                                            <div class="flex justify-between items-start">
                                                <h5 class="font-bold text-indigo-700">{{ $assignment->title }}</h5>
                                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $assignment->type }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2 truncate">{{ Str::limit($assignment->description, 100) }}</p>
                                            <a href="{{ route('assignments.show', $assignment) }}" class="mt-2 inline-block text-xs text-indigo-600 hover:underline">Bekijk Opdracht &rarr;</a>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 italic text-sm">Dit bedrijf heeft momenteel geen openstaande opdrachten.</p>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
