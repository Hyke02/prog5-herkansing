<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($posts as $post)
                    <div class="post">
                        <h2>{{ $post->title }}</h2>
                        <p>{{ $post->text }}</p>

                        <form method="POST" action="{{ route('post.toggle', $post->id) }}" class="inline-block">
                            @csrf
                            <label for="toggleStatus">
                                <input type="checkbox" name="is_active" id="toggleStatus"
                                       class="toggle-status" data-id="{{ $post->id }}"
                                       {{ $post->is_active ? 'checked' : '' }}
                                       onclick="this.form.submit()"> Toggle Status
                            </label>
                        </form>

                        <p>Species:
                            @foreach($post->species as $species)
                                {{ $species->name }},
                            @endforeach
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
