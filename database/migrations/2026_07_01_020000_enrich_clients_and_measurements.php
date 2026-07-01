<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('email')->nullable()->after('whatsapp');
            $table->date('date_naissance')->nullable()->after('email');
            $table->string('genre')->nullable()->after('date_naissance');
            $table->string('profession')->nullable()->after('adresse');
            $table->string('source')->nullable()->after('profession');
            $table->string('taille_habit')->nullable()->after('source');
            $table->string('morphologie')->nullable()->after('taille_habit');
            $table->text('couleurs_favorites')->nullable()->after('preferences_style');
            $table->text('tissus_preferes')->nullable()->after('couleurs_favorites');
            $table->text('allergies_tissus')->nullable()->after('tissus_preferes');
            $table->text('instructions_livraison')->nullable()->after('allergies_tissus');
        });

        Schema::table('client_measurements', function (Blueprint $table) {
            $table->decimal('tour_cou', 8, 2)->nullable()->after('client_id');
            $table->decimal('carrure_dos', 8, 2)->nullable()->after('epaule');
            $table->decimal('longueur_buste', 8, 2)->nullable()->after('carrure_dos');
            $table->decimal('tour_emmanchure', 8, 2)->nullable()->after('tour_bras');
            $table->decimal('tour_poignet', 8, 2)->nullable()->after('tour_emmanchure');
            $table->decimal('longueur_jupe', 8, 2)->nullable()->after('longueur_robe');
            $table->decimal('longueur_boubou', 8, 2)->nullable()->after('longueur_jupe');
            $table->decimal('longueur_pantalon', 8, 2)->nullable()->after('longueur_boubou');
            $table->decimal('entrejambe', 8, 2)->nullable()->after('longueur_pantalon');
            $table->decimal('tour_cuisse', 8, 2)->nullable()->after('entrejambe');
            $table->decimal('tour_genou', 8, 2)->nullable()->after('tour_cuisse');
            $table->decimal('tour_cheville', 8, 2)->nullable()->after('tour_genou');
            $table->decimal('hauteur_talon', 8, 2)->nullable()->after('tour_cheville');
            $table->date('mesure_at')->nullable()->after('hauteur_talon');
            $table->string('prise_par')->nullable()->after('mesure_at');
        });
    }

    public function down(): void
    {
        Schema::table('client_measurements', function (Blueprint $table) {
            $table->dropColumn([
                'tour_cou',
                'carrure_dos',
                'longueur_buste',
                'tour_emmanchure',
                'tour_poignet',
                'longueur_jupe',
                'longueur_boubou',
                'longueur_pantalon',
                'entrejambe',
                'tour_cuisse',
                'tour_genou',
                'tour_cheville',
                'hauteur_talon',
                'mesure_at',
                'prise_par',
            ]);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'date_naissance',
                'genre',
                'profession',
                'source',
                'taille_habit',
                'morphologie',
                'couleurs_favorites',
                'tissus_preferes',
                'allergies_tissus',
                'instructions_livraison',
            ]);
        });
    }
};
