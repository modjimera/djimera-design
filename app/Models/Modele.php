<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modele extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'description',
        'tissu_recommande',
        'prix_indicatif',
        'temps_estime_heures',
        'niveau_difficulte',
        'favori',
        'photo_path',
    ];

    protected function casts(): array
    {
        return [
            'prix_indicatif' => 'decimal:2',
            'favori' => 'boolean',
        ];
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }
}
