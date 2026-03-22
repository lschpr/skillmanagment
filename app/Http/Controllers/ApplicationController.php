<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationReceived;
use App\Mail\ApplicationStatusUpdated;

/**
 * Dit is waar ik het solliciteren op opdrachten regel.
 */
class ApplicationController extends Controller
{
    /**
     * Als een student op 'reageer' klikt, komt hij hier uit.
     */
    public function store(Request $request)
    {
        // Even checken of de velden wel goed zijn ingevuld door de student.
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'message' => 'required|string|max:1000',
        ]);

        // Ik check eerst even of deze student niet al eerder op deze opdracht heeft gereageerd.
        $existing = Application::where('user_id', Auth::id())
            ->where('assignment_id', $request->assignment_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Je hebt al gereageerd, even afwachten!');
        }

        // Sollicitatie opslaan in de database.
        $application = Application::create([
            'user_id' => Auth::id(),
            'assignment_id' => $request->assignment_id,
            'message' => $request->message,
            'status' => 'pending', // Standaard staat een nieuwe reactie op 'in afwachting'.
        ]);

        // Ik stuur direct een mailtje naar het bedrijf om te zeggen dat er iemand heeft gereageerd.
        Mail::to($application->assignment->company->email)->send(new ApplicationReceived($application));

        return redirect()->route('assignments.index')->with('success', 'Je reactie is verstuurd!');
    }

    /**
     * Bedrijven kunnen hier een reactie accepteren of afwijzen.
     */
    public function update(Request $request, Application $application)
    {
        // Alleen de eigenaar van de opdracht mag de status wijzigen, anders zou iedereen het kunnen doen.
        if (Auth::id() !== $application->assignment->user_id) {
            abort(403, 'Dit is niet jouw opdracht!');
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected,pending',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        // Ik stuur de student een mailtje met de uitslag (geaccepteerd of afgewezen).
        Mail::to($application->student->email)->send(new ApplicationStatusUpdated($application));

        return back()->with('success', 'De status is bijgewerkt!');
    }
}
