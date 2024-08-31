<?php

namespace App\Models;

use App\Http\Controllers\GoogleTextToSpeechController;
use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    // Les champs qui peuvent être remplis en masse
    protected $fillable = [
        'nom',
        'commentaire',
        'gratuit',
        'probability_of_appearance',
        'level_id',
        'theme_id',
        'category_id',
        'sub_category_id',
        'audioblob',
    ];

    // Boot method pour ajouter le comportement personnalisé après la sauvegarde
    public static function boot()
    {
        parent::boot();

        // Lorsqu'un mot est sauvegardé, générer l'audio s'il n'existe pas
        self::saved(function ($model) {
            // Vérifier si le champ audioblob est vide
            if (is_null($model->audioblob)) {
                $gttsCtrl = new GoogleTextToSpeechController();
                $audio = $gttsCtrl->generateAudioOfString($model->traduction);
                
                // Si l'audio est généré, le stocker dans le champ audioblob
                if ($audio) {
                    $model->audioblob = $audio;
                    $model->saveQuietly(); // Sauvegarde sans déclencher à nouveau l'événement saved
                }
            }
        });
    }

    // Relation avec le modèle Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relation avec le modèle Theme
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // Relation avec le modèle Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation avec le modèle SubCategory
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Accesseur pour encoder l'audio en base64 lorsque l'on accède au champ audioblob
    public function getAudioblobAttribute($audioblob)
    {
        return base64_encode($audioblob);
    }
}
