<form action="" method="post" class="vstack gap-2" enctype="multipart/form-data">
    @csrf

    @method($post->id ? 'PATCH' : 'POST')

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image">
        @error('image')
            {{ $message }}
        @enderror
    </div>

    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
        @error('title')
            {{ $message }}
        @enderror
    </div>

    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $post->slug) }}">
        @error('slug')
            {{ $message }}
        @enderror
    </div>

    <div class="form-group">
        <label for="content">Contenu</label>
        <textarea id="content" class="form-control" name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
            {{ $message }}
        @enderror
    </div>

    <div class="form-group">
        <label for="category">Catégorie</label>
        <select class="form-control" id="category" name="category_id">
            <option value="">Sélectionner une catégorie</option>
            @foreach ($categories as $category)
                <option @selected(old('category_id', $post->category_id) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            {{ $message }}
        @enderror
    </div>

    @php
        $tagsIds = $post->tags()->pluck('id');
    @endphp

    <div class="form-group">
        <label for="tag">Tags</label>
        <select class="form-control" id="tag" name="tags[]" multiple>
            @foreach ($tags as $tag)
                <option @selected($tagsIds->contains($tag->id)) value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        @error('tags')
            {{ $message }}
        @enderror
    </div>

    <button class="btn btn-primary">
        @if ($post->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>
