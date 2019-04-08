<?php

namespace Tests\Feature;

use Tests\TestCase;
use Acme\Models\Tag;
use Acme\Models\Post;

class PostShowingTest extends TestCase
{
    /** @test */
    public function user_can_see_single_post()
    {
        // arrange
        $post = factory(Post::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $post->tags()->sync($tags);

        // act
        $response = $this->get(route('posts.show', $post));

        // assert
        $response->assertOk();
        $response->assertSee($post->title);
        $response->assertSee($post->user->name);
        $response->assertSee($post->category->name);

        foreach ($post->tags as $tag) {
            $response->assertSee($tag->name);
        }
    }
}
