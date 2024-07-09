<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieTheme extends Model
{
    protected $table    = 'categories'; // Assurez-vous que le nom de la table correspond à votre base de données
    protected $fillable = ['nom', 'theme_id']; // Les attributs que vous pouvez assigner massivement

    /**
     * Relation avec Theme.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    /**
     * Relation avec SousCategorieTheme.
     */
    public function sousCategories()
    {
        return $this->hasMany(SousCategorieTheme::class, 'categorie_theme_id');
    }
}
