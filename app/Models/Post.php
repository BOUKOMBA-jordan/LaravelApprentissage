<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory;

    // Attributs du modèle autorisés à être mass assignable
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'image'
    ];

    // Relation "belongsTo" avec le modèle Category : un article de blog appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   /* public function posts();
    {
        return$this->hasMany(Post::class);
    }*/

    // Relation "belongsToMany" avec le modèle Tag : un article de blog peut avoir plusieurs tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Retourne l'URL de l'image associée à l'article
    public function imageUrl(): string
    {
        return Storage::disk('public')->url($this->image);
    }
}
