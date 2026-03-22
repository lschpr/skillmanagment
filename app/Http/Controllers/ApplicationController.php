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
     * Overzicht van al mijn eigen reacties (voor studenten).
     * Ik haal hier alle applications op van de ingelogde user.
     * Met 'with(assignment)' gebruik ik Eager Loading om database queries te besparen.
     */
    public function index()
    {
        $applications = Auth::user()->applications()->with('assignment')->latest()->get();
        return view('applications.index', compact('applications'));
    }

    /**
     * Als een student op 'reageer' klikt, komt de data hier binnen.
     * Ik controleer de input en kijk of de student niet al eerder heeft gereageerd.
     */
    public function store(Request $request)
    {
        // Validatie: ik check of de opdracht bestaat en of het bericht niet te lang is.
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'message' => 'required|string|max:1000',
        ]);

        // Dubbele reacties voorkomen: ik zoek of er al een record is met deze user en opdracht.
        $existing = Application::where('user_id', Auth::id())
            ->where('assignment_id', $request->assignment_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Je hebt al gereageerd, even afwachten!');
        }

        // Nieuwe sollicitatie aanmaken in de 'applications' tabel.
        $application = Application::create([
            'user_id' => Auth::id(),
            'assignment_id' => $request->assignment_id,
            'message' => $request->message,
            'status' => 'pending', 
        ]);

        // E-mailnotificatie: ik stuur direct een mail naar het bedrijf.
        // De 'ApplicationReceived' klas regelt hoe dit mailtje eruit ziet.
        Mail::to($application->assignment->company->email)->send(new ApplicationReceived($application));

        return redirect()->route('assignments.index')->with('success', 'Je reactie is verstuurd!');
    }

    /**
     * Bedrijven kunnen hier een reactie accepteren of afwijzen.
     */
    public function update(Request $request, Application $application)
    {
        // Autorizatie: ik check of de ingelogde gebruiker wel de eigenaar is van de opdracht.
        if (Auth::id() !== $application->assignment->user_id) {
            abort(403, 'Dit is niet jouw opdracht!');
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected,pending',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        // Mailtje sturen naar de student om te laten weten of hij is aangenomen of niet.
        Mail::to($application->student->email)->send(new ApplicationStatusUpdated($application));

        return back()->with('success', 'De status is bijgewerkt!');
    }
}
