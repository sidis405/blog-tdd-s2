<?php

namespace Acme\Http\Controllers;

use Acme\Models\Post;
use Illuminate\Http\Request;
use Acme\Events\PostWasUpdated;
use Acme\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
    }

    public function index()
    {
        $posts = Post::with('user', 'category', 'tags')->get();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('user', 'category', 'tags');

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        event(new PostWasUpdated($post));

        return redirect()->route('posts.show', $post);
    }
}
