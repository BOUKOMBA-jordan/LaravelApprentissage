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
        // Création de la table 'posts' pour stocker les articles de blog
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'article
            $table->string('title'); // Titre de l'article
            $table->string('slug')->unique(); // Slug de l'article (unique)
            $table->longText('content'); // Contenu de l'article
            $table->timestamps(); // Horodatages de création et de mise à jour
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        // Suppression de la table 'posts' si elle existe
        Schema::dropIfExists('posts');
    }
};
