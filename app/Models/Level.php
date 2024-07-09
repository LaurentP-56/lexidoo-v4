<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table    = 'levels'; // Nom de la table dans la base de données
    protected $fillable = ['label', 'sub_label', 'classe']; // Attributs qui sont mass assignable
    public $timestamps  = false; // Désactiver les timestamps
}
