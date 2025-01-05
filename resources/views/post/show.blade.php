<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $post->title }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif
</head>
<body>
    <nav></nav>
    <div class="post-details">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->text }}</p>
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="300">
        @endif
        <p><strong>Species:</strong>
            @foreach($post->species as $species)
                {{ $species->name }}{{ !$loop->last ? ', ' : '' }}
            @endforeach
        </p>
        <a href="{{ route('home') }}">Back to Posts</a>
    </div>
    @auth($post->)
</body>
</html>
