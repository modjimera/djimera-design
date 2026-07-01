<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('nom')->after('id');
            $table->string('telephone')->nullable()->after('nom');
            $table->string('whatsapp')->nullable()->after('telephone');
            $table->string('adresse')->nullable()->after('whatsapp');
            $table->text('preferences_style')->nullable()->after('adresse');
            $table->text('notes')->nullable()->after('preferences_style');
            $table->decimal('solde', 12, 2)->default(0)->after('notes');
            $table->date('rappel_at')->nullable()->after('solde');
        });

        Schema::create('client_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->decimal('tour_poitrine', 8, 2)->nullable();
            $table->decimal('tour_taille', 8, 2)->nullable();
            $table->decimal('tour_hanches', 8, 2)->nullable();
            $table->decimal('longueur_robe', 8, 2)->nullable();
            $table->decimal('longueur_manche', 8, 2)->nullable();
            $table->decimal('epaule', 8, 2)->nullable();
            $table->decimal('tour_bras', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('modeles', function (Blueprint $table) {
            $table->string('nom')->after('id');
            $table->string('categorie')->nullable()->after('nom');
            $table->text('description')->nullable()->after('categorie');
            $table->string('tissu_recommande')->nullable()->after('description');
            $table->decimal('prix_indicatif', 12, 2)->default(0)->after('tissu_recommande');
            $table->unsignedInteger('temps_estime_heures')->nullable()->after('prix_indicatif');
            $table->string('niveau_difficulte')->default('moyen')->after('temps_estime_heures');
            $table->boolean('favori')->default(false)->after('niveau_difficulte');
            $table->string('photo_path')->nullable()->after('favori');
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignId('client_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('modele_id')->nullable()->after('client_id')->constrained('modeles')->nullOnDelete();
            $table->string('numero')->unique()->after('modele_id');
            $table->string('modele_demande')->nullable()->after('numero');
            $table->string('type_tenue')->nullable()->after('modele_demande');
            $table->string('tissu_utilise')->nullable()->after('type_tenue');
            $table->decimal('prix_convenu', 12, 2)->default(0)->after('tissu_utilise');
            $table->decimal('avance_versee', 12, 2)->default(0)->after('prix_convenu');
            $table->date('date_commande')->nullable()->after('avance_versee');
            $table->date('date_livraison_prevue')->nullable()->after('date_commande');
            $table->string('statut')->default('Nouvelle commande')->after('date_livraison_prevue');
            $table->text('notes')->nullable()->after('statut');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
            $table->string('libelle');
            $table->unsignedInteger('quantite')->default(1);
            $table->decimal('prix_unitaire', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->foreignId('commande_id')->nullable()->after('id')->constrained('commandes')->nullOnDelete();
            $table->foreignId('client_id')->after('commande_id')->constrained()->cascadeOnDelete();
            $table->string('numero')->unique()->after('client_id');
            $table->string('type')->default('definitive')->after('numero');
            $table->decimal('montant_total', 12, 2)->default(0)->after('type');
            $table->decimal('montant_paye', 12, 2)->default(0)->after('montant_total');
            $table->string('statut')->default('impayee')->after('montant_paye');
            $table->date('date_facture')->nullable()->after('statut');
            $table->date('date_echeance')->nullable()->after('date_facture');
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->foreignId('client_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('commande_id')->nullable()->after('client_id')->constrained('commandes')->nullOnDelete();
            $table->foreignId('facture_id')->nullable()->after('commande_id')->constrained('factures')->nullOnDelete();
            $table->decimal('montant', 12, 2)->default(0)->after('facture_id');
            $table->string('type')->default('avance')->after('montant');
            $table->string('moyen')->default('especes')->after('type');
            $table->date('date_paiement')->nullable()->after('moyen');
            $table->text('notes')->nullable()->after('date_paiement');
        });

        Schema::table('depenses', function (Blueprint $table) {
            $table->string('libelle')->after('id');
            $table->string('categorie')->default('charges diverses')->after('libelle');
            $table->decimal('montant', 12, 2)->default(0)->after('categorie');
            $table->string('moyen')->default('especes')->after('montant');
            $table->date('date_depense')->nullable()->after('moyen');
            $table->text('notes')->nullable()->after('date_depense');
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->string('nom')->after('id');
            $table->string('categorie')->default('tissu')->after('nom');
            $table->string('unite')->default('metre')->after('categorie');
            $table->decimal('quantite', 12, 2)->default(0)->after('unite');
            $table->decimal('seuil_alerte', 12, 2)->default(0)->after('quantite');
            $table->decimal('prix_unitaire', 12, 2)->default(0)->after('seuil_alerte');
            $table->string('fournisseur')->nullable()->after('prix_unitaire');
            $table->text('notes')->nullable()->after('fournisseur');
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->decimal('quantite', 12, 2);
            $table->string('motif')->nullable();
            $table->date('date_mouvement')->nullable();
            $table->timestamps();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('role');
            $table->string('telephone')->nullable();
            $table->decimal('tarif', 12, 2)->default(0);
            $table->string('statut')->default('actif');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->nullable()->constrained('commandes')->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('titre');
            $table->string('statut')->default('a faire');
            $table->date('date_echeance')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('client_measurements');
    }
};
