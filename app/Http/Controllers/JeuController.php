<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JeuService;
use Illuminate\Support\Facades\Auth;

class JeuController extends Controller
{
    protected $jeuService;

    public function __construct(JeuService $jeuService)
    {
        // Assurez-vous que l'utilisateur est connecté pour accéder à toutes les méthodes de ce contrôleur
        $this->middleware('auth');
        $this->jeuService = $jeuService;
    }

    /**
     * Affiche l'interface de jeu avec les données initiales.
     */
   // Dans JeuController.php
   public function index()
   {
       $userId = Auth::id();
       $gameData = $this->jeuService->initializeGame($userId);

       if (!$gameData || !is_array($gameData) || count($gameData) === 0) {
           return redirect('/')->with('error', 'Impossible de charger les données du jeu.');
       }

       return view('jeu.index', [
           'levels' => $gameData['levels'] ?? [],
           'themes' => $gameData['themes'] ?? [],
           'sousThemes' => $gameData['sousThemes'] ?? [],
           'categories' => $gameData['categories'] ?? [],
           'sousCategories' => $gameData['sousCategories'] ?? [],
           'tempsOptions' => $gameData['tempsOptions'] ?? [],
           'isPremium' => $gameData['isPremium'] ?? false,
       ]);
   }
    /**
     * Gère la soumission du formulaire de jeu et la sélection des mots.
     */
    public function play(Request $request)
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'level_id' => 'required|integer|exists:levels,id',
            'theme_id' => 'nullable|integer|exists:themes,id',
            'sous_theme_id' => 'nullable|integer|exists:themes,id',
            'categorie_id' => 'nullable|integer|exists:categories,id',
            'temps_id' => 'required|integer|exists:tempsOptions,id',
        ]);

        $mots = $this->jeuService->selectMots(
            $userId,
            $validatedData['level_id'],
            $validatedData['theme_id'],
            $validatedData['sous_theme_id'],
            $validatedData['categorie_id'],
            $validatedData['temps_id']
        );

        if ($mots->isEmpty()) {
            return back()->with('error', 'Aucun mot trouvé pour les critères sélectionnés.');
        }

        return view('jeu.play', compact('mots'));
    }

    /**
     * Met à jour la probabilité d'apparition d'un mot en fonction de la réaction de l'utilisateur.
     */
    public function react(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'mot_id' => 'required|integer|exists:mots,id',
            'reaction' => 'required|in:sait,ne sait pas,ne veut pas apprendre'
        ]);

        $this->jeuService->updateMotProbability($userId, $validated['mot_id'], $validated['reaction']);

        return back()->with('status', 'Réaction enregistrée.');
    }
}
