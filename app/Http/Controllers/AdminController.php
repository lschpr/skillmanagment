<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Hier beheer ik alles waar alleen de admin bij mag. 
 * Zoals het blokkeren van gebruikers of het verwijderen van accounts.
 */
class AdminController extends Controller
{
    /**
     * Dit is mijn overzichtspagina voor de admin.
     */
    public function index()
    {
        // Ik check hier nog een keer extra of de gebruiker wel echt admin is.
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hier mag je niet komen!');
        }

        // Alle users ophalen (behalve de admin zelf) en alle opdrachten.
        $users = User::where('id', '!=', Auth::id())->latest()->get();
        $assignments = Assignment::latest()->get();

        return view('admin.index', compact('users', 'assignments'));
    }

    /**
     * Hiermee kan ik een gebruiker op 'blocked' zetten of juist weer deblokkeren.
     */
    public function toggleStatus(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // Als de status 'active' is, maak ik er 'blocked' van, en andersom.
        $user->status = $user->status === 'active' ? 'blocked' : 'active';
        $user->save();

        return back()->with('success', 'Status van ' . $user->name . ' is nu ' . $user->status);
    }

    /**
     * Account verwijderen van een gebruiker.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'De gebruiker is verwijderd uit mijn systeem.');
    }

    /**
     * Een opdracht verwijderen (bijvoorbeeld als deze ongepast is).
     */
    public function destroyAssignment(Assignment $assignment)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $assignment->delete();

        return back()->with('success', 'De opdracht is verwijderd.');
    }
}
