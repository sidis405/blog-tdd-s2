<?php

namespace Tests\Feature\Api;

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
        $response = $this->apiCall('DELETE', route('api.posts.destroy', $post));

        // assert
        $response->assertStatus(401);
    }

    /** @test */
    public function non_author_cannot_delete_post()
    {
        // arrange
        $this->signInApi()->withExceptionHandling();

        $post = create(Post::class);

        // act
        $response = $this->apiCall('DELETE', route('api.posts.destroy', $post));

        // assert
        $response->assertStatus(403);
    }


    /** @test */
    public function author_can_delete_own_post()
    {
        // arrange
        $this->signInApi();

        $post = create(Post::class, null, [
            'user_id' => $this->apiUser->id
        ]);

        // act
        $response = $this->apiCall('DELETE', route('api.posts.destroy', $post));

        // assert
        $this->assertDatabaseMissing('posts', ['title' => $post->title]);
        $response->assertStatus(200);
    }
}
