<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Species;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $species = Species::all();
        return view('posts.create', compact('species'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'species' => 'required|array', // Ensuring species are selected
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'image' => $imagePath ?? null,
        ]);

        // Attach selected species to the post
        $post->species()->attach($validated['species']);

        return redirect()->route('posts.index');
    }

    public function index(Request $request)
    {
        $posts = Post::with('species');

        if ($request->has('species')) {
            $posts = $posts->whereHas('species', function($query) use ($request) {
                $query->whereIn('id', $request->species);
            });
        }

        $posts = $posts->get();

        return view('posts.index', compact('posts'));
    }
};
