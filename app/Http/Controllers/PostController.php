<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Species;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('species') && $request->species != '') {
            $query->whereHas('species', function ($query) use ($request) {
                $query->where('species.id', $request->species);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('text', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->with('species')->get();

        $species = Species::all();

        return view('home', compact('posts', 'species'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $species = Species::all();
        return view('post.create', compact('species'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'species' => 'array',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'image' => $request->file('image')?->store('images'),
        ]);

        $post->species()->sync($validated['species'] ?? []);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('species')->findOrFail($id);

        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $species = Species::all();
        return view('post.edit', compact('post', 'species'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'species' => 'array',
        ]);

        $post->update([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'image' => $request->file('image')?->store('images'),
        ]);

        $post->species()->sync($validated['species'] ?? []);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
