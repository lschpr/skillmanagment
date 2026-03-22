<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Hier beheer ik zowel mijn accountgegevens als mijn extra profiel-info.
 */
class ProfileController extends Controller
{
    /**
     * Mijn gegevens bijwerken.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // De basisgegevens (naam en email) in de users tabel vullen.
        $user->fill($request->validated());

        // Als ik mijn email verander, moet ik hem daarna weer even opnieuw bevestigen.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Mijn extra profielgegevens (zoals bio en skills) opslaan in de profiles tabel.
        // Ik gebruik updateOrCreate zodat ik niet eerst hoef te checken of het profiel al bestaat.
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['bio', 'skills', 'location', 'website'])
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Mijn account helemaal verwijderen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Ik moet hier even mijn huidige wachtwoord invullen om te bewijzen dat ik het echt ben.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Eerst uitloggen en dan pas deleten.
        Auth::logout();

        $user->delete();

        // Mijn sessie en token even helemaal resetten voor de veiligheid.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
