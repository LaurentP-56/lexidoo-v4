<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Mot;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories'; // Assurez-vous que le nom de la table correspond à votre base de données

    protected $fillable = ['name', 'theme_id', 'category_id']; // Les attributs que vous pouvez assigner massivement

    /**
     * Relation avec Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec Theme.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Relation avec Mot.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function mots()
    {
        return $this->hasMany(Mot::class);
    }
}
