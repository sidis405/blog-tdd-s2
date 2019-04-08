<?php

namespace Acme\Repostories;

use Acme\Models\Post;
use Acme\Events\PostWasUpdated;

class PostRepository
{
    public function index()
    {
        return Post::with('user', 'category', 'tags')->get();
    }

    public function show(Post $post)
    {
        return $post->load('user', 'category', 'tags');
    }

    public function store(array $props)
    {
        return auth()->user()->posts()->create($props);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $post;
    }

    public function update(Post $post, array $props)
    {
        $post->update($props);

        event(new PostWasUpdated($post));

        return $post;
    }
}
