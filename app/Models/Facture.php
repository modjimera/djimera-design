<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    protected $fillable = [
        'commande_id',
        'client_id',
        'numero',
        'type',
        'montant_total',
        'montant_paye',
        'statut',
        'date_facture',
        'date_echeance',
    ];

    protected function casts(): array
    {
        return [
            'montant_total' => 'decimal:2',
            'montant_paye' => 'decimal:2',
            'date_facture' => 'date',
            'date_echeance' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function getResteAPayerAttribute(): float
    {
        return max(0, (float) $this->montant_total - (float) $this->montant_paye);
    }
}
