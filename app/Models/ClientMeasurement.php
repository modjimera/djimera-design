<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMeasurement extends Model
{
    protected $fillable = [
        'client_id',
        'tour_cou',
        'tour_poitrine',
        'tour_taille',
        'tour_hanches',
        'epaule',
        'carrure_dos',
        'longueur_buste',
        'longueur_robe',
        'longueur_jupe',
        'longueur_boubou',
        'longueur_pantalon',
        'entrejambe',
        'longueur_manche',
        'tour_bras',
        'tour_emmanchure',
        'tour_poignet',
        'tour_cuisse',
        'tour_genou',
        'tour_cheville',
        'hauteur_talon',
        'mesure_at',
        'prise_par',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'mesure_at' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
