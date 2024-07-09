<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Level;
use App\Models\Mot;
use App\Models\SousCategory;
use App\Models\Theme;
use App\Models\User;
use App\Models\UserWordProbability;
use Illuminate\Support\Facades\DB;

class JeuService
{
    /**
     * Initialise le jeu
     *
     * @param [type] $userId
     * @return void
     * @author Bhavesh Vyas
     */
    public function initializeGame($userId)
    {
        $user      = User::find($userId);
        $isPremium = (bool) $user->premium; // Convertissez en booléen si nécessaire

        // Récupérez les données nécessaires de la base de données ou de votre logique d'application
        $levels         = Level::all();
        $themes         = Theme::whereNull('parent_id')->get();
        $sousThemes     = Theme::whereNotNull('parent_id')->get();
        $categories     = Category::all();
        $sousCategories = SousCategory::all();
        $mots           = Mot::pluck('nom', 'id')->all();
        $motThemes      = [];
        $motThemeData   = DB::table('mot_theme')->get();
        foreach ($motThemeData as $key => $value) {
            if (isset($mots[$value->mot_id])) {
                $motThemes[$value->theme_id][$value->mot_id] = $mots[$value->mot_id];
            }
        }
        $motSousCategoryData = DB::table('mot_sous_categorie_theme')->get();
        foreach ($motSousCategoryData as $key => $value) {
            if (isset($mots[$value->mot_id])) {
                $motSousCategoryThemes[$value->sous_categorie_theme_id][$value->mot_id] = $mots[$value->mot_id];
            }
        }
        $tempsOptions = [
            ['id' => 1, 'duree' => '3 Minutes', 'description' => '3 minutes par jour, c’est mieux que rien !'],
            ['id' => 2, 'duree' => '5 Minutes', 'description' => 'Idéal pour une petite pause !'],
            ['id' => 3, 'duree' => '10 Minutes', 'description' => 'Parfait pour un bon entraînement !'],
        ];

        // Retourne un tableau associatif contenant toutes les données nécessaires à la vue
        return [
            'isPremium'      => $isPremium,
            'levels'         => $levels,
            'themes'         => $themes,
            'sousThemes'     => $sousThemes,
            'categories'     => $categories,
            'sousCategories' => $sousCategories,
            'tempsOptions'   => $tempsOptions,
        ];
    }

    /**
     * Gère la soumission du formulaire de jeu et la sélection des mots.
     *
     * @param [type] $userId
     * @param [type] $levelId
     * @param [type] $themeId
     * @param [type] $sousThemeId
     * @param [type] $categorieId
     * @param [type] $tempsId
     * @return void
     * @author Bhavesh Vyas
     */
    public function selectMots($userId, $levelId, $themeId = null, $sousThemeId = null, $categorieId = null, $sousCategoriesId = null, $tempsId = null)
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

    /**
     * Mettre à jour la probabilité d'apparition d'un mot
     *
     * @param [type] $userId
     * @param [type] $motId
     * @param [type] $reaction
     * @return void
     * @author Bhavesh Vyas
     */
    public function updateMotProbability($userId, $motId, $reaction)
    {
        // Trouver ou créer la probabilité du mot pour cet utilisateur
        $probability = UserWordProbability::firstOrNew([
            'user_id' => $userId,
            'mot_id'  => $motId,
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

    /**
     * Détermine si l'utilisateur est premium
     *
     * @param int $userId
     * @return boolean
     * @author Bhavesh Vyas
     */
    protected function isUserPremium(int $userId)
    {
        // Implémentez la logique pour déterminer si l'utilisateur est premium
        $user = User::find($userId);
        return $user && $user->isPremiumActive();
    }
}
