<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\Modele;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $client = Client::query()->updateOrCreate([
            'telephone' => '+221 77 123 45 67',
        ], [
            'nom' => 'Aminata Diop',
            'whatsapp' => '+221 77 123 45 67',
            'email' => 'aminata.diop@example.com',
            'date_naissance' => '1992-04-18',
            'genre' => 'Femme',
            'adresse' => 'Sacré-Cœur 3, Dakar',
            'profession' => 'Entrepreneure',
            'source' => 'Instagram',
            'taille_habit' => 'M',
            'morphologie' => 'Silhouette A',
            'preferences_style' => 'Chic, glamour, coupe cintrée, finitions dorées',
            'couleurs_favorites' => 'Bordeaux, or, beige',
            'tissus_preferes' => 'Bazin riche, dentelle, voile',
            'allergies_tissus' => 'Aucune',
            'instructions_livraison' => 'Livraison à domicile après appel WhatsApp',
            'notes' => 'Cliente VIP, préfère les tenues de cérémonie sobres.',
            'solde' => 35000,
            'rappel_at' => now()->addDays(3)->toDateString(),
        ]);

        $client->measurement()->updateOrCreate([
            'client_id' => $client->id,
        ], [
            'tour_cou' => 36,
            'tour_poitrine' => 92,
            'tour_taille' => 74,
            'tour_hanches' => 102,
            'epaule' => 40,
            'carrure_dos' => 38,
            'longueur_buste' => 43,
            'longueur_robe' => 150,
            'longueur_jupe' => 105,
            'longueur_boubou' => 145,
            'longueur_pantalon' => 108,
            'entrejambe' => 78,
            'longueur_manche' => 58,
            'tour_bras' => 30,
            'tour_emmanchure' => 44,
            'tour_poignet' => 17,
            'tour_cuisse' => 58,
            'tour_genou' => 40,
            'tour_cheville' => 24,
            'hauteur_talon' => 8,
            'mesure_at' => now()->subDays(2)->toDateString(),
            'prise_par' => 'Styliste Djiméra',
            'notes' => 'Prévoir aisance légère au niveau des hanches.',
        ]);

        $modele = Modele::query()->updateOrCreate([
            'nom' => 'Robe Sirène Chic & Glam',
        ], [
            'categorie' => 'Cérémonie',
            'description' => 'Robe longue cintrée avec détails brodés et finition dorée.',
            'tissu_recommande' => 'Bazin riche avec dentelle brodée',
            'prix_indicatif' => 185000,
            'temps_estime_heures' => 18,
            'niveau_difficulte' => 'Avancé',
            'favori' => true,
        ]);

        $commande = Commande::query()->updateOrCreate([
            'numero' => 'CMD-2026-0001',
        ], [
            'client_id' => $client->id,
            'modele_id' => $modele->id,
            'modele_demande' => 'Robe sirène bordeaux avec broderie dorée',
            'type_tenue' => 'Cérémonie',
            'tissu_utilise' => 'Bazin riche, dentelle brodée, voile',
            'prix_convenu' => 185000,
            'avance_versee' => 150000,
            'date_commande' => now()->subDays(2)->toDateString(),
            'date_livraison_prevue' => now()->addDays(10)->toDateString(),
            'statut' => 'En couture',
            'notes' => 'Essayage prévu dans 5 jours. Ajouter une doublure confortable.',
        ]);

        $facture = Facture::query()->updateOrCreate([
            'numero' => 'FAC-2026-0001',
        ], [
            'commande_id' => $commande->id,
            'client_id' => $client->id,
            'type' => 'Facture définitive',
            'montant_total' => 185000,
            'montant_paye' => 150000,
            'statut' => 'Partiel',
            'date_facture' => now()->subDays(2)->toDateString(),
            'date_echeance' => now()->addDays(10)->toDateString(),
        ]);

        Paiement::query()->updateOrCreate([
            'facture_id' => $facture->id,
            'type' => 'Avance',
        ], [
            'client_id' => $client->id,
            'commande_id' => $commande->id,
            'montant' => 150000,
            'moyen' => 'Wave',
            'date_paiement' => now()->subDays(2)->toDateString(),
            'notes' => 'Avance reçue à la commande.',
        ]);
    }
}
