<?php

namespace App\Livewire;
use Illuminate\Support\Collection;

use App\Models\Category;
use App\Models\Level;
use App\Models\Mot;
use App\Models\ProbabilityLevel;
use App\Models\SubCategory;
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
    public $currentAudio  = null;

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

    public $knowLevel          = null;
    public $dontKnowLevel      = null;

    public $timeLeft;
    public $totalWords         = 0;
    public $knewWordClicks     = 0;
    public $didntKnowWordClicks = 0;
    public $dontWantToLearnClicks = 0;
    public $isGameRunning      = false;

	
	 //(FR) Fonction Mount, sers à vérifier si le jeu à des themes/catégories/sous-categorie/mots
	 //(EN) Mount function, used to check if the game has themes/categories/subcategories/words
	 
	 

public function mount()
{
    $this->step = 1;
    $this->userId = auth()->user()->id;
    $this->isPremium = (bool) auth()->user()->premium;
    $this->levels = Level::all();

    // Convertir le résultat de getThemes en collection
    $this->themes = collect(getThemes())->filter(function ($theme, $themeId) {
        // Vérifier s'il y a des mots directement associés à ce thème (sans catégorie ni sous-catégorie)
        $hasWordsDirect = Mot::where('theme_id', $themeId)
            ->whereNull('category_id')
            ->whereNull('sub_category_id')
            ->where('levels', 'like', '%' . $this->levelId . '%')
            ->exists();

        // Vérifier s'il y a des mots via les catégories
        $hasWordsInCategories = Category::where('theme_id', $themeId)
            ->whereHas('mots', function ($query) {
                $query->where('levels', 'like', '%' . $this->levelId . '%');
            })
            ->exists();

        // Retourner true si le thème a des mots directement ou via des catégories
        return $hasWordsDirect || $hasWordsInCategories;
    });

    $probability = ProbabilityLevel::first();
    $this->knowLevel = $probability->know;
    $this->dontKnowLevel = $probability->dont_know;

    $this->tempsOptions = [
        ['id' => 1, 'duree' => 3, 'description' => '3 minutes par jour, c’est mieux que rien !'],
        ['id' => 2, 'duree' => 5, 'description' => 'Idéal pour une petite pause !'],
        ['id' => 3, 'duree' => 10, 'description' => 'Parfait pour un bon entraînement !'],
    ];
}



 // (FR) Fonction d'initialisation du jeu avec le timer
 // (EN) Game initialization function with timer

    public function initializeGame()
    {
        $duree = $this->tempsOptions[$this->tempsOption - 1]['duree'];
        if (is_numeric($duree)) {
            $this->timeLeft = $duree * 60; // Conversion en secondes
        } else {
            $this->timeLeft = 0; // Par sécurité, définissez une valeur par défaut
        }

        $this->isGameRunning = true;
    }

    public function getFormattedTime()
    {
        if (is_numeric($this->timeLeft)) {
            $minutes = intdiv($this->timeLeft, 60);
            $seconds = $this->timeLeft % 60;
            return sprintf('%02d:%02d', $minutes, $seconds);
        } else {
            return '00:00'; // Valeur par défaut si quelque chose ne va pas
        }
    }

    public function tick()
    {
        if ($this->timeLeft > 0) {
            $this->timeLeft--;
        } else {
            $this->endGame();
        }
    }

    public function endGame()
    {
        $this->isGameRunning = false;
    }

	
	// (FR) Fonction de sélection d'option 
	// (EN) Option selection function
	
public function selectOption(string $stepName, string $optionId)
{
    if ($stepName == 'level') {
        $this->levelId = $optionId;
    } elseif ($stepName == 'temps') {
        $this->tempsOption = $optionId;
    } elseif ($stepName == 'theme') {
        $this->themeId = $optionId;

        $this->fetchWords();

        if (!empty($this->finalWords)) {
            $this->step = 6;
            $this->initializeGame();
            return;
        }

        $this->categories = Category::where('theme_id', $optionId)
            ->whereHas('mots', function ($query) {
                $query->where('levels', 'like', '%' . $this->levelId . '%');
            })
            ->pluck('name', 'id');

        if ($this->categories->isEmpty()) {
            $this->step = 6;
            return;
        }
    } elseif ($stepName == 'category') {
        $this->categoryId = $optionId;

        $this->subCategories = SubCategory::where('category_id', $optionId)
            ->whereHas('mots', function ($query) {
                $query->where('levels', 'like', '%' . $this->levelId . '%');
            })
            ->pluck('name', 'id');

        if ($this->subCategories->isEmpty()) {
            $this->fetchWords();
            if (!empty($this->finalWords)) {
                $this->step = 6;
                $this->initializeGame();
                return;
            }
        }
    } elseif ($stepName == 'subCategory') {
        $this->subCategoryId = $optionId;
        $this->fetchWords();
        if (!empty($this->finalWords)) {
            $this->initializeGame();
        } else {
            $this->step = 6;
        }
    }

    if ($this->step != 6) {
        $this->step++;
    }
}

	//(FR) Récupération de tout les mots
	//(EN) Recovery of all words


public function fetchWords()
{
    $this->allMots = $this->finalWords = [];

    if (!empty($this->levelId) && !empty($this->themeId)) {
        $query = Mot::select("id", "nom", "traduction")
            ->where('theme_id', $this->themeId)
            ->where('levels', 'like', '%' . $this->levelId . '%');

        // Ajouter des filtres de catégorie et sous-catégorie uniquement s'ils sont présents
        if (!empty($this->categoryId)) {
            $query->where('category_id', $this->categoryId);
        }

        if (!empty($this->subCategoryId)) {
            $query->where('sub_category_id', $this->subCategoryId);
        }

        $finalWords = $query->get()->toArray();

        if (!empty($finalWords)) {
            $this->allMots = array_column($finalWords, 'id');
            foreach ($finalWords as $word) {
                $this->finalWords[$word['id']] = $word;
            }
            $this->getCurrentWord();
        } else {
            $this->step = 6;
            $this->initializeGame();
        }
    }
}



	//(FR) Mot Courant
	//(EN) Common Word

public function getCurrentWord()
{
    if (!empty($this->allMots)) {
        $randId = array_rand($this->allMots, 1);
        $wordId = $this->allMots[$randId];
        
        if (isset($this->finalWords[$wordId])) {
            $final = $this->finalWords[$wordId];
            $this->currentWord = $final['nom'];
            $this->currentTranslation = $final['traduction'];
            $this->currentWordId = $final['id'];
            $this->currentAudio = $final['audioblob'] ?? null;
            unset($this->allMots[$randId]);
        }
    } else {
        // Gérer le cas où il n'y a plus de mots à afficher
        $this->endGame();
    }
}

		// (FR) Affiche la réponse + fonction retour en arrière
		// (EN) Displays the answer + backtrack function

    public function showNewAnswer()
    {
        $this->showAnswer = true;
    }

    public function backToStep($step)
    {
        $this->step = $step;
    }

	//(FR) Mise à jour des probabilitées
	//(EN) Update of probabilities
	
    public function updateProbability(string $reaction)
    {
        $userWordProbability = UserWordProbability::where('user_id', $this->userId)
            ->where('mot_id', $this->currentWordId)
            ->first();

        $currentProbability = $userWordProbability->probability_of_appearance ?? 50;

        if ($reaction == 'know') {
            $newProbability = $currentProbability - ($currentProbability * $this->knowLevel / 100);
            $this->knewWordClicks++;
        } elseif ($reaction == 'dont_know') {
            $newProbability = $currentProbability + ($currentProbability * $this->dontKnowLevel / 100);
            $this->didntKnowWordClicks++;
        } else if ($reaction == 'dont_want_to_learn') {
            $newProbability = 0;
            $this->dontWantToLearnClicks++;
        }

        if (!$userWordProbability) {
            $userWordProbability = new UserWordProbability();
            $userWordProbability->user_id = $this->userId;
            $userWordProbability->mot_id = $this->currentWordId;
            $userWordProbability->probability_of_appearance = $newProbability;
            $userWordProbability->know_level = $this->knowLevel;
            $userWordProbability->dont_know_level = $this->dontKnowLevel;
        } else {
            $userWordProbability->probability_of_appearance = $newProbability;
        }

        $userWordProbability->updated_at = now();
        $userWordProbability->save();

        $this->totalWords++;
        $this->showAnswer = false;
        $this->getCurrentWord();
    }

	//(FR) Fonction Fin du jeu
	//(EN) End of game function
	
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

    public function render()
    {
        return view('livewire.my-game-component')
            ->layout('layouts.app');
    }
}
