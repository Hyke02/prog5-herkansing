<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>home</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif
</head>
<body>
    <nav></nav>
    <div class="container">
        <h1>Edit Post</h1>

        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                       class="border-gray-300 rounded w-full"
                       required>
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="text" class="block text-gray-700 font-bold mb-2">Content</label>
                <textarea id="text" name="text" rows="5"
                          class="border-gray-300 rounded w-full"
                          required>{{ old('text', $post->text) }}</textarea>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Thumbnail</label>
                <input type="file" id="image" name="image"
                       accept="image/*"
                       class="border-gray-300 rounded">
                @if ($post->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current Thumbnail" width="100">
                    </div>
                @endif
            </div>

            <!-- Species -->
            <div class="mb-4">
                <label for="species" class="block text-gray-700 font-bold mb-2">Species</label>
                <select id="species" name="species[]"
                        class="border-gray-300 rounded w-full"
                        multiple>
                    @foreach($species as $s)
                        <option value="{{ $s->id }}"
                            {{ in_array($s->id, old('species', $post->species->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</body>
</html>
