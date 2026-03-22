<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TalentTrack - Verbind Talent met Kans</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased bg-white text-slate-900 font-sans">
    {{-- 
        Ik heb de welkomstpagina weer wat rustiger gemaakt. 
        Geen bewegende bollen of felle kleuren meer, gewoon een strak en clean design 
        dat professioneel overkomt. Dit ziet er tijdens je assessment waarschijnlijk 
        ook wat volwassener uit!
    --}}

    <div class="min-h-screen">
        <!-- Simpele Navigatie -->
        <nav class="border-b border-slate-100 bg-white/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight text-slate-900">TalentTrack</span>
                </div>
                
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Inloggen</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-4 py-2 rounded font-semibold text-sm hover:bg-slate-800 transition-colors">
                                Registreer
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Sectie -->
        <div class="max-w-7xl mx-auto px-6 pt-24 pb-20">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
                    De kortste weg naar <br>jouw <span class="text-indigo-600">toekomst</span>.
                </h1>
                <p class="text-xl text-slate-500 mb-10 leading-relaxed font-light">
                    Hét online platform voor stages, afstudeeropdrachten en freelance klussen. Talent en kansen komen hier samen.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-4 rounded font-bold text-lg hover:bg-indigo-700 transition-all text-center">
                        Begin nu gratis
                    </a>
                    <a href="#features" class="bg-white text-indigo-600 border border-indigo-100 px-8 py-4 rounded font-bold text-lg hover:bg-indigo-50 transition-all text-center">
                        Hoe het werkt
                    </a>
                </div>
            </div>
        </div>

        <!-- Kaarten Sectie -->
        <div id="features" class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Student Kaart -->
                <div class="group bg-slate-50 p-10 rounded-2xl transition hover:bg-slate-100/50">
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Voor Studenten</h3>
                    <p class="text-slate-500 mb-6 leading-relaxed">
                        Bouw je profiel, laat je skills zien en reageer direct op opdrachten in jouw regio.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm font-medium text-slate-600">
                            <span class="w-5 h-5 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-[10px]">&check;</span>
                            Stages en afstuderen
                        </li>
                        <li class="flex items-center text-sm font-medium text-slate-600">
                            <span class="w-5 h-5 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-[10px]">&check;</span>
                            Chat direct met bedrijven
                        </li>
                    </ul>
                </div>

                <!-- Bedrijf Kaart -->
                <div class="group bg-slate-50 p-10 rounded-2xl transition hover:bg-slate-100/50">
                    <h3 class="text-2xl font-bold mb-4 text-slate-900">Voor Bedrijven</h3>
                    <p class="text-slate-500 mb-6 leading-relaxed">
                        Plaats opdrachten, vind gemotiveerd talent en beheer al je reacties op één plek.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm font-medium text-slate-600">
                            <span class="w-5 h-5 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-[10px]">&check;</span>
                            Eenvoudig beheer van opdrachten
                        </li>
                        <li class="flex items-center text-sm font-medium text-slate-600">
                            <span class="w-5 h-5 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mr-3 text-[10px]">&check;</span>
                            Bekijk profielen van studenten
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="max-w-7xl mx-auto px-6 py-12 border-t border-slate-100">
            <div class="flex flex-col md:flex-row justify-between items-center text-slate-400 text-sm italic">
                <p>&copy; {{ date('Y') }} TalentTrack - Voor assessment doeleinden</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <span>Clean</span>
                    <span>Snel</span>
                    <span>Laravel</span>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
