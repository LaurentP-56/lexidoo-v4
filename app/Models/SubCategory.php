<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_category'; // Assurez-vous que le nom de la table correspond à votre base de données

    protected $fillable = ['nom', 'theme_id', 'category_id']; // Les attributs que vous pouvez assigner massivement

    /**
     * Relation avec Category.
     */
    public function categorie()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relation avec Theme.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function mots()
    {
        return $this->hasMany(Mot::class, 'sub_category_id');
    }
}
