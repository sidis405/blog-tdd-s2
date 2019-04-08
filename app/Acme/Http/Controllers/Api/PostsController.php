<?php

namespace Acme\Http\Controllers\Api;

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
        $this->middleware('jwt.auth')->except('show', 'index');
        $this->middleware('can:update,post')->only('edit', 'update');
        $this->middleware('can:delete,post')->only('destroy');
        $this->postsRepo = $postsRepo;
    }

    public function index()
    {
        return $this->postsRepo->index();
    }

    public function show(Post $post)
    {
        return $this->postsRepo->show($post);
    }

    public function store(PostRequest $request)
    {
        return $this->postsRepo->store([
            'title' => $request->title,
            'category_id' => $request->category_id,
        ], 201);
    }

    public function update(Request $request, Post $post)
    {
        return $this->postsRepo->update($post, [
            'title' => $request->title,
            'category_id' => $request->category_id,
        ]);
    }

    public function destroy(Post $post)
    {
        return $this->postsRepo->destroy($post);
    }
}
