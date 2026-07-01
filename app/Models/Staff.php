<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'nom',
        'role',
        'telephone',
        'tarif',
        'statut',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'tarif' => 'decimal:2',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
