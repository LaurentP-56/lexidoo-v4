<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProbabilityLevel extends Model
{
    protected $table    = 'probability_levels'; // Nom de la table
    protected $fillable = ['*']; // Les champs qui peuvent être remplis
}
