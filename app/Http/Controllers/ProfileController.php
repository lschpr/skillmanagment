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
     * Toon het formulier om je eigen profiel aan te passen.
     * Dit is onderdeel van de standaard Laravel Breeze functionaliteit.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Publiek profiel bekijken (bijv. van een bedrijf door een student).
     * Ik gebruik de User om alle gekoppelde info (zoals opdrachten) te tonen.
     */
    public function show(User $user)
    {
        return view('profile.show', compact('user'));
    }

    /**
     * Mijn gegevens bijwerken in zowel de 'users' als 'profiles' tabel.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // 'fill': ik vul de user-velden met de gevalideerde data.
        $user->fill($request->validated());

        // E-mail check: als ik mijn e-mail verander, moet ik hem opnieuw verifiëren.
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Profiel-info: ik gebruik 'updateOrCreate' om de extra velden (bio, skills) op te slaan.
        // Als het profiel nog niet bestaat, wordt het hier direct aangemaakt.
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['bio', 'skills', 'location', 'website'])
        );

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Mijn account verwijderen.
     * Dit is een gevoelige actie, dus ik check eerst of het wachtwoord klopt.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validatie met een 'error bag' specifiek voor het verwijderen van een user.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Uitloggen om de sessie te verbreken en daarna de user uit de database halen.
        Auth::logout();

        $user->delete();

        // Sessie vernietigen voor de veiligheid.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
