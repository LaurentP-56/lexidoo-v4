<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mot extends Model
{
    protected $fillable = [
        'nom',
        'traduction',
        'audioblob',
        'gratuit',
        'probability_of_appearance',
        'level_id',
        'theme_id',
        'category_id',
        'sub_category_id',
    ];

    /**
     * Relation avec Level.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Relation avec Theme.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Relation avec Category.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec SubCategory.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
