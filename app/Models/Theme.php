<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';

    protected $fillable = ['nom', 'parent_id']; // 'parent_id' pour gérer la relation parent/enfant des thèmes/sous-thèmes

    public function mots()
    {
        return $this->hasMany(Mot::class, 'theme_id');
    }
}
