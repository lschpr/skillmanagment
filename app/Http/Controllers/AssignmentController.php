<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Hier regel ik alles rondom de opdrachten op de site.
 */
class AssignmentController extends Controller
{
    /**
     * Overzichtspagina voor opdrachten.
     * Ik haal hier de data op uit de database (Model) en stuur het naar de Blade-view.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCompany()) {
            // Als je een bedrijf bent, haal ik alleen de opdrachten op met jouw id.
            // Dit is handig zodat je direct je eigen werk ziet.
            $assignments = $user->assignments()->latest()->get();
        } else {
            // Studenten zien alle opdrachten die de status 'open' hebben.
            // 'latest()' zorgt dat de nieuwste bovenaan staan.
            $assignments = Assignment::where('status', 'open')->latest()->get();
        }

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Formulier om een nieuwe opdracht online te zetten.
     * Ik check eerst of je wel een bedrijf bent (abort 403 als dat niet zo is).
     */
    public function create()
    {
        if (!Auth::user()->isCompany()) {
            abort(403, 'Sorry, alleen bedrijven mogen dit.');
        }

        return view('assignments.create');
    }

    /**
     * De opdracht daadwerkelijk in de database zetten.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isCompany()) {
            abort(403);
        }

        // Validatie: ik controleer hier of de gebruiker alles goed heeft ingevuld.
        // Als dit faalt, gaat Laravel automatisch terug naar het formulier met foutmeldingen.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:stage,afstuderen,freelance',
            'region' => 'required|string|max:255',
        ]);

        // Ik gebruik de relatie op de User om de opdracht direct te koppelen aan de ingelogde gebruiker.
        Auth::user()->assignments()->create($validated);

        // Terugsturen naar het overzicht met een succesmelding (flash session).
        return redirect()->route('assignments.index')->with('success', 'Je opdracht staat online!');
    }

    /**
     * Toon de detailpagina van een opdracht.
     * Laravel doet hier aan 'Route Model Binding': het zoekt automatisch de Assignment met het ID uit de URL.
     */
    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    /**
     * Formulier voor het bewerken van een opdracht.
     */
    public function edit(Assignment $assignment)
    {
        // Veiligheidscheck: alleen de eigenaar mag zijn eigen opdracht bewerken.
        if (Auth::id() !== $assignment->user_id) {
            abort(403, 'Niet jouw opdracht, dus afblijven!');
        }

        return view('assignments.edit', compact('assignment'));
    }

    /**
     * De wijzigingen opslaan in de database.
     */
    public function update(Request $request, Assignment $assignment)
    {
        if (Auth::id() !== $assignment->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:stage,afstuderen,freelance',
            'region' => 'required|string|max:255',
            'status' => 'required|string|in:open,closed',
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.index')->with('success', 'De opdracht is bijgewerkt.');
    }

    /**
     * De opdracht verwijderen uit de database.
     */
    public function destroy(Assignment $assignment)
    {
        if (Auth::id() !== $assignment->user_id) {
            abort(403);
        }

        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Opdracht is weg!');
    }
}
