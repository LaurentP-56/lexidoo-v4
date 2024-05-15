<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Tarifs; // Assurez-vous d'ajouter cette ligne en haut pour importer le modèle Tarifs
use App\Models\User;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function showTarifs()
    {
        $tarifs = Tarifs::all(); // Récupère tous les tarifs
        // Assurez-vous de passer les tarifs à la vue, en plus de toutes autres données nécessaires
        return view('show', compact('tarifs')); // 'show' est le nom de votre vue
    }


    public function users(Request $request)
    {
        // Exemple d'utilisation du modèle User
        $users = User::all();
        // Logique pour retourner une vue avec les utilisateurs...
    }

}

