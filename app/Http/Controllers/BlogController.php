<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\FormPostRequest;
use App\Http\Requests\UpdatePostRequest; // Assurez-vous d'avoir cette requête pour la mise à jour
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function create(): View
    {
        $post = new Post();
        return view('blog.create', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags' =>Tag::select('id', 'name')->get()
        ]);

    }

    public function store(CreatePostRequest $request): RedirectResponse
    {

        // Utilisez validated() pour obtenir les données validées
        $post = Post::create($this->extractData(new Post(), $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post): View
    {
        return view('blog.edit', [
            'post' => $post,
            'categories' =>Category::select('id', 'name')->get(),
            'tags' =>Tag::select('id', 'name')->get()
        ]);
    }

    public function update( Post $post, FormPostRequest $request)
    {
       $post->update($this->extractData($post, $request));
        $post->tags()->sync($request->validated('tags'));

        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été modifié");
    }


    private function extractData(Post $post, FormPostRequest $request): array
    {
        $data = $request->validated();
        /** @var UploadedFile|null $image */

        $image = $request->validated('image');

        if ($image == null || $image->getError()) {
            return $data;
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $data['image'] = $image->store('blog', 'public');

        return $data;
    }


    public function index(): View
    {
        //Pour créer un utilisateur
       /* User::create([
            'name'=> 'jordan',
            'email' => 'jordan@doe.fr',
            'password' => Hash::make('0000')
        ]);*/

        /*Category::create([
            'name' => 'Catégorie 1'
        ]);

        Category::create([
            'name' => 'Catégorie 2'
        ]);*/

        /*$post = Post::find(2);
        $post->category_id = 2;
        $post->save();*/

        /*$post->tags()->createMany([[
            'name' => 'Tag 1'
        ], [
            'name' => 'Tag 2'
        ]]);*/

        return view('blog.index', [
            'posts' => Post::with('tags', 'category')->paginate(8)
        ]);
    }


    public function show(string $slug, Post $post): RedirectResponse | View
    {
        // Vérifiez si le slug est différent
        if ($post->slug !== $slug) {
            // Utilisez $post->slug pour l'accès correct
            return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id]);
        }

        return view('blog.show', [
            'post' => $post
        ]);
    }
}
