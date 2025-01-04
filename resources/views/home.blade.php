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
    <div class="flex">
        <div class="filter-window flex justify-center p-4 bg-[#0E1113] border-r-2 border-gray-800 w-2/12 h-screen">
            <form class="flex flex-col items-center" method="GET" action="{{ route('home') }}">

                <div class="mb-5">
                    <x-input-label for="search" class="sr-only"></x-input-label>
                    <x-text-input class="w-full bg-[#333D42] border-none text-[#EEF1F3]" type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search posts"></x-text-input>
                </div>

                <div class="mb-5">
                    <x-input-label class="sr-only" for="species">Filter by Species:</x-input-label>
                    <select class="bg-transparent border-none text-[#EEF1F3] w-full" name="species" id="species">
                        <option value="">All Species</option>
                        @foreach($species as $speciesItem)
                            <option value="{{ $speciesItem->id }}"
                                {{ request('species') == $speciesItem->id ? 'selected' : '' }}>
                                {{ $speciesItem->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-primary-button class="mb-5" type="submit">Filter</x-primary-button>
            </form>
        </div>
        <div class="post-window flex flex-col items-center bg-[#0E1113] w-10/12 h-screen">
            @foreach($posts as $post)
                <a href="{{ route('post.show', $post->id) }}" class="w-2/4 px-6 py-4 m-4 hover:bg-gray-300 rounded">
                    <div>
                        <h2 class="text-xl font-bold text-[#EEF1F3] capitalize">{{ $post->title }}</h2>
                        <p class="text-[#EEF1F3]">{{ $post->text }}</p>
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="100">
                        @endif
                        <p>Species:
                            @foreach($post->species as $species)
                                {{ $species->name }},
                            @endforeach
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
