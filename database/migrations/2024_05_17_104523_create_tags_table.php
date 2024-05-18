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
        // Création de la table 'tags' pour stocker les tags des articles de blog
        Schema::create('tags', function (Blueprint $table) {
            $table->id(); // Identifiant unique du tag
            $table->string('name'); // Nom du tag
            $table->timestamps(); // Horodatages de création et de mise à jour
        });

        // Création de la table pivot 'post_tag' pour gérer la relation many-to-many entre les articles et les tags
        Schema::create('post_tag', function (Blueprint $table) {
            // Clé étrangère pour l'identifiant de l'article dans la table 'posts'
            $table->foreignIdFor(\App\Models\Post::class)->constrained()->cascadeOnDelete();
            // Clé étrangère pour l'identifiant du tag dans la table 'tags'
            $table->foreignIdFor(\App\Models\Tag::class)->constrained()->cascadeOnDelete();
            // Clé primaire composite pour les colonnes 'post_id' et 'tag_id'
            $table->primary(['post_id', 'tag_id']);
        });
    }

    /**
     * Annuler les migrations.
     */
    public function down(): void
    {
        // Suppression de la table pivot 'post_tag'
        Schema::dropIfExists('post_tag');
        // Suppression de la table 'tags'
        Schema::dropIfExists('tags');
    }
};
