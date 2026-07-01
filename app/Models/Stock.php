<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    protected $fillable = [
        'nom',
        'categorie',
        'unite',
        'quantite',
        'seuil_alerte',
        'prix_unitaire',
        'fournisseur',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantite' => 'decimal:2',
            'seuil_alerte' => 'decimal:2',
            'prix_unitaire' => 'decimal:2',
        ];
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getEstFaibleAttribute(): bool
    {
        return (float) $this->quantite <= (float) $this->seuil_alerte;
    }
}
