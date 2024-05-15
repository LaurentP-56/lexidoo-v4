<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifs extends Model
{
    // Spécifiez le nom de la table si ce n'est pas le nom par défaut
    protected $table = 'tarifs';

    // Les champs qui peuvent être assignés massivement
    protected $fillable = ['nom_offre', 'prix', 'description', 'duree'];

    // Les champs cachés dans les tableaux et les conversions JSON
    protected $hidden = [];

    // Les attributs qui doivent être castés en types natifs
    protected $casts = [
        'prix' => 'decimal:2', // Pour conserver la précision décimale
    ];

    // Les dates qui seront traitées comme des instances de Carbon
    protected $dates = ['created_at', 'updated_at'];

    // Relations avec d'autres modèles, si nécessaire
    // Par exemple, si un tarif est lié à des abonnements ou à des utilisateurs

    // public function abonnements()
    // {
    //     return $this->hasMany(Abonnement::class);
    // }

    // Méthodes supplémentaires spécifiques à votre logique métier

    // Par exemple, une méthode pour calculer une réduction
    // public function calculerReduction($pourcentage)
    // {
    //     // Logique de calcul de la réduction
    // }
}
