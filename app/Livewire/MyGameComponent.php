<?php

namespace App\Livewire;

use App\Models\CategorieTheme;
use App\Models\Level;
use App\Models\Mot;
use App\Models\SousCategorieTheme;
use App\Models\Theme;
use App\Models\User;
use App\Models\UserWordProbability;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyGameComponent extends Component
{

    public $levelId       = null;
    public $themeId       = null;
    public $subThemeId    = null;
    public $categoryId    = null;
    public $subCategoryId = null;
    public $tempsOption   = null;

    public $levels        = null;
    public $themes        = null;
    public $subThemes     = null;
    public $categories    = null;
    public $subCategories = null;
    public $tempsOptions  = null;
    public $isPremium     = null;
    public $jeuService    = null;
    public $userId        = null;
    public $step          = null;

    public $finalWords    = null;
    public $currentWord   = null;
    public $currentWordId = 0;
    public $showAnswer    = false;
    public $allMots       = null;

    /**
     * Mount the component.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function mount()
    {
        $this->step         = 1;
        $this->userId       = auth()->user()->id;
        $this->isPremium    = (bool) auth()->user()->premium;
        $this->levels       = Level::all();
        $this->themes       = Theme::whereNull('parent_id')->pluck('name', 'id');
        $this->categories   = CategorieTheme::pluck('nom', 'id');
        $this->tempsOptions = [
            ['id' => 1, 'duree' => '3 Minutes', 'description' => '3 minutes par jour, c’est mieux que rien !'],
            ['id' => 2, 'duree' => '5 Minutes', 'description' => 'Idéal pour une petite pause !'],
            ['id' => 3, 'duree' => '10 Minutes', 'description' => 'Parfait pour un bon entraînement !'],
        ];
    }

    /**
     * Select an option.
     *
     * @param string $stepName
     * @param string $optionId
     * @return void
     * @author Bhavesh Vyas
     */
    public function selectOption(string $stepName, string $optionId)
    {
        if ($stepName == 'level') {
            $this->levelId = $optionId;
        } elseif ($stepName == 'theme') {
            $this->themeId   = $optionId;
            $this->subThemes = Theme::whereNotNull('parent_id')->where('parent_id', $optionId)->pluck('name', 'id');
        } elseif ($stepName == 'subTheme') {
            $this->subThemeId = $optionId;
        } elseif ($stepName == 'category') {
            $this->categoryId    = $optionId;
            $this->subCategories = SousCategorieTheme::where('categorie_theme_id', $optionId)->pluck('nom', 'id');
        } elseif ($stepName == 'temps') {
            $this->tempsOption = $optionId;
        }
        $this->step++;
    }

    /**
     * Fetch words.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function fetchWords($subCategoryId)
    {
        $this->subCategoryId = $subCategoryId;

        $this->allMots = $this->finalWords = [];

        if ($this->levelId != '' && $this->themeId != '' && $this->subThemeId != '' && $this->categoryId != '' && $this->subCategoryId != '' && $this->tempsOption != '') {

            $levelId       = $this->levelId;
            $themeId       = $this->themeId;
            $subThemeId    = $this->subThemeId;
            $categoryId    = $this->categoryId;
            $subCategoryId = $this->subCategoryId;
            $tempsId       = $this->tempsOption;

            // By level
            $motByLevel = Mot::where('level', "like", "%{$levelId}%")->pluck('id')->all();

            // By sous theme
            $motBySousTheme = DB::table('mot_theme')->where('theme_id', $subThemeId)->pluck('mot_id')->all();

            // By categories
            $motByCategories = DB::table('categorie_theme_mot')->where('categorie_theme_id', $categoryId)->pluck('mot_id')->all();

            // By sous categories
            $motBySousCategories = DB::table('mot_sous_categorie_theme')->where('sous_categorie_theme_id', $subCategoryId)->pluck('mot_id')->all();

            // merge and take only unique values
            $this->allMots    = array_unique(array_merge($motByLevel, $motBySousTheme, $motByCategories, $motBySousCategories));
            $this->finalWords = Mot::select("id", "nom")->whereIn('id', $this->allMots)->pluck('nom', 'id')->all();
            $this->getCurrentWord();
            $this->step++;
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function showNewAnswer()
    {
        $this->showAnswer = true;
    }

    /**
     * Mettre à jour la probabilité d'apparition d'un mot
     *
     * @param integer $motId
     * @param string $reaction
     * @return void
     * @author Bhavesh Vyas
     */
    public function updateProbability(string $reaction)
    {
        $userWordProbability = UserWordProbability::where('user_id', $this->userId)
            ->where('mot_id', $this->currentWordId)
            ->first();

        if (!$userWordProbability) {
            // If the record does not exist, create a new one with default probability (e.g., 50%).
            $userWordProbability                            = new UserWordProbability();
            $userWordProbability->user_id                   = $this->userId;
            $userWordProbability->mot_id                    = $this->currentWordId;
            $userWordProbability->probability_of_appearance = 50; // Set initial probability
            $userWordProbability->save();
        }

        $currentProbability = $userWordProbability->probability_of_appearance;

        if ($reaction == 'knew') {
            // Decreases the probability of the word appearing by 5%, down to a minimum of 1%.
            $newProbability = max(1, $currentProbability - 5);
        } elseif ($reaction == 'didntKnow') {
            // Increases the probability of the word appearing to 90%.
            $newProbability = 90;
        } elseif ($reaction == 'dontWant') {
            // Sets the probability of the word appearing to 0.
            $newProbability = 0;
        }

        $userWordProbability->probability_of_appearance = $newProbability;
        $userWordProbability->updated_at                = now();
        $userWordProbability->save();

        $this->showAnswer = false;
        $this->getCurrentWord();
    }

    /**
     * Get the current word.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function getCurrentWord()
    {
        $randId = array_rand($this->finalWords, 1);
        if (isset($this->finalWords[$randId])) {
            $this->currentWord   = $this->finalWords[$randId];
            $this->currentWordId = $randId;
            unset($this->finalWords[$randId]);
        }
    }

    /**
     * Render the component.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function render()
    {
        return view('livewire.my-game-component')
            ->layout('layouts.app');
    }
}
