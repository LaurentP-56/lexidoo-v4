<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Mot;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';

    protected $fillable = ['name']; // 'parent_id' pour gérer la relation parent/enfant des thèmes/sous-thèmes

    /**
     * Relation avec Category.
     *
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Relation avec SubCategory.
     *
     * @return void
     * @author Bhavesh Vyas
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
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
