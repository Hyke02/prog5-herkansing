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
        <h1>Create a New Post</h1>

        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" id="title" name="title" class="border-gray-300 rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="text" class="block text-gray-700 font-bold mb-2">Content</label>
                <textarea id="text" name="text" rows="5" class="border-gray-300 rounded w-full" required></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Thumbnail</label>
                <input type="file" id="image" name="image" accept="image/*" class="border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="species" class="block text-gray-700 font-bold mb-2">Species</label>
                <select id="species" name="species[]" class="border-gray-300 rounded w-full" multiple>
                    @foreach($species as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                    Create Post
                </button>
            </div>
        </form>
    </div>
</body>
</html>
