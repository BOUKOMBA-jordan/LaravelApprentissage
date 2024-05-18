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
        // Création de la table 'categories' pour stocker les catégories des articles de blog
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la catégorie
            $table->string('name'); // Nom de la catégorie
            $table->timestamps(); // Horodatages de création et de mise à jour
        });

        // Ajout d'une clé étrangère à la table 'posts' pour référencer les catégories
        Schema::table('posts', function(Blueprint $table) {
            $table->foreignIdFor(\App\Models\Category::class) // Clé étrangère vers la table 'categories'
                  ->nullable() // Permet de laisser la colonne vide (NULL)
                  ->constrained() // Contrainte de clé étrangère
                  ->cascadeOnDelete(); // Cascade de suppression : supprime les articles associés lorsqu'une catégorie est supprimée
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        // Suppression de la table 'categories'
        Schema::dropIfExists('categories');

        // Suppression de la clé étrangère de la table 'posts'
        Schema::table('posts', function(Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Category::class);
        });
    }
};

