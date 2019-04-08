<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Acme\Models\Post;

class PostEditingTest extends TestCase
{

    /** @test */
    public function guest_cannot_update_post()
    {
        // arrage
        $this->withExceptionHandling();
        $post = create(Post::class);

        // act
        $response = $this->patch(route('api.posts.update', $post), []);

        // assert
        $response->assertStatus(401);
    }


    /** @test */
    public function non_author_cannot_update_post()
    {
        // arrange
        $this->signInApi()->withExceptionHandling();

        $post = create(Post::class);

        // act
        $response = $this->apiCall('PATCH', route('api.posts.update', $post), []);

        // assert
        $response->assertStatus(403);
    }


    /** @test */
    public function author_can_update_a_post()
    {
        [$post, $postData, $response] = $this->updatePost();

        $this->assertEquals($post->title, $postData['title']);

        $response->assertStatus(200);
    }

    public function updatePost()
    {
        $this->signInApi();
        $post = create(Post::class, null, ['user_id' => $this->apiUser->id]);
        $postData = [
            'title' => 'Updated post',
            'category_id' => 1,
        ];

        $response = $this->apiCall('PATCH', route('api.posts.update', $post), $postData);

        $post = $post->fresh();

        return [$post, $postData, $response];
    }
}
