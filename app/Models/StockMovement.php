<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'stock_id',
        'type',
        'quantite',
        'motif',
        'date_mouvement',
    ];

    protected function casts(): array
    {
        return [
            'quantite' => 'decimal:2',
            'date_mouvement' => 'date',
        ];
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
