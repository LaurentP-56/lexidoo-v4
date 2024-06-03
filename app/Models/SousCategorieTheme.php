<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousCategorieTheme extends Model
{
    protected $table = 'sous_categorie_themes'; // Assurez-vous que le nom de la table correspond à votre base de données

    protected $fillable = ['nom', 'categorie_theme_id']; // Les attributs que vous pouvez assigner massivement

    /**
     * Relation avec CategorieTheme.
     */
    public function categorie()
    {
        return $this->belongsTo(CategorieTheme::class, 'categorie_theme_id');
    }
}
