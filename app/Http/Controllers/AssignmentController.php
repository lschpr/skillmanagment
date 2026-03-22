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
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCompany()) {
            // Als je een bedrijf bent, laat ik alleen je eigen geplaatste opdrachten zien.
            $assignments = $user->assignments()->latest()->get();
        } else {
            // Studenten zien alle opdrachten die nog op 'open' staan.
            $assignments = Assignment::where('status', 'open')->latest()->get();
        }

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Formulier om een nieuwe opdracht online te zetten.
     */
    public function create()
    {
        if (!Auth::user()->isCompany()) {
            abort(403, 'Sorry, alleen bedrijven mogen dit.');
        }

        return view('assignments.create');
    }

    /**
     * Nieuwe opdracht opslaan nadat ik de input heb gecheckt.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isCompany()) {
            abort(403);
        }

        // Checken of de titel, omschrijving enzo wel kloppen.
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:stage,afstuderen,freelance',
            'region' => 'required|string|max:255',
        ]);

        // De nieuwe opdracht koppelen aan de ingelogde user.
        Auth::user()->assignments()->create($validated);

        return redirect()->route('assignments.index')->with('success', 'Je opdracht staat online!');
    }

    /**
     * Detailpagina van een specifieke opdracht bekijken.
     */
    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    /**
     * Formulier om een opdracht aan te passen.
     */
    public function edit(Assignment $assignment)
    {
        // Ik check hier of je wel echt de eigenaar bent van de opdracht.
        if (Auth::id() !== $assignment->user_id) {
            abort(403, 'Niet jouw opdracht, dus afblijven!');
        }

        return view('assignments.edit', compact('assignment'));
    }

    /**
     * Wijzigingen opslaan in de database.
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
     * Een opdracht helemaal verwijderen.
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
