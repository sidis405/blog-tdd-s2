<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;

class PostDeletionTest extends TestCase
{
    /** @test */
    public function guests_cannot_delete_post()
    {
        // arrange
        $this->withExceptionHandling();
        $post = create(Post::class);

        // act
        $response = $this->delete(route('posts.destroy', $post));

        // assert
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function non_author_cannot_delete_post()
    {
        // arrange
        $this->signIn()->withExceptionHandling();

        $post = create(Post::class);

        // act
        $response = $this->delete(route('posts.destroy', $post));

        // assert
        $response->assertStatus(403);
    }


    /** @test */
    public function author_can_delete_own_post()
    {
        // arrange
        $this->signIn();

        $post = create(Post::class, null, [
            'user_id' => auth()->id()
        ]);

        // act
        $response = $this->delete(route('posts.destroy', $post));

        // assert
        $this->assertDatabaseMissing('posts', ['title' => $post->title]);
        $response->assertRedirect('/');
    }
}
