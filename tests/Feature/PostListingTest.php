<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Post;

class PostListingTest extends TestCase
{


    /** @test */
    public function user_can_see_post_listing()
    {
        // A - A - A
        // arrange
        $posts  = factory(Post::class, 10)->create();

        // act
        $response = $this->get(route('posts.index'));

        // $response->assertStatus(200);
        $response->assertOk();

        // assert
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }
}
