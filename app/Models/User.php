<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés massivement.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'tel',
        'adresse',
        'ville',
        'pays',
        'premium',
        'offre_premium',
        'finDuPremium',
        'image',
        'provider',
        'provider_id',
        'password',
        'isAdmin',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'finDuPremium'      => 'datetime', // Assurez-vous que finDuPremium est traité comme datetime
    ];

    /**
     * Détermine si l'utilisateur est premium.
     *
     * @return bool
     */
    public function isPremium()
    {
        // Assumer que 'premium' est un attribut booléen (1 pour premium, 0 sinon)
        return (bool) $this->premium;
    }

    /**
     * Détermine si le statut premium de l'utilisateur est actif.
     *
     * @return bool
     */
    public function isPremiumActive()
    {
        // Supposons que vous utilisiez 'finDuPremium' pour déterminer si le statut premium est encore actif.
        // Cette méthode vérifie si 'finDuPremium' est dans le futur.
        return $this->finDuPremium instanceof \Carbon\Carbon  && $this->finDuPremium->isFuture();
    }
}
