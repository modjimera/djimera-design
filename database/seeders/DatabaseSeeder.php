<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->updateOrCreate([
            'email' => 'admin@djimera-design.com',
        ], [
            'name' => 'Administrateur Djimera',
            'role' => 'Administrateur',
            'telephone' => '+221 77 000 00 00',
            'statut' => 'Actif',
            'password' => Hash::make('password'),
        ]);
    }
}
