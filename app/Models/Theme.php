<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes';
    protected $fillable = ['nom', 'parent_id']; // 'parent_id' pour gérer la relation parent/enfant des thèmes/sous-thèmes

    /**
     * Relation pour obtenir les sous-thèmes d'un thème.
     */
    public function sousThemes()
    {
        return $this->hasMany(Theme::class, 'parent_id');
    }

    /**
     * Relation pour obtenir le thème parent d'un sous-thème.
     */
    public function parent()
    {
        return $this->belongsTo(Theme::class, 'parent_id');
    }
    public function mots()
    {
        // Assurez-vous que la clé étrangère et la clé locale sont correctement spécifiées si elles diffèrent des conventions par défaut de Laravel
        return $this->hasMany(Mot::class, 'theme_id');
    }
}
