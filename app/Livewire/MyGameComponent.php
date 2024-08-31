<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Level;
use App\Models\Mot;
use App\Models\ProbabilityLevel;
use App\Models\SubCategory;
use App\Models\Theme;
use App\Models\User;
use App\Models\UserWordProbability;
use Livewire\Component;

class MyGameComponent extends Component
{

    public $levelId       = null;
    public $themeId       = null;
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

    public $finalWords         = null;
    public $currentWord        = null;
    public $currentWordId      = 0;
    public $currentTranslation = null;
    public $showAnswer         = false;
    public $allMots            = null;

    public $knowLevel     = null;
    public $dontKnowLevel = null;

    /**
     * Mount the component.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function mount()
    {
        $this->step          = 1;
        $this->userId        = auth()->user()->id;
        $this->isPremium     = (bool) auth()->user()->premium;
        $this->levels        = Level::all();
        $probability         = ProbabilityLevel::first();
        $this->knowLevel     = $probability->know;
        $this->dontKnowLevel = $probability->dont_know;

        $this->themes = Theme::whereHas('mots', function ($query) {
            $query->where('levels', 'like', '%' . $this->levelId . '%');
        })->pluck('name', 'id')->all();

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
        } else if ($stepName == 'temps') {
            $this->tempsOption = $optionId;
        } elseif ($stepName == 'theme') {
            $this->themeId  = $optionId;
            $this->category = [];
            // get distinct categories from mots table based on theme_id
            $this->categories = Category::whereHas('mots', function ($query) {
                $query->where('theme_id', $this->themeId)
                    ->where('levels', 'like', '%' . $this->levelId . '%');
            })->pluck('name', 'id')->all();
        } elseif ($stepName == 'category') {
            $this->categoryId    = $optionId;
            $this->subCategories = SubCategory::wherehas('mots', function ($query) {
                $query->where('theme_id', $this->themeId)
                    ->where('category_id', $this->categoryId)
                    ->where('levels', 'like', '%' . $this->levelId . '%');
            })->pluck('name', 'id')->all();
        } else if ($stepName == 'subCategory') {
            $this->subCategoryId = $optionId;
            $this->fetchWords();
        }

        if ($this->step != 6) {
            $this->step++;
        }
    }

    /**
     * Fetch words.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function fetchWords()
    {
        $this->allMots = $this->finalWords = [];

        if ($this->levelId != '' && $this->themeId != '' && $this->categoryId != '') {

            $levelId       = $this->levelId;
            $themeId       = $this->themeId;
            $categoryId    = $this->categoryId;
            $subCategoryId = ($this->subCategoryId == '') ? 0 : $this->subCategoryId;
            $tempsId       = $this->tempsOption;

            $motBySubCategories = Mot::select("id", "nom", "traduction")
                ->where('theme_id', $themeId)
                ->where('category_id', $categoryId)
                ->where('levels', 'like', '%' . $levelId . '%');
            if ($subCategoryId != 0) {
                $motBySubCategories->where('sub_category_id', $subCategoryId);
            }

            if ($motBySubCategories->count() > 0) {
                $firstResult  = clone $motBySubCategories;
                $secondResult = clone $motBySubCategories;

                $this->allMots = $firstResult->pluck('id', 'id')->all();
                $finalWords    = $secondResult->get()->toArray();

                foreach ($finalWords as $key => $value) {
                    $this->finalWords[$value['id']] = $value;
                }

                $this->getCurrentWord();
            }
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

    public function backToStep($step)
    {
        $this->step = $step;
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
            $currentProbability                             = 50;
            $userWordProbability                            = new UserWordProbability();
            $userWordProbability->user_id                   = $this->userId;
            $userWordProbability->mot_id                    = $this->currentWordId;
            $userWordProbability->probability_of_appearance = $currentProbability;
            $userWordProbability->know_level                = $this->knowLevel;
            $userWordProbability->dont_know_level           = $this->dontKnowLevel;
            if ($reaction == 'know') {
                // Decreases the probability of the word appearing by $this->knowlevel %, down to a minimum of 1%.
                // find the $this->knowlevel % of the current probability
                $newProbability = $currentProbability - ($currentProbability * $this->knowLevel / 100);
            } elseif ($reaction == 'dont_know') {
                // Increases the probability of the word appearing to $this->dontKnowLevel %.
                $newProbability = $currentProbability + ($currentProbability * $this->dontKnowLevel / 100);
            } else if ($reaction == 'dont_want_to_learn') {
                $newProbability = 0;
            }

            $userWordProbability->probability_of_appearance = $newProbability;
            $userWordProbability->updated_at                = now();
            $userWordProbability->save();
        }

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
        $randId = array_rand($this->allMots, 1);
        if (isset($this->finalWords[$randId])) {
            $final                    = $this->finalWords[$randId];
            $this->currentWord        = $final['nom'];
            $this->currentTranslation = $final['traduction'];
            $this->currentWordId      = $final['id'];
            unset($this->finalWords[$randId]);
        }
    }

    /**
     * Gérer la fin du jeu
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function finalWord($themeId)
    {
        $finalWords = Mot::select("id", "nom", "traduction")
            ->where('theme_id', $themeId)
            ->get()
            ->toArray();
        foreach ($finalWords as $key => $value) {
            $this->finalWords[$value['id']] = $value;
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
