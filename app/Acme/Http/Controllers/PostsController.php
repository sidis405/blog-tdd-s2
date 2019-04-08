<?php

namespace Acme\Http\Controllers;

use Acme\Models\Post;
use Illuminate\Http\Request;
use Acme\Http\Requests\PostRequest;
use Acme\Repostories\PostRepository;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    protected $postsRepo;

    public function __construct(PostRepository $postsRepo)
    {
        $this->middleware('auth')->except('show', 'index');
        $this->middleware('can:update,post')->only('edit', 'update');
        $this->middleware('can:delete,post')->only('destroy');
        $this->postsRepo = $postsRepo;
    }

    public function index()
    {
        $posts = $this->postsRepo->index();

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post = $this->postsRepo->show($post);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = $this->postsRepo->store([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->postsRepo->update($post, [
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->postsRepo->destroy($post);

        return redirect()->to('/');
    }
}
