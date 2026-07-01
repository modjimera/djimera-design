<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = [
        'libelle',
        'categorie',
        'montant',
        'moyen',
        'date_depense',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'date_depense' => 'date',
        ];
    }
}
