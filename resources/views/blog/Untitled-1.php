<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
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
            'tags' => Tag::select('id', 'name')->get()
        ]);
    }

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $post = Post::create($validatedData);
        if ($request->has('tags')) {
            $post->tags()->sync($validatedData['tags']);
        }
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])
            ->with('success', "L'article a bien été sauvegardé");
    }

    public function edit(Post $post): View
    {
        return view('blog.edit', [
            'post' => $post,
            'categories' => Category::select('id', 'name')->get(),
            'tags' => Tag::select('id', 'name')->get()
        ]);
    }

    public function update(Post $post, CreatePostRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $post->update($validatedData);
        if ($request->has('tags')) {
            $post->tags()->sync($validatedData['tags']);
        }
        return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id])
            ->with('success', "L'article a bien été modifié");
    }

    private function extractData(Post $post, CreatePostRequest $request): array
    {
        $data = $request->validated();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $imagePath = $request->file('image')->store('blog', 'public');
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $imagePath;
        } 
        return $data;
    }

    public function index(): View
    {
        return view('blog.index', [
            'posts' => Post::with('tags', 'category')->paginate(8)
        ]);
    }

    public function show(string $slug, Post $post): View
    {
        if ($post->slug !== $slug) {
            return redirect()->route('blog.show', ['slug' => $post->slug, 'post' => $post->id]);
        }
        return view('blog.show', [
            'post' => $post
        ]);
    }
}
