<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    protected $fillable = [
        'nom',
        'traduction',
        'commentaire',
        'gratuit',
        'probability_of_appearance',
        'level_id', // Assurez-vous d'inclure 'level_id' dans le tableau $fillable si vous souhaitez assigner massivement.
    ];

    // Définir la relation avec Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Si vous avez une relation avec Theme également, assurez-vous que celle-ci est correctement définie
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    // Méthodes supplémentaires au besoin
}

