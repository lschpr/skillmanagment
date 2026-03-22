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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                                <div class="text-sm text-indigo-600 font-bold uppercase">Mijn Reacties</div>
                                <div class="text-2xl font-black">{{ Auth::user()->applications()->count() }}</div>
                                <a href="{{ route('applications.index') }}" class="text-xs text-indigo-700 hover:underline">Bekijk status &rarr;</a>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                <div class="text-sm text-green-600 font-bold uppercase">Openstaande Opdrachten</div>
                                <div class="text-2xl font-black">{{ \App\Models\Assignment::where('status', 'open')->count() }}</div>
                                <a href="{{ route('assignments.index') }}" class="text-xs text-green-700 hover:underline">Zoek opdrachten &rarr;</a>
                            </div>
                        </div>
                        
                    @elseif(Auth::user()->isCompany())
                        <h3 class="text-lg font-bold mb-4">Welkom bij Skillmanagment, {{ Auth::user()->name }}!</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                                <div class="text-sm text-indigo-600 font-bold uppercase">Mijn Opdrachten</div>
                                <div class="text-2xl font-black">{{ Auth::user()->assignments()->count() }}</div>
                                <a href="{{ route('assignments.index') }}" class="text-xs text-indigo-700 hover:underline">Beheer &rarr;</a>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <div class="text-sm text-blue-600 font-bold uppercase">Totaal Reacties</div>
                                <div class="text-2xl font-black">{{ \App\Models\Application::whereHas('assignment', function($q) { $q->where('user_id', Auth::id()); })->count() }}</div>
                                <span class="text-xs text-blue-700">Van studenten</span>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-100 flex flex-col justify-center items-center">
                                <a href="{{ route('assignments.create') }}" class="w-full text-center py-2 bg-green-600 text-white rounded font-bold hover:bg-green-700 transition">
                                    + Nieuwe Opdracht
                                </a>
                            </div>
                        </div>
                        
                    @else
                        <h3 class="text-lg font-bold mb-4">Admin Dashboard</h3>
                        <p>Beheer accounts en platform content.</p>
                        <a href="{{ route('admin.index') }}" class="mt-4 inline-block bg-gray-800 text-white px-4 py-2 rounded">Naar Admin Panel</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
