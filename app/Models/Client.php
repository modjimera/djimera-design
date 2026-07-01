<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'telephone',
        'whatsapp',
        'email',
        'date_naissance',
        'genre',
        'adresse',
        'profession',
        'source',
        'taille_habit',
        'morphologie',
        'preferences_style',
        'couleurs_favorites',
        'tissus_preferes',
        'allergies_tissus',
        'instructions_livraison',
        'notes',
        'solde',
        'rappel_at',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'solde' => 'decimal:2',
            'rappel_at' => 'date',
        ];
    }

    public function measurement(): HasOne
    {
        return $this->hasOne(ClientMeasurement::class);
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }

    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }
}
