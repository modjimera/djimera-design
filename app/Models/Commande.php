<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    public const STATUTS = [
        'Nouvelle commande',
        'En attente d\'avance',
        'En coupe',
        'En couture',
        'En broderie',
        'Essayage prévu',
        'Correction en cours',
        'Prête',
        'Livrée',
        'Annulée',
    ];

    protected $fillable = [
        'client_id',
        'modele_id',
        'numero',
        'modele_demande',
        'type_tenue',
        'tissu_utilise',
        'prix_convenu',
        'avance_versee',
        'date_commande',
        'date_livraison_prevue',
        'statut',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'prix_convenu' => 'decimal:2',
            'avance_versee' => 'decimal:2',
            'date_commande' => 'date',
            'date_livraison_prevue' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function modele(): BelongsTo
    {
        return $this->belongsTo(Modele::class);
    }

    public function facture(): HasOne
    {
        return $this->hasOne(Facture::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function getResteAPayerAttribute(): float
    {
        return max(0, (float) $this->prix_convenu - (float) $this->avance_versee);
    }
}
