<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Level;
use App\Models\SubCategory;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    protected $fillable = [
        'nom',
        'commentaire',
        'gratuit',
        'probability_of_appearance',
        'level_id',
        'theme_id',
        'category_id',
        'sub_category_id',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
