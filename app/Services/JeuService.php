<?php

namespace App\Services;

use App\Models\{Mot, Level, Theme, CategorieTheme, SousCategorieTheme, User, UserWordProbability};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JeuService
{
    public function initializeGame($userId)
    {
        $user = User::find($userId);
        $isPremium = (bool) $user->premium; // Convertissez en booléen si nécessaire

        // Récupérez les données nécessaires de la base de données ou de votre logique d'application
        $levels = Level::all();
        $themes = Theme::whereNull('parent_id')->get();
        $sousThemes = Theme::whereNotNull('parent_id')->get();
        $categories = CategorieTheme::all();
        $sousCategories = SousCategorieTheme::all();
        $tempsOptions = [
            ['id' => 1, 'duree' => '3 Minutes', 'description' => '3 minutes par jour, c’est mieux que rien !'],
            ['id' => 2, 'duree' => '5 Minutes', 'description' => 'Idéal pour une petite pause !'],
            ['id' => 3, 'duree' => '10 Minutes', 'description' => 'Parfait pour un bon entraînement !'],
        ];

        // Retourne un tableau associatif contenant toutes les données nécessaires à la vue
        return [
            'isPremium' => $isPremium,
            'levels' => $levels,
            'themes' => $themes,
            'sousThemes' => $sousThemes,
            'categories' => $categories,
            'sousCategories' => $sousCategories,
            'tempsOptions' => $tempsOptions,
        ];
    }
    public function selectMots($userId, $levelId, $themeId = null, $sousThemeId = null, $categorieId = null, $tempsId = null)
    {
        // Déterminez les critères de sélection des mots en fonction des paramètres
        // et du statut premium de l'utilisateur.
        $query = Mot::where('level_id', $levelId);

        if ($themeId) {
            $query->whereHas('themes', function ($q) use ($themeId) {
                $q->where('id', $themeId);
            });
        }

        // Répétez le processus pour sousThemes, categories, et sousCategories si applicable.

        // Prendre en compte la probabilité d'apparition pour cet utilisateur
        $query->with(['userWordProbabilities' => function ($q) use ($userId) {
            $q->where('user_id', $userId);
        }]);

        // Exemple basique de sélection de mots. Adaptez selon vos critères.
        $mots = $query->get();

        // Filtrer en fonction de la probabilité d'apparition si nécessaire
        // et retourner la sélection finale des mots
        return $mots;
    }

    public function updateMotProbability($userId, $motId, $reaction)
    {
        // Trouver ou créer la probabilité du mot pour cet utilisateur
        $probability = UserWordProbability::firstOrNew([
            'user_id' => $userId,
            'mot_id' => $motId,
        ]);

        // Ajuster la probabilité en fonction de la réaction
        switch ($reaction) {
            case 'sait':
                $probability->probability_of_appearance -= 5;
                break;
            case 'ne sait pas':
                $probability->probability_of_appearance = 90;
                break;
            case 'ne veut pas apprendre':
                $probability->probability_of_appearance = 0;
                break;
        }

        // S'assurer que la probabilité reste dans les limites acceptables
        $probability->probability_of_appearance = max(0, min(100, $probability->probability_of_appearance));

        $probability->save();
    }

    protected function isUserPremium($userId)
    {
        // Implémentez la logique pour déterminer si l'utilisateur est premium
        $user = User::find($userId);
        return $user && $user->isPremiumActive();
    }
}
