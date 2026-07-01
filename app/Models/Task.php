<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'commande_id',
        'staff_id',
        'titre',
        'statut',
        'date_echeance',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_echeance' => 'date',
        ];
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
