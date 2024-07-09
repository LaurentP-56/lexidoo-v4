<?php

namespace App\Models;

use App\Models\Mot;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table    = 'categories'; // Assurez-vous que le nom de la table correspond à votre base de données
    protected $fillable = ['name', 'theme_id']; // Les attributs que vous pouvez assigner massivement

    /**
     * Relation avec Theme.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    /**
     * Relation avec SousCategory.
     */
    public function sousCategories()
    {
        return $this->hasMany(SousCategory::class, 'categorie_theme_id');
    }

    public function mots()
    {
        return $this->hasMany(Mot::class, 'category_id');
    }
}
