<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        // Ajout de la colonne 'image' à la table 'posts'
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image')->nullable(); // Colonne pour stocker le chemin d'accès aux images associées aux articles (peut être NULL)
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        // Suppression de la colonne 'image' de la table 'posts'
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image'); // Suppression de la colonne 'image'
        });
    }
};
