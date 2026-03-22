<x-app-layout>
    {{-- Blade comments worden niet naar de browser gestuurd, ideaal voor uitleg --}}
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- @if: We gebruiken Blade directives om verschillende content te tonen op basis van de rol --}}
                    
                    @if(Auth::user()->isStudent())
                        <h3 class="text-lg font-bold mb-4">Welkom Student, {{ Auth::user()->name }}!</h3>
                        <p class="mb-4">Bekijk de nieuwste opdrachten en reageer direct.</p>
                        {{-- route(): Genereert automatisch de juiste URL op basis van de naam in web.php --}}
                        <a href="{{ route('assignments.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Bekijk Opdrachten
                        </a>
                        
                    @elseif(Auth::user()->isCompany())
                        <h3 class="text-lg font-bold mb-4">Welkom bij Skillmanagment, {{ Auth::user()->name }}!</h3>
                        <p class="mb-4">Beheer uw opdrachten en bekijk reacties van studenten.</p>
                        <div class="flex space-x-4">
                            <a href="{{ route('assignments.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Mijn Opdrachten
                            </a>
                            <a href="{{ route('assignments.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Nieuwe Opdracht Plaatsen
                            </a>
                        </div>
                        
                    @else
                        {{-- Dit wordt getoond als de gebruiker een 'admin' rol heeft --}}
                        <h3 class="text-lg font-bold mb-4">Admin Dashboard</h3>
                        <p>Beheer accounts en platform content.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
